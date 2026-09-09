<?php
/**
 * ============================================================
 *  Truant Enterprises — Storage Fix (GoDaddy No-Symlink Mode)
 * ============================================================
 *  Upload to:  public_html/storage_repair.php
 *  Visit:      https://truantenterprises.com/storage_repair.php
 *
 *  ROOT CAUSE CONFIRMED:
 *  GoDaddy shared hosting Apache does NOT follow symlinks.
 *  public_html/storage IS a symlink but Apache returns 403/404
 *  for every file served through it.
 *
 *  THIS SCRIPT:
 *  1. Removes the broken symlink
 *  2. Creates a real physical folder at public_html/storage
 *  3. Copies every file from storage/app/public → public_html/storage
 *  4. Sets FILESYSTEM_PUBLIC_ROOT in .env so Laravel writes
 *     NEW uploads directly into public_html/storage (no sync needed)
 *  5. Clears config cache so the change takes effect immediately
 * ============================================================
 */

declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '0');

$log = [];
function note(string $type, string $title, string $body = ''): void {
    global $log; $log[] = compact('type','title','body');
}

/* ── Recursive copy ─────────────────────────────────────── */
function copy_tree(string $src, string $dst): array {
    $copied = []; $failed = [];
    try {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($src, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );
        foreach ($it as $item) {
            $rel  = $it->getSubPathName();
            $dest = $dst . '/' . str_replace('\\', '/', $rel);
            if ($item->isDir()) {
                if (!is_dir($dest)) @mkdir($dest, 0755, true);
            } else {
                if (!is_dir(dirname($dest))) @mkdir(dirname($dest), 0755, true);
                $srcFile = $item->getPathname();
                $needsCopy = !file_exists($dest)
                          || filesize($srcFile) !== filesize($dest);
                if ($needsCopy) {
                    if (@copy($srcFile, $dest)) {
                        @chmod($dest, 0644);
                        $copied[] = $rel;
                    } else {
                        $failed[] = $rel;
                    }
                }
            }
        }
    } catch (\Throwable $e) {
        note('warning', 'copy_tree error', htmlspecialchars($e->getMessage()));
    }
    return ['copied' => $copied, 'failed' => $failed];
}

/* ── List files ─────────────────────────────────────────── */
function list_tree(string $dir): array {
    $out = [];
    if (!is_dir($dir)) return $out;
    try {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        foreach ($it as $f) { if ($f->isFile()) $out[] = $it->getSubPathName(); }
    } catch (\Throwable $e) {}
    sort($out);
    return $out;
}

/* ── Remove directory recursively ───────────────────────── */
function remove_dir(string $dir): bool {
    if (!is_dir($dir) && !is_link($dir)) return true;
    if (is_link($dir)) return @unlink($dir);
    try {
        $it = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($it as $item) {
            $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
        }
    } catch (\Throwable $e) {}
    return @rmdir($dir);
}

// ============================================================
//  KNOWN PATHS (confirmed from diagnostics)
// ============================================================
$webRoot        = '/home/uq7hadnu944q/public_html';
$laravelRoot    = '/home/uq7hadnu944q/repositories/truant_app';
$internalPublic = $laravelRoot . '/storage/app/public';
$publicStorage  = $webRoot . '/storage';   // public_html/storage

// Safety: fall back to auto-detect if paths don't exist on this server
if (!is_dir($webRoot))     $webRoot     = realpath(__DIR__) ?: __DIR__;
if (!is_dir($laravelRoot)) {
    foreach ([
        dirname($webRoot) . '/repositories/truant_app',
        dirname($webRoot) . '/truant_app',
        dirname($webRoot) . '/my-laravel-app',
    ] as $c) {
        if (is_dir($c) && file_exists($c.'/artisan')) { $laravelRoot = realpath($c); break; }
    }
    $internalPublic = $laravelRoot . '/storage/app/public';
}
$publicStorage = $webRoot . '/storage';

note('info', 'Confirmed server paths',
    "<table style='font-size:12px;width:100%'>
     <tr><td style='color:#94a3b8;padding:2px 8px'>Web root</td><td><code>{$webRoot}</code></td></tr>
     <tr><td style='color:#94a3b8;padding:2px 8px'>Laravel root</td><td><code>{$laravelRoot}</code></td></tr>
     <tr><td style='color:#94a3b8;padding:2px 8px'>Internal storage</td><td><code>{$internalPublic}</code></td></tr>
     <tr><td style='color:#94a3b8;padding:2px 8px'>Public storage target</td><td><code>{$publicStorage}</code></td></tr>
     </table>"
);

// ============================================================
//  STEP 1: REMOVE THE SYMLINK — Replace with real folder
// ============================================================
$symlinkWasPresent = is_link($publicStorage);

if ($symlinkWasPresent) {
    $symlinkTarget = readlink($publicStorage);
    if (@unlink($publicStorage)) {
        note('success', 'Symlink removed',
            "Removed <code>public_html/storage</code> &rarr; <code>{$symlinkTarget}</code><br>
             GoDaddy Apache cannot follow symlinks on shared hosting — switching to real folder mode.");
    } else {
        note('danger', 'Could not remove symlink',
            'Try manually deleting <code>public_html/storage</code> in cPanel File Manager, then run this script again.');
    }
} elseif (is_dir($publicStorage)) {
    note('info', 'public_html/storage is already a real folder', 'No symlink to remove.');
} else {
    note('info', 'public_html/storage does not exist yet', 'Will create it now.');
}

// ============================================================
//  STEP 2: CREATE REAL FOLDERS
// ============================================================
$requiredDirs = [
    $publicStorage,
    $publicStorage . '/events',
    $publicStorage . '/events/banners',
    $publicStorage . '/events/form-banners',
    $publicStorage . '/events/registrations',
    $publicStorage . '/livewire-tmp',
];

$createdDirs = 0;
foreach ($requiredDirs as $dir) {
    if (!is_dir($dir)) {
        if (@mkdir($dir, 0755, true)) $createdDirs++;
        else note('warning', "Could not create: {$dir}", 'Check permissions on public_html.');
    } else {
        @chmod($dir, 0755);
    }
}
note('success', "Folder structure ready ({$createdDirs} created)",
    "<code>public_html/storage/events/banners</code> and subdirectories exist.");

// Also ensure internal storage dirs exist (for future Laravel writes)
if (is_dir($internalPublic)) {
    foreach (['events','events/banners','events/form-banners','events/registrations','livewire-tmp'] as $sub) {
        @mkdir($internalPublic . '/' . $sub, 0755, true);
    }
}

// ============================================================
//  STEP 3: COPY ALL FILES from storage/app/public → public_html/storage
// ============================================================
if (is_dir($internalPublic)) {
    $result = copy_tree($internalPublic, $publicStorage);
    $n = count($result['copied']);
    $f = count($result['failed']);

    if ($n > 0) {
        note('success', "{$n} file(s) copied to public_html/storage",
            implode('<br>', array_map(fn($r) => '<code>' . htmlspecialchars($r) . '</code>', $result['copied'])));
    } else {
        note('info', 'No new files to copy (all already in sync)', '');
    }

    if ($f > 0) {
        note('warning', "{$f} file(s) failed to copy — check permissions",
            implode('<br>', array_map(fn($r) => '<code>' . htmlspecialchars($r) . '</code>', $result['failed'])));
    }
} else {
    note('warning', 'storage/app/public not found',
        "Path <code>{$internalPublic}</code> does not exist. No files to copy.");
}

// ============================================================
//  STEP 4: UPDATE .env
//  Set FILESYSTEM_PUBLIC_ROOT → public_html/storage
//  so that ALL future uploads go directly there
// ============================================================
$envPath = $laravelRoot . '/.env';
if (file_exists($envPath) && is_writable($envPath)) {
    $env     = file_get_contents($envPath);
    $changed = false;

    // APP_URL
    if (!preg_match('/^APP_URL=https:\/\/truantenterprises\.com\s*$/m', $env)) {
        if (preg_match('/^APP_URL=/m', $env)) {
            $env = preg_replace('/^APP_URL=.*$/m', 'APP_URL=https://truantenterprises.com', $env);
        } else {
            $env .= "\nAPP_URL=https://truantenterprises.com\n";
        }
        $changed = true;
    }

    // FILESYSTEM_PUBLIC_ROOT = real public_html/storage path
    $desiredRoot = $publicStorage;  // /home/uq7hadnu944q/public_html/storage
    if (preg_match('/^FILESYSTEM_PUBLIC_ROOT=/m', $env)) {
        // Only update if value differs
        if (!preg_match('/^FILESYSTEM_PUBLIC_ROOT=' . preg_quote($desiredRoot, '/') . '\s*$/m', $env)) {
            $env     = preg_replace('/^FILESYSTEM_PUBLIC_ROOT=.*$/m', "FILESYSTEM_PUBLIC_ROOT={$desiredRoot}", $env);
            $changed = true;
        }
    } else {
        $env    .= "\nFILESYSTEM_PUBLIC_ROOT={$desiredRoot}\n";
        $changed = true;
    }

    // FILESYSTEM_PUBLIC_URL = /storage
    if (!preg_match('/^FILESYSTEM_PUBLIC_URL=\/storage\s*$/m', $env)) {
        if (preg_match('/^FILESYSTEM_PUBLIC_URL=/m', $env)) {
            $env = preg_replace('/^FILESYSTEM_PUBLIC_URL=.*$/m', 'FILESYSTEM_PUBLIC_URL=/storage', $env);
        } else {
            $env .= "FILESYSTEM_PUBLIC_URL=/storage\n";
        }
        $changed = true;
    }

    if ($changed) {
        file_put_contents($envPath, $env);
        note('success', '.env updated',
            "<code>FILESYSTEM_PUBLIC_ROOT={$desiredRoot}</code><br>
             <code>FILESYSTEM_PUBLIC_URL=/storage</code><br>
             <code>APP_URL=https://truantenterprises.com</code><br>
             <em>Laravel will now save new uploads directly to <code>public_html/storage</code>. No more syncing needed.</em>");
    } else {
        note('info', '.env already has correct values', '');
    }
} else {
    note('danger', '.env not writable',
        "Set permissions on <code>{$envPath}</code> to <code>644</code> in cPanel File Manager, then re-run.");
}

// ============================================================
//  STEP 5: ADD FollowSymLinks to public_html/.htaccess (bonus)
// ============================================================
$htaccess = $webRoot . '/.htaccess';
if (file_exists($htaccess) && is_writable($htaccess)) {
    $hc = file_get_contents($htaccess);
    if (!str_contains($hc, 'FollowSymLinks') && !str_contains($hc, 'SymLinksIfOwnerMatch')) {
        // Insert after <IfModule mod_rewrite.c> or at top of file
        $insert = "Options +FollowSymLinks\n";
        if (str_contains($hc, '<IfModule mod_rewrite.c>')) {
            $hc = str_replace('<IfModule mod_rewrite.c>', "<IfModule mod_rewrite.c>\n    {$insert}", $hc);
        } else {
            $hc = $insert . $hc;
        }
        file_put_contents($htaccess, $hc);
        note('info', '.htaccess: added Options +FollowSymLinks',
            'This may help if GoDaddy allows it. If it causes a 500 error, remove this line from .htaccess manually.');
    } else {
        note('info', '.htaccess already has FollowSymLinks', '');
    }
}

// ============================================================
//  STEP 6: CLEAR BOOTSTRAP CACHE
// ============================================================
$bCache  = $laravelRoot . '/bootstrap/cache';
$deleted = 0;
foreach (['config.php','routes-v7.php','routes.php','services.php','packages.php','events.php'] as $cf) {
    if (file_exists($bCache . '/' . $cf) && @unlink($bCache . '/' . $cf)) $deleted++;
}
note('success', "Cleared {$deleted} bootstrap/cache file(s)",
    'Stale compiled config removed. Laravel will rebuild on next request.');

try {
    if (file_exists($laravelRoot . '/vendor/autoload.php')) {
        require_once $laravelRoot . '/vendor/autoload.php';
        $app    = require_once $laravelRoot . '/bootstrap/app.php';
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $kernel->call('optimize:clear');
        $artOut = trim($kernel->output());
        note('success', 'artisan optimize:clear',
            "<pre style='font-size:12px;margin-top:5px;line-height:1.5'>" . htmlspecialchars($artOut) . "</pre>");
    }
} catch (\Throwable $e) {
    note('info', 'Artisan note', htmlspecialchars($e->getMessage()));
}

// ============================================================
//  STEP 7: VERIFY BROKEN IMAGE + BUILD FILE LIST
// ============================================================
$knownBroken     = '01M20Q42Y0255P0XHNV6QE10JH.jpg';
$brokenPublic    = $publicStorage . '/events/banners/' . $knownBroken;
$brokenInternal  = $internalPublic . '/events/banners/' . $knownBroken;
$existsPublic    = file_exists($brokenPublic);
$existsInternal  = is_dir($internalPublic) && file_exists($brokenInternal);

$allFiles        = list_tree($publicStorage);
$imgCount        = count(array_filter($allFiles, fn($f) => in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), ['jpg','jpeg','png','gif','webp','svg','avif'])));

