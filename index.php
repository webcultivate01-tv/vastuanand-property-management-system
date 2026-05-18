<?php
/**
 * Top-level shim — when the webroot is mistakenly pointed at the project root
 * instead of /public, this file forwards the request safely.
 *
 * In production, point your domain webroot at /public.
 */
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . '/public' . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false; // let the built-in server serve static files
}
require __DIR__ . '/public/index.php';
