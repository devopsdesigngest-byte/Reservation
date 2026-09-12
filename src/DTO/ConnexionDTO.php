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
            self::env('DB_DRIVER', 'mysql'),
            self::env('DB_HOST', '127.0.0.1'),
            self::env('DB_PORT', '3306'),
            self::env('DB_DATABASE') ?? self::env('MYSQL_DATABASE'),
            self::env('DB_USERNAME') ?? self::env('MYSQL_USER'),
            self::env('DB_PASSWORD') ?? self::env('MYSQL_PASSWORD')
        );
    }

    private static function env(string $key, ?string $default = null): ?string
    {
        $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        if ($value === false || $value === null || $value === '') {
            return $default;
        }
        return (string) $value;
    }
}
