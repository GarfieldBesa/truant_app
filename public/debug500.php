<?php
/**
 * 500 Error Diagnostics — Truant Enterprises
 * Upload to: public_html/debug500.php
 * Visit:     https://truantenterprises.com/debug500.php
 * DELETE after fixing.
 */

error_reporting(E_ALL);
ini_set('display_errors', '0');

$webRoot     = '/home/uq7hadnu944q/public_html';
$laravelRoot = '/home/uq7hadnu944q/production/truant_app';

$checks = [];

function chk(string $label, bool $pass, string $detail = '', string $fix = ''): array {
    return compact('label','pass','detail','fix');
}

// ── 1. Core Laravel file existence ────────────────────────────
$checks[] = chk('production/truant_app/ exists',
    is_dir($laravelRoot),
    $laravelRoot,
    'The Laravel app folder does not exist at this path. Check your cPanel File Manager.');

$checks[] = chk('artisan exists',
    file_exists($laravelRoot . '/artisan'),
    $laravelRoot . '/artisan',
    'artisan file missing — ensure the full Laravel project was uploaded/cloned.');

$checks[] = chk('vendor/autoload.php exists',
    file_exists($laravelRoot . '/vendor/autoload.php'),
    $laravelRoot . '/vendor/autoload.php',
    'CRITICAL: vendor/ folder is missing. Run "composer install" via cPanel Terminal: cd ~/production/truant_app && composer install --no-dev');

$checks[] = chk('bootstrap/app.php exists',
    file_exists($laravelRoot . '/bootstrap/app.php'),
    $laravelRoot . '/bootstrap/app.php',
    'bootstrap/app.php missing — the app was not fully uploaded.');

$checks[] = chk('.env file exists',
    file_exists($laravelRoot . '/.env'),
    $laravelRoot . '/.env',
    'CRITICAL: No .env file. Copy .env.example to .env and set your DB credentials + APP_KEY.');

$checks[] = chk('.env is readable',
    is_readable($laravelRoot . '/.env'),
    'Permissions: ' . (file_exists($laravelRoot.'/.env') ? substr(sprintf('%o', fileperms($laravelRoot.'/.env')), -4) : 'N/A'),
    'Set .env file permissions to 644 in cPanel File Manager.');

// ── 2. APP_KEY check ──────────────────────────────────────────
$appKey = '';
$appUrl = '';
$filesystemRoot = '';
if (file_exists($laravelRoot . '/.env')) {
    $envContent = file_get_contents($laravelRoot . '/.env');
    preg_match('/^APP_KEY=(.+)$/m', $envContent, $m);
    $appKey = trim($m[1] ?? '');
    preg_match('/^APP_URL=(.+)$/m', $envContent, $m2);
    $appUrl = trim($m2[1] ?? '');
    preg_match('/^FILESYSTEM_PUBLIC_ROOT=(.+)$/m', $envContent, $m3);
    $filesystemRoot = trim($m3[1] ?? '');
}
$checks[] = chk('APP_KEY is set in .env',
    !empty($appKey) && str_starts_with($appKey, 'base64:'),
    $appKey ? substr($appKey, 0, 20) . '...' : '(empty)',
    'Run in cPanel Terminal: cd ~/production/truant_app && php artisan key:generate');

// ── 3. Storage directory structure ────────────────────────────
$storageDirs = [
    'storage/app',
    'storage/app/public',
    'storage/app/public/events/banners',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'bootstrap/cache',
];
foreach ($storageDirs as $dir) {
    $full = $laravelRoot . '/' . $dir;
    $writable = is_dir($full) && is_writable($full);
    $checks[] = chk("{$dir}/ writable",
        $writable,
        is_dir($full) ? 'Perms: ' . substr(sprintf('%o', fileperms($full)), -4) : 'MISSING',
        is_dir($full) ? "chmod 755 {$full}" : "mkdir -p {$full} && chmod 755 {$full}");
}

// ── 4. public_html/storage status ─────────────────────────────
$pubStorage = $webRoot . '/storage';
$isSymlink  = is_link($pubStorage);
$isDir      = is_dir($pubStorage);
$checks[] = chk('public_html/storage is a real folder (not symlink)',
    $isDir && !$isSymlink,
    $isSymlink ? 'Is a symlink → ' . readlink($pubStorage) : ($isDir ? 'Real folder ✓' : 'MISSING'),
    $isSymlink ? 'Run storage_repair.php to replace symlink with real folder.' : 'Create it.');

