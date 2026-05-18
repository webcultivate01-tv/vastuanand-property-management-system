<?php
namespace App\Core;

final class App
{
    public static Router $router;

    public static function boot(string $basePath): void
    {
        // Session
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 0,
                'path'     => '/',
                'secure'   => !empty($_SERVER['HTTPS']),
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }

        // Composer or fallback autoload — must run BEFORE we use any helpers
        $composerAutoload = $basePath . '/vendor/autoload.php';
        if (is_file($composerAutoload)) {
            require $composerAutoload;
        } else {
            self::registerFallbackAutoloader($basePath);
            require $basePath . '/app/helpers/functions.php';
        }
        // Belt-and-braces — make sure helpers exist even with composer
        if (!function_exists('env')) {
            require $basePath . '/app/helpers/functions.php';
        }

        // Env
        Env::load($basePath . '/.env');

        // Timezone
        date_default_timezone_set(\env('APP_TIMEZONE', 'Asia/Kolkata'));

        // Error handling
        $debug = filter_var(\env('APP_DEBUG', false), FILTER_VALIDATE_BOOL);
        ini_set('display_errors', $debug ? '1' : '0');
        error_reporting(E_ALL);
        set_exception_handler(function (\Throwable $e) use ($debug) {
            \logger('error', $e->getMessage(), ['file' => $e->getFile(), 'line' => $e->getLine()]);
            if ($debug) {
                echo "<pre style='background:#0a0a0a;color:#C9A35B;padding:24px;font-family:monospace'>";
                echo "Exception: " . htmlspecialchars($e->getMessage()) . "\n\n";
                echo htmlspecialchars($e->getTraceAsString());
                echo "</pre>";
            } else {
                Response::serverError();
            }
        });

        // Shared view data
        View::share('app',   \config('app'));
        View::share('brand', \config('app.brand'));

        // Routes
        self::$router = new Router();
        require $basePath . '/routes/web.php';
        require $basePath . '/routes/api.php';
    }

    private static function registerFallbackAutoloader(string $base): void
    {
        spl_autoload_register(function (string $class) use ($base) {
            if (!str_starts_with($class, 'App\\')) return;
            $rel = str_replace('\\', '/', substr($class, 4));
            $path = $base . '/app/' . lcfirst($rel) . '.php';
            // also try preserved case (Controllers, Models, Core)
            $alt  = $base . '/app/' . $rel . '.php';
            if (is_file($path)) require $path;
            elseif (is_file($alt)) require $alt;
            else {
                // case-insensitive fallback
                $altLower = $base . '/app/' . strtolower($rel) . '.php';
                if (is_file($altLower)) require $altLower;
            }
        });
    }

    public static function run(): void
    {
        self::$router->dispatch(new Request());
    }
}
