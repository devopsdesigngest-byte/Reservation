<?php

namespace App\Service;

interface AnnulerReservationServiceInterface
{
    public function executer(int $reservationId): void;
}
