<?php

namespace App\DTO;

final class FiltresReservation
{
    public function __construct(
        public readonly ?string $responsable = null,
        public readonly ?string $email = null,
        public readonly ?string $statut = null,
        public readonly ?int $salleId = null,
        public readonly ?string $dateDebut = null,
        public readonly ?string $dateFin = null,
    ) {
    }

    public static function depuisGet(array $data): self
    {
        return new self(
            responsable: self::texte($data['responsable'] ?? null),
            email: self::texte($data['email'] ?? null),
            statut: self::texte($data['statut'] ?? null),
            salleId: isset($data['salle_id']) && $data['salle_id'] !== '' ? (int) $data['salle_id'] : null,
            dateDebut: self::texte($data['date_debut'] ?? null),
            dateFin: self::texte($data['date_fin'] ?? null),
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
