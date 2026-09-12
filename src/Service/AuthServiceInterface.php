<?php

namespace App\Service;

interface AuthServiceInterface
{
    public function authentifier(string $email, string $password): bool;

    public function deconnecter(): void;

    public function utilisateur(): ?array;
}
