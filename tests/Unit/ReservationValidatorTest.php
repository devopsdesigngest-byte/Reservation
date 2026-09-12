<?php

namespace Tests\Unit;

use App\Validation\ReservationValidator;
use PHPUnit\Framework\TestCase;

class ReservationValidatorTest extends TestCase
{
    public function testEmailInvalide(): void
    {
        $validator = new ReservationValidator();
        $resultat = $validator->validate([
            'salle_id' => '1',
            'responsable' => 'Jean',
            'email' => 'adresse-invalide',
            'motif' => 'TP',
            'date_debut' => '2026-09-10T10:00',
            'date_fin' => '2026-09-10T12:00',
        ]);

        $this->assertFalse($resultat->isValid());
        $this->assertArrayHasKey('email', $resultat->errors());
        $this->assertArrayHasKey('motif', $resultat->errors());
    }
}
