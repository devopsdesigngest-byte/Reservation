<?php

namespace App\Service;

use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Model\Reservation;
use Illuminate\Support\Collection;

class ReservationService
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository
    ) {}

    public function lister(): Collection
    {
        return $this->reservationRepository->lister();
    }

    public function trouver(int $id): ?Reservation
    {
        return $this->reservationRepository->trouver($id);
    }

    // public function listerSalles(): Collection
    // {
    //     return $this->salleRepository->lister();
    // }
}