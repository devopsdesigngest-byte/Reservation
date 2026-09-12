<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Model\Reservation;

interface CreerReservationServiceInterface
{
    public function executer(CreerReservationDTO $dto): Reservation;
}
