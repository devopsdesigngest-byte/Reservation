<?php

use App\DTO\ConnexionDTO;
use Illuminate\Database\Capsule\Manager as Capsule;

$envPath = dirname(__DIR__);
if (is_readable($envPath . '/.env')) {
    Dotenv\Dotenv::createImmutable($envPath)->safeLoad();
}

$env = ConnexionDTO::depuisEnv();

$confifDB = [
    'driver' => $env->driver,
    'host' => $env->host,
    'port' => $env->port,
    'database' => $env->database,
    'username' => $env->username,
    'password' => $env->password,
];
$capsule = new Capsule();
$capsule->addConnection($confifDB);
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;
