<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

use App\Application;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Pagination\Paginator;

$builder = new ContainerBuilder();
$builder->addDefinitions(dirname(__DIR__) . '/config/container.php');
$container = $builder->build();

$container->get(Capsule::class);

Paginator::currentPathResolver(static function (): string {
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $path = parse_url($uri, PHP_URL_PATH);
    return is_string($path) && $path !== '' ? $path : '/';
});

$application = $container->get(Application::class);
$application->run();