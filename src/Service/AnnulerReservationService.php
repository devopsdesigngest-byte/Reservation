<?php

namespace App\Service;

use App\Repository\ReservationRepositoryInterface;
use App\Exception\ReservationIntrouvableException;

final class AnnulerReservationService implements AnnulerReservationServiceInterface
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function executer(int $reservationId): void
    {
        $reservation = $this->reservationRepository->trouver($reservationId);
        if ($reservation === null) {
            throw new ReservationIntrouvableException("La réservation n'existe pas.");
        }
        $this->reservationRepository->annuler($reservationId);
    }
}
