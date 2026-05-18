<?php
namespace App\Helpers;

/**
 * Minimal Cloudinary uploader (server-side signed).
 * Uploads a file to Cloudinary and returns the secure URL.
 *
 * Requires .env:
 *   CLOUDINARY_CLOUD_NAME
 *   CLOUDINARY_API_KEY
 *   CLOUDINARY_API_SECRET
 *
 * Usage:
 *   $url = Cloudinary::upload($_FILES['image']['tmp_name'], 'properties');
 */
final class Cloudinary
{
    public static function configured(): bool
    {
        return env('CLOUDINARY_CLOUD_NAME') && env('CLOUDINARY_API_KEY') && env('CLOUDINARY_API_SECRET');
    }

    /**
     * Upload a file to Cloudinary. Returns secure URL or null on failure.
     *
     * @param string $filePath  Absolute path to the file on disk (e.g. tmp_name).
     * @param string $folder    Sub-folder inside Cloudinary (e.g. "properties").
     * @return string|null
     */
    public static function upload(string $filePath, string $folder = 'vastuanand'): ?string
    {
        if (!self::configured() || !is_file($filePath)) {
            logger('warn', 'Cloudinary upload skipped (not configured or file missing)');
            return null;
        }

        $cloudName = env('CLOUDINARY_CLOUD_NAME');
        $apiKey    = env('CLOUDINARY_API_KEY');
        $apiSecret = env('CLOUDINARY_API_SECRET');
        $timestamp = time();
        $folder    = trim($folder, '/');

        // Params to sign (alphabetical), excluding file, api_key, signature
        $paramsToSign = ['folder' => $folder, 'timestamp' => $timestamp];
        ksort($paramsToSign);
        $signString = '';
        foreach ($paramsToSign as $k => $v) {
            $signString .= "$k=$v&";
        }
        $signString = rtrim($signString, '&') . $apiSecret;
        $signature  = sha1($signString);

        $endpoint = "https://api.cloudinary.com/v1_1/{$cloudName}/image/upload";

        // Build multipart POST
        $mime = mime_content_type($filePath) ?: 'application/octet-stream';
        $cfile = new \CURLFile($filePath, $mime, basename($filePath));

        $postFields = [
            'file'      => $cfile,
            'api_key'   => $apiKey,
            'timestamp' => $timestamp,
            'folder'    => $folder,
            'signature' => $signature,
        ];

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postFields,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $raw  = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err  = curl_error($ch);
        curl_close($ch);

        if ($raw === false || $code >= 400) {
            logger('error', 'Cloudinary upload failed', ['code' => $code, 'err' => $err, 'body' => substr((string)$raw, 0, 400)]);
            return null;
        }

        $json = json_decode($raw, true);
        return $json['secure_url'] ?? null;
    }

    /**
     * Upload many files (from $_FILES array — single field, multiple files).
     * Returns array of secure URLs (failed uploads filtered out).
     */
    public static function uploadMany(array $filesField, string $folder = 'vastuanand/properties'): array
    {
        $urls = [];
        if (!isset($filesField['tmp_name']) || !is_array($filesField['tmp_name'])) {
            return $urls;
        }
        foreach ($filesField['tmp_name'] as $i => $tmp) {
            if (empty($tmp) || ($filesField['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
                continue;
            }
            $url = self::upload($tmp, $folder);
            if ($url) $urls[] = $url;
        }
        return $urls;
    }
}