// ── 5. PHP version ────────────────────────────────────────────
$phpVer = PHP_VERSION;
$phpOk  = version_compare($phpVer, '8.1.0', '>=');
$checks[] = chk('PHP >= 8.1',
    $phpOk,
    "PHP {$phpVer}",
    'Laravel 11 requires PHP 8.1+. Change PHP version in cPanel → MultiPHP Manager.');

// ── 6. Required extensions ────────────────────────────────────
$requiredExt = ['pdo','pdo_mysql','mbstring','openssl','tokenizer','xml','ctype','json','bcmath','fileinfo'];
foreach ($requiredExt as $ext) {
    $loaded = extension_loaded($ext);
    $checks[] = chk("PHP ext: {$ext}", $loaded, $loaded ? 'loaded' : 'MISSING',
        "Enable {$ext} in cPanel → MultiPHP INI Editor");
}

// ── 7. index.php paths check ──────────────────────────────────
$indexFile = $webRoot . '/index.php';
$indexContent = file_exists($indexFile) ? file_get_contents($indexFile) : '';
$pointsToProduction = str_contains($indexContent, 'production/truant_app');
$checks[] = chk('index.php points to production/truant_app',
    $pointsToProduction,
    $pointsToProduction ? '✓ Correct paths' : 'Still points to old location',
    'Update paths in public_html/index.php to use production/truant_app');

// ── 8. Try to load Laravel and catch the real error ───────────
$laravelError = null;
$laravelLoaded = false;
if (file_exists($laravelRoot . '/vendor/autoload.php') && file_exists($laravelRoot . '/.env')) {
    try {
        ob_start();
        require_once $laravelRoot . '/vendor/autoload.php';
        $app = require_once $laravelRoot . '/bootstrap/app.php';
        ob_end_clean();
        $laravelLoaded = true;
    } catch (\Throwable $e) {
        ob_end_clean();
        $laravelError = get_class($e) . ': ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();
    }
}

// ── 9. .env values summary ────────────────────────────────────
$envSummary = [];
if (file_exists($laravelRoot . '/.env')) {
    $lines = explode("\n", file_get_contents($laravelRoot . '/.env'));
    $showKeys = ['APP_NAME','APP_ENV','APP_DEBUG','APP_URL','DB_CONNECTION','DB_HOST','DB_DATABASE','FILESYSTEM_DISK','FILESYSTEM_PUBLIC_ROOT','FILESYSTEM_PUBLIC_URL'];
    foreach ($lines as $line) {
        foreach ($showKeys as $k) {
            if (str_starts_with(trim($line), $k . '=')) {
                $val = substr(trim($line), strlen($k) + 1);
                // Mask passwords
                $envSummary[$k] = (str_contains(strtolower($k), 'pass') || str_contains(strtolower($k), 'secret') || $k === 'APP_KEY')
                    ? '***hidden***' : $val;
            }
        }
    }
}

