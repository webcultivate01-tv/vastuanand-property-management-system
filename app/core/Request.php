<?php
namespace App\Core;

final class Request
{
    public array $params = [];

    public function method(): string {
        $m = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        if ($m === 'POST' && isset($_POST['_method'])) {
            $m = strtoupper($_POST['_method']);
        }
        return $m;
    }

    public function uri(): string {
        $u = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        return '/' . trim($u, '/');
    }

    public function isAjax(): bool {
        return (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest')
            || str_contains(strtolower($_SERVER['HTTP_ACCEPT'] ?? ''), 'application/json');
    }

    public function input(string $key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $this->json()[$key] ?? $default;
    }

    public function all(): array {
        return array_merge($_GET ?? [], $_POST ?? [], $this->json());
    }

    public function only(array $keys): array {
        $all = $this->all();
        return array_intersect_key($all, array_flip($keys));
    }

    public function json(): array {
        static $cache = null;
        if ($cache !== null) return $cache;
        $body = file_get_contents('php://input') ?: '';
        if ($body === '') return $cache = [];
        $decoded = json_decode($body, true);
        return $cache = (is_array($decoded) ? $decoded : []);
    }

    public function header(string $name): ?string {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
        return $_SERVER[$key] ?? null;
    }

    public function bearerToken(): ?string {
        $h = $this->header('Authorization') ?? '';
        if (preg_match('/Bearer\s+(\S+)/i', $h, $m)) return $m[1];
        return $_COOKIE['vt_token'] ?? null;
    }

    public function ip(): string {
        return $_SERVER['HTTP_X_FORWARDED_FOR']
            ?? $_SERVER['HTTP_CLIENT_IP']
            ?? $_SERVER['REMOTE_ADDR']
            ?? '0.0.0.0';
    }

    public function userAgent(): string {
        return $_SERVER['HTTP_USER_AGENT'] ?? '';
    }
}
