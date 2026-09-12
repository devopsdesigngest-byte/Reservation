<?php

namespace App\Service;

use App\DTO\CreerSalleDTO;
use App\DTO\FiltresSalle;
use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SalleServiceInterface
{
    public function lister(FiltresSalle $filtres, int $page = 1): LengthAwarePaginator;

    public function trouver(int $id): ?Salle;

    public function creer(CreerSalleDTO $dto): void;

    public function modifier(int $id, array $data): void;
}