$passCount = count(array_filter($checks, fn($c) => $c['pass']));
$failCount = count($checks) - $passCount;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>500 Diagnostics — Truant</title>
<style>
:root{--bg:#060d1a;--card:#0d1b2e;--border:#1a2d45;--green:#10b981;--red:#ef4444;--blue:#38bdf8;--yellow:#f59e0b;--gray:#94a3b8;--text:#f1f5f9}
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif}
body{background:var(--bg);color:var(--text);padding:24px 14px}
.wrap{max-width:900px;margin:0 auto;display:flex;flex-direction:column;gap:14px}
h1{font-size:20px;font-weight:700;color:#fff}
p.sub{font-size:12.5px;color:var(--gray);margin-top:3px}
.score{border-radius:10px;padding:13px 18px;font-size:14px;font-weight:600;display:flex;align-items:center;justify-content:space-between}
.score-ok{background:rgba(16,185,129,.13);border:1px solid var(--green);color:#6ee7b7}
.score-warn{background:rgba(245,158,11,.12);border:1px solid var(--yellow);color:#fde68a}
.score-fail{background:rgba(239,68,68,.12);border:1px solid var(--red);color:#fca5a5}
.card{background:var(--card);border:1px solid var(--border);border-radius:10px;padding:16px 20px}
.card h2{font-size:13px;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px}
.check{display:flex;align-items:flex-start;gap:10px;padding:7px 0;border-bottom:1px solid var(--border);font-size:12.5px}
.check:last-child{border-bottom:none}
.icon{font-size:14px;margin-top:1px;flex-shrink:0}
.label{color:#e2e8f0;font-weight:500;min-width:260px}
.detail{color:var(--gray);font-size:11.5px;margin-top:2px;word-break:break-all}
.fix-text{color:#fbbf24;font-size:11.5px;margin-top:3px;line-height:1.5}
.fail-group .check{background:rgba(239,68,68,.04)}
code{background:rgba(0,0,0,.5);padding:2px 6px;border-radius:4px;font-family:ui-monospace,monospace;font-size:11.5px}
pre{background:rgba(0,0,0,.5);padding:12px 16px;border-radius:7px;font-size:12px;line-height:1.6;overflow-x:auto;color:#cbd5e1;white-space:pre-wrap;word-break:break-all}
.env-grid{display:grid;grid-template-columns:200px 1fr;gap:4px 12px;font-size:12px}
.env-key{color:var(--gray)}
.env-val{color:#e2e8f0;word-break:break-all}
.terminal{background:#04090f;border:1px solid var(--border);border-radius:8px;padding:16px 20px;font-family:ui-monospace,monospace;font-size:12.5px;color:#4ade80;line-height:2}
.prompt{color:var(--blue)}
.section-label{font-size:12px;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px}
.badge{display:inline-block;padding:2px 8px;border-radius:9999px;font-size:11px;font-weight:700}
.b-ok{background:rgba(16,185,129,.2);color:#34d399}
.b-fail{background:rgba(239,68,68,.2);color:#f87171}
</style>
</head>
<body>
<div class="wrap">

<div>
  <h1>&#128680; 500 Error Diagnostics</h1>
  <p class="sub">Checking new folder structure: <code>production/truant_app</code></p>
</div>

<!-- Score -->
<div class="score <?= $failCount === 0 ? 'score-ok' : ($failCount <= 3 ? 'score-warn' : 'score-fail') ?>">
  <span><?= $failCount === 0 ? '✅ All checks passed — 500 error should be resolved' : "⚠️ {$failCount} issue(s) found — fix the red items below" ?></span>
  <span style="font-size:13px"><?= $passCount ?> / <?= count($checks) ?> passed</span>
</div>

<!-- FAILED Checks -->
<?php $failed = array_filter($checks, fn($c) => !$c['pass']); ?>
<?php if (!empty($failed)): ?>
<div class="card fail-group">
  <h2>&#10060; Failed Checks (fix these)</h2>
  <?php foreach ($failed as $c): ?>
    <div class="check">
      <span class="icon">&#10060;</span>
      <div style="flex:1">
        <div class="label"><?= htmlspecialchars($c['label']) ?></div>
        <?php if ($c['detail']): ?><div class="detail"><?= htmlspecialchars($c['detail']) ?></div><?php endif ?>
        <?php if ($c['fix']): ?><div class="fix-text">&#128736; Fix: <?= htmlspecialchars($c['fix']) ?></div><?php endif ?>
      </div>
    </div>
  <?php endforeach ?>
</div>
<?php endif ?>

<!-- PASSED Checks -->
<div class="card">
  <h2>&#9989; Passed Checks</h2>
  <?php foreach ($checks as $c): if (!$c['pass']) continue; ?>
    <div class="check">
      <span class="icon">&#9989;</span>
      <div style="flex:1">
        <div class="label"><?= htmlspecialchars($c['label']) ?></div>
        <?php if ($c['detail']): ?><div class="detail"><?= htmlspecialchars($c['detail']) ?></div><?php endif ?>
      </div>
    </div>
  <?php endforeach ?>
</div>

<!-- Laravel Bootstrap Test -->
<div class="card">
  <h2>&#9889; Laravel Bootstrap Test</h2>
  <?php if ($laravelLoaded): ?>
    <p style="color:#34d399;font-size:13px">&#9989; Laravel bootstrapped successfully — the 500 is likely a routing or .htaccess issue.</p>
  <?php elseif ($laravelError): ?>
    <p style="color:#f87171;font-size:12.5px;margin-bottom:8px">&#10060; Laravel threw an exception during bootstrap:</p>
    <pre style="color:#fca5a5"><?= htmlspecialchars($laravelError) ?></pre>
  <?php elseif (!file_exists($laravelRoot . '/vendor/autoload.php')): ?>
    <p style="color:#fbbf24;font-size:12.5px">&#9888; Skipped — <code>vendor/autoload.php</code> is missing (run composer install first).</p>
  <?php else: ?>
    <p style="color:#fbbf24;font-size:12.5px">&#9888; Could not test — .env missing.</p>
  <?php endif ?>
</div>

<!-- .env values -->
<?php if (!empty($envSummary)): ?>
<div class="card">
  <h2>&#128196; .env Values (relevant keys)</h2>
  <div class="env-grid">
  <?php foreach ($envSummary as $k => $v): ?>
    <div class="env-key"><?= htmlspecialchars($k) ?></div>
    <div class="env-val"><code><?= htmlspecialchars($v ?: '(empty)') ?></code></div>
  <?php endforeach ?>
  </div>

  <?php
  // Specific .env warnings
  if (isset($envSummary['FILESYSTEM_PUBLIC_ROOT']) && str_contains($envSummary['FILESYSTEM_PUBLIC_ROOT'], 'repositories')) {
      echo '<p style="color:#fbbf24;font-size:12px;margin-top:10px">⚠️ FILESYSTEM_PUBLIC_ROOT still points to the old <code>repositories/</code> path. Update it to <code>/home/uq7hadnu944q/public_html/storage</code></p>';
  }
  if (isset($envSummary['APP_URL']) && !str_contains($envSummary['APP_URL'], 'truantenterprises.com')) {
      echo '<p style="color:#fbbf24;font-size:12px;margin-top:8px">⚠️ APP_URL does not match truantenterprises.com</p>';
  }
  ?>
</div>
<?php endif ?>

<!-- Quick Fixes terminal commands -->
<div class="card">
  <h2>&#128196; cPanel Terminal Commands (fix all at once)</h2>
  <div class="terminal">
    <span style="color:#64748b"># Navigate to the app</span><br>
    <span class="prompt">$</span> cd /home/uq7hadnu944q/production/truant_app<br><br>
    <span style="color:#64748b"># Install dependencies (if vendor/ is missing)</span><br>
    <span class="prompt">$</span> composer install --no-dev --optimize-autoloader<br><br>
    <span style="color:#64748b"># Generate APP_KEY (if missing)</span><br>
    <span class="prompt">$</span> php artisan key:generate<br><br>
    <span style="color:#64748b"># Fix storage permissions</span><br>
    <span class="prompt">$</span> chmod -R 755 storage bootstrap/cache<br><br>
    <span style="color:#64748b"># Clear all caches</span><br>
    <span class="prompt">$</span> php artisan optimize:clear<br><br>
    <span style="color:#64748b"># Update .env FILESYSTEM path to new location</span><br>
    <span class="prompt">$</span> sed -i 's|FILESYSTEM_PUBLIC_ROOT=.*|FILESYSTEM_PUBLIC_ROOT=/home/uq7hadnu944q/public_html/storage|' .env
  </div>
</div>

<!-- .htaccess check -->
<div class="card">
  <h2>&#128196; public_html/.htaccess check</h2>
  <?php
  $ht = $webRoot . '/.htaccess';
  if (file_exists($ht)):
      $htc = file_get_contents($ht);
      $hasRewrite = str_contains($htc, 'mod_rewrite');
  ?>
    <p style="color:#34d399;font-size:12.5px;margin-bottom:8px">&#9989; .htaccess exists</p>
    <?php if (!$hasRewrite): ?>
      <p style="color:#fbbf24;font-size:12.5px;margin-bottom:8px">&#9888; mod_rewrite rules missing — add Laravel's standard .htaccess rules.</p>
    <?php endif ?>
    <pre><?= htmlspecialchars(substr($htc, 0, 800)) ?></pre>
  <?php else: ?>
    <p style="color:#f87171;font-size:12.5px">&#10060; .htaccess is MISSING from public_html/. This will cause 500 errors.</p>
    <p style="color:#94a3b8;font-size:12px;margin-top:8px">The standard Laravel .htaccess content is shown below — create this file in public_html/:</p>
    <pre>&lt;IfModule mod_rewrite.c&gt;
    &lt;IfModule mod_negotiation.c&gt;
        Options -MultiViews -Indexes
    &lt;/IfModule&gt;

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
&lt;/IfModule&gt;</pre>
  <?php endif ?>
</div>

<div style="background:rgba(239,68,68,.09);border:1px solid rgba(239,68,68,.35);border-radius:9px;padding:14px 17px;font-size:12px;color:#fca5a5">
  <strong>&#9888;&#65039; Security:</strong> Delete <code>public_html/debug500.php</code> after resolving the 500 error.
</div>

</div>
</body>
</html>
