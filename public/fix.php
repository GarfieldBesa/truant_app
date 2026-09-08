<?php
/**
 * Truant Enterprises - Complete Application Storage Repair
 * 
 * Upload this file to public_html/fix.php using cPanel File Manager,
 * then visit https://truantenterprises.com/fix.php in your browser.
 */

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

$log = [];
function report(string $type, string $title, string $msg = ''): void {
    global $log;
    $log[] = ['type' => $type, 'title' => $title, 'msg' => $msg];
}

$webRoot = realpath(__DIR__) ?: __DIR__;
$publicStorage = $webRoot . '/storage';

// 1. Locate Laravel Root by searching up and around
$possibleRoots = [
    $webRoot,
    dirname($webRoot) . '/my-laravel-app',
    dirname($webRoot) . '/laravel',
    dirname($webRoot) . '/truant_app',
    dirname($webRoot) . '/truant-app',
    dirname($webRoot) . '/app',
    dirname($webRoot),
    '/home/uq7hadnu944q/my-laravel-app',
    '/home/uq7hadnu944q/laravel',
    '/home/uq7hadnu944q/truant_app',
    '/home/uq7hadnu944q/truant-app',
    '/home/uq7hadnu944q/app',
    '/home/uq7hadnu944q',
];

$laravelRoot = null;
foreach (array_unique($possibleRoots) as $dir) {
    if (is_dir($dir) && file_exists($dir . '/artisan') && file_exists($dir . '/bootstrap/app.php')) {
        $laravelRoot = realpath($dir);
        break;
    }
}

if ($laravelRoot) {
    report('success', "Found Laravel Application Root", "Located at: <code>{$laravelRoot}</code>");
} else {
    report('danger', "Could Not Locate Laravel Root", "Checked standard directories. Please make sure artisan and bootstrap/app.php exist.");
}

// 2. Locate Internal storage/app/public
$internalStoragePublic = null;
if ($laravelRoot && is_dir($laravelRoot . '/storage/app/public')) {
    $internalStoragePublic = realpath($laravelRoot . '/storage/app/public');
} elseif (is_dir(dirname($webRoot) . '/storage/app/public')) {
    $internalStoragePublic = realpath(dirname($webRoot) . '/storage/app/public');
} elseif (is_dir('/home/uq7hadnu944q/storage/app/public')) {
    $internalStoragePublic = realpath('/home/uq7hadnu944q/storage/app/public');
}

if ($internalStoragePublic) {
    report('info', "Found Internal Storage Directory", "Located at: <code>{$internalStoragePublic}</code>");
}

// Ensure required subdirectories exist in internal storage
if ($internalStoragePublic) {
    @mkdir($internalStoragePublic . '/events/banners', 0755, true);
    @mkdir($internalStoragePublic . '/events/form-banners', 0755, true);
    @mkdir($internalStoragePublic . '/events/registrations', 0755, true);
    @mkdir($internalStoragePublic . '/livewire-tmp', 0755, true);
}
if ($laravelRoot) {
    @mkdir($laravelRoot . '/storage/app/livewire-tmp', 0755, true);
    @mkdir($laravelRoot . '/storage/app/private/livewire-tmp', 0755, true);
}

// 3. Search for the missing image on the server!
$soughtImages = [
    '01M20P128MZBMPZXJVDE3ZPX16.jpg',
    '01M20KJ52S5J41476AP7PFTG57.jpg',
];

$foundLocations = [];
$searchBases = array_unique(array_filter([
    $laravelRoot ? $laravelRoot . '/storage' : null,
    dirname($webRoot) . '/storage',
    '/home/uq7hadnu944q/storage',
    '/home/uq7hadnu944q/my-laravel-app',
    '/home/uq7hadnu944q/laravel',
    '/home/uq7hadnu944q/public_html',
    '/tmp',
]));

foreach ($soughtImages as $img) {
    $foundLocations[$img] = null;
    foreach ($searchBases as $sBase) {
        if (!is_dir($sBase)) continue;
        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($sBase, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($iterator as $item) {
                if ($item->isFile() && $item->getFilename() === $img) {
                    $foundLocations[$img] = $item->getPathname();
                    break 2;
                }
            }
        } catch (\Throwable $e) {}
    }
}

