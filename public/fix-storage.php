<?php
/**
 * Truant App - Storage & Cache Fix Utility
 * 
 * Instructions:
 * 1. Upload this file to your GoDaddy cPanel into your public_html/ folder.
 * 2. Visit https://truantenterprises.com/fix-storage.php in your browser.
 * 3. Delete this file after running for security.
 */

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

$results = [];

function logMsg(string $type, string $message): void {
    global $results;
    $results[] = ['type' => $type, 'message' => $message];
}

// 1. Locate public_html and storage directory
$publicHtmlDir = __DIR__;
$storageTarget = $publicHtmlDir . '/storage';

logMsg('info', "Current Web Root (public_html): {$publicHtmlDir}");
logMsg('info', "Target Public Storage: {$storageTarget}");

// 2. Locate Laravel Root
$possibleLaravelRoots = array_filter([
    $publicHtmlDir,
    dirname($publicHtmlDir) . '/my-laravel-app',
    dirname($publicHtmlDir) . '/laravel',
    dirname($publicHtmlDir) . '/truant_app',
    dirname($publicHtmlDir) . '/app',
    dirname($publicHtmlDir),
    '/home/uq7hadnu944q/my-laravel-app',
    '/home/uq7hadnu944q/laravel',
    '/home/uq7hadnu944q/truant_app',
    '/home/uq7hadnu944q/app',
    '/home/uq7hadnu944q',
]);

$laravelRoot = null;
foreach ($possibleLaravelRoots as $path) {
    if (file_exists($path . '/artisan') && file_exists($path . '/bootstrap/app.php')) {
        $laravelRoot = realpath($path);
        break;
    }
}

if ($laravelRoot) {
    logMsg('success', "Found Laravel Application Root at: {$laravelRoot}");
} else {
    logMsg('warning', "Could not automatically locate artisan file. Checking standard storage locations directly.");
}

// 3. Clear Laravel Cache files manually
if ($laravelRoot) {
    $bootstrapCache = $laravelRoot . '/bootstrap/cache';
    $cacheFiles = [
        'config.php',
        'routes-v7.php',
        'routes.php',
        'services.php',
        'packages.php',
        'events.php',
    ];

    $clearedFiles = 0;
    foreach ($cacheFiles as $file) {
        $fullPath = $bootstrapCache . '/' . $file;
        if (file_exists($fullPath)) {
            if (@unlink($fullPath)) {
                $clearedFiles++;
            }
        }
    }
    logMsg('success', "Cleared {$clearedFiles} Laravel cache files in bootstrap/cache/ (including cached config).");

    // Also try running optimize:clear via Artisan
    try {
        require_once $laravelRoot . '/vendor/autoload.php';
        $app = require_once $laravelRoot . '/bootstrap/app.php';
        
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $kernel->call('optimize:clear');
        $output = $kernel->output();
        logMsg('success', "Executed 'php artisan optimize:clear' via PHP kernel:<br><pre style='margin:5px 0; font-size:12px;'>" . htmlspecialchars(trim($output)) . "</pre>");
    } catch (\Throwable $e) {
        logMsg('info', "Artisan in-memory call note: " . htmlspecialchars($e->getMessage()));
    }
}

// 4. Ensure public_html/storage and its subdirectories exist with 0755
$requiredDirs = [
    $storageTarget,
    $storageTarget . '/events',
    $storageTarget . '/events/banners',
    $storageTarget . '/events/form-banners',
    $storageTarget . '/events/registrations',
    $storageTarget . '/livewire-tmp',
];

foreach ($requiredDirs as $dir) {
    if (!file_exists($dir)) {
        if (@mkdir($dir, 0755, true)) {
            logMsg('success', "Created directory: " . htmlspecialchars($dir));
        } else {
            logMsg('danger', "Failed to create directory: " . htmlspecialchars($dir) . " (Check folder permissions)");
        }
    } else {
        @chmod($dir, 0755);
        logMsg('info', "Directory exists: " . htmlspecialchars($dir) . " (Permissions set to 0755)");
    }
}

// 5. Copy missing files from Laravel's storage/app/public to public_html/storage
$sourceStorageDirs = [];
if ($laravelRoot) {
    $sourceStorageDirs[] = $laravelRoot . '/storage/app/public';
}
$sourceStorageDirs[] = dirname($publicHtmlDir) . '/storage/app/public';
$sourceStorageDirs[] = '/home/uq7hadnu944q/storage/app/public';

$filesCopied = 0;
$copiedList = [];

foreach (array_unique($sourceStorageDirs) as $srcDir) {
    if (is_dir($srcDir)) {
        logMsg('info', "Found internal storage source at: {$srcDir}");
        
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($srcDir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $subPath = $iterator->getSubPathName();
            $destPath = $storageTarget . '/' . $subPath;

            if ($item->isDir()) {
                if (!file_exists($destPath)) {
                    @mkdir($destPath, 0755, true);
                }
            } else {
                // Ensure parent folder exists
                $parent = dirname($destPath);
                if (!file_exists($parent)) {
                    @mkdir($parent, 0755, true);
                }
                
                // Copy if missing or different
                if (!file_exists($destPath) || filesize($item->getPathname()) !== filesize($destPath)) {
                    if (@copy($item->getPathname(), $destPath)) {
                        @chmod($destPath, 0644);
                        $filesCopied++;
                        $copiedList[] = $subPath;
                    }
                }
            }
        }
    }
}

