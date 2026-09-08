<?php
/**
 * Truant Enterprises - Complete Storage & Cache Auto-Repair Tool
 * 
 * Instructions:
 * 1. Upload this file to your public_html/ folder using cPanel File Manager.
 * 2. Visit https://truantenterprises.com/fix.php in your browser.
 * 3. Review results and test the upload.
 * 4. Delete this file when done.
 */

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

$actions = [];
function addAction(string $status, string $title, string $details = ''): void {
    global $actions;
    $actions[] = ['status' => $status, 'title' => $title, 'details' => $details];
}

// 1. Identify Environment & Directories
$webRoot = realpath(__DIR__) ?: __DIR__;
$publicStorage = $webRoot . '/storage';

// Find Laravel Root
$searchDirs = [
    $webRoot,
    dirname($webRoot) . '/my-laravel-app',
    dirname($webRoot) . '/laravel',
    dirname($webRoot) . '/truant_app',
    dirname($webRoot) . '/app',
    dirname($webRoot),
    '/home/uq7hadnu944q/my-laravel-app',
    '/home/uq7hadnu944q/laravel',
    '/home/uq7hadnu944q/truant_app',
    '/home/uq7hadnu944q/app',
    '/home/uq7hadnu944q/public_html',
    '/home/uq7hadnu944q',
];

$laravelRoot = null;
foreach ($searchDirs as $dir) {
    if (is_dir($dir) && file_exists($dir . '/artisan') && file_exists($dir . '/bootstrap/app.php')) {
        $laravelRoot = realpath($dir);
        break;
    }
}

// Handle Direct File Upload Test if posted
$uploadTestResult = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['test_file'])) {
    $targetDir = $publicStorage . '/events/banners';
    if (!is_dir($targetDir)) {
        @mkdir($targetDir, 0755, true);
    }
    $ext = pathinfo($_FILES['test_file']['name'], PATHINFO_EXTENSION) ?: 'jpg';
    $targetFile = $targetDir . '/upload_test_' . time() . '.' . $ext;
    if (move_uploaded_file($_FILES['test_file']['tmp_name'], $targetFile)) {
        @chmod($targetFile, 0644);
        $webUrl = '/storage/events/banners/' . basename($targetFile);
        $uploadTestResult = [
            'success' => true,
            'message' => 'File uploaded directly to storage successfully!',
            'url' => $webUrl,
        ];
    } else {
        $uploadTestResult = [
            'success' => false,
            'message' => 'Upload failed: could not move uploaded file into ' . htmlspecialchars($targetDir),
        ];
    }
}

// 2. Inspect & Update .env (Fix APP_URL & FILESYSTEM_PUBLIC_ROOT)
$envPath = null;
$envUpdated = false;
if ($laravelRoot && file_exists($laravelRoot . '/.env')) {
    $envPath = $laravelRoot . '/.env';
} elseif (file_exists($webRoot . '/.env')) {
    $envPath = $webRoot . '/.env';
} elseif (file_exists(dirname($webRoot) . '/.env')) {
    $envPath = dirname($webRoot) . '/.env';
}

if ($envPath) {
    $envContent = file_get_contents($envPath);
    $origContent = $envContent;

    // Check APP_URL
    if (preg_match('/^APP_URL=(.*)$/m', $envContent, $m)) {
        $currentAppUrl = trim($m[1], " \t\n\r\0\x0B\"'");
        if (str_starts_with($currentAppUrl, 'http://localhost') || str_starts_with($currentAppUrl, 'http://truantenterprises.com')) {
            $envContent = preg_replace('/^APP_URL=.*$/m', 'APP_URL=https://truantenterprises.com', $envContent);
            addAction('success', 'Fixed APP_URL in .env', "Changed from <code>{$currentAppUrl}</code> to <code>https://truantenterprises.com</code> (Fixes Livewire temporary upload signatures).");
            $envUpdated = true;
        } else {
            addAction('info', 'APP_URL in .env', "Currently set to: <code>{$currentAppUrl}</code>");
        }
    } else {
        $envContent .= "\nAPP_URL=https://truantenterprises.com\n";
        $envUpdated = true;
        addAction('success', 'Added APP_URL to .env', "Set to <code>https://truantenterprises.com</code>");
    }

    // Check FILESYSTEM_PUBLIC_ROOT
    $expectedPublicRoot = $publicStorage;
    if (preg_match('/^FILESYSTEM_PUBLIC_ROOT=(.*)$/m', $envContent, $m)) {
        $currentRoot = trim($m[1], " \t\n\r\0\x0B\"'");
        addAction('info', 'FILESYSTEM_PUBLIC_ROOT in .env', "Currently points to: <code>{$currentRoot}</code>");
    } else {
        $envContent .= "\nFILESYSTEM_PUBLIC_ROOT={$expectedPublicRoot}\nFILESYSTEM_PUBLIC_URL=/storage\n";
        $envUpdated = true;
        addAction('success', 'Added FILESYSTEM_PUBLIC_ROOT to .env', "Set to: <code>{$expectedPublicRoot}</code>");
    }

    if ($envUpdated && is_writable($envPath)) {
        file_put_contents($envPath, $envContent);
    }
} else {
    addAction('warning', 'Could not locate .env file', 'Please ensure .env exists in your Laravel directory.');
}

