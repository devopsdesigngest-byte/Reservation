<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;

interface ReservationRuleInterface
{
    public function verifier(CreerReservationDTO $dto): void;
}