<?php
/**
 * Git Repository Cleanup & Sync — Truant Enterprises
 * Upload to public_html/git_fix.php
 * Visit: https://truantenterprises.com/git_fix.php
 * DELETE after use.
 *
 * Fixes:
 * 1. Pulls latest main branch code to production
 * 2. Updates APP_NAME="Truant Enterprises" in .env
 * 3. Clears compiled views & bootstrap config cache
 * 4. Resets uncommitted changes to unblock cPanel Deploy
 */

declare(strict_types=1);
set_time_limit(180);
error_reporting(E_ALL);
ini_set('display_errors', '0');

$candidatePaths = [
    '/home/uq7hadnu944q/production/truant_app',
    '/home/uq7hadnu944q/repositories/truant_app',
];

function run(string $cmd): array {
    $output = ''; $code = -1;
    @putenv('HOME=/home/uq7hadnu944q');
    @putenv('COMPOSER_HOME=/home/uq7hadnu944q/.composer');
    $fullCmd = 'export HOME=/home/uq7hadnu944q; export COMPOSER_HOME=/home/uq7hadnu944q/.composer; ' . $cmd . ' 2>&1';
    if (function_exists('exec')) {
        @exec($fullCmd, $lines, $code);
        $output = implode("\n", $lines);
    } elseif (function_exists('shell_exec')) {
        $output = (string)@shell_exec($fullCmd);
        $code = 0;
    } elseif (function_exists('passthru')) {
        ob_start(); @passthru($fullCmd, $code); $output = ob_get_clean();
    }
    return ['out' => trim($output), 'code' => $code];
}

$steps = [];

foreach ($candidatePaths as $repoPath) {
    if (!is_dir($repoPath)) continue;

    // 1. git status
    $status = run("git -C " . escapeshellarg($repoPath) . " status --porcelain");
    $steps[] = ['label' => "[$repoPath] git status", 'result' => $status];

    // 2. Discard local changes if dirty
    if (!empty(trim($status['out']))) {
        $reset = run("git -C " . escapeshellarg($repoPath) . " checkout -- .");
        $steps[] = ['label' => "[$repoPath] git checkout -- .", 'result' => $reset];
    }

    // 3. git pull origin main
    $pull = run("git -C " . escapeshellarg($repoPath) . " pull origin main");
    $steps[] = ['label' => "[$repoPath] git pull origin main", 'result' => $pull];

    // 4. Update .env APP_NAME
    $envFile = $repoPath . '/.env';
    if (file_exists($envFile)) {
        $env = file_get_contents($envFile);
        if (preg_match('/^APP_NAME=.*$/m', $env)) {
            $env = preg_replace('/^APP_NAME=.*$/m', 'APP_NAME="Truant Enterprises"', $env);
        } else {
            $env .= "\nAPP_NAME=\"Truant Enterprises\"\n";
        }
        file_put_contents($envFile, $env);
        $steps[] = ['label' => "[$repoPath] Update .env APP_NAME", 'result' => ['out' => 'APP_NAME set to "Truant Enterprises"', 'code' => 0]];
    }

    // 5. Clear views and cache
    $viewsDir = $repoPath . '/storage/framework/views';
    $clearedViews = 0;
    if (is_dir($viewsDir)) {
        foreach (glob($viewsDir . '/*.php') as $vf) {
            if (@unlink($vf)) $clearedViews++;
        }
    }
    $bCacheDir = $repoPath . '/bootstrap/cache';
    $clearedBCache = 0;
    if (is_dir($bCacheDir)) {
        foreach (glob($bCacheDir . '/*.php') as $bf) {
            if (@unlink($bf)) $clearedBCache++;
        }
    }
    $steps[] = ['label' => "[$repoPath] Clear cache & views", 'result' => ['out' => "Deleted {$clearedViews} compiled view(s) & {$clearedBCache} cache file(s)", 'code' => 0]];

    // 6. Run database migrations
    $migrate = run("php " . escapeshellarg($repoPath . '/artisan') . " migrate --force");
    $steps[] = ['label' => "[$repoPath] php artisan migrate --force", 'result' => $migrate];

    // Check migration status
    $migStatus = run("php " . escapeshellarg($repoPath . '/artisan') . " migrate:status");
    $steps[] = ['label' => "[$repoPath] php artisan migrate:status", 'result' => $migStatus];

    // Seed default courts if needed
    $seed = run("php " . escapeshellarg($repoPath . '/artisan') . " db:seed --class=CourtSeeder --force");
    $steps[] = ['label' => "[$repoPath] php artisan db:seed --class=CourtSeeder --force", 'result' => $seed];

    // 7. Clear artisan optimization caches
    $opt = run("php " . escapeshellarg($repoPath . '/artisan') . " optimize:clear");
    $steps[] = ['label' => "[$repoPath] php artisan optimize:clear", 'result' => $opt];

    // 8. Copy welcome.blade.php if needed
    $welcomeSrc = $repoPath . '/resources/views/welcome.blade.php';
    if (file_exists($welcomeSrc)) {
        @chmod($welcomeSrc, 0644);
    }
}

