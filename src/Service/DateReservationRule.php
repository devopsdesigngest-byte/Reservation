<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;

class DateReservationRule implements ReservationRuleInterface
{
    public function verifier(CreerReservationDTO $dto): void
    {
        if ($dto->dateDebut >= $dto->dateFin) {
            throw new SalleIndisponibleException("La date de début doit précéder la date de fin.");
        }
    }
}