<?php

namespace App\DTO;

final class FiltresSalle
{
    public function __construct(
        public readonly ?string $nom = null,
        public readonly ?string $batiment = null,
        public readonly ?string $type = null,
        public readonly ?bool $active = null,
    ) {
    }

    public static function depuisGet(array $data): self
    {
        $active = null;
        if (isset($data['active']) && $data['active'] !== '') {
            $active = in_array((string) $data['active'], ['1', 'true', 'oui'], true);
        }

        return new self(
            nom: self::texte($data['nom'] ?? null),
            batiment: self::texte($data['batiment'] ?? null),
            type: self::texte($data['type'] ?? null),
            active: $active,
        );
    }

    private static function texte(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }
        return (string) $value;
    }
}
