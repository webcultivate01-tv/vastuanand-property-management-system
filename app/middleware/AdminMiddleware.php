<?php
namespace App\Middleware;

use App\Core\Request;
use App\Core\Response;
use App\Helpers\JWT;

final class AdminMiddleware
{
    public function handle(Request $req): void
    {
        // Web admin uses sessions
        if (!empty($_SESSION['admin'])) return;

        // API admin uses JWT with role=admin
        $token = $req->bearerToken();
        if ($token) {
            $payload = JWT::decode($token);
            if ($payload && ($payload['role'] ?? null) === 'admin') {
                $_SESSION['_jwt_user'] = $payload;
                return;
            }
        }

        if ($req->isAjax()) {
            Response::json(['ok' => false, 'message' => 'Admin access required'], 403);
        }
        Response::redirect('/admin/login');
    }
}
