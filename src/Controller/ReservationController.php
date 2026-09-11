<?php

namespace App\Controller;

use App\Validation\ReservationValidator;
use App\DTO\CreerReservationDTOBuilder;
use App\Service\CreerReservationService;
use App\Service\AnnulerReservationService;
use App\Service\ReservationService;
// use App\Exception\ValidationException;
// use App\Exception\SalleIndisponibleException;
use App\Exception\ReservationIntrouvableException;
use App\View\Render;

class ReservationController
{
    public function __construct(
        private ReservationService $reservationService,
        private CreerReservationService $creerReservationService,
        private AnnulerReservationService $annulerReservationService
    ) {
    }

    public function index(): void
    {
        $reservations = $this->reservationService->lister();
        echo Render::render('reservation/index', ['reservations' => $reservations]);
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationService->trouver($id);

        if ($reservation === null) {
            http_response_code(404);
            echo Render::render('error/404');
            return;
        }
        echo Render::render('reservation/show', ['reservation' => $reservation]);
    }

    public function create(): void
    {
        $salles = $this->reservationService->listerSalles();
        echo Render::render('reservation/form', [
            'salles' => $salles,
            'errors' => [],
            'old' => []
        ]);
    }

    public function store(): void
    {
        $data = $_POST;

        $resultat = (new ReservationValidator())->validate($data);

        if (!$resultat->isValid()) {
            echo Render::render('reservation/form', [
                'salles' => $this->reservationService->listerSalles(),
                'errors' => $resultat->errors(),
                'old' => $data
            ]);
            return;
        }

        $dto = CreerReservationDTOBuilder::fromArrayBuilder($data);

        $reservation = $this->creerReservationService->executer($dto);

        header('Location: /reservations/' . $reservation->id);
        exit;
    }

    // public function store(): void
    // {
    //     $data = $_POST;
    //     $resultat = (new ReservationValidator())->validate($data);
    //     if (!$resultat->isValid()) {
    //         echo Render::render('reservation/form', [
    //             'salles' => $this->reservationService->listerSalles(),
    //             'errors' => $resultat->errors(),
    //             'old' => $data
    //         ]);
    //         return;
    //     }
    //     try {
    //         $dto = CreerReservationDTOBuilder::fromArrayBuilder($data);
    //         $reservation = $this->creerReservationService->executer($dto);

    //         header('Location: /reservations/' . $reservation->id);
    //         exit;
    //     } catch (ValidationException $e) {
    //         echo Render::render('reservation/form', [
    //             'salles' => $this->reservationService->listerSalles(),
    //             'errors' => $e->errors(),
    //             'old' => $data
    //         ]);
    //     } catch (SalleIndisponibleException $e) {
    //         echo Render::render('reservation/form', [
    //             'salles' => $this->reservationService->listerSalles(),
    //             'errors' => ['general' => [$e->getMessage()]],
    //             'old' => $data
    //         ]);
    //     }
    // }

    public function cancel(int $id): void
    {
        try {
            $this->annulerReservationService->executer($id);

            header('Location: /reservations');
            exit;
        } catch (ReservationIntrouvableException $e) {
            http_response_code(404);
            echo Render::render('error/404');
        }
    }
}