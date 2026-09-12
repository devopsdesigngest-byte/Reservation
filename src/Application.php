<?php

namespace App;

use App\Http\Request;
use App\Middleware\Middleware;
use App\View\RenderInterface;
use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;

final class Application
{
    public function __construct(
        private ContainerInterface $container,
        private Dispatcher $dispatcher,
        private Middleware $middleware,
        private RenderInterface $render,
        private Request $request
    ) {
    }

    public function run(): void
    {
        $routeInfo = $this->dispatcher->dispatch($this->request->method(), $this->request->path());

        match ($routeInfo[0]) {
            Dispatcher::NOT_FOUND => $this->render->render('error/404', [], 404),
            Dispatcher::METHOD_NOT_ALLOWED => $this->methodNotAllowed($routeInfo[1]),
            Dispatcher::FOUND => $this->dispatchFound($routeInfo[1], $routeInfo[2]),
        };
    }

    private function methodNotAllowed(array $allowedMethods): void
    {
        header('Allow: ' . implode(', ', $allowedMethods));
        $this->render->render('error/405', ['allowed' => $allowedMethods], 405);
    }

    private function dispatchFound(array $handler, array $vars): void
    {
        [$controllerClass, $method] = $handler;
        $controller = $this->container->get($controllerClass);

        $this->middleware->handle(function () use ($controller, $method, $vars): void {
            empty($vars)
                ? $controller->$method()
                : $controller->$method(...array_values($vars));
        });
    }
}
