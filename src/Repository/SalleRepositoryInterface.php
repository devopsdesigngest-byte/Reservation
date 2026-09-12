<?php

namespace App\Repository;

use App\DTO\FiltresSalle;
use App\Model\Salle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface SalleRepositoryInterface
{
    public function lister(FiltresSalle $filtres, int $page = 1): LengthAwarePaginator;

    public function toutes(): Collection;

    public function trouver(int $id): ?Salle;

    public function enregistrer(Salle $salle): int;
}
