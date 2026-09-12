<?php

namespace App\Controller;

use App\Http\Request;
use App\Service\SalleServiceInterface;
use App\Validation\SalleValidatorInterface;
use App\DTO\CreerSalleDTO;
use App\DTO\FiltresSalle;
use App\View\RenderInterface;

final class SalleController
{
    public function __construct(
        private SalleServiceInterface $salleService,
        private SalleValidatorInterface $salleValidator,
        private RenderInterface $render,
        private Request $request
    ) {
    }

    public function index(): void
    {
        $filtres = FiltresSalle::depuisGet($this->request->query());
        $salles = $this->salleService->lister($filtres, $this->request->page());
        $this->render->render('salle/index', [
            'salles' => $salles,
            'filters' => $this->request->query(),
        ]);
    }

    public function show(int $id): void
    {
        $salle = $this->salleService->trouver($id);
        if ($salle === null) {
            $this->render->render('error/404', [], 404);
            return;
        }
        $this->render->render('salle/show', ['salle' => $salle]);
    }

    public function create(): void
    {
        $this->render->render('salle/form', ['salle' => null, 'errors' => [], 'old' => []]);
    }

    public function store(): void
    {
        $data = $this->request->input();
        $data['active'] = isset($data['active']) && $data['active'] ? '1' : '0';
        $resultat = $this->salleValidator->validate($data);
        if (!$resultat->isValid()) {
            $this->render->render('salle/form', [
                'salle' => null,
                'errors' => $resultat->errors(),
                'old' => $data,
            ], 422);
            return;
        }
        $valide = $resultat->data();
        $dto = CreerSalleDTO::create(
            $valide['nom'],
            $valide['batiment'],
            (int) $valide['capacite'],
            $valide['type'],
            (bool) $valide['active']
        );
        $this->salleService->creer($dto);
        $this->render->redirect('/salles');
    }

    public function edit(int $id): void
    {
        $salle = $this->salleService->trouver($id);
        if ($salle === null) {
            $this->render->render('error/404', [], 404);
            return;
        }
        $this->render->render('salle/form', ['salle' => $salle, 'errors' => [], 'old' => []]);
    }

    public function update(int $id): void
    {
        $salle = $this->salleService->trouver($id);
        if ($salle === null) {
            $this->render->render('error/404', [], 404);
            return;
        }
        $data = $this->request->input();
        $data['active'] = isset($data['active']) && $data['active'] ? '1' : '0';
        $resultat = $this->salleValidator->validate($data);
        if (!$resultat->isValid()) {
            $this->render->render('salle/form', [
                'salle' => $salle,
                'errors' => $resultat->errors(),
                'old' => $data,
            ], 422);
            return;
        }
        $this->salleService->modifier($id, $resultat->data());
        $this->render->redirect('/salles/' . $id);
    }
}