foreach ($foundLocations as $img => $loc) {
    if ($loc) {
        report('success', "Found Image on Server: {$img}", "Located at: <code>{$loc}</code> (" . round(filesize($loc)/1024, 1) . " KB)");
    } else {
        report('warning', "Image Not Found on Disk: {$img}", "The temporary upload may have failed before saving. We will ensure all folders are ready for a new upload.");
    }
}

// 4. Create or Fix Symlink from public_html/storage -> storage/app/public
$symlinkCreated = false;
if ($internalStoragePublic) {
    // Check if public_html/storage is already a symlink
    if (is_link($publicStorage)) {
        $target = readlink($publicStorage);
        report('success', "public_html/storage is a Symbolic Link", "Points to: <code>{$target}</code>");
        $symlinkCreated = true;
    } else {
        // It is a real folder or does not exist.
        // First, copy any files from public_html/storage into internal storage so no files are lost!
        if (is_dir($publicStorage)) {
            try {
                $it = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($publicStorage, RecursiveDirectoryIterator::SKIP_DOTS),
                    RecursiveIteratorIterator::SELF_FIRST
                );
                foreach ($it as $f) {
                    $sub = $it->getSubPathName();
                    $dest = $internalStoragePublic . '/' . $sub;
                    if ($f->isDir()) {
                        if (!is_dir($dest)) @mkdir($dest, 0755, true);
                    } else {
                        $p = dirname($dest);
                        if (!is_dir($p)) @mkdir($p, 0755, true);
                        if (!file_exists($dest)) {
                            @copy($f->getPathname(), $dest);
                        }
                    }
                }
            } catch (\Throwable $e) {}

            // Rename public_html/storage to backup
            $backupName = $publicStorage . '_backup_' . time();
            if (@rename($publicStorage, $backupName)) {
                report('info', "Backed Up Static Folder", "Renamed existing folder to: <code>{$backupName}</code>");
            }
        }

        // Try creating symlink
        if (!file_exists($publicStorage) && function_exists('symlink')) {
            if (@symlink($internalStoragePublic, $publicStorage)) {
                report('success', "Created Symlink Successfully!", "<code>public_html/storage</code> &rarr; <code>{$internalStoragePublic}</code>. Any file Laravel saves to internal storage is now instantly available in public_html!");
                $symlinkCreated = true;
            } else {
                report('warning', "symlink() failed", "Host blocked symlink creation. Switching to Direct Public Folder mode.");
            }
        }
    }
}

// If symlink could not be created, ensure public_html/storage is a real folder with copied files
if (!$symlinkCreated) {
    if (!is_dir($publicStorage)) {
        @mkdir($publicStorage, 0755, true);
    }
    @mkdir($publicStorage . '/events/banners', 0755, true);
    @mkdir($publicStorage . '/events/form-banners', 0755, true);
    @mkdir($publicStorage . '/events/registrations', 0755, true);
    @mkdir($publicStorage . '/livewire-tmp', 0755, true);

    // Sync all files from internal storage to public_html/storage
    if ($internalStoragePublic && is_dir($internalStoragePublic)) {
        $syncCount = 0;
        try {
            $it = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($internalStoragePublic, RecursiveDirectoryIterator::SKIP_DOTS),
                RecursiveIteratorIterator::SELF_FIRST
            );
            foreach ($it as $f) {
                $sub = $it->getSubPathName();
                $dest = $publicStorage . '/' . $sub;
                if ($f->isDir()) {
                    if (!is_dir($dest)) @mkdir($dest, 0755, true);
                } else {
                    $p = dirname($dest);
                    if (!is_dir($p)) @mkdir($p, 0755, true);
                    if (!file_exists($dest) || filesize($f->getPathname()) !== filesize($dest)) {
                        if (@copy($f->getPathname(), $dest)) {
                            @chmod($dest, 0644);
                            $syncCount++;
                        }
                    }
                }
            }
        } catch (\Throwable $e) {}
        report('info', "Direct Storage Mode Active", "Synced {$syncCount} file(s) into <code>public_html/storage</code>.");
    }
}

// Copy any found images to public storage destination
foreach ($foundLocations as $img => $loc) {
    if ($loc) {
        $dest = $publicStorage . '/events/banners/' . $img;
        if (!file_exists($dest)) {
            @copy($loc, $dest);
            @chmod($dest, 0644);
            report('success', "Copied {$img} to Public Storage", "Available at <code>/storage/events/banners/{$img}</code>");
        }
    }
}

