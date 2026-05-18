<?php
namespace App\Controllers\Api;

use App\Core\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Helpers\JWT;

final class AuthApi extends Controller
{
    public function login(): void
    {
        $data = $this->validate(['email' => 'required|email', 'password' => 'required|min:6']);

        $admin = Admin::byEmail($data['email']);
        if ($admin && password_verify($data['password'], $admin['password'] ?? '')) {
            $token = JWT::encode(['sub' => $admin['id'], 'email' => $admin['email'], 'role' => 'admin']);
            $this->json(['ok' => true, 'token' => $token, 'role' => 'admin', 'user' => ['name' => $admin['name'] ?? 'Admin']]);
        }

        $user = User::byEmail($data['email']);
        if (!$user || !password_verify($data['password'], $user['password'] ?? '')) {
            $this->json(['ok' => false, 'message' => 'Invalid credentials'], 401);
        }

        $token = JWT::encode(['sub' => $user['id'], 'email' => $user['email'], 'role' => 'user']);
        $this->json(['ok' => true, 'token' => $token, 'role' => 'user', 'user' => ['name' => $user['name'] ?? '']]);
    }

    public function register(): void
    {
        $data = $this->validate([
            'name'     => 'required|min:2',
            'email'    => 'required|email',
            'phone'    => 'required|phone',
            'password' => 'required|min:8',
        ]);

        if (User::byEmail($data['email'])) {
            $this->json(['ok' => false, 'message' => 'Email already registered'], 409);
        }

        $user = User::create([
            'name'     => $data['name'],
            'email'    => strtolower($data['email']),
            'phone'    => $data['phone'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'role'     => 'user',
            'verified' => false,
        ]);

        $token = JWT::encode(['sub' => $user['id'], 'email' => $user['email'], 'role' => 'user']);
        $this->json(['ok' => true, 'token' => $token, 'user' => ['name' => $user['name'], 'email' => $user['email']]]);
    }

    public function refresh(): void
    {
        $token = $this->request->bearerToken();
        $payload = $token ? JWT::decode($token) : null;
        if (!$payload) $this->json(['ok' => false], 401);
        $new = JWT::encode(['sub' => $payload['sub'], 'email' => $payload['email'], 'role' => $payload['role'] ?? 'user']);
        $this->json(['ok' => true, 'token' => $new]);
    }

    public function me(): void
    {
        $this->json(['ok' => true, 'user' => $_SESSION['_jwt_user'] ?? null]);
    }
}