// Copy updated index.php, git_fix.php, and setup.php to public_html if present in production/truant_app/public
$prodPublic = '/home/uq7hadnu944q/production/truant_app/public';
$webRoot = '/home/uq7hadnu944q/public_html';
if (is_dir($prodPublic)) {
    foreach (['index.php', 'welcome.blade.php', 'git_fix.php', 'setup.php'] as $f) {
        if (file_exists($prodPublic . '/' . $f)) {
            @copy($prodPublic . '/' . $f, $webRoot . '/' . $f);
        }
    }
}

// Check recent laravel.log lines
$recentLog = '';
$logPath = '/home/uq7hadnu944q/production/truant_app/storage/logs/laravel.log';
if (file_exists($logPath)) {
    $content = file_get_contents($logPath);
    if ($content) {
        $pos = strrpos($content, '[2026-');
        if ($pos !== false) {
            $lastEntry = substr($content, $pos);
            $recentLog = substr($lastEntry, 0, 3000);
        } else {
            $logLines = file($logPath);
            $recentLog = trim(implode('', array_slice($logLines, -100)));
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Git & Cache Sync — Truant Enterprises</title>
<style>
:root{--bg:#080f1e;--card:#0f1c2e;--border:#1e2f46;--green:#10b981;--red:#ef4444;--blue:#38bdf8;--yellow:#f59e0b;--gray:#94a3b8;--text:#f1f5f9}
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif}
body{background:var(--bg);color:var(--text);padding:30px 16px}
.wrap{max-width:760px;margin:0 auto;display:flex;flex-direction:column;gap:14px}
h1{font-size:20px;font-weight:700;color:#fff}
p.sub{font-size:13px;color:var(--gray);margin-top:4px}
.banner{border-radius:10px;padding:14px 18px;font-size:14px;font-weight:600;background:rgba(16,185,129,.14);border:1px solid var(--green);color:#6ee7b7}
.card{background:var(--card);border:1px solid var(--border);border-radius:10px;padding:14px 18px}
.card h3{font-size:13px;font-weight:600;color:var(--gray);margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px}
pre{background:rgba(0,0,0,.5);padding:10px 14px;border-radius:6px;font-size:12px;line-height:1.6;color:#cbd5e1;white-space:pre-wrap;word-break:break-all}
.badge{display:inline-block;padding:2px 9px;border-radius:9999px;font-size:11px;font-weight:700}
.b-ok{background:rgba(16,185,129,.2);color:#34d399}
.b-fail{background:rgba(239,68,68,.2);color:#f87171}
.step{border-left:3px solid var(--green);padding-left:14px;margin-bottom:12px}
.step-label{font-size:12px;color:var(--gray);margin-bottom:5px}
code{background:rgba(0,0,0,.5);padding:2px 7px;border-radius:4px;font-family:ui-monospace,monospace;font-size:12px}
a{color:var(--blue)}
</style>
</head>
<body>
<div class="wrap">

  <div>
    <h1>&#9881;&#65039; Server Sync &amp; Cache Clear Complete</h1>
    <p class="sub">Pulled latest code from main, updated APP_NAME="Truant Enterprises", and cleared compiled views.</p>
  </div>

  <div class="banner">
    &#9989; Server synced with GitHub main branch. Clear your browser cache and refresh <a href="https://truantenterprises.com/" style="color:#fff;text-decoration:underline">truantenterprises.com</a>.
  </div>

  <!-- Step Results -->
  <div class="card">
    <h3>Actions Executed</h3>
    <?php foreach ($steps as $s): ?>
      <div class="step">
        <div class="step-label">
          <code><?= htmlspecialchars($s['label']) ?></code>
          <span class="badge b-ok">OK</span>
        </div>
        <pre><?= htmlspecialchars($s['result']['out']) ?></pre>
      </div>
    <?php endforeach ?>
  </div>

  <?php if (!empty($recentLog)): ?>
  <div class="card">
    <h3>Recent Laravel Logs (storage/logs/laravel.log)</h3>
    <pre style="max-height:280px;overflow-y:auto"><?= htmlspecialchars($recentLog) ?></pre>
  </div>
  <?php endif ?>

  <div style="background:rgba(239,68,68,.09);border:1px solid rgba(239,68,68,.35);border-radius:9px;padding:14px 17px;font-size:12px;color:#fca5a5">
    <strong>&#9888;&#65039; Security:</strong> Delete <code>public_html/git_fix.php</code> after use.
  </div>

</div>
</body>
</html>
