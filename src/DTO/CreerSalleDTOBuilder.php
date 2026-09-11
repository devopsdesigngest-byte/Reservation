<?php

namespace App\DTO;

use App\Validation\SalleValidator;
use App\Exception\ValidationException;

readonly class CreerSalleDTOBuilder
{
    public static function fromArrayBuilder(array $data): CreerSalleDTO
    {
        $resultat = (new SalleValidator())->validate([
            'nom' => $data['nom'] ?? '',
            'batiment' => $data['batiment'] ?? '',
            'capacite' => (int) ($data['capacite'] ?? 0),
            'type' => $data['type'] ?? '',
            'active' => (bool) ($data['active'] ?? false),
        ]);

        if (!$resultat->isValid()) throw new ValidationException($resultat->errors());

        $valide = $resultat->data();

        return CreerSalleDTO::create($valide['nom'], $valide['batiment'], $valide['capacite'],  $valide['type'], $valide['active']);
    }
}
