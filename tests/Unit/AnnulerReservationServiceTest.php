<?php

namespace Tests\Unit;

use App\Exception\ReservationIntrouvableException;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Service\AnnulerReservationService;
use PHPUnit\Framework\TestCase;

class AnnulerReservationServiceTest extends TestCase
{
    public function testAnnulationReussie(): void
    {
        $repository = $this->createMock(ReservationRepositoryInterface::class);
        $reservation = $this->getMockBuilder(Reservation::class)
            ->disableOriginalConstructor()
            ->getMock();

        $repository->expects($this->once())->method('trouver')->with(5)->willReturn($reservation);
        $repository->expects($this->once())->method('annuler')->with(5)->willReturn(true);

        (new AnnulerReservationService($repository))->executer(5);
    }

    public function testAnnulationIntrouvable(): void
    {
        $repository = $this->createMock(ReservationRepositoryInterface::class);
        $repository->expects($this->once())->method('trouver')->with(99)->willReturn(null);
        $repository->expects($this->never())->method('annuler');

        $this->expectException(ReservationIntrouvableException::class);
        (new AnnulerReservationService($repository))->executer(99);
    }
}
