<?php

use function DI\autowire;
use function DI\factory;
use function DI\get;

use App\Application;
use App\Http\Request;
use App\Repository\SalleRepositoryInterface;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\ResponsableRepositoryInterface;
use App\Repository\EloquentSalleRepository;
use App\Repository\EloquentReservationRepository;
use App\Repository\EloquentResponsableRepository;
use App\Validation\SalleValidatorInterface;
use App\Validation\ReservationValidatorInterface;
use App\Validation\SalleValidator;
use App\Validation\ReservationValidator;
use App\Service\CreerReservationServiceInterface;
use App\Service\AnnulerReservationServiceInterface;
use App\Service\SalleServiceInterface;
use App\Service\ReservationServiceInterface;
use App\Service\AuthServiceInterface;
use App\Service\CreerReservationService;
use App\Service\AnnulerReservationService;
use App\Service\SalleService;
use App\Service\ReservationService;
use App\Service\AuthService;
use App\Service\ReservationRules;
use App\Service\SalleExisteRule;
use App\Service\SalleActiveRule;
use App\Service\DateReservationRule;
use App\Service\DureeReservationRule;
use App\Service\ReservationFutureRule;
use App\Service\ConflitReservationRule;
use App\View\RenderInterface;
use App\View\Strategy\HtmlRenderStrategy;
use App\View\Strategy\JsonRenderStrategy;

use Illuminate\Database\Capsule\Manager as Capsule;
use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;

return [
    SalleRepositoryInterface::class => autowire(EloquentSalleRepository::class),
    ReservationRepositoryInterface::class => autowire(EloquentReservationRepository::class),
    ResponsableRepositoryInterface::class => autowire(EloquentResponsableRepository::class),

    SalleValidatorInterface::class => autowire(SalleValidator::class),
    ReservationValidatorInterface::class => autowire(ReservationValidator::class),

    CreerReservationServiceInterface::class => autowire(CreerReservationService::class),
    AnnulerReservationServiceInterface::class => autowire(AnnulerReservationService::class),
    SalleServiceInterface::class => autowire(SalleService::class),
    ReservationServiceInterface::class => autowire(ReservationService::class),
    AuthServiceInterface::class => autowire(AuthService::class),

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
            $container->get(ConflitReservationRule::class),
        ]);
    }),

    RenderInterface::class => factory(function (ContainerInterface $container): RenderInterface {
        $strategies = [
            'html' => HtmlRenderStrategy::class,
            'json' => JsonRenderStrategy::class,
        ];
        $mode = strtolower((string) ($_ENV['RENDER_MODE'] ?? $_SERVER['RENDER_MODE'] ?? getenv('RENDER_MODE') ?: 'html'));
        $strategyClass = $strategies[$mode] ?? HtmlRenderStrategy::class;

        return $container->get($strategyClass);
    }),

    Request::class => autowire(),

    Application::class => autowire()
        ->constructorParameter('container', get(ContainerInterface::class))
        ->constructorParameter('dispatcher', get(Dispatcher::class)),
];
