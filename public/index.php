<?php
/**
 * Vastu Anand Real Estate — Front Controller
 * All HTTP traffic is routed through this file via .htaccess / nginx rewrites.
 */

declare(strict_types=1);

require_once __DIR__ . '/../app/core/Env.php';
require_once __DIR__ . '/../app/core/App.php';

\App\Core\App::boot(dirname(__DIR__));
\App\Core\App::run();
