<?php

namespace App\Controller;

use App\Http\Request;
use App\Service\AuthServiceInterface;
use App\View\RenderInterface;

final class AuthController
{
    public function __construct(
        private AuthServiceInterface $authService,
        private RenderInterface $render,
        private Request $request
    ) {
    }

    public function loginForm(): void
    {
        $this->render->render('auth/login', [
            'errors' => [],
            'old' => [],
            'info' => 'Mode test : il n\'y a pas encore d\'inscription. Saisissez un email et un mot de passe, la connexion laisse passer.',
        ]);
    }

    public function login(): void
    {
        $data = $this->request->input();
        $email = trim((string) ($data['email'] ?? ''));
        $password = (string) ($data['password'] ?? '');

        if ($email === '' || $password === '') {
            $this->render->render('auth/login', [
                'errors' => ['general' => ['Email et mot de passe requis.']],
                'old' => ['email' => $email],
                'info' => 'Mode test : il n\'y a pas encore d\'inscription. La connexion laisse passer.',
            ], 422);
            return;
        }

        $this->authService->authentifier($email, $password);
        $this->render->redirect('/reservations');
    }

    public function logout(): void
    {
        $this->authService->deconnecter();
        $this->render->redirect('/login');
    }
}
