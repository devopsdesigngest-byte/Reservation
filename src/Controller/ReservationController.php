<?php

namespace App\Controller;

use App\DTO\CreerReservationDTOBuilder;
use App\DTO\FiltresReservation;
use App\Http\Request;
use App\Service\AnnulerReservationServiceInterface;
use App\Service\CreerReservationServiceInterface;
use App\Service\ReservationServiceInterface;
use App\View\RenderInterface;

final class ReservationController
{
    public function __construct(
        private ReservationServiceInterface $reservationService,
        private CreerReservationServiceInterface $creerReservationService,
        private AnnulerReservationServiceInterface $annulerReservationService,
        private CreerReservationDTOBuilder $dtoBuilder,
        private RenderInterface $render,
        private Request $request
    ) {
    }

    public function index(): void
    {
        $filtres = FiltresReservation::depuisGet($this->request->query());
        $reservations = $this->reservationService->lister($filtres, $this->request->page());
        $this->render->render('reservation/index', [
            'reservations' => $reservations,
            'salles' => $this->reservationService->listerSalles(),
            'filters' => $this->request->query(),
        ]);
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationService->trouver($id);
        if ($reservation === null) {
            $this->render->render('error/404', [], 404);
            return;
        }
        $this->render->render('reservation/show', ['reservation' => $reservation]);
    }

    public function create(): void
    {
        $this->render->render('reservation/form', [
            'salles' => $this->reservationService->listerSalles(),
            'errors' => [],
            'old' => [],
        ]);
    }

    public function store(): void
    {
        $dto = $this->dtoBuilder->fromArray($this->request->input());
        $reservation = $this->creerReservationService->executer($dto);
        $this->render->redirect('/reservations/' . $reservation->id);
    }

    public function cancel(int $id): void
    {
        $this->annulerReservationService->executer($id);
        $this->render->redirect('/reservations');
    }
}
