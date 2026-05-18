<?php
namespace App\Core;

final class Response
{
    public static function json($data, int $status = 200, array $headers = []): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        foreach ($headers as $k => $v) header("{$k}: {$v}");
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    public static function html(string $content, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: text/html; charset=utf-8');
        echo $content;
        exit;
    }

    public static function redirect(string $to, int $status = 302): void
    {
        header("Location: {$to}", true, $status);
        exit;
    }

    public static function notFound(string $msg = 'Not Found'): void
    {
        http_response_code(404);
        if (is_file(app_path('views/pages/404.php'))) {
            require app_path('views/pages/404.php');
        } else {
            echo "<h1>404 — {$msg}</h1>";
        }
        exit;
    }

    public static function serverError(string $msg = 'Server Error'): void
    {
        http_response_code(500);
        if (is_file(app_path('views/pages/500.php'))) {
            require app_path('views/pages/500.php');
        } else {
            echo "<h1>500 — {$msg}</h1>";
        }
        exit;
    }
}
