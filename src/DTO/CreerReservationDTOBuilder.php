<?php

namespace App\DTO;

use App\Validation\ReservationValidator;
use App\Exception\ValidationException;

class CreerReservationDTOBuilder
{
    public static function fromArrayBuilder(array $data): CreerReservationDTO
    {
        $resultat = (new ReservationValidator())->validate([
            'salle_id' => (int) ($data['salle_id'] ?? 0),
            'responsable' => $data['responsable'] ?? '',
            'email' => $data['email'] ?? '',
            'motif' => $data['motif'] ?? '',
            'date_debut' => $data['date_debut'] ?? '',
            'date_fin' => $data['date_fin'] ?? '',
        ]);

        if (!$resultat->isValid()) throw new ValidationException($resultat->errors());

        $valide = $resultat->data();

        return CreerReservationDTO::create($valide['salle_id'], $valide['responsable'], $valide['email'], $valide['motif'],  new \DateTimeImmutable($valide['date_debut']), new \DateTimeImmutable($valide['date_fin']));
    }
}