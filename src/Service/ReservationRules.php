<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;

class ReservationRules
{
    public function __construct(private array $rules) {}

    public function verifier(CreerReservationDTO $dto): void
    {
        foreach ($this->rules as $rule) {
            $rule->verifier($dto);
        }
    }
}