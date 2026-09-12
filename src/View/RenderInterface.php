<?php

namespace App\View;

interface RenderInterface
{
    public function render(string $view, array $data = [], int $status = 200): void;

    public function redirect(string $url, int $status = 302): void;
}
