<?php

namespace App\Service;

use App\DTO\FiltresReservation;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class ReservationService implements ReservationServiceInterface
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository
    ) {
    }

    public function lister(FiltresReservation $filtres, int $page = 1): LengthAwarePaginator
    {
        return $this->reservationRepository->lister($filtres, $page);
    }

    public function trouver(int $id): ?Reservation
    {
        return $this->reservationRepository->trouver($id);
    }

    public function listerSalles(): Collection
    {
        return $this->salleRepository->toutes();
    }
}
