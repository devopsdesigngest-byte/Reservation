<?php

namespace App\Middleware;

use App\Exception\ValidationException;
use App\Exception\SalleIndisponibleException;
use App\Exception\ReservationIntrouvableException;
use App\View\Render;

class ExceptionMiddleware
{
    public function handle(callable $next): void
    {
        try {
            $next();
        } catch (ValidationException $e) {
            echo Render::render('reservation/form', ['salles' => [], 'errors' => $e->errors(), 'old' => $_POST]);
        } catch (SalleIndisponibleException $e) {
            echo Render::render('reservation/form', ['salles' => [], 'errors' => ['general' => [$e->getMessage()]], 'old' => $_POST]);
        } catch (ReservationIntrouvableException $e) {
            http_response_code(404);
            echo Render::render('error/404');
        } catch (\Throwable $e) {
            error_log($e->getMessage() . "\n" . $e->getTraceAsString());
            http_response_code(500);
            echo 'Une erreur est survenue. Veuillez réessayer plus tard.';
        }
    }
}