// 3. Clear Laravel Cache
if ($laravelRoot) {
    $bootstrapCache = $laravelRoot . '/bootstrap/cache';
    $cacheFiles = ['config.php', 'routes-v7.php', 'routes.php', 'services.php', 'packages.php', 'events.php'];
    $cleared = 0;
    foreach ($cacheFiles as $cf) {
        $p = $bootstrapCache . '/' . $cf;
        if (file_exists($p) && @unlink($p)) {
            $cleared++;
        }
    }
    addAction('success', "Cleared {$cleared} cache file(s) in bootstrap/cache/", "Config, routes, and package caches were removed.");

    // Run optimize:clear in-memory
    try {
        if (file_exists($laravelRoot . '/vendor/autoload.php')) {
            require_once $laravelRoot . '/vendor/autoload.php';
            $app = require_once $laravelRoot . '/bootstrap/app.php';
            $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
            $kernel->call('optimize:clear');
            $out = trim($kernel->output());
            addAction('success', 'Executed php artisan optimize:clear', "<pre style='margin-top:5px; font-size:12px;'>" . htmlspecialchars($out) . "</pre>");
        }
    } catch (\Throwable $e) {
        addAction('info', 'Kernel call result', htmlspecialchars($e->getMessage()));
    }
}

// 4. Ensure public_html/storage and subdirectories exist with 0755
$foldersToCreate = [
    $publicStorage,
    $publicStorage . '/events',
    $publicStorage . '/events/banners',
    $publicStorage . '/events/form-banners',
    $publicStorage . '/events/registrations',
    $publicStorage . '/livewire-tmp',
];
if ($laravelRoot) {
    $foldersToCreate[] = $laravelRoot . '/storage/app/livewire-tmp';
    $foldersToCreate[] = $laravelRoot . '/storage/app/public';
    $foldersToCreate[] = $laravelRoot . '/storage/app/public/events/banners';
}

$createdFolders = 0;
foreach ($foldersToCreate as $dir) {
    if (!is_dir($dir)) {
        if (@mkdir($dir, 0755, true)) {
            $createdFolders++;
        }
    } else {
        @chmod($dir, 0755);
    }
}
addAction('success', 'Verified Storage Directories & Permissions', "Checked " . count($foldersToCreate) . " directories (Permissions set to 0755). Created {$createdFolders} missing folders.");

// 5. Search Account for Any Strayed Uploaded Images
$targetImageNames = [
    '01M20P128MZBMPZXJVDE3ZPX16.jpg',
    '01M20KJ52S5J41476AP7PFTG57.jpg',
];

$recoveredImages = 0;
$searchRoots = array_unique(array_filter([
    $laravelRoot ? $laravelRoot . '/storage' : null,
    dirname($webRoot) . '/storage',
    '/home/uq7hadnu944q/storage',
    '/home/uq7hadnu944q/my-laravel-app/storage',
    '/tmp',
]));

foreach ($targetImageNames as $imgName) {
    $targetDestination = $publicStorage . '/events/banners/' . $imgName;
    if (file_exists($targetDestination)) {
        continue;
    }

    foreach ($searchRoots as $root) {
        if (!is_dir($root)) continue;
        try {
            $it = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($it as $file) {
                if ($file->isFile() && (str_contains($file->getFilename(), pathinfo($imgName, PATHINFO_FILENAME)) || $file->getFilename() === $imgName)) {
                    @copy($file->getPathname(), $targetDestination);
                    @chmod($targetDestination, 0644);
                    $recoveredImages++;
                    addAction('success', "Recovered Missing Image: {$imgName}", "Found at <code>{$file->getPathname()}</code> and copied to <code>public_html/storage/events/banners/{$imgName}</code>.");
                    break 2;
                }
            }
        } catch (\Throwable $e) {}
    }
}

// 6. Recursively sync all files from storage/app/public to public_html/storage
$srcDirs = array_unique(array_filter([
    $laravelRoot ? $laravelRoot . '/storage/app/public' : null,
    dirname($webRoot) . '/storage/app/public',
    '/home/uq7hadnu944q/storage/app/public',
]));

