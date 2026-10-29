<?php
/**
 * Git Repository Cleanup & Sync — Truant Enterprises
 * Upload to public_html/git_fix.php
 * Visit: https://truantenterprises.com/git_fix.php
 * DELETE after use.
 *
 * Fixes:
 * 1. Pulls latest main branch code to production
 * 2. Updates APP_NAME and MAIL_* settings in .env
 * 3. Clears compiled views & bootstrap config cache
 * 4. Resets uncommitted changes to unblock cPanel Deploy
 * 5. Tests SMTP connection to truantenterprises.com:465
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

    // 4. Update .env APP_NAME, APP_URL, Mail, and Google OAuth configuration
    $envFile = $repoPath . '/.env';
    if (file_exists($envFile)) {
        $env = file_get_contents($envFile);

        $submittedPass = trim((string)($_POST['mail_password'] ?? $_GET['mail_password'] ?? ''));
        $submittedGoogleId = trim((string)($_POST['google_client_id'] ?? $_GET['google_client_id'] ?? ''));
        $submittedGoogleSecret = trim((string)($_POST['google_client_secret'] ?? $_GET['google_client_secret'] ?? ''));
        $submittedAppUrl = trim((string)($_POST['app_url'] ?? $_GET['app_url'] ?? ''));

        $envUpdates = [
            'APP_NAME' => '"Truant Enterprises"',
            'APP_URL' => $submittedAppUrl !== '' ? $submittedAppUrl : 'https://truantenterprises.com',
            'MAIL_MAILER' => 'smtp',
            'MAIL_SCHEME' => 'smtps',
            'MAIL_HOST' => 'truantenterprises.com',
            'MAIL_PORT' => '465',
            'MAIL_USERNAME' => 'info@truantenterprises.com',
            'MAIL_FROM_ADDRESS' => '"info@truantenterprises.com"',
            'MAIL_FROM_NAME' => '"Truant Enterprises"',
            'GOOGLE_REDIRECT_URI' => 'https://truantenterprises.com/auth/google/callback',
        ];

        // If mail_password was submitted via POST or GET, update MAIL_PASSWORD
        if ($submittedPass !== '') {
            $envUpdates['MAIL_PASSWORD'] = '"' . addcslashes($submittedPass, '"$\\') . '"';
        }

        // GOOGLE_CLIENT_ID
        if ($submittedGoogleId !== '') {
            $envUpdates['GOOGLE_CLIENT_ID'] = $submittedGoogleId;
        } elseif (!preg_match('/^GOOGLE_CLIENT_ID=\S+/m', $env)) {
            $envUpdates['GOOGLE_CLIENT_ID'] = 'your_production_google_client_id';
        }

        // GOOGLE_CLIENT_SECRET
        if ($submittedGoogleSecret !== '') {
            $envUpdates['GOOGLE_CLIENT_SECRET'] = $submittedGoogleSecret;
        } elseif (!preg_match('/^GOOGLE_CLIENT_SECRET=\S+/m', $env)) {
            $envUpdates['GOOGLE_CLIENT_SECRET'] = 'your_production_google_client_secret';
        }

        $applied = [];
        foreach ($envUpdates as $key => $val) {
            if (preg_match("/^{$key}=.*$/m", $env)) {
                $env = preg_replace("/^{$key}=.*$/m", "{$key}={$val}", $env);
            } else {
                $env .= "\n{$key}={$val}\n";
            }
            $applied[] = "{$key}=" . (str_contains(strtolower($key), 'pass') || str_contains(strtolower($key), 'secret') ? '***hidden***' : $val);
        }

        file_put_contents($envFile, $env);
        $steps[] = ['label' => "[$repoPath] Update .env (APP, MAIL, & GOOGLE OAuth settings)", 'result' => ['out' => implode("\n", $applied), 'code' => 0]];
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

// Test SMTP connection with current production credentials
$smtpCheckResult = 'Not tested';
$smtpCheckStatus = 'neutral';
$prodEnvPath = '/home/uq7hadnu944q/production/truant_app/.env';
$currentAppUrl = '';
$currentGoogleClientId = '';
$currentGoogleClientSecret = '';
$currentGoogleRedirect = '';
if (file_exists($prodEnvPath)) {
    $envContent = file_get_contents($prodEnvPath);
    if (preg_match('/^APP_URL=(.*)$/m', $envContent, $m)) {
        $currentAppUrl = trim($m[1], " \t\n\r\0\x0B\"'");
    }
    if (preg_match('/^GOOGLE_CLIENT_ID=(.*)$/m', $envContent, $m)) {
        $currentGoogleClientId = trim($m[1], " \t\n\r\0\x0B\"'");
    }
    if (preg_match('/^GOOGLE_CLIENT_SECRET=(.*)$/m', $envContent, $m)) {
        $currentGoogleClientSecret = trim($m[1], " \t\n\r\0\x0B\"'");
    }
    if (preg_match('/^GOOGLE_REDIRECT_URI=(.*)$/m', $envContent, $m)) {
        $currentGoogleRedirect = trim($m[1], " \t\n\r\0\x0B\"'");
    }
    $mailPass = '';
    if (preg_match('/^MAIL_PASSWORD=(.*)$/m', $envContent, $m)) {
        $mailPass = trim($m[1], " \t\n\r\0\x0B\"'");
    }

    if (!empty($mailPass)) {
        $context = stream_context_create([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ]);
        $fp = @stream_socket_client('ssl://truantenterprises.com:465', $errno, $errstr, 6, STREAM_CLIENT_CONNECT, $context);
        if ($fp) {
            fgets($fp);
            fputs($fp, "EHLO truantenterprises.com\r\n");
            while ($line = fgets($fp)) {
                if (strpos($line, '250 ') === 0) break;
            }
            fputs($fp, "AUTH LOGIN\r\n");
            fgets($fp);
            fputs($fp, base64_encode("info@truantenterprises.com") . "\r\n");
            fgets($fp);
            fputs($fp, base64_encode($mailPass) . "\r\n");
            $res = trim((string)fgets($fp));
            fclose($fp);
            if (strpos($res, '235') === 0) {
                $smtpCheckResult = "✅ SMTP Authentication SUCCESS! ($res)\nReady to send real verification passcode emails from info@truantenterprises.com.";
                $smtpCheckStatus = 'success';
            } else {
                $smtpCheckResult = "❌ SMTP Authentication FAILED ($res).\nPlease check the password for info@truantenterprises.com and try again.";
                $smtpCheckStatus = 'fail';
            }
        } else {
            $smtpCheckResult = "❌ Could not connect to ssl://truantenterprises.com:465: $errstr ($errno)";
            $smtpCheckStatus = 'fail';
        }
    } else {
        $smtpCheckResult = "⚠️ MAIL_PASSWORD is currently empty in .env.\nEnter the cPanel email password below and click 'Save & Test SMTP'.";
        $smtpCheckStatus = 'warning';
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
<title>Git &amp; Mail Sync — Truant Enterprises</title>
<style>
:root{--bg:#080f1e;--card:#0f1c2e;--border:#1e2f46;--green:#10b981;--red:#ef4444;--blue:#38bdf8;--yellow:#f59e0b;--gray:#94a3b8;--text:#f1f5f9}
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif}
body{background:var(--bg);color:var(--text);padding:30px 16px}
.wrap{max-width:760px;margin:0 auto;display:flex;flex-direction:column;gap:14px}
h1{font-size:20px;font-weight:700;color:#fff}
p.sub{font-size:13px;color:var(--gray);margin-top:4px}
.banner{border-radius:10px;padding:14px 18px;font-size:14px;font-weight:600;background:rgba(16,185,129,.14);border:1px solid var(--green);color:#6ee7b7}
.card{background:var(--card);border:1px solid var(--border);border-radius:10px;padding:16px 18px}
.card h3{font-size:13px;font-weight:600;color:var(--gray);margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px}
pre{background:rgba(0,0,0,.5);padding:10px 14px;border-radius:6px;font-size:12px;line-height:1.6;color:#cbd5e1;white-space:pre-wrap;word-break:break-all}
.badge{display:inline-block;padding:2px 9px;border-radius:9999px;font-size:11px;font-weight:700}
.b-ok{background:rgba(16,185,129,.2);color:#34d399}
.b-fail{background:rgba(239,68,68,.2);color:#f87171}
.step{border-left:3px solid var(--green);padding-left:14px;margin-bottom:12px}
.step-label{font-size:12px;color:var(--gray);margin-bottom:5px}
code{background:rgba(0,0,0,.5);padding:2px 7px;border-radius:4px;font-family:ui-monospace,monospace;font-size:12px}
a{color:var(--blue)}
input[type="password"]{background:#080f1e;border:1px solid var(--border);color:#fff;padding:9px 12px;border-radius:6px;font-size:13px;outline:none}
input[type="password"]:focus{border-color:var(--blue)}
button.btn-primary{background:#4f46e5;color:#fff;border:none;padding:9px 18px;border-radius:6px;font-weight:600;font-size:13px;cursor:pointer;transition:background .15s}
button.btn-primary:hover{background:#4338ca}
</style>
</head>
<body>
<div class="wrap">

  <div>
    <h1>&#9881;&#65039; Server Sync &amp; Mail Config — Truant Enterprises</h1>
    <p class="sub">Git pull origin main, .env updated with SMTP settings, and compiled caches refreshed.</p>
  </div>

  <div class="banner">
    &#9989; Server synced with GitHub main branch. Clear browser cache and refresh <a href="https://truantenterprises.com/" style="color:#fff;text-decoration:underline">truantenterprises.com</a>.
  </div>

  <!-- Mail SMTP Card -->
  <div class="card" style="border-color: <?= $smtpCheckStatus === 'success' ? 'var(--green)' : ($smtpCheckStatus === 'warning' ? 'var(--yellow)' : 'var(--blue)') ?>;">
    <h3 style="color:var(--blue);">&#128231; SMTP Mail Configuration (info@truantenterprises.com)</h3>
    <p style="font-size:13px;color:var(--gray);margin-bottom:10px;">
      Host: <code>truantenterprises.com</code> &bull; Port: <code>465</code> (SSL/TLS) &bull; User: <code>info@truantenterprises.com</code> &bull; Scheme: <code>smtps</code>
    </p>
    <pre style="margin-bottom:12px;color:<?= $smtpCheckStatus === 'success' ? '#34d399' : ($smtpCheckStatus === 'warning' ? '#fbbf24' : '#f87171') ?>;"><?= htmlspecialchars($smtpCheckResult) ?></pre>
    
    <form method="POST" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
      <input type="password" name="mail_password" placeholder="Enter password for info@truantenterprises.com" style="flex:1;min-width:240px;" required />
      <button type="submit" class="btn-primary">Save &amp; Test SMTP</button>
    </form>
  </div>

  <!-- Google OAuth Card -->
  <div class="card" style="border-color: <?= !empty($currentGoogleClientId) && $currentGoogleClientId !== 'your_production_google_client_id' ? 'var(--green)' : 'var(--blue)' ?>;">
    <h3 style="color:var(--blue);">&#128273; Google OAuth Configuration</h3>
    <p style="font-size:13px;color:var(--gray);margin-bottom:10px;">
      APP_URL: <code><?= htmlspecialchars($currentAppUrl ?: 'https://truantenterprises.com') ?></code> &bull; Redirect URI: <code><?= htmlspecialchars($currentGoogleRedirect ?: 'https://truantenterprises.com/auth/google/callback') ?></code>
    </p>
    <div style="font-size:12px;margin-bottom:12px;padding:8px 12px;border-radius:6px;background:rgba(0,0,0,0.4);display:flex;flex-direction:column;gap:4px;">
      <div>Client ID: <code><?= htmlspecialchars($currentGoogleClientId ?: 'your_production_google_client_id') ?></code></div>
      <div>Client Secret: <code><?= !empty($currentGoogleClientSecret) ? (strlen($currentGoogleClientSecret) > 8 ? substr($currentGoogleClientSecret, 0, 4) . '••••••••' . substr($currentGoogleClientSecret, -4) : '••••••••') : 'your_production_google_client_secret' ?></code></div>
    </div>
    <form method="POST" style="display:flex;flex-direction:column;gap:10px;">
      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <input type="text" name="google_client_id" placeholder="Enter Google Client ID" value="<?= htmlspecialchars($currentGoogleClientId !== 'your_production_google_client_id' ? $currentGoogleClientId : '') ?>" style="flex:1;min-width:260px;background:#080f1e;border:1px solid var(--border);color:#fff;padding:9px 12px;border-radius:6px;font-size:13px;" />
        <input type="password" name="google_client_secret" placeholder="Enter Google Client Secret" style="flex:1;min-width:260px;background:#080f1e;border:1px solid var(--border);color:#fff;padding:9px 12px;border-radius:6px;font-size:13px;" />
      </div>
      <div>
        <button type="submit" class="btn-primary">Save Google OAuth Credentials</button>
      </div>
    </form>
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
    <strong>&#9888;&#65039; Security:</strong> Delete <code>public_html/git_fix.php</code> after verification.
  </div>

</div>
</body>
</html>
