<?php

namespace App\Repository;

use App\DTO\FiltresReservation;
use App\Model\Reservation;
use DateTimeImmutable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ReservationRepositoryInterface
{
    public function lister(FiltresReservation $filtres, int $page = 1): LengthAwarePaginator;

    public function trouver(int $id): ?Reservation;

    public function enregistrer(Reservation $reservation): Reservation;

    public function annuler(int $id): bool;

    public function rechercherConflit(
        int $salleId,
        DateTimeImmutable $dateDebut,
        DateTimeImmutable $dateFin,
        ?int $excludeId = null
    ): ?Reservation;
}
