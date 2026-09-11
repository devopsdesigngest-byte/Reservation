<?php

namespace App\Repository;

use App\Model\Reservation;
use Illuminate\Support\Collection;

class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function lister(): Collection
    {
        return Reservation::query()->get();
    }

    public function trouver(int $id): ?Reservation
    {
        return Reservation::query()->find($id);
    }

    public function enregistrer(Reservation $reservation): Reservation
    {
        $reservation->save();
        return $reservation;
    }

    public function annuler(int $id): bool
    {
        $reservation = $this->trouver($id);
        if ($reservation === null)
            return false;
        $reservation->statut = 'annulée';
        $reservation->save();
        return true;
    }

    public function rechercherConflit(
        int $salleId,
        \DateTimeImmutable $dateDebut,
        \DateTimeImmutable $dateFin,
        ?int $excludeId = null
    ): ?Reservation {
        $query = Reservation::query()
            ->where('salle_id', $salleId)
            ->where('statut', 'confirmée')
            ->where('date_debut', '<', $dateFin)
            ->where('date_fin', '>', $dateDebut);

        if ($excludeId !== null) $query->where('id', '!=', $excludeId);

        return $query->first();
    }
}