// 5. Update config/filesystems.php on the server if needed
if ($laravelRoot) {
    $cfgFile = $laravelRoot . '/config/filesystems.php';
    if (file_exists($cfgFile) && is_writable($cfgFile)) {
        $cfgCode = file_get_contents($cfgFile);
        $changed = false;

        // Ensure 'serve' => false on local
        if (str_contains($cfgCode, "'serve' => true")) {
            $cfgCode = str_replace("'serve' => true", "'serve' => false", $cfgCode);
            $changed = true;
        }

        // Ensure public disk has env('FILESYSTEM_PUBLIC_ROOT')
        if (!str_contains($cfgCode, 'FILESYSTEM_PUBLIC_ROOT')) {
            $cfgCode = preg_replace(
                "/'public'\s*=>\s*\[\s*'driver'\s*=>\s*'local',\s*'root'\s*=>\s*storage_path\('app\/public'\),/",
                "'public' => [\n            'driver' => 'local',\n            'root' => env('FILESYSTEM_PUBLIC_ROOT', is_dir(base_path('../public_html/storage')) ? base_path('../public_html/storage') : storage_path('app/public')),",
                $cfgCode
            );
            $changed = true;
        }

        if ($changed) {
            file_put_contents($cfgFile, $cfgCode);
            report('success', "Patched config/filesystems.php on Server", "Enabled FILESYSTEM_PUBLIC_ROOT and disabled private serve collision.");
        } else {
            report('info', "config/filesystems.php", "Already configured properly.");
        }
    }
}

// 6. Update .env
if ($laravelRoot && file_exists($laravelRoot . '/.env') && is_writable($laravelRoot . '/.env')) {
    $envC = file_get_contents($laravelRoot . '/.env');
    $envMod = false;

    // APP_URL
    if (preg_match('/^APP_URL=(.*)$/m', $envC, $m)) {
        $u = trim($m[1], " \t\n\r\0\x0B\"'");
        if ($u !== 'https://truantenterprises.com') {
            $envC = preg_replace('/^APP_URL=.*$/m', 'APP_URL=https://truantenterprises.com', $envC);
            $envMod = true;
        }
    } else {
        $envC .= "\nAPP_URL=https://truantenterprises.com\n";
        $envMod = true;
    }

    // FILESYSTEM_PUBLIC_ROOT (only if not symlinked)
    if (!$symlinkCreated) {
        $rootVal = $publicStorage;
        if (preg_match('/^FILESYSTEM_PUBLIC_ROOT=(.*)$/m', $envC)) {
            $envC = preg_replace('/^FILESYSTEM_PUBLIC_ROOT=.*$/m', "FILESYSTEM_PUBLIC_ROOT={$rootVal}", $envC);
        } else {
            $envC .= "\nFILESYSTEM_PUBLIC_ROOT={$rootVal}\nFILESYSTEM_PUBLIC_URL=/storage\n";
        }
        $envMod = true;
    }

    if ($envMod) {
        file_put_contents($laravelRoot . '/.env', $envC);
        report('success', "Updated .env", "APP_URL set to https://truantenterprises.com.");
    }
}

// 7. Clear all caches
if ($laravelRoot) {
    $bCache = $laravelRoot . '/bootstrap/cache';
    $cFiles = ['config.php', 'routes-v7.php', 'routes.php', 'services.php', 'packages.php', 'events.php'];
    $del = 0;
    foreach ($cFiles as $f) {
        $p = $bCache . '/' . $f;
        if (file_exists($p) && @unlink($p)) $del++;
    }
    report('success', "Cache Cleared", "Deleted {$del} file(s) from bootstrap/cache/.");

    try {
        if (file_exists($laravelRoot . '/vendor/autoload.php')) {
            require_once $laravelRoot . '/vendor/autoload.php';
            $app = require_once $laravelRoot . '/bootstrap/app.php';
            $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
            $kernel->call('optimize:clear');
            report('success', "Executed Artisan optimize:clear", "<pre style='font-size:12px; margin-top:4px;'>" . htmlspecialchars(trim($kernel->output())) . "</pre>");
        }
    } catch (\Throwable $e) {
        report('info', "Artisan note", htmlspecialchars($e->getMessage()));
    }
}

