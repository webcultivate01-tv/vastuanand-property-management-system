<?php
/**
 * Vastu Anand · Hostinger diagnostic page.
 * Upload this file to your public_html and visit  https://yoursite.com/_check.php
 * It will tell you EXACTLY what is wrong without exposing secrets.
 *
 * Delete it from production once everything works.
 */

header('Content-Type: text/html; charset=utf-8');
$ok = '✅'; $warn = '⚠️'; $bad = '❌';

function box($label, $val, $status) {
    $color = $status === 'ok' ? '#7ee787' : ($status === 'warn' ? '#e3b341' : '#ff7b72');
    $icon  = $status === 'ok' ? '✓' : ($status === 'warn' ? '!' : '✗');
    echo "<tr><td style='padding:10px 14px;border-bottom:1px solid #222;color:#aaa'>{$label}</td>";
    echo "<td style='padding:10px 14px;border-bottom:1px solid #222;color:{$color};font-family:monospace'>{$icon}&nbsp;&nbsp;" . htmlspecialchars((string)$val) . "</td></tr>";
}

$base = __DIR__;
$missing = [];
foreach (['app','routes','public','database','app/config/app.php','app/core/App.php','public/index.php'] as $f) {
    if (!file_exists($base . '/' . $f)) $missing[] = $f;
}

$envExists  = file_exists($base . '/.env');
$envValues  = [];
if ($envExists) {
    foreach (file($base . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line,'=')) continue;
        [$k,$v] = explode('=',$line,2);
        $envValues[trim($k)] = trim($v);
    }
}

$mongoExt     = extension_loaded('mongodb');
$mongoLib     = file_exists($base . '/vendor/autoload.php');
$writableLogs = is_writable($base . '/storage/logs') || @mkdir($base . '/storage/logs', 0775, true);
$writableUp   = is_writable($base . '/public/uploads') || @mkdir($base . '/public/uploads', 0775, true);

