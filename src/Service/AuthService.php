<?php

namespace App\Service;

use App\Core\SessionManager;

final class AuthService implements AuthServiceInterface
{
    public function __construct(private SessionManager $session)
    {
    }

    public function authentifier(string $email, string $password): bool
    {
        // Mode test : pas d'inscription encore, on laisse passer.
        $this->session->set('responsable', [
            'id' => 0,
            'nom' => $email,
            'email' => $email,
        ]);

        return true;
    }

    public function deconnecter(): void
    {
        $this->session->remove('responsable');
    }

    public function utilisateur(): ?array
    {
        return $this->session->get('responsable');
    }
}
