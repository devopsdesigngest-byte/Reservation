<?php

namespace Tests\Integration;

use App\Application;
use App\Core\SessionManager;
use App\Http\Request;
use App\Middleware\Middleware;
use App\Service\ReservationServiceInterface;
use App\View\RenderInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ApplicationTest extends TestCase
{
    private function creerApplication(RenderInterface $render): Application
    {
        $dispatcher = \FastRoute\simpleDispatcher(
            require dirname(__DIR__, 2) . '/routes/web.php'
        );

        $middleware = new Middleware(
            $this->createMock(SessionManager::class),
            new Request(),
            $render,
            $this->createMock(ReservationServiceInterface::class)
        );

        return new Application(
            $this->createMock(ContainerInterface::class),
            $dispatcher,
            $middleware,
            $render,
            new Request()
        );
    }

    public function testUrlInconnue(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/inconnue';

        $render = $this->createMock(RenderInterface::class);
        $render->expects($this->once())
            ->method('render')
            ->with('error/404', [], 404);

        $this->creerApplication($render)->run();
    }

    public function testMethodeNonAutorisee(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_SERVER['REQUEST_URI'] = '/salles';

        $render = $this->createMock(RenderInterface::class);
        $render->expects($this->once())
            ->method('render')
            ->with('error/405', $this->callback(fn (array $data): bool => isset($data['allowed'])), 405);

        $this->creerApplication($render)->run();
    }
}
