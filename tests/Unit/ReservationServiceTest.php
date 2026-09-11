<?php

// Scénario 1 — Réservation valide
// Salle : Salle B12
// Début : demain à 10h00
// Fin : demain à 12h00
// Responsable : Awa Ndiaye
// Email : awa.ndiaye@universite.sn
// Motif : Cours d'architecture logicielle
// Résultat attendu :
// Réservation confirmée
// Scénario 2 — Chevauchement
// Réservation existante :
// 10h00 → 12h00
// Nouvelle demande :
// 11h30 → 13h00
// Résultat attendu :
// La salle est indisponible pendant cette période.
// Scénario 3 — Réservations voisines
// Réservation existante :
// 10h00 → 12h00
// Nouvelle demande :
// 12h00 → 14h00
// Résultat attendu :
// Réservation confirmée
// Scénario 4 — Salle inactive
// Résultat attendu :
// Cette salle ne peut pas être réservée.
// Scénario 5 — Durée excessive
// Début : 08h00
// Fin : 14h00
// Résultat attendu :
// Une réservation ne peut pas dépasser quatre heures.



// namespace Tests\Unit;

// use App\DTO\CreerReservationDTO;
// use App\Exception\SalleIndisponibleException;
// use App\Model\Reservation;
// use App\Repository\ReservationRepositoryInterface;
// use App\Service\CreerReservationService;
// use App\Service\ReservationRules;
// use PHPUnit\Framework\TestCase;

// class ReservationServiceTest extends TestCase
// {
//     private CreerReservationService $service;
//     private $reservationRepository;
//     private $reservationRules;

//     protected function setUp(): void
//     {
//         parent::setUp();

//         $this->reservationRepository = $this->createMock(
//             ReservationRepositoryInterface::class
//         );

//         $this->reservationRules = $this->createMock(
//             ReservationRules::class
//         );

//         $this->service = new CreerReservationService(
//             $this->reservationRepository,
//             $this->reservationRules
//         );
//     }

//     public function testReservationValide(): void
//     {
//         $demain = new \DateTimeImmutable('tomorrow');

//         $dto = CreerReservationDTO::create(
//             1,
//             'Awa Ndiaye',
//             'awa.ndiaye@universite.sn',
//             'Cours d\'architecture logicielle',
//             $demain->setTime(10, 0),
//             $demain->setTime(12, 0)
//         );

//         $this->reservationRules
//             ->expects($this->once())
//             ->method('verifier')
//             ->with($dto);

//         $reservation = $this->getMockBuilder(Reservation::class)
//             ->disableOriginalConstructor()
//             ->getMock();

//         $this->reservationRepository
//             ->expects($this->once())
//             ->method('enregistrer')
//             ->willReturn($reservation);

//         $resultat = $this->service->executer($dto);

//         $this->assertInstanceOf(Reservation::class, $resultat);
//     }

//     public function testReservationChevauchement(): void
//     {
//         $demain = new \DateTimeImmutable('tomorrow');

//         $dto = CreerReservationDTO::create(
//             1,
//             'Awa Ndiaye',
//             'awa.ndiaye@universite.sn',
//             'TP test',
//             $demain->setTime(11, 30),
//             $demain->setTime(13, 0)
//         );

//         $this->reservationRules
//             ->expects($this->once())
//             ->method('verifier')
//             ->with($dto)
//             ->willThrowException(
//                 new SalleIndisponibleException(
//                     'La salle est déjà réservée sur ce créneau.'
//                 )
//             );

//         $this->reservationRepository
//             ->expects($this->never())
//             ->method('enregistrer');

//         $this->expectException(SalleIndisponibleException::class);
//         $this->expectExceptionMessage(
//             'La salle est déjà réservée sur ce créneau.'
//         );

//         $this->service->executer($dto);
//     }

//     public function testReservationsVoisines(): void
//     {
//         $demain = new \DateTimeImmutable('tomorrow');

//         $dto = CreerReservationDTO::create(
//             1,
//             'Awa Ndiaye',
//             'awa.ndiaye@universite.sn',
//             'Cours suivant',
//             $demain->setTime(12, 0),
//             $demain->setTime(14, 0)
//         );

//         $this->reservationRules
//             ->expects($this->once())
//             ->method('verifier')
//             ->with($dto);

//         $reservation = $this->getMockBuilder(Reservation::class)
//             ->disableOriginalConstructor()
//             ->getMock();

//         $this->reservationRepository
//             ->expects($this->once())
//             ->method('enregistrer')
//             ->willReturn($reservation);

//         $resultat = $this->service->executer($dto);

//         $this->assertInstanceOf(Reservation::class, $resultat);
//     }

//     public function testSalleInactive(): void
//     {
//         $demain = new \DateTimeImmutable('tomorrow');

//         $dto = CreerReservationDTO::create(
//             1,
//             'Awa Ndiaye',
//             'awa.ndiaye@universite.sn',
//             'TP test',
//             $demain->setTime(10, 0),
//             $demain->setTime(12, 0)
//         );

//         $this->reservationRules
//             ->expects($this->once())
//             ->method('verifier')
//             ->with($dto)
//             ->willThrowException(
//                 new SalleIndisponibleException(
//                     "La salle 'Salle B12' n'est pas active."
//                 )
//             );

//         $this->reservationRepository
//             ->expects($this->never())
//             ->method('enregistrer');

//         $this->expectException(SalleIndisponibleException::class);
//         $this->expectExceptionMessage(
//             "La salle 'Salle B12' n'est pas active."
//         );

//         $this->service->executer($dto);
//     }

//     public function testDureeExcessive(): void
//     {
//         $demain = new \DateTimeImmutable('tomorrow');

//         $dto = CreerReservationDTO::create(
//             1,
//             'Awa Ndiaye',
//             'awa.ndiaye@universite.sn',
//             'TP test',
//             $demain->setTime(8, 0),
//             $demain->setTime(14, 0)
//         );

//         $this->reservationRules
//             ->expects($this->once())
//             ->method('verifier')
//             ->with($dto)
//             ->willThrowException(
//                 new SalleIndisponibleException(
//                     'La durée de réservation ne peut pas dépasser 4 heures.'
//                 )
//             );

//         $this->reservationRepository
//             ->expects($this->never())
//             ->method('enregistrer');

//         $this->expectException(SalleIndisponibleException::class);
//         $this->expectExceptionMessage(
//             'La durée de réservation ne peut pas dépasser 4 heures.'
//         );

//         $this->service->executer($dto);
//     }
// }