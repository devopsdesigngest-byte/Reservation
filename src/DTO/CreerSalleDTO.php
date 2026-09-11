<?php

namespace App\DTO;

class CreerSalleDTO
{
    private function __construct(
        public readonly string $nom,
        public readonly string $batiment,
        public readonly int $capacite,
        public readonly string $type,
        public readonly bool $active
    ) {
    }

    public static function create(string $nom, string $batiment, int $capacite, string $type, bool $active): self {
        return new self($nom, $batiment, $capacite, $type, $active);
    }
}