<?php

namespace App\Core;

class SessionManager
{
    public function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function set(string $key, mixed $value): void
    {
        $this->init();
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $this->init();
        return $_SESSION[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        $this->init();
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        $this->init();
        unset($_SESSION[$key]);
    }

    public function destroy(): void
    {
        $this->init();
        $_SESSION = [];
        session_destroy();
    }
}
