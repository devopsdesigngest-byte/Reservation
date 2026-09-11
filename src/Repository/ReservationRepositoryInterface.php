<?php

namespace App\Repository;

use App\Model\Reservation;
use DateTimeImmutable;
use Illuminate\Support\Collection;

interface ReservationRepositoryInterface
{
    public function lister(): Collection;
    public function trouver(int $id): ?Reservation;
    public function enregistrer(Reservation $reservation): Reservation;
    public function annuler(int $id): bool;
    public function rechercherConflit(int $salleId, DateTimeImmutable $dateDebut, DateTimeImmutable $dateFin, ?int $excludeId = null): ?Reservation;
}