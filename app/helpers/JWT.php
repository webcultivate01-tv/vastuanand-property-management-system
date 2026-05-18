<?php
namespace App\Helpers;

/**
 * Minimal HS256 JWT implementation — used as a fallback when the
 * firebase/php-jwt library is not installed. If you have composer set up,
 * this class still works and is fully RFC-7519 compatible for HS256.
 */
final class JWT
{
    public static function encode(array $payload, ?string $secret = null, int $ttl = 0): string
    {
        $secret = $secret ?? (string) env('JWT_SECRET', 'change-me');
        $ttl    = $ttl ?: (int) env('JWT_TTL', 86400);

        $header  = ['typ' => 'JWT', 'alg' => 'HS256'];
        $payload['iat'] = time();
        $payload['exp'] = time() + $ttl;
        $payload['iss'] = config('app.url');

        $b64Header  = self::b64(json_encode($header));
        $b64Payload = self::b64(json_encode($payload));
        $sig        = self::b64(hash_hmac('sha256', "{$b64Header}.{$b64Payload}", $secret, true));

        return "{$b64Header}.{$b64Payload}.{$sig}";
    }

    public static function decode(string $token, ?string $secret = null): ?array
    {
        $secret = $secret ?? (string) env('JWT_SECRET', 'change-me');
        $parts = explode('.', $token);
        if (count($parts) !== 3) return null;
        [$h, $p, $s] = $parts;
        $expected = self::b64(hash_hmac('sha256', "{$h}.{$p}", $secret, true));
        if (!hash_equals($expected, $s)) return null;
        $payload = json_decode(self::b64d($p), true);
        if (!is_array($payload)) return null;
        if (isset($payload['exp']) && time() > (int) $payload['exp']) return null;
        return $payload;
    }

    private static function b64(string $bin): string {
        return rtrim(strtr(base64_encode($bin), '+/', '-_'), '=');
    }
    private static function b64d(string $str): string {
        $pad = 4 - (strlen($str) % 4);
        if ($pad < 4) $str .= str_repeat('=', $pad);
        return base64_decode(strtr($str, '-_', '+/'));
    }
}
