<?php

// Scénario 6 — Formulaire invalide
// Responsable : vide
// Email : adresse-invalide
// Motif : TP
// Résultat attendu :
// aucune insertion ;
// affichage de toutes les erreurs ;
// conservation des valeurs valides dans le formulaire.




// namespace Tests\Unit;

// use App\Validation\ReservationValidator;
// use PHPUnit\Framework\TestCase;

// class ReservationValidatorTest extends TestCase
// {
//     public function testEmailInvalide(): void
//     {
//         $validator = new ReservationValidator();

//         $data = [
//             'salle_id' => '1',
//             'responsable' => 'Jean',
//             'email' => 'adresse-invalide',
//             'motif' => 'TP',
//             'date_debut' => '2026-09-10T10:00',
//             'date_fin' => '2026-09-10T12:00',
//         ];

//         $resultat = $validator->validate($data);

//         $this->assertArrayHasKey(
//             'email',
//             $resultat->errors()
//         );
//     }
// }