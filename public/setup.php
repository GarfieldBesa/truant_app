<?php
/**
 * ============================================================
 *  Truant Enterprises — Production Setup Script
 * ============================================================
 *  Upload to: public_html/setup.php
 *  Visit:     https://truantenterprises.com/setup.php
 *  DELETE after setup is complete.
 *
 *  Fixes:
 *  1. Creates .env from old location or .env.example
 *  2. Generates APP_KEY
 *  3. Creates all required storage directories
 *  4. Runs composer install
 *  5. Clears caches
 * ============================================================
 */

declare(strict_types=1);
set_time_limit(300); // composer install can take a while
error_reporting(E_ALL);
ini_set('display_errors', '0');

$log = [];
function step(string $type, string $title, string $body = ''): void {
    global $log; $log[] = compact('type','title','body');
}

function sh(string $cmd): array {
    $out = ''; $code = -1;
    @putenv('HOME=/home/uq7hadnu944q');
    @putenv('COMPOSER_HOME=/home/uq7hadnu944q/.composer');
    $_ENV['HOME'] = '/home/uq7hadnu944q';
    $_ENV['COMPOSER_HOME'] = '/home/uq7hadnu944q/.composer';

    $fullCmd = 'export HOME=/home/uq7hadnu944q; export COMPOSER_HOME=/home/uq7hadnu944q/.composer; ' . $cmd . ' 2>&1';
    if (function_exists('exec')) {
        @exec($fullCmd, $lines, $code);
        $out = implode("\n", $lines);
    } elseif (function_exists('shell_exec')) {
        $out = (string)@shell_exec($fullCmd); $code = 0;
    }
    return ['out' => trim($out), 'code' => $code];
}

// ── Known paths ───────────────────────────────────────────────
$webRoot     = '/home/uq7hadnu944q/public_html';
$newRoot     = '/home/uq7hadnu944q/production/truant_app';
$oldRoot     = '/home/uq7hadnu944q/repositories/truant_app'; // previous location
$pubStorage  = $webRoot . '/storage';

// ============================================================
//  STEP 1: CREATE .env
// ============================================================
$envTarget  = $newRoot . '/.env';
$envCreated = false;

if (file_exists($envTarget)) {
    step('info', '.env already exists', "<code>{$envTarget}</code>");
} else {
    // Try copying from old location first
    $envSource = null;
    if (file_exists($oldRoot . '/.env')) {
        $envSource = $oldRoot . '/.env';
    } elseif (file_exists($newRoot . '/.env.example')) {
        $envSource = $newRoot . '/.env.example';
    } elseif (file_exists($oldRoot . '/.env.example')) {
        $envSource = $oldRoot . '/.env.example';
    }

    if ($envSource && @copy($envSource, $envTarget)) {
        @chmod($envTarget, 0644);
        $envCreated = true;
        $sourceLabel = str_contains($envSource, '.env.example') ? '.env.example' : 'old .env';
        step('success', ".env created from {$sourceLabel}", "<code>{$envSource}</code> &rarr; <code>{$envTarget}</code>");
    } else {
        // Create a minimal .env from scratch
        $minimalEnv = <<<ENV
APP_NAME="Truant Enterprises"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://truantenterprises.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

FILESYSTEM_DISK=public
FILESYSTEM_PUBLIC_ROOT=/home/uq7hadnu944q/public_html/storage
FILESYSTEM_PUBLIC_URL=/storage
ENV;
        if (@file_put_contents($envTarget, $minimalEnv) !== false) {
            @chmod($envTarget, 0644);
            $envCreated = true;
            step('warning', '.env created with minimal defaults — FILL IN DB CREDENTIALS!',
                "Edit <code>{$envTarget}</code> in cPanel File Manager to add your database name, username, and password.");
        } else {
            step('danger', 'Could not create .env',
                "Manually create <code>{$newRoot}/.env</code> in cPanel File Manager.");
        }
    }
}

// ============================================================
//  STEP 2: FIX .env VALUES for new folder structure
// ============================================================
if (file_exists($envTarget) && is_writable($envTarget)) {
    $env = file_get_contents($envTarget);
    $changed = false;

    // APP_URL
    if (!preg_match('/^APP_URL=https:\/\/truantenterprises\.com\s*$/m', $env)) {
        $env = preg_match('/^APP_URL=/m', $env)
             ? preg_replace('/^APP_URL=.*$/m', 'APP_URL=https://truantenterprises.com', $env)
             : $env . "\nAPP_URL=https://truantenterprises.com\n";
        $changed = true;
    }

    // APP_ENV → production
    if (preg_match('/^APP_ENV=local\s*$/m', $env)) {
        $env = preg_replace('/^APP_ENV=.*$/m', 'APP_ENV=production', $env);
        $changed = true;
    }

    // APP_DEBUG → false in production
    if (preg_match('/^APP_DEBUG=true\s*$/m', $env)) {
        $env = preg_replace('/^APP_DEBUG=.*$/m', 'APP_DEBUG=false', $env);
        $changed = true;
    }

    // FILESYSTEM_PUBLIC_ROOT → new public_html/storage
    $desiredFSRoot = $pubStorage;
    if (!preg_match('/^FILESYSTEM_PUBLIC_ROOT=' . preg_quote($desiredFSRoot, '/') . '\s*$/m', $env)) {
        if (preg_match('/^FILESYSTEM_PUBLIC_ROOT=/m', $env)) {
            $env = preg_replace('/^FILESYSTEM_PUBLIC_ROOT=.*$/m', "FILESYSTEM_PUBLIC_ROOT={$desiredFSRoot}", $env);
        } else {
            $env .= "\nFILESYSTEM_PUBLIC_ROOT={$desiredFSRoot}\nFILESYSTEM_PUBLIC_URL=/storage\n";
        }
        $changed = true;
    }

    // FILESYSTEM_PUBLIC_URL
    if (!preg_match('/^FILESYSTEM_PUBLIC_URL=\/storage\s*$/m', $env)) {
        if (preg_match('/^FILESYSTEM_PUBLIC_URL=/m', $env)) {
            $env = preg_replace('/^FILESYSTEM_PUBLIC_URL=.*$/m', 'FILESYSTEM_PUBLIC_URL=/storage', $env);
        } else {
            $env .= "FILESYSTEM_PUBLIC_URL=/storage\n";
        }
        $changed = true;
    }

    if ($changed) {
        file_put_contents($envTarget, $env);
        step('success', '.env values updated',
            "<code>APP_URL</code>, <code>APP_ENV</code>, <code>FILESYSTEM_PUBLIC_ROOT</code> set correctly.");
    } else {
        step('info', '.env values already correct', '');
    }
}

// ============================================================
//  STEP 3: CREATE STORAGE DIRECTORY STRUCTURE
// ============================================================
$storageDirs = [
    $newRoot . '/storage',
    $newRoot . '/storage/app',
    $newRoot . '/storage/app/public',
    $newRoot . '/storage/app/public/events',
    $newRoot . '/storage/app/public/events/banners',
    $newRoot . '/storage/app/public/events/form-banners',
    $newRoot . '/storage/app/public/events/registrations',
    $newRoot . '/storage/app/livewire-tmp',
    $newRoot . '/storage/app/private',
    $newRoot . '/storage/framework',
    $newRoot . '/storage/framework/cache',
    $newRoot . '/storage/framework/cache/data',
    $newRoot . '/storage/framework/sessions',
    $newRoot . '/storage/framework/views',
    $newRoot . '/storage/logs',
    $newRoot . '/bootstrap/cache',
    // public_html/storage directories
    $pubStorage,
    $pubStorage . '/events',
    $pubStorage . '/events/banners',
    $pubStorage . '/events/form-banners',
    $pubStorage . '/events/registrations',
    $pubStorage . '/livewire-tmp',
];

$created = 0; $existing = 0;
foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        if (@mkdir($dir, 0755, true)) $created++;
    } else {
        @chmod($dir, 0755); $existing++;
    }
}
step('success', "Storage directories ready ({$created} created, {$existing} already existed)", '');