?><!doctype html><html><head><title>Vastu Anand · System Check</title>
<style>body{background:#050505;color:#f5f2ec;font-family:system-ui,sans-serif;margin:0;padding:32px}
h1{font-family:'Cormorant Garamond',serif;color:#C9A35B;font-weight:300;font-size:36px;margin:0 0 8px}
.box{max-width:780px;margin:0 auto;background:#0f0f0f;border:1px solid #222;border-radius:14px;overflow:hidden}
table{width:100%;border-collapse:collapse;font-size:14px}
.hd{padding:24px 28px;border-bottom:1px solid #222}
.section{padding:18px 28px;background:rgba(201,163,91,0.08);color:#C9A35B;letter-spacing:.18em;text-transform:uppercase;font-size:11px;font-weight:600}
.fix{padding:20px 28px;background:#0a0a0a;border-top:1px solid #222;font-size:14px;line-height:1.7;color:#bbb}
.fix code{background:#1a1a1a;padding:2px 7px;border-radius:4px;color:#C9A35B;font-size:13px}
</style></head><body>
<div class="box">
  <div class="hd">
    <h1>Vastu Anand · System Check</h1>
    <p style="margin:6px 0 0;color:#888;font-size:13px">Diagnostic for Hostinger / shared hosting. Delete this file once the site works.</p>
  </div>

  <div class="section">PHP Environment</div>
  <table>
    <?php
    box('PHP version', PHP_VERSION, version_compare(PHP_VERSION, '8.0', '>=') ? 'ok' : 'bad');
    box('Server software', $_SERVER['SERVER_SOFTWARE'] ?? '?', 'ok');
    box('Document root', $_SERVER['DOCUMENT_ROOT'] ?? '?', 'ok');
    box('This script path', __DIR__, 'ok');
    box('Public path', $base . '/public', is_dir($base.'/public') ? 'ok' : 'bad');
    ?>
  </table>

  <div class="section">Required Extensions</div>
  <table>
    <?php
    foreach (['mongodb'=>'CRITICAL for DB','curl','mbstring','openssl','json','session','fileinfo'] as $ext => $note) {
        $loaded = extension_loaded(is_string($ext)?$ext:$note);
        $label  = is_string($ext) ? $ext : $note;
        box($label, $loaded ? 'loaded' : ($label==='mongodb' ? 'NOT loaded — install via hPanel → Advanced → PHP Configuration' : 'not loaded'), $loaded ? 'ok' : ($label==='mongodb' ? 'warn' : 'bad'));
    }
    ?>
  </table>

  <div class="section">Project Files</div>
  <table>
    <?php
    box('.env present', $envExists ? 'yes' : 'NO — upload your .env',  $envExists ? 'ok' : 'bad');
    box('vendor/autoload.php', $mongoLib ? 'yes (Composer installed)' : 'NO — run composer install or upload vendor/', $mongoLib ? 'ok' : 'warn');
    box('storage/logs writable', $writableLogs ? 'yes' : 'NO — chmod 775 storage/logs', $writableLogs ? 'ok' : 'bad');
    box('public/uploads writable', $writableUp ? 'yes' : 'NO — chmod 775 public/uploads', $writableUp ? 'ok' : 'bad');
    if ($missing) box('Missing core files', implode(', ', $missing), 'bad');
    else          box('Core files', 'all present', 'ok');
    ?>
  </table>

  <?php if ($envExists): ?>
  <div class="section">.env Values (secrets masked)</div>
  <table>
    <?php
    foreach (['APP_ENV','APP_DEBUG','APP_URL','MONGO_DB','ADMIN_EMAIL'] as $k) {
        box($k, $envValues[$k] ?? '(not set)', isset($envValues[$k]) ? 'ok' : 'warn');
    }
    box('MONGO_URI', isset($envValues['MONGO_URI']) && $envValues['MONGO_URI']
        ? preg_replace('#://[^@]+@#', '://***:***@', $envValues['MONGO_URI'])
        : '(not set)', isset($envValues['MONGO_URI']) ? 'ok' : 'warn');
    box('JWT_SECRET length', isset($envValues['JWT_SECRET']) ? strlen($envValues['JWT_SECRET']) . ' chars' : '(not set)', !empty($envValues['JWT_SECRET']) ? 'ok' : 'bad');
    ?>
  </table>
  <?php endif; ?>

  <div class="section">MongoDB Connection Test</div>
  <table>
    <?php
    $connected = false; $err = '';
    if ($mongoExt && $mongoLib && !empty($envValues['MONGO_URI'])) {
        require $base . '/vendor/autoload.php';
        try {
            $client = new MongoDB\Client($envValues['MONGO_URI']);
            $client->selectDatabase($envValues['MONGO_DB'] ?? 'vastuanand')->command(['ping' => 1]);
            $connected = true;
        } catch (\Throwable $e) {
            $err = $e->getMessage();
        }
    }
    box('Atlas ping', $connected ? 'success' : ($err ?: 'skipped (driver / library / URI missing)'), $connected ? 'ok' : 'warn');
    ?>
  </table>

  <div class="fix">
    <strong style="color:#C9A35B">Quick fix recipes</strong><br><br>
    • Set document root to <code>public_html/public</code> in hPanel → Domains → Manage → Public Folder<br>
    • Use PHP <code>8.1</code> or higher in hPanel → Advanced → PHP Configuration<br>
    • Enable <code>mongodb</code> extension in the same screen (Premium / Business plans support it)<br>
    • Upload <code>vendor/</code> from local machine, or use SSH: <code>composer install --no-dev -o</code><br>
    • Whitelist Hostinger's outbound IP in MongoDB Atlas (Network Access → Add IP)<br>
    • Set <code>APP_DEBUG=true</code> in .env temporarily to see real PHP errors
  </div>
</div>
</body></html>