if ($filesCopied > 0) {
    logMsg('success', "Synchronized <strong>{$filesCopied}</strong> missing/updated file(s) into <code>public_html/storage</code>:<br><ul style='margin:5px 0; font-size:13px;'>" . implode('', array_map(fn($f) => "<li>" . htmlspecialchars($f) . "</li>", array_slice($copiedList, 0, 20))) . ($filesCopied > 20 ? "<li>... and " . ($filesCopied - 20) . " more</li>" : "") . "</ul>");
} else {
    logMsg('info', "All files in storage/app/public are already present in public_html/storage.");
}

// 6. Specifically check the image reported missing
$testBannerRel = 'events/banners/01M20KJ52S5J41476AP7PFTG57.jpg';
$testBannerFull = $storageTarget . '/' . $testBannerRel;
$testBannerStatus = file_exists($testBannerFull);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truant Storage & Cache Fix Utility</title>
    <style>
        :root {
            --bg: #0f172a;
            --card-bg: #1e293b;
            --text: #f8fafc;
            --text-muted: #94a3b8;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #38bdf8;
            --border: #334155;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: var(--bg); color: var(--text); padding: 40px 20px; line-height: 1.6; }
        .container { max-width: 850px; margin: 0 auto; background: var(--card-bg); border: 1px solid var(--border); border-radius: 16px; padding: 32px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5); }
        h1 { font-size: 24px; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 10px; color: #fff; }
        p.subtitle { color: var(--text-muted); font-size: 14px; margin-bottom: 24px; }
        .alert-box { padding: 14px 18px; border-radius: 10px; margin-bottom: 14px; font-size: 14px; border-left: 4px solid; display: flex; flex-direction: column; gap: 4px; }
        .alert-info { background: rgba(56, 189, 248, 0.1); border-color: var(--info); color: #bae6fd; }
        .alert-success { background: rgba(16, 185, 129, 0.1); border-color: var(--success); color: #a7f3d0; }
        .alert-warning { background: rgba(245, 158, 11, 0.1); border-color: var(--warning); color: #fde68a; }
        .alert-danger { background: rgba(239, 68, 68, 0.1); border-color: var(--danger); color: #fecaca; }
        .status-badge { display: inline-flex; align-items: center; gap: 6px; padding: 6px 14px; border-radius: 9999px; font-weight: 600; font-size: 13px; }
        .badge-success { background: rgba(16, 185, 129, 0.2); color: #34d399; border: 1px solid #059669; }
        .badge-danger { background: rgba(239, 68, 68, 0.2); color: #f87171; border: 1px solid #dc2626; }
        .card { background: rgba(15, 23, 42, 0.6); border: 1px solid var(--border); border-radius: 12px; padding: 20px; margin-top: 24px; }
        .btn { display: inline-block; background: #3b82f6; color: #fff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; margin-top: 10px; }
        .btn:hover { background: #2563eb; }
        .danger-note { margin-top: 30px; background: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); padding: 16px; border-radius: 10px; font-size: 13px; color: #fca5a5; }
        code { background: rgba(0,0,0,0.3); padding: 2px 6px; border-radius: 4px; font-family: ui-monospace, monospace; font-size: 13px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🛠️ Truant Storage & Cache Fixer</h1>
        <p class="subtitle">Utility to clear Laravel cache, ensure storage permissions, and sync uploaded media on GoDaddy.</p>

        <h3 style="margin-bottom: 12px; font-size: 16px; color: #cbd5e1;">Diagnostic & Repair Actions:</h3>
        <?php foreach ($results as $res): ?>
            <div class="alert-box alert-<?= $res['type'] ?>">
                <?= $res['message'] ?>
            </div>
        <?php endforeach; ?>

        <div class="card">
            <h3 style="font-size: 16px; margin-bottom: 8px;">Target Missing Image Verification:</h3>
            <p style="font-size: 14px; color: var(--text-muted); margin-bottom: 12px;">
                Checking file: <code><?= htmlspecialchars($testBannerRel) ?></code>
            </p>
            <?php if ($testBannerStatus): ?>
                <div>
                    <span class="status-badge badge-success">✓ File Located in public_html/storage</span>
                    <p style="margin-top: 10px; font-size: 14px;">
                        The image file is now physically in place. Click below to view it directly in your browser:
                    </p>
                    <a href="/storage/<?= htmlspecialchars($testBannerRel) ?>" target="_blank" class="btn">
                        Open Image in New Tab &rarr;
                    </a>
                </div>
            <?php else: ?>
                <div>
                    <span class="status-badge badge-danger">&times; File Still Missing</span>
                    <p style="margin-top: 10px; font-size: 14px; color: #fca5a5;">
                        The image file <code><?= htmlspecialchars($testBannerRel) ?></code> was not found in internal storage either. You may need to edit Event #10 in the admin panel and re-upload the banner image now that the cache and folders are fixed.
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <div class="danger-note">
            <strong>⚠️ Security Precaution:</strong> Once you have verified that images load and the cache is cleared, please delete <code>public_html/fix-storage.php</code> using cPanel File Manager so that outside visitors cannot trigger this script.
        </div>
    </div>
</body>
</html>
