<?php

namespace App\DTO;

readonly class ConnexionDTO
{
    public function __construct(
        public string $driver,
        public string $host,
        public string $port,
        public string $database,
        public string $username,
        public string $password
    ) {
    }

    public static function depuisEnv(): self
    {
        return new self(
            $_ENV['DB_DRIVER'],
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD']
        );
    }
}