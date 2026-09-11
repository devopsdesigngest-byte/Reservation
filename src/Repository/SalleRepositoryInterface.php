<?php

namespace App\Repository;

use App\Model\Salle;
use Illuminate\Support\Collection;


interface SalleRepositoryInterface
{
    public function lister(int $page = 1, int $parPage = 5);

    public function toutes(): Collection;

    public function trouver(int $id): ?Salle;

    public function enregistrer(Salle $salle): int;
}