$syncedCount = 0;
foreach ($srcDirs as $srcDir) {
    if (is_dir($srcDir)) {
        try {
            $it = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($srcDir, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($it as $item) {
                $sub = $it->getSubPathName();
                $dest = $publicStorage . '/' . $sub;
                if ($item->isDir()) {
                    if (!is_dir($dest)) @mkdir($dest, 0755, true);
                } else {
                    $parent = dirname($dest);
                    if (!is_dir($parent)) @mkdir($parent, 0755, true);
                    if (!file_exists($dest) || filesize($item->getPathname()) !== filesize($dest)) {
                        if (@copy($item->getPathname(), $dest)) {
                            @chmod($dest, 0644);
                            $syncedCount++;
                        }
                    }
                }
            }
        } catch (\Throwable $e) {}
    }
}

if ($syncedCount > 0) {
    addAction('success', "Synchronized {$syncedCount} asset(s) into public storage", "Copied files from internal storage to public_html/storage.");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Truant Storage Repair Tool</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: #0f172a; color: #f8fafc; padding: 30px 15px; }
        .container { max-width: 860px; margin: 0 auto; background: #1e293b; border: 1px solid #334155; border-radius: 16px; padding: 28px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.5); }
        h1 { font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 6px; }
        p.sub { color: #94a3b8; font-size: 14px; margin-bottom: 20px; }
        .item { padding: 12px 16px; border-radius: 8px; margin-bottom: 10px; font-size: 14px; border-left: 4px solid; }
        .item-success { background: rgba(16,185,129,0.12); border-color: #10b981; color: #a7f3d0; }
        .item-info { background: rgba(56,189,248,0.12); border-color: #38bdf8; color: #bae6fd; }
        .item-warning { background: rgba(245,158,11,0.12); border-color: #f59e0b; color: #fde68a; }
        .item-danger { background: rgba(239,68,68,0.12); border-color: #ef4444; color: #fecaca; }
        .item strong { color: #fff; display: block; margin-bottom: 2px; }
        code { background: rgba(0,0,0,0.35); padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 13px; }
        .card { background: rgba(15,23,42,0.6); border: 1px solid #334155; border-radius: 12px; padding: 20px; margin-top: 24px; }
        .card h3 { font-size: 16px; margin-bottom: 12px; color: #fff; }
        .btn { display: inline-block; background: #3b82f6; color: #fff; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; border: none; cursor: pointer; }
        .btn:hover { background: #2563eb; }
        input[type=file] { padding: 8px; background: #0f172a; border: 1px solid #334155; border-radius: 6px; color: #fff; margin-right: 10px; }
        .preview-box { display: inline-block; margin-top: 12px; padding: 8px; background: #0f172a; border-radius: 8px; border: 1px solid #334155; }
        .preview-box img { max-width: 250px; max-height: 150px; border-radius: 6px; display: block; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔧 Truant Auto-Repair & Storage Diagnostics</h1>
        <p class="sub">Repairs Laravel caches, directory permissions, and configuration for GoDaddy cPanel.</p>

        <h3 style="margin-bottom: 12px; font-size: 16px; color: #cbd5e1;">Actions Performed:</h3>
        <?php foreach ($actions as $a): ?>
            <div class="item item-<?= $a['status'] ?>">
                <strong><?= htmlspecialchars($a['title']) ?></strong>
                <?= $a['details'] ?>
            </div>
        <?php endforeach; ?>

        <!-- Direct Upload Test Form -->
        <div class="card">
            <h3>🧪 Test Direct Upload to <code>public_html/storage/events/banners</code></h3>
            <p style="font-size: 13px; color: #94a3b8; margin-bottom: 14px;">
                Upload a sample image below to verify that PHP can physically write to the banners directory and serve it over HTTP.
            </p>
            <form method="POST" enctype="multipart/form-data">
                <input type="file" name="test_file" accept="image/*" required>
                <button type="submit" class="btn">Test Direct Upload &rarr;</button>
            </form>

            <?php if ($uploadTestResult): ?>
                <div style="margin-top: 15px;">
                    <?php if ($uploadTestResult['success']): ?>
                        <div class="item item-success">
                            <strong>✓ Upload Succeeded!</strong>
                            <?= htmlspecialchars($uploadTestResult['message']) ?>
                            <div class="preview-box">
                                <img src="<?= htmlspecialchars($uploadTestResult['url']) ?>" alt="Test Upload Preview">
                            </div>
                            <div style="margin-top: 8px;">
                                Accessible at: <a href="<?= htmlspecialchars($uploadTestResult['url']) ?>" target="_blank" style="color:#38bdf8;"><?= htmlspecialchars($uploadTestResult['url']) ?></a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="item item-danger">
                            <strong>Upload Failed</strong>
                            <?= htmlspecialchars($uploadTestResult['message']) ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 25px; padding: 14px; background: rgba(239,68,68,0.1); border: 1px solid #ef4444; border-radius: 8px; font-size: 13px; color: #fca5a5;">
            <strong>⚠️ Security Notice:</strong> After you have tested and verified that event banner uploads work, remember to delete <code>public_html/fix.php</code> from cPanel File Manager.
        </div>
    </div>
</body>
</html>
