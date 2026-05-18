<?php
namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Helpers\JWT;

final class AuthMiddleware
{
    public function handle(Request $req): void
    {
        $token = $req->bearerToken();
        if (!$token) Response::json(['ok' => false, 'message' => 'Unauthorized'], 401);
        $payload = JWT::decode($token);
        if (!$payload) Response::json(['ok' => false, 'message' => 'Invalid token'], 401);
        $_SESSION['_jwt_user'] = $payload;
    }
}
