<?php

namespace App\View\Strategy;

use App\Core\SessionManager;
use App\View\RenderInterface;

final class HtmlRenderStrategy implements RenderInterface
{
    public function __construct(private SessionManager $session)
    {
    }

    public function render(string $view, array $data = [], int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: text/html; charset=UTF-8');
        $data['authUser'] = $this->session->get('responsable');
        extract($data);
        ob_start();
        require dirname(__DIR__, 3) . '/templates/' . $view . '.php';
        $content = ob_get_clean();
        require dirname(__DIR__, 3) . '/templates/layout/base.php';
    }

    public function redirect(string $url, int $status = 302): void
    {
        http_response_code($status);
        header('Location: ' . $url);
        exit;
    }
}
