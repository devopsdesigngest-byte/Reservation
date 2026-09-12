<?php

namespace App\Service;

use App\DTO\CreerSalleDTO;
use App\DTO\FiltresSalle;
use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class SalleService implements SalleServiceInterface
{
    public function __construct(private SalleRepositoryInterface $salleRepository)
    {
    }

    public function lister(FiltresSalle $filtres, int $page = 1): LengthAwarePaginator
    {
        return $this->salleRepository->lister($filtres, $page);
    }

    public function trouver(int $id): ?Salle
    {
        return $this->salleRepository->trouver($id);
    }

    public function creer(CreerSalleDTO $dto): void
    {
        $salle = new Salle();
        $salle->nom = $dto->nom;
        $salle->batiment = $dto->batiment;
        $salle->capacite = $dto->capacite;
        $salle->type = $dto->type;
        $salle->active = $dto->active;
        $this->salleRepository->enregistrer($salle);
    }

    public function modifier(int $id, array $data): void
    {
        $salle = $this->salleRepository->trouver($id);
        $salle->nom = $data['nom'];
        $salle->batiment = $data['batiment'];
        $salle->capacite = $data['capacite'];
        $salle->type = $data['type'];
        $salle->active = $data['active'];
        $this->salleRepository->enregistrer($salle);
    }
}
