<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Repository\SalleRepositoryInterface;
use App\Exception\SalleIndisponibleException;

class SalleActiveRule implements ReservationRuleInterface
{
    public function __construct(private SalleRepositoryInterface $salleRepository) {}

    public function verifier(CreerReservationDTO $dto): void
    {
        $salle = $this->salleRepository->trouver($dto->salleId);

        if (!$salle->active) {
            throw new SalleIndisponibleException("La salle '{$salle->nom}' n'est pas active.");
        }
    }
}