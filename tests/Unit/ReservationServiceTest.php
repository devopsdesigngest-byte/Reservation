<?php

namespace Tests\Unit;

use App\DTO\CreerReservationDTO;
use App\Exception\SalleIndisponibleException;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Service\CreerReservationService;
use App\Service\ReservationRules;
use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;

class ReservationServiceTest extends TestCase
{
    private CreerReservationService $service;
    private ReservationRepositoryInterface $reservationRepository;
    private ReservationRules $reservationRules;

    protected function setUp(): void
    {
        parent::setUp();

        $capsule = new Capsule();
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $this->reservationRepository = $this->createMock(ReservationRepositoryInterface::class);
        $this->reservationRules = $this->createMock(ReservationRules::class);
        $this->service = new CreerReservationService(
            $this->reservationRepository,
            $this->reservationRules
        );
    }

    public function testReservationValide(): void
    {
        $demain = new \DateTimeImmutable('tomorrow');
        $dto = CreerReservationDTO::create(
            1,
            'Awa Ndiaye',
            'awa.ndiaye@universite.sn',
            'Cours d\'architecture logicielle',
            $demain->setTime(10, 0),
            $demain->setTime(12, 0)
        );

        $this->reservationRules->expects($this->once())->method('verifier')->with($dto);

        $reservation = $this->getMockBuilder(Reservation::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reservationRepository
            ->expects($this->once())
            ->method('enregistrer')
            ->willReturn($reservation);

        $this->assertInstanceOf(Reservation::class, $this->service->executer($dto));
    }

    public function testReservationChevauchement(): void
    {
        $demain = new \DateTimeImmutable('tomorrow');
        $dto = CreerReservationDTO::create(
            1,
            'Awa Ndiaye',
            'awa.ndiaye@universite.sn',
            'TP test',
            $demain->setTime(11, 30),
            $demain->setTime(13, 0)
        );

        $this->reservationRules
            ->expects($this->once())
            ->method('verifier')
            ->with($dto)
            ->willThrowException(new SalleIndisponibleException('La salle est déjà réservée sur ce créneau.'));

        $this->reservationRepository->expects($this->never())->method('enregistrer');
        $this->expectException(SalleIndisponibleException::class);

        $this->service->executer($dto);
    }

    public function testReservationsVoisines(): void
    {
        $demain = new \DateTimeImmutable('tomorrow');
        $dto = CreerReservationDTO::create(
            1,
            'Awa Ndiaye',
            'awa.ndiaye@universite.sn',
            'Cours suivant',
            $demain->setTime(12, 0),
            $demain->setTime(14, 0)
        );

        $this->reservationRules->expects($this->once())->method('verifier')->with($dto);

        $reservation = $this->getMockBuilder(Reservation::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->reservationRepository
            ->expects($this->once())
            ->method('enregistrer')
            ->willReturn($reservation);

        $this->assertInstanceOf(Reservation::class, $this->service->executer($dto));
    }

    public function testSalleInactive(): void
    {
        $demain = new \DateTimeImmutable('tomorrow');
        $dto = CreerReservationDTO::create(
            1,
            'Awa Ndiaye',
            'awa.ndiaye@universite.sn',
            'TP test',
            $demain->setTime(10, 0),
            $demain->setTime(12, 0)
        );

        $this->reservationRules
            ->expects($this->once())
            ->method('verifier')
            ->willThrowException(new SalleIndisponibleException("La salle 'Salle B12' n'est pas active."));

        $this->reservationRepository->expects($this->never())->method('enregistrer');
        $this->expectException(SalleIndisponibleException::class);

        $this->service->executer($dto);
    }

    public function testDureeExcessive(): void
    {
        $demain = new \DateTimeImmutable('tomorrow');
        $dto = CreerReservationDTO::create(
            1,
            'Awa Ndiaye',
            'awa.ndiaye@universite.sn',
            'TP test',
            $demain->setTime(8, 0),
            $demain->setTime(14, 0)
        );

        $this->reservationRules
            ->expects($this->once())
            ->method('verifier')
            ->willThrowException(new SalleIndisponibleException('La durée de réservation ne peut pas dépasser 4 heures.'));

        $this->reservationRepository->expects($this->never())->method('enregistrer');
        $this->expectException(SalleIndisponibleException::class);

        $this->service->executer($dto);
    }
}
