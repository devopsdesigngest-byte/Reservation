<?php

namespace App\Repository;

use App\DTO\FiltresSalle;
use App\Model\Salle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

final class EloquentSalleRepository implements SalleRepositoryInterface
{
    public function lister(FiltresSalle $filtres, int $page = 1): LengthAwarePaginator
    {
        $query = Salle::query();

        if ($filtres->nom !== null) {
            $query->where('nom', 'like', '%' . $filtres->nom . '%');
        }
        if ($filtres->batiment !== null) {
            $query->where('batiment', 'like', '%' . $filtres->batiment . '%');
        }
        if ($filtres->type !== null) {
            $query->where('type', $filtres->type);
        }
        if ($filtres->active !== null) {
            $query->where('active', $filtres->active);
        }

        return $query->paginate(null, ['*'], 'page', $page);
    }

    public function toutes(): Collection
    {
        return Salle::query()->get();
    }

    public function trouver(int $id): ?Salle
    {
        return Salle::query()->find($id);
    }

    public function enregistrer(Salle $salle): int
    {
        $salle->save();
        return $salle->id;
    }
}
