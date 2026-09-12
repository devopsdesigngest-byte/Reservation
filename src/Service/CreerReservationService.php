<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;

final class CreerReservationService implements CreerReservationServiceInterface
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private ReservationRules $reservationRules
    ) {
    }

    public function executer(CreerReservationDTO $dto): Reservation
    {
        $this->reservationRules->verifier($dto);

        $reservation = new Reservation();
        $reservation->forceFill([
            'salle_id' => $dto->salleId,
            'responsable' => $dto->responsable,
            'email' => $dto->email,
            'motif' => $dto->motif,
            'date_debut' => $dto->dateDebut->format('Y-m-d H:i:s'),
            'date_fin' => $dto->dateFin->format('Y-m-d H:i:s'),
            'statut' => 'confirmée',
        ]);

        return $this->reservationRepository->enregistrer($reservation);
    }
}
