<?php

namespace App\View;

class Render
{
    public static function render(string $template, array $data = []): string
    {
        extract($data);
        ob_start();
        require dirname(__DIR__, 2) . '/templates/' . $template . '.php';
        $content = ob_get_clean();

        ob_start();
        require dirname(__DIR__, 2) . '/templates/layout/base.php';
        return ob_get_clean();
    }
}