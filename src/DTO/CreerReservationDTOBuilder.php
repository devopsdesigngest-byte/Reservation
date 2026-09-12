<?php

namespace App\DTO;

use App\Validation\ReservationValidatorInterface;
use App\Exception\ValidationException;

final class CreerReservationDTOBuilder
{
    public function __construct(private ReservationValidatorInterface $validator)
    {
    }

    public function fromArray(array $data): CreerReservationDTO
    {
        $resultat = $this->validator->validate([
            'salle_id' => (int) ($data['salle_id'] ?? 0),
            'responsable' => $data['responsable'] ?? '',
            'email' => $data['email'] ?? '',
            'motif' => $data['motif'] ?? '',
            'date_debut' => $data['date_debut'] ?? '',
            'date_fin' => $data['date_fin'] ?? '',
        ]);

        if (!$resultat->isValid()) {
            throw new ValidationException($resultat->errors());
        }

        $valide = $resultat->data();

        return CreerReservationDTO::create(
            (int) $valide['salle_id'],
            $valide['responsable'],
            $valide['email'],
            $valide['motif'],
            new \DateTimeImmutable($valide['date_debut']),
            new \DateTimeImmutable($valide['date_fin'])
        );
    }
}
