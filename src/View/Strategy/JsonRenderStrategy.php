<?php

namespace App\View\Strategy;

use App\View\RenderInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

final class JsonRenderStrategy implements RenderInterface
{
    public function render(string $view, array $data = [], int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($this->payload($view, $data), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function redirect(string $url, int $status = 302): void
    {
        $this->render('redirect', ['url' => $url], $status === 302 ? 200 : $status);
        exit;
    }

    private function payload(string $view, array $data): array
    {
        $payload = [
            'view' => $view,
            'data' => $this->normalize($data),
        ];

        if (isset($data['errors']) && $data['errors'] !== []) {
            $payload['errors'] = $data['errors'];
        }

        return $payload;
    }

    private function normalize(mixed $value): mixed
    {
        if ($value instanceof LengthAwarePaginator) {
            return [
                'items' => $this->normalize($value->items()),
                'pagination' => [
                    'current_page' => $value->currentPage(),
                    'last_page' => $value->lastPage(),
                    'per_page' => $value->perPage(),
                    'total' => $value->total(),
                    'has_more' => $value->hasMorePages(),
                ],
            ];
        }

        if ($value instanceof Model) {
            return $value->toArray();
        }

        if ($value instanceof Collection) {
            return $value->map(fn ($item) => $this->normalize($item))->all();
        }

        if (is_array($value)) {
            $normalized = [];
            foreach ($value as $key => $item) {
                $normalized[$key] = $this->normalize($item);
            }
            return $normalized;
        }

        return $value;
    }
}
