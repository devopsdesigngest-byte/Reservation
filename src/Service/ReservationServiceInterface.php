<?php

namespace App\Service;

use App\DTO\FiltresReservation;
use App\Model\Reservation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ReservationServiceInterface
{
    public function lister(FiltresReservation $filtres, int $page = 1): LengthAwarePaginator;

    public function trouver(int $id): ?Reservation;

    public function listerSalles(): Collection;
}