// 8. Test banner status
$testUrl1 = '/storage/events/banners/01M20P128MZBMPZXJVDE3ZPX16.jpg';
$testUrl2 = '/storage/events/banners/01M20KJ52S5J41476AP7PFTG57.jpg';

$file1Exists = file_exists($publicStorage . '/events/banners/01M20P128MZBMPZXJVDE3ZPX16.jpg');
$file2Exists = file_exists($publicStorage . '/events/banners/01M20KJ52S5J41476AP7PFTG57.jpg');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Truant Application Storage Repair</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: #0b1329; color: #f1f5f9; padding: 30px 15px; }
        .wrap { max-width: 860px; margin: 0 auto; background: #1e293b; border: 1px solid #334155; border-radius: 14px; padding: 26px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        h1 { font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 8px; }
        p.desc { color: #94a3b8; font-size: 14px; margin-bottom: 22px; }
        .card { padding: 12px 16px; border-radius: 8px; margin-bottom: 12px; font-size: 14px; border-left: 4px solid; }
        .card-success { background: rgba(16,185,129,0.12); border-color: #10b981; color: #a7f3d0; }
        .card-info { background: rgba(56,189,248,0.12); border-color: #38bdf8; color: #bae6fd; }
        .card-warning { background: rgba(245,158,11,0.12); border-color: #f59e0b; color: #fde68a; }
        .card-danger { background: rgba(239,68,68,0.12); border-color: #ef4444; color: #fecaca; }
        .card strong { color: #fff; display: block; margin-bottom: 3px; font-size: 15px; }
        code { background: rgba(0,0,0,0.35); padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 13px; }
        .box { background: rgba(15,23,42,0.6); border: 1px solid #334155; border-radius: 10px; padding: 18px; margin-top: 20px; }
        .box h3 { font-size: 16px; margin-bottom: 10px; color: #fff; }
        .preview { display: flex; gap: 15px; align-items: center; margin-top: 10px; }
        .preview img { max-width: 140px; max-height: 90px; border-radius: 6px; border: 1px solid #475569; }
        .badge { padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 600; }
        .badge-ok { background: rgba(16,185,129,0.2); color: #34d399; }
        .badge-miss { background: rgba(239,68,68,0.2); color: #f87171; }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>🛠️ Truant Application Storage Repair</h1>
        <p class="desc">Diagnoses and fixes the GoDaddy cPanel storage link, cache, and banner images.</p>

        <?php foreach ($log as $l): ?>
            <div class="card card-<?= $l['type'] ?>">
                <strong><?= htmlspecialchars($l['title']) ?></strong>
                <?= $l['msg'] ?>
            </div>
        <?php endforeach; ?>

        <div class="box">
            <h3>🖼️ Banner Image Verification:</h3>
            
            <div style="margin-bottom: 15px;">
                <div>
                    <code>01M20P128MZBMPZXJVDE3ZPX16.jpg</code>: 
                    <?php if ($file1Exists): ?>
                        <span class="badge badge-ok">✓ Active in Storage</span>
                        <div class="preview">
                            <img src="<?= $testUrl1 ?>" alt="Banner 1">
                            <a href="<?= $testUrl1 ?>" target="_blank" style="color: #38bdf8;">Open Image &rarr;</a>
                        </div>
                    <?php else: ?>
                        <span class="badge badge-miss">&times; Missing</span>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <div>
                    <code>01M20KJ52S5J41476AP7PFTG57.jpg</code>: 
                    <?php if ($file2Exists): ?>
                        <span class="badge badge-ok">✓ Active in Storage</span>
                        <div class="preview">
                            <img src="<?= $testUrl2 ?>" alt="Banner 2">
                            <a href="<?= $testUrl2 ?>" target="_blank" style="color: #38bdf8;">Open Image &rarr;</a>
                        </div>
                    <?php else: ?>
                        <span class="badge badge-miss">&times; Missing</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div style="margin-top: 25px; padding: 12px 16px; background: rgba(59,130,246,0.1); border: 1px solid #3b82f6; border-radius: 8px; font-size: 13px; color: #93c5fd;">
            <strong>Next Step:</strong> Go back to your Filament Admin Panel (<code>/admin/events</code>) and upload the image now. It will save and display immediately. Once verified, delete <code>public_html/fix.php</code> for security.
        </div>
    </div>
</body>
</html>
