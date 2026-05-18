<?php
/**
 * Global helpers — kept intentionally small.
 * All helpers are namespaced via the root namespace because they are
 * autoloaded as files (see composer.json).
 */

if (!function_exists('env')) {
    function env(string $key, $default = null)
    {
        $val = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);
        if ($val === false || $val === null) return $default;
        $lower = strtolower((string)$val);
        return match ($lower) {
            'true', '(true)'   => true,
            'false', '(false)' => false,
            'null', '(null)'   => null,
            'empty', '(empty)' => '',
            default            => $val,
        };
    }
}

if (!function_exists('config')) {
    function config(string $dotKey, $default = null)
    {
        static $cache = [];
        [$file, $rest] = array_pad(explode('.', $dotKey, 2), 2, null);
        if (!isset($cache[$file])) {
            $path = dirname(__DIR__) . "/config/{$file}.php";
            $cache[$file] = is_file($path) ? require $path : [];
        }
        if ($rest === null) return $cache[$file];
        $value = $cache[$file];
        foreach (explode('.', $rest) as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) return $default;
            $value = $value[$segment];
        }
        return $value;
    }
}

if (!function_exists('app_path')) {
    function app_path(string $sub = ''): string {
        return rtrim(dirname(__DIR__) . ($sub ? "/{$sub}" : ''), '/');
    }
}

if (!function_exists('base_path')) {
    function base_path(string $sub = ''): string {
        return rtrim(dirname(__DIR__, 2) . ($sub ? "/{$sub}" : ''), '/');
    }
}

if (!function_exists('public_path')) {
    function public_path(string $sub = ''): string {
        return base_path('public' . ($sub ? "/{$sub}" : ''));
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string {
        return config('app.url') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string {
        return url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('upload')) {
    function upload(string $path): string {
        return url('uploads/' . ltrim($path, '/'));
    }
}

if (!function_exists('e')) {
    function e($value): string {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('old')) {
    function old(string $key, $default = '') {
        return $_SESSION['_old'][$key] ?? $default;
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string {
        if (empty($_SESSION['_csrf'])) {
            $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string {
        return '<input type="hidden" name="_csrf" value="' . csrf_token() . '">';
    }
}

if (!function_exists('verify_csrf')) {
    function verify_csrf(?string $token): bool {
        return !empty($token) && hash_equals($_SESSION['_csrf'] ?? '', $token);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $to, int $code = 302): void {
        header('Location: ' . $to, true, $code);
        exit;
    }
}

if (!function_exists('json_response')) {
    function json_response($data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}

if (!function_exists('format_price')) {
    function format_price($amount): string {
        $amount = (float)$amount;
        if ($amount >= 1_00_00_000) return '₹' . number_format($amount / 1_00_00_000, 2) . ' Cr';
        if ($amount >= 1_00_000)    return '₹' . number_format($amount / 1_00_000, 2) . ' L';
        return '₹' . number_format($amount, 0);
    }
}

if (!function_exists('slug')) {
    function slug(string $text): string {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
        return trim($text, '-');
    }
}

if (!function_exists('logger')) {
    function logger(string $level, string $message, array $context = []): void {
        $file = base_path('storage/logs/app.log');
        $line = sprintf("[%s] %s: %s %s\n",
            date('Y-m-d H:i:s'),
            strtoupper($level),
            $message,
            $context ? json_encode($context, JSON_UNESCAPED_UNICODE) : ''
        );
        @file_put_contents($file, $line, FILE_APPEND | LOCK_EX);
    }
}
