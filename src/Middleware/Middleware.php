<?php

namespace App\Middleware;

use App\Core\SessionManager;
use App\Exception\ValidationException;
use App\Exception\SalleIndisponibleException;
use App\Exception\ReservationIntrouvableException;
use App\Http\Request;
use App\Service\ReservationServiceInterface;
use App\View\RenderInterface;

final class Middleware
{
    private const ROUTES_PROTEGEES = [
        'GET /salles/create',
        'POST /salles',
        'GET /salles/*/edit',
        'POST /salles/*/edit',
        'GET /reservations/create',
        'POST /reservations',
        'POST /reservations/*/cancel',
    ];

    public function __construct(
        private SessionManager $session,
        private Request $request,
        private RenderInterface $render,
        private ReservationServiceInterface $reservationService
    ) {
    }

    public function handle(callable $action): void
    {
        $this->session->init();

        if ($this->estProtege() && !$this->session->has('responsable')) {
            $this->render->render('auth/login', [
                'errors' => ['general' => ['Connectez-vous pour continuer.']],
                'old' => [],
                'info' => 'Mode test : pas d\'inscription encore. Email + mot de passe = connexion OK.',
            ], 401);
            return;
        }

        try {
            $action();
        } catch (ValidationException $e) {
            $this->render->render('reservation/form', [
                'salles' => $this->reservationService->listerSalles(),
                'errors' => $e->errors(),
                'old' => $this->request->input(),
            ], 422);
        } catch (SalleIndisponibleException $e) {
            $this->render->render('reservation/form', [
                'salles' => $this->reservationService->listerSalles(),
                'errors' => ['general' => [$e->getMessage()]],
                'old' => $this->request->input(),
            ], 409);
        } catch (ReservationIntrouvableException $e) {
            $this->render->render('error/404', [], 404);
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            $this->render->render('error/500', ['message' => 'Une erreur est survenue.'], 500);
        }
    }

    private function estProtege(): bool
    {
        $actuel = $this->request->method() . ' ' . $this->request->path();

        foreach (self::ROUTES_PROTEGEES as $route) {
            $motif = '#^' . str_replace('\*', '[^/]+', preg_quote($route, '#')) . '$#';
            if (preg_match($motif, $actuel) === 1) {
                return true;
            }
        }

        return false;
    }
}
