<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;

class DureeReservationRule implements ReservationRuleInterface
{
    public function verifier(CreerReservationDTO $dto): void
    {
        $duree = $dto->dateDebut->diff($dto->dateFin);
        $heures = ($duree->days * 24) + $duree->h + ($duree->i / 60);

        if ($heures > 4) {
            throw new SalleIndisponibleException("La durée de réservation ne peut pas dépasser 4 heures.");
        }
    }
}