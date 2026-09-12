<?php

use function DI\autowire;
use function DI\factory;
use function DI\get;

use App\Application;
// use App\Controller\SalleController;
// use App\Controller\ReservationController;
use App\Repository\SalleRepositoryInterface;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\EloquentSalleRepository;
use App\Repository\EloquentReservationRepository;
// use App\Validation\SalleValidator;
// use App\Validation\ReservationValidator;
// use App\Service\CreerReservationService;
// use App\Service\AnnulerReservationService;
use App\Service\ReservationRules;
use App\Service\SalleExisteRule;
use App\Service\SalleActiveRule;
use App\Service\DateReservationRule;
use App\Service\DureeReservationRule;
use App\Service\ReservationFutureRule;
use App\Service\ConflitReservationRule;
// use App\Middleware\ExceptionMiddleware;

use Illuminate\Database\Capsule\Manager as Capsule;
use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;

return [
    SalleRepositoryInterface::class => autowire(EloquentSalleRepository::class),
    ReservationRepositoryInterface::class => autowire(EloquentReservationRepository::class),
    Capsule::class => factory(function (): Capsule {
        return require dirname(__DIR__) . '/config/database.php';
    }),
    Dispatcher::class => factory(function (): Dispatcher {
        return FastRoute\simpleDispatcher(
            require dirname(__DIR__) . '/routes/web.php'
        );
    }),
    ReservationRules::class => factory(function (ContainerInterface $container) {
        return new ReservationRules([
            $container->get(SalleExisteRule::class),
            $container->get(SalleActiveRule::class),
            $container->get(DateReservationRule::class),
            $container->get(DureeReservationRule::class),
            $container->get(ReservationFutureRule::class),
            $container->get(ConflitReservationRule::class)
        ]);
    }),
    Application::class => autowire()
        ->constructorParameter('container', get(ContainerInterface::class))
        ->constructorParameter('dispatcher', get(Dispatcher::class)),
    // SalleValidator::class => autowire(),
    // ReservationValidator::class => autowire(),
    // CreerReservationService::class => autowire(),
    // AnnulerReservationService::class => autowire(),
    // SalleController::class => autowire(),
    // ReservationController::class => autowire(),
    // ExceptionMiddleware::class => autowire(),
];