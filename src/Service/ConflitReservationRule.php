<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Repository\ReservationRepositoryInterface;
use App\Exception\SalleIndisponibleException;

class ConflitReservationRule implements ReservationRuleInterface
{
    public function __construct(private ReservationRepositoryInterface $reservationRepository) {}

    public function verifier(CreerReservationDTO $dto): void
    {
        $conflit = $this->reservationRepository->rechercherConflit(
            $dto->salleId,
            $dto->dateDebut,
            $dto->dateFin
        );

        if ($conflit !== null) {
            throw new SalleIndisponibleException("La salle est déjà réservée sur ce créneau.");
        }
    }
}