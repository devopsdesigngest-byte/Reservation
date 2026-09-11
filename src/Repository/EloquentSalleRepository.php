<?php

namespace App\Repository;

use App\Model\Salle;
// use Illuminate\Support\Collection;

class EloquentSalleRepository implements SalleRepositoryInterface
{
    // public function lister(): Collection
    // {
    //     return Salle::query()->get();
    // }
    public function lister(int $page = 1, int $parPage = 5)
    {
        return Salle::query()->paginate($parPage, ['*'], 'page', $page);
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