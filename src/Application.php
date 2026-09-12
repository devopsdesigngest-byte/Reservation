<?php

namespace App;

use App\View\Render;
use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;
use App\Middleware\ExceptionMiddleware;

final class Application
{
    public function __construct(
        private ContainerInterface $container,
        private Dispatcher $dispatcher
    ) {
    }

    public function run(): void
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?'))
            $uri = substr($uri, 0, $pos);
            $uri = rawurldecode($uri);

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                echo Render::render('error/404');
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                http_response_code(405);
                header('Allow: ' . implode(', ', $allowedMethods));
                echo Render::render('error/405', ['allowed' => $allowedMethods]);
                break;

            // case Dispatcher::FOUND:
            //     [$controllerClass, $method] = $routeInfo[1];
            //     $vars = $routeInfo[2];
            //     $controller = $this->container->get($controllerClass);
            //     if (!empty($vars)) $controller->$method(...array_values($vars));
            //     else $controller->$method();
            // break;
            case Dispatcher::FOUND:
                [$controllerClass, $method] = $routeInfo[1];
                $vars = $routeInfo[2];
                $controller = $this->container->get($controllerClass);
                $next = function () use ($controller, $method, $vars): void {
                    if (!empty($vars)) $controller->$method(...array_values($vars));
                    else $controller->$method();
                };
                $this->container->get(ExceptionMiddleware::class)->handle($next);
                break;
        }
    }
}