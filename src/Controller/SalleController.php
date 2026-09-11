<?php

namespace App\Controller;

use App\Service\SalleService;
use App\Validation\SalleValidator;
use App\DTO\CreerSalleDTO;
use App\View\Render;

class SalleController
{
    public function __construct(private SalleService $salleService)
    {
    }
    // public function index(): void
    // {
    //     $salles = $this->salleService->lister();
    //     echo Render::render('salle/index', ['salles' => $salles]);
    // }
    public function index(): void
    {
        $page = max(1, (int) ($_GET['page'] ?? 1));
        $salles = $this->salleService->lister($page, 5);
        $pagination = [
            'page' => $salles->currentPage(),
            'totalPages' => $salles->lastPage(),
            'precedent' => $salles->currentPage() > 1 ? '/salles?page=' . ($salles->currentPage() - 1) : null,
            'suivant' => $salles->hasMorePages()  ? '/salles?page=' . ($salles->currentPage() + 1) : null
        ];
        echo Render::render('salle/index', ['salles' => $salles, 'pagination' => $pagination]);
    }

    public function show(int $id): void
    {
        $salle = $this->salleService->trouver($id);
        if ($salle === null) {
            http_response_code(404);
            echo Render::render('error/404');
            return;
        }
        echo Render::render('salle/show', ['salle' => $salle]);
    }

    public function create(): void
    {
        echo Render::render('salle/form', ['salle' => null, 'errors' => [], 'old' => []]);
    }

    public function store(): void
    {
        $data = $_POST;
        $data['active'] = isset($data['active']) ? '1' : '0';
        $resultat = (new SalleValidator())->validate($data);
        if (!$resultat->isValid()) {
            echo Render::render('salle/form', ['salle' => null, 'errors' => $resultat->errors(), 'old' => $data]);
            return;
        }
        $valide = $resultat->data();
        $dto = CreerSalleDTO::create(
            $valide['nom'],
            $valide['batiment'],
            $valide['capacite'],
            $valide['type'],
            $valide['active']
        );
        $this->salleService->creer($dto);
        header('Location: /salles');
        exit;
    }

    public function edit(int $id): void
    {
        $salle = $this->salleService->trouver($id);
        if ($salle === null) {
            http_response_code(404);
            echo Render::render('error/404');
            return;
        }
        echo Render::render('salle/form', ['salle' => $salle, 'errors' => [], 'old' => []]);
    }

    public function update(int $id): void
    {
        $salle = $this->salleService->trouver($id);
        if ($salle === null) {
            http_response_code(404);
            echo Render::render('error/404');
            return;
        }
        $data = $_POST;
        $data['active'] = isset($data['active']) ? '1' : '0';
        $resultat = (new SalleValidator())->validate($data);
        if (!$resultat->isValid()) {
            echo Render::render('salle/form', ['salle' => $salle, 'errors' => $resultat->errors(), 'old' => $data]);
            return;
        }
        $this->salleService->modifier($id, $resultat->data());
        header('Location: /salles/' . $id);
        exit;
    }
}