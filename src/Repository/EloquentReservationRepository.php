<?php

namespace App\Repository;

use App\DTO\FiltresReservation;
use App\Model\Reservation;
use DateTimeImmutable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class EloquentReservationRepository implements ReservationRepositoryInterface
{
    public function lister(FiltresReservation $filtres, int $page = 1): LengthAwarePaginator
    {
        $query = Reservation::query()->with('salle');

        if ($filtres->responsable !== null) {
            $query->where('responsable', 'like', '%' . $filtres->responsable . '%');
        }
        if ($filtres->email !== null) {
            $query->where('email', 'like', '%' . $filtres->email . '%');
        }
        if ($filtres->statut !== null) {
            $query->where('statut', $filtres->statut);
        }
        if ($filtres->salleId !== null) {
            $query->where('salle_id', $filtres->salleId);
        }
        if ($filtres->dateDebut !== null) {
            $query->where('date_debut', '>=', $filtres->dateDebut);
        }
        if ($filtres->dateFin !== null) {
            $query->where('date_fin', '<=', $filtres->dateFin);
        }

        return $query->orderByDesc('date_debut')->paginate(null, ['*'], 'page', $page);
    }

    public function trouver(int $id): ?Reservation
    {
        return Reservation::query()->with('salle')->find($id);
    }

    public function enregistrer(Reservation $reservation): Reservation
    {
        $reservation->save();
        return $reservation;
    }

    public function annuler(int $id): bool
    {
        $reservation = $this->trouver($id);
        if ($reservation === null) {
            return false;
        }
        $reservation->statut = 'annulée';
        $reservation->save();
        return true;
    }

    public function rechercherConflit(
        int $salleId,
        DateTimeImmutable $dateDebut,
        DateTimeImmutable $dateFin,
        ?int $excludeId = null
    ): ?Reservation {
        $query = Reservation::query()
            ->where('salle_id', $salleId)
            ->where('statut', 'confirmée')
            ->where('date_debut', '<', $dateFin)
            ->where('date_fin', '>', $dateDebut);

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->first();
    }
}
