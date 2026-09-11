<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use DateTimeImmutable;

class ReservationFutureRule implements ReservationRuleInterface
{
    public function verifier(CreerReservationDTO $dto): void
    {
        if ($dto->dateDebut <= new DateTimeImmutable()) {
            throw new SalleIndisponibleException("La réservation doit être planifiée dans le futur.");
        }
    }
}