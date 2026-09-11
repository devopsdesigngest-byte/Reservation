<?php

namespace App\DTO;

class CreerReservationDTO
{
    private function __construct(
        public readonly int $salleId,
        public readonly string $responsable,
        public readonly string $email,
        public readonly string $motif,
        public readonly \DateTimeImmutable $dateDebut,
        public readonly \DateTimeImmutable $dateFin
    ) {
    }
    public static function create(int $salleId, string $responsable, string $email, string $motif, \DateTimeImmutable $dateDebut, \DateTimeImmutable $dateFin): self {
        return new self($salleId, $responsable, $email, $motif, $dateDebut, $dateFin);
    }
}