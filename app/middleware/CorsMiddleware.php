<?php
namespace App\Middleware;

use App\Core\Request;

final class CorsMiddleware
{
    public function handle(Request $req): void
    {
        header('Access-Control-Allow-Origin: ' . ($_SERVER['HTTP_ORIGIN'] ?? '*'));
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        if ($req->method() === 'OPTIONS') { http_response_code(204); exit; }
    }
}
