<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Repository\SalleRepositoryInterface;
use App\Exception\SalleIndisponibleException;

class SalleExisteRule implements ReservationRuleInterface
{
    public function __construct(private SalleRepositoryInterface $salleRepository) {}

    public function verifier(CreerReservationDTO $dto): void
    {
        if ($this->salleRepository->trouver($dto->salleId) === null) {
            throw new SalleIndisponibleException("La salle demandée n'existe pas.");
        }
    }
}