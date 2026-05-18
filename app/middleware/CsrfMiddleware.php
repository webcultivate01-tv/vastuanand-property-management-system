<?php
namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;

final class CsrfMiddleware
{
    public function handle(Request $req): void
    {
        if (in_array($req->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
            $token = $req->input('_csrf') ?? $req->header('X-CSRF-Token');
            if (!verify_csrf($token)) {
                if ($req->isAjax()) Response::json(['ok' => false, 'message' => 'CSRF token mismatch'], 419);
                http_response_code(419);
                exit('CSRF token mismatch');
            }
        }
    }
}