// ============================================================
//  STEP 4: COPY FILES from old storage → new storage + public_html/storage
// ============================================================
$oldInternal = $oldRoot . '/storage/app/public';
$newInternal = $newRoot . '/storage/app/public';
$copiedFiles = 0;

if (is_dir($oldInternal)) {
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($oldInternal, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($it as $item) {
        $rel  = $it->getSubPathName();
        // Copy to new internal storage
        $dest1 = $newInternal . '/' . str_replace('\\','/',$rel);
        // Copy to public_html/storage
        $dest2 = $pubStorage . '/' . str_replace('\\','/',$rel);

        if ($item->isDir()) {
            if (!is_dir($dest1)) @mkdir($dest1, 0755, true);
            if (!is_dir($dest2)) @mkdir($dest2, 0755, true);
        } else {
            foreach ([$dest1, $dest2] as $dest) {
                if (!is_dir(dirname($dest))) @mkdir(dirname($dest), 0755, true);
                if (!file_exists($dest) || filesize($item->getPathname()) !== filesize($dest)) {
                    if (@copy($item->getPathname(), $dest)) { @chmod($dest, 0644); $copiedFiles++; }
                }
            }
        }
    }
    step('success', "Migrated {$copiedFiles} file(s) from old storage to new locations",
        "Copied from <code>{$oldInternal}</code> → new internal storage + <code>{$pubStorage}</code>");
} else {
    step('info', 'No old storage files to migrate', "Old path <code>{$oldInternal}</code> not found.");
}

// ============================================================
//  STEP 5: COMPOSER INSTALL
// ============================================================
$vendorExists = file_exists($newRoot . '/vendor/autoload.php');

if ($vendorExists) {
    step('info', 'vendor/ already exists — skipping composer install', '');
} else {
    step('info', 'Running composer install (this may take 60–120 seconds)…', '');

    // Set environment variables for composer
    putenv('HOME=/home/uq7hadnu944q');
    putenv('COMPOSER_HOME=/home/uq7hadnu944q/.composer');
    $_ENV['HOME'] = '/home/uq7hadnu944q';
    $_ENV['COMPOSER_HOME'] = '/home/uq7hadnu944q/.composer';

    // Find composer binary
    $composerPaths = [
        '/usr/local/bin/composer',
        '/usr/bin/composer',
        '/home/uq7hadnu944q/bin/composer',
        'composer',
    ];
    $composerBin = null;
    foreach ($composerPaths as $cp) {
        $test = sh("which {$cp}");
        if ($test['code'] === 0 && !empty($test['out'])) { $composerBin = trim($test['out']); break; }
        if (file_exists($cp)) { $composerBin = $cp; break; }
    }

    $composerSuccess = false;
    $outputLog = '';

    if ($composerBin) {
        $composerResult = sh("{$composerBin} install --no-dev --optimize-autoloader --no-interaction --working-dir=" . escapeshellarg($newRoot));
        $outputLog = $composerResult['out'];
        if ($composerResult['code'] === 0 || file_exists($newRoot . '/vendor/autoload.php')) {
            $composerSuccess = true;
            step('success', 'composer install completed successfully via system composer',
                "<pre style='font-size:11px'>" . htmlspecialchars(substr($outputLog, -2000)) . "</pre>");
        }
    }

    // Try downloading composer.phar if system composer missing or failed
    if (!$composerSuccess && !file_exists($newRoot . '/vendor/autoload.php')) {
        step('info', 'Attempting composer.phar download & execution…', '');
        $pharFile = $newRoot . '/composer.phar';
        if (!file_exists($pharFile)) {
            $pharData = @file_get_contents('https://getcomposer.org/composer.phar');
            if ($pharData) {
                file_put_contents($pharFile, $pharData);
                @chmod($pharFile, 0755);
            }
        }
        if (file_exists($pharFile)) {
            $pharResult = sh("php " . escapeshellarg($pharFile) . " install --no-dev --optimize-autoloader --no-interaction --working-dir=" . escapeshellarg($newRoot));
            $outputLog .= "\n\n--- composer.phar run ---\n" . $pharResult['out'];
            if ($pharResult['code'] === 0 || file_exists($newRoot . '/vendor/autoload.php')) {
                $composerSuccess = true;
                step('success', 'composer install completed via composer.phar',
                    "<pre style='font-size:11px'>" . htmlspecialchars(substr($pharResult['out'], -2000)) . "</pre>");
            }
        }
    }

    // Fallback: Copy vendor directory from old location if present
    if (!file_exists($newRoot . '/vendor/autoload.php')) {
        $oldVendor = $oldRoot . '/vendor';
        if (is_dir($oldVendor) && file_exists($oldVendor . '/autoload.php')) {
            step('info', 'Copying existing vendor directory from old location as fallback…', '');
            $newVendor = $newRoot . '/vendor';
            if (!is_dir($newVendor)) @mkdir($newVendor, 0755, true);

            $it = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($oldVendor, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );
            $copiedVendorFiles = 0;
            foreach ($it as $item) {
                $target = $newVendor . '/' . $it->getSubPathName();
                if ($item->isDir()) {
                    if (!is_dir($target)) @mkdir($target, 0755, true);
                } else {
                    if (!file_exists($target) || filesize($item->getPathname()) !== filesize($target)) {
                        if (@copy($item->getPathname(), $target)) $copiedVendorFiles++;
                    }
                }
            }
            if (file_exists($newVendor . '/autoload.php')) {
                $composerSuccess = true;
                step('success', 'vendor/ copied from previous location',
                    "Copied {$copiedVendorFiles} files from <code>{$oldVendor}</code>.");
            }
        }
    }

    if (!file_exists($newRoot . '/vendor/autoload.php')) {
        step('danger', 'composer install failed',
            "<pre style='font-size:11px;color:#fca5a5'>" . htmlspecialchars(substr($outputLog, -1500)) . "</pre>" .
            "Please upload the <code>vendor</code> folder from your local project to <code>/home/uq7hadnu944q/production/truant_app/vendor</code> using cPanel File Manager (zip & extract).");
    }
}

// ============================================================
//  STEP 6: GENERATE APP_KEY + CLEAR CACHES (via Artisan)
// ============================================================
if (file_exists($newRoot . '/vendor/autoload.php')) {
    // Check if APP_KEY is set
    $envContent = file_exists($envTarget) ? file_get_contents($envTarget) : '';
    preg_match('/^APP_KEY=(.*)$/m', $envContent, $km);
    $currentKey = trim($km[1] ?? '');

    if (empty($currentKey) || $currentKey === 'base64:') {
        try {
            require_once $newRoot . '/vendor/autoload.php';
            $app = require_once $newRoot . '/bootstrap/app.php';
            $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
            $kernel->call('key:generate', ['--force' => true]);
            step('success', 'APP_KEY generated', '<code>php artisan key:generate</code> ran successfully.');
            $kernel->call('optimize:clear');
            step('success', 'artisan optimize:clear',
                "<pre style='font-size:11.5px'>" . htmlspecialchars(trim($kernel->output())) . "</pre>");
        } catch (\Throwable $e) {
            step('warning', 'artisan key:generate failed in-process',
                htmlspecialchars($e->getMessage()) . '<br>Run manually: <code>cd ~/production/truant_app && php artisan key:generate</code>');
        }
    } else {
        // Run migrations and clear caches
        try {
            require_once $newRoot . '/vendor/autoload.php';
            $app    = require_once $newRoot . '/bootstrap/app.php';
            $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

            // Run pending database migrations
            $kernel->call('migrate', ['--force' => true]);
            step('success', 'artisan migrate --force',
                "<pre style='font-size:11.5px'>" . htmlspecialchars(trim($kernel->output())) . "</pre>");

            $kernel->call('optimize:clear');
            step('success', 'artisan optimize:clear',
                "<pre style='font-size:11.5px'>" . htmlspecialchars(trim($kernel->output())) . "</pre>");
        } catch (\Throwable $e) {
            step('warning', 'artisan migrate / optimize note', htmlspecialchars($e->getMessage()));
        }
    }

    // Clear bootstrap/cache manually as well
    $bCache = $newRoot . '/bootstrap/cache';
    $del = 0;
    foreach (['config.php','routes-v7.php','routes.php','services.php','packages.php','events.php'] as $cf) {
        if (file_exists($bCache.'/'.$cf) && @unlink($bCache.'/'.$cf)) $del++;
    }
    if ($del > 0) step('success', "Cleared {$del} bootstrap/cache file(s)", '');
} else {
    step('warning', 'Skipping artisan steps — vendor/ still missing', 'Run composer install first.');
}

// ============================================================
//  STEP 7: FINAL STATUS CHECK
// ============================================================
$finalChecks = [
    'vendor/autoload.php' => file_exists($newRoot . '/vendor/autoload.php'),
    '.env file'            => file_exists($envTarget),
    'APP_KEY set'          => (function() use ($envTarget) {
        if (!file_exists($envTarget)) return false;
        preg_match('/^APP_KEY=(.+)$/m', file_get_contents($envTarget), $m);
        return !empty(trim($m[1] ?? '')) && str_starts_with(trim($m[1]), 'base64:');
    })(),
    'storage/ writable'    => is_writable($newRoot . '/storage'),
    'bootstrap/cache/ writable' => is_writable($newRoot . '/bootstrap/cache'),
    'public_html/storage/ exists' => is_dir($pubStorage),
];

$allGood = !in_array(false, $finalChecks, true);
$failCount = count(array_filter($finalChecks, fn($v) => !$v));

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Setup — Truant</title>
<style>
:root{--bg:#060d1a;--card:#0d1b2e;--border:#1a2d45;--green:#10b981;--red:#ef4444;--blue:#38bdf8;--yellow:#f59e0b;--gray:#94a3b8;--text:#f1f5f9}
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif}
body{background:var(--bg);color:var(--text);padding:24px 14px}
.wrap{max-width:860px;margin:0 auto;display:flex;flex-direction:column;gap:13px}
h1{font-size:20px;font-weight:700;color:#fff}
p.sub{font-size:12.5px;color:var(--gray);margin-top:3px}
.banner{border-radius:10px;padding:13px 18px;font-size:13.5px;font-weight:600}
.b-ok{background:rgba(16,185,129,.13);border:1px solid var(--green);color:#6ee7b7}
.b-fail{background:rgba(239,68,68,.12);border:1px solid var(--red);color:#fca5a5}
.b-warn{background:rgba(245,158,11,.11);border:1px solid var(--yellow);color:#fde68a}
.card{background:var(--card);border:1px solid var(--border);border-radius:10px;padding:15px 19px}
.card h2{font-size:12.5px;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.5px;margin-bottom:11px}
.log{display:flex;flex-direction:column;gap:8px}
.entry{border-radius:8px;padding:11px 15px;border-left:4px solid}
.entry-success{border-color:var(--green);background:rgba(16,185,129,.07)}
.entry-info{border-color:var(--blue);background:rgba(56,189,248,.07)}
.entry-warning{border-color:var(--yellow);background:rgba(245,158,11,.07)}
.entry-danger{border-color:var(--red);background:rgba(239,68,68,.07)}
.entry strong{color:#fff;font-size:13px;display:block;margin-bottom:3px}
.body{font-size:12px;color:var(--gray);line-height:1.6}
code{background:rgba(0,0,0,.5);padding:2px 6px;border-radius:4px;font-family:ui-monospace,monospace;font-size:11.5px}
pre{background:rgba(0,0,0,.5);padding:10px 13px;border-radius:6px;font-size:11.5px;line-height:1.5;overflow-x:auto;color:#cbd5e1;white-space:pre-wrap;word-break:break-all;max-height:250px}
.check-row{display:flex;align-items:center;gap:10px;padding:6px 0;border-bottom:1px solid var(--border);font-size:12.5px}
.check-row:last-child{border-bottom:none}
.terminal{background:#04090f;border:1px solid var(--border);border-radius:8px;padding:15px 19px;font-family:ui-monospace,monospace;font-size:12.5px;color:#4ade80;line-height:2}
.prompt{color:var(--blue)}
</style>
</head>
<body>
<div class="wrap">
  <div>
    <h1>&#9881;&#65039; Production Setup</h1>
    <p class="sub">Setting up <code>production/truant_app</code> — fixing all critical issues automatically.</p>
  </div>

  <div class="banner <?= $allGood ? 'b-ok' : ($failCount <= 2 ? 'b-warn' : 'b-fail') ?>">
    <?php if ($allGood): ?>
      &#9989; All set! Visit <a href="/" style="color:inherit;font-weight:700">https://truantenterprises.com</a> — the 500 error should be gone.
    <?php else: ?>
      &#9888; <?= $failCount ?> item(s) still need attention — see below. You may need to run composer via cPanel Terminal.
    <?php endif ?>
  </div>

  <div class="log">
    <?php foreach ($log as $l): ?>
      <div class="entry entry-<?= htmlspecialchars($l['type']) ?>">
        <strong><?= htmlspecialchars($l['title']) ?></strong>
        <?php if ($l['body']): ?><div class="body"><?= $l['body'] ?></div><?php endif ?>
      </div>
    <?php endforeach ?>
  </div>

  <!-- Final status -->
  <div class="card">
    <h2>&#128203; Final Status</h2>
    <?php foreach ($finalChecks as $label => $pass): ?>
      <div class="check-row">
        <span><?= $pass ? '&#9989;' : '&#10060;' ?></span>
        <span style="color:<?= $pass ? '#34d399' : '#f87171' ?>;font-weight:500"><?= htmlspecialchars($label) ?></span>
      </div>
    <?php endforeach ?>
  </div>

  <!-- If composer still missing -->
  <?php if (!file_exists($newRoot . '/vendor/autoload.php')): ?>
  <div class="card">
    <h2>&#128187; composer install — Run in cPanel Terminal</h2>
    <p style="font-size:12.5px;color:var(--gray);margin-bottom:10px">
      PHP <code>exec()</code> may be blocked. Use <strong>cPanel &rarr; Advanced &rarr; Terminal</strong>:
    </p>
    <div class="terminal">
      <span class="prompt">$</span> cd /home/uq7hadnu944q/production/truant_app<br>
      <span class="prompt">$</span> composer install --no-dev --optimize-autoloader<br>
      <span class="prompt">$</span> php artisan key:generate<br>
      <span class="prompt">$</span> php artisan optimize:clear<br>
      <span class="prompt">$</span> chmod -R 755 storage bootstrap/cache
    </div>
    <p style="font-size:12px;color:var(--gray);margin-top:10px">
      After running these, <strong>reload this page</strong> to re-run the setup checks.
    </p>
  </div>
  <?php endif ?>

  <!-- DB credentials reminder -->
  <?php
  $dbSet = false;
  if (file_exists($envTarget)) {
      preg_match('/^DB_DATABASE=(.+)$/m', file_get_contents($envTarget), $dbm);
      $dbSet = !empty(trim($dbm[1] ?? ''));
  }
  if (!$dbSet): ?>
  <div class="card">
    <h2>&#128196; Database Credentials — Update .env</h2>
    <p style="font-size:12.5px;color:#fbbf24;margin-bottom:10px">
      &#9888; <code>DB_DATABASE</code> is empty. Edit <code>production/truant_app/.env</code> in cPanel File Manager:
    </p>
    <div class="terminal">
      DB_CONNECTION=mysql<br>
      DB_HOST=localhost<br>
      DB_PORT=3306<br>
      DB_DATABASE=<span style="color:#fbbf24">your_database_name</span><br>
      DB_USERNAME=<span style="color:#fbbf24">your_db_username</span><br>
      DB_PASSWORD=<span style="color:#fbbf24">your_db_password</span>
    </div>
    <p style="font-size:12px;color:var(--gray);margin-top:8px">
      Find your DB credentials in <strong>cPanel &rarr; MySQL Databases</strong>.
      After saving, reload this page.
    </p>
  </div>
  <?php endif ?>

  <div style="background:rgba(239,68,68,.09);border:1px solid rgba(239,68,68,.35);border-radius:9px;padding:13px 17px;font-size:12px;color:#fca5a5">
    <strong>&#9888;&#65039; Security:</strong> Delete <code>public_html/setup.php</code> and <code>public_html/debug500.php</code> once the site is working.
  </div>
</div>
</body>
</html>