// Overall
$hasError   = (bool) array_filter($log, fn($l) => $l['type'] === 'danger');
$overallMsg = $hasError ? '⚠️ Action required — see errors below.' : '✅ Fix applied. Upload a new banner and it will appear immediately.';
$overallCls = $hasError ? 'danger' : 'success';

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Truant Storage Fix</title>
<style>
:root{--bg:#080f1e;--card:#0f1c2e;--border:#1e2f46;--green:#10b981;--blue:#38bdf8;--yellow:#f59e0b;--red:#ef4444;--gray:#94a3b8;--text:#f1f5f9}
*{box-sizing:border-box;margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif}
body{background:var(--bg);color:var(--text);padding:24px 14px;min-height:100vh}
.wrap{max-width:960px;margin:0 auto;display:flex;flex-direction:column;gap:14px}
header{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:22px 26px;display:flex;align-items:center;gap:14px}
.hicon{font-size:34px;line-height:1}
header h1{font-size:20px;font-weight:700;color:#fff}
header p{font-size:12.5px;color:var(--gray);margin-top:3px}
.summary{border-radius:10px;padding:14px 18px;font-size:13.5px;font-weight:600}
.summary-success{background:rgba(16,185,129,.14);border:1px solid var(--green);color:#6ee7b7}
.summary-danger{background:rgba(239,68,68,.12);border:1px solid var(--red);color:#fca5a5}
.log{display:flex;flex-direction:column;gap:8px}
.card{background:var(--card);border:1px solid var(--border);border-radius:9px;padding:12px 16px;border-left:4px solid}
.card-success{border-color:var(--green);background:rgba(16,185,129,.06)}
.card-info{border-color:var(--blue);background:rgba(56,189,248,.06)}
.card-warning{border-color:var(--yellow);background:rgba(245,158,11,.06)}
.card-danger{border-color:var(--red);background:rgba(239,68,68,.06)}
.card strong{color:#fff;font-size:13px;display:block;margin-bottom:3px}
.body{font-size:12px;color:var(--gray);line-height:1.65}
code{background:rgba(0,0,0,.5);padding:2px 6px;border-radius:4px;font-family:ui-monospace,monospace;font-size:11.5px}
pre{background:rgba(0,0,0,.45);padding:9px 12px;border-radius:6px;font-size:11.5px;line-height:1.5;overflow-x:auto;color:#cbd5e1}
.section{background:var(--card);border:1px solid var(--border);border-radius:12px;padding:18px 22px}
.section h2{font-size:14px;font-weight:700;color:#fff;margin-bottom:12px}
/* Verify */
.v-row{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:7px;margin-bottom:7px;font-size:12.5px}
.v-ok{background:rgba(16,185,129,.1);border:1px solid rgba(16,185,129,.4)}
.v-fail{background:rgba(239,68,68,.1);border:1px solid rgba(239,68,68,.4)}
.v-warn{background:rgba(245,158,11,.1);border:1px solid rgba(245,158,11,.4)}
.vb{font-size:11px;font-weight:700;padding:2px 9px;border-radius:9999px;white-space:nowrap}
.vb-ok{background:rgba(16,185,129,.25);color:#34d399}
.vb-fail{background:rgba(239,68,68,.25);color:#f87171}
.vb-warn{background:rgba(245,158,11,.25);color:#fbbf24}
/* File grid */
.file-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:8px}
.fi{background:rgba(0,0,0,.35);border:1px solid var(--border);border-radius:7px;overflow:hidden;transition:border-color .15s}
.fi:hover{border-color:var(--blue)}
.fi-thumb{width:100%;height:100px;object-fit:cover;display:block;background:#060c18}
.fi-ph{height:65px;display:flex;align-items:center;justify-content:center;color:var(--gray);font-size:22px}
.fi-info{padding:6px 8px}
.fi-name{font-size:10.5px;color:#cbd5e1;word-break:break-all;margin-bottom:3px}
.fi-link{font-size:10px;color:var(--blue);text-decoration:none}
.fi-link:hover{text-decoration:underline}
.empty{color:var(--gray);font-size:13px}
.sec-note{background:rgba(239,68,68,.09);border:1px solid rgba(239,68,68,.4);border-radius:9px;padding:14px 17px;font-size:12px;color:#fca5a5}
.steps ol{margin-left:20px;line-height:2;font-size:13px;color:#cbd5e1}
.steps a{color:var(--blue)}
table{width:100%;border-collapse:collapse}
td{padding:3px 8px;vertical-align:top}
</style>
</head>
<body>
<div class="wrap">

<header>
  <div class="hicon">&#128295;</div>
  <div>
    <h1>Truant Storage Fix — GoDaddy No-Symlink Mode</h1>
    <p>Replaces the broken symlink with a real folder so Apache can serve images normally.</p>
  </div>
</header>

<div class="summary summary-<?= $overallCls ?>"><?= $overallMsg ?></div>

<div class="log">
<?php foreach ($log as $l): ?>
  <div class="card card-<?= htmlspecialchars($l['type']) ?>">
    <strong><?= htmlspecialchars($l['title']) ?></strong>
    <?php if ($l['body']): ?><div class="body"><?= $l['body'] ?></div><?php endif ?>
  </div>
<?php endforeach ?>
</div>

<!-- Specific image verification -->
<div class="section">
  <h2>&#128444;&#65039; Broken Image Verification</h2>
  <p style="font-size:12px;color:var(--gray);margin-bottom:10px">
    File: <code>/storage/events/banners/<?= htmlspecialchars($knownBroken) ?></code>
  </p>

  <div class="v-row <?= $existsPublic ? 'v-ok' : 'v-fail' ?>">
    <span class="vb <?= $existsPublic ? 'vb-ok' : 'vb-fail' ?>"><?= $existsPublic ? '✓ In public_html/storage' : '✗ Missing from public_html/storage' ?></span>
    <?php if ($existsPublic): ?>
      <span style="color:#94a3b8;font-size:11.5px"><?= round(filesize($brokenPublic)/1024, 1) ?> KB</span>
      <a href="/storage/events/banners/<?= htmlspecialchars($knownBroken) ?>" target="_blank" style="font-size:11.5px;color:var(--blue)">Open &#8599;</a>
    <?php endif ?>
  </div>

  <div class="v-row <?= $existsInternal ? 'v-ok' : 'v-warn' ?>">
    <span class="vb <?= $existsInternal ? 'vb-ok' : 'vb-warn' ?>"><?= $existsInternal ? '✓ In storage/app/public' : '⚠ Missing from storage/app/public' ?></span>
    <span style="color:#94a3b8;font-size:11.5px">Laravel internal storage</span>
  </div>

  <?php if ($existsPublic): ?>
    <div style="margin-top:12px">
      <img src="/storage/events/banners/<?= htmlspecialchars($knownBroken) ?>"
           style="max-width:320px;border-radius:8px;border:1px solid var(--border);display:block"
           alt="Banner preview"
           onerror="this.insertAdjacentHTML('afterend','<p style=\'color:#f87171;font-size:12px;margin-top:6px\'>&#9888; File exists on disk but Apache still returns an error. Check file permissions — run: chmod 644 on the file via cPanel.</p>');this.remove()">
    </div>
  <?php elseif (!$existsInternal): ?>
    <p style="color:#fde68a;font-size:12px;margin-top:10px">
      &#9888; This image does not exist anywhere on the server. The file was never saved.
      Go to <a href="/admin/events" style="color:var(--blue)">/admin/events</a>, edit the event, and re-upload the banner.
      After uploading, reload this page to verify.
    </p>
  <?php else: ?>
    <p style="color:#fde68a;font-size:12px;margin-top:10px">
      &#9888; File is in internal storage but copy to public_html/storage failed. Check folder permissions.
    </p>
  <?php endif ?>
</div>

<!-- File browser -->
<div class="section">
  <h2>&#128193; Files in public_html/storage (<?= count($allFiles) ?> total, <?= $imgCount ?> images)</h2>
  <?php if (empty($allFiles)): ?>
    <p class="empty">No files yet. Upload a banner from the admin panel then reload this page.</p>
  <?php else: ?>
    <div class="file-grid">
    <?php
    $imgExts = ['jpg','jpeg','png','gif','webp','svg','avif'];
    foreach ($allFiles as $rel):
        $ext   = strtolower(pathinfo($rel, PATHINFO_EXTENSION));
        $url   = '/storage/' . str_replace('\\', '/', $rel);
        $isImg = in_array($ext, $imgExts, true);
    ?>
      <div class="fi">
        <?php if ($isImg): ?>
          <img class="fi-thumb" src="<?= htmlspecialchars($url) ?>" alt=""
               onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
          <div class="fi-ph" style="display:none">&#128444;</div>
        <?php else: ?>
          <div class="fi-ph">&#128196;</div>
        <?php endif ?>
        <div class="fi-info">
          <div class="fi-name"><?= htmlspecialchars($rel) ?></div>
          <a class="fi-link" href="<?= htmlspecialchars($url) ?>" target="_blank">Open &#8599;</a>
        </div>
      </div>
    <?php endforeach ?>
    </div>
  <?php endif ?>
</div>

<!-- What to do now -->
<div class="section steps">
  <h2>&#128203; What to do now</h2>
  <ol>
    <li>Scroll up — verify the broken image shows a preview above. If it does, it is fixed.</li>
    <li>Go to <a href="/admin/events">/admin/events</a> and upload a new banner image to any event.</li>
    <li>Come back and <strong>reload this page</strong> — the new image should appear in the file grid and show a preview.</li>
    <li>Check the public landing page and admin list — images should now load.</li>
    <li>Once confirmed, <strong>delete <code>public_html/storage_repair.php</code></strong> from cPanel File Manager.</li>
  </ol>
  <p style="font-size:12px;color:#94a3b8;margin-top:12px">
    &#9432; Future uploads will go directly to <code>public_html/storage</code> via the <code>FILESYSTEM_PUBLIC_ROOT</code> .env setting — no further syncing needed.
  </p>
</div>

<div class="sec-note">
  <strong>&#9888;&#65039; Security:</strong> Delete <code>public_html/storage_repair.php</code> once confirmed working.
</div>

</div>
</body>
</html>
