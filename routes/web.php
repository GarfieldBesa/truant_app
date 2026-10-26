<?php

use App\Http\Controllers\EventPublicController;
use App\Http\Controllers\TimesheetPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventPublicController::class, 'index'])->name('home');
Route::get('/events/{event}', [EventPublicController::class, 'show'])->name('events.public.show');
Route::post('/events/{event}/register', [EventPublicController::class, 'register'])->name('events.public.register');
Route::post('/events/{event}/register-by-ref', [EventPublicController::class, 'registerByReference'])->name('events.public.registerByRef');
Route::post('/events/{event}/teams/check-member', [EventPublicController::class, 'lookupTeamMember'])->name('events.public.teams.checkMember');
Route::post('/events/{event}/teams/register', [EventPublicController::class, 'registerTeam'])->name('events.public.teams.register');

Route::get('/portal', [TimesheetPortalController::class, 'index'])->name('portal.index');
Route::get('/timesheet-portal', [TimesheetPortalController::class, 'index'])->name('portal.alias');
Route::get('/portal/ip-request', [TimesheetPortalController::class, 'showIpRequest'])->name('portal.ipRequest');
Route::post('/portal/ip-request', [TimesheetPortalController::class, 'submitIpRequest'])->name('portal.submitIpRequest');
Route::post('/portal/time-in', [TimesheetPortalController::class, 'timeIn'])->name('portal.timeIn');
Route::post('/portal/time-out', [TimesheetPortalController::class, 'timeOut'])->name('portal.timeOut');
Route::post('/portal/request-leave', [TimesheetPortalController::class, 'requestLeave'])->name('portal.requestLeave');
Route::post('/portal/request-cash-advance', [TimesheetPortalController::class, 'requestCashAdvance'])->name('portal.requestCashAdvance');
Route::post('/portal/logout', [TimesheetPortalController::class, 'logout'])->name('portal.logout');

// Storage fallback route for shared hosting / GoDaddy NFS cache latency
Route::get('/storage/{path}', function (string $path) {
    // Disallow path traversal attempts
    if (str_contains($path, '..')) {
        abort(404);
    }

    // 1. Check Laravel's configured public disk
    try {
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
        }
    } catch (\Throwable $e) {
        // Fall through to file checks
    }

    // 2. Check candidate public storage locations with path traversal prevention
    $candidateBases = array_filter([
        config('filesystems.disks.public.root'),
        env('FILESYSTEM_PUBLIC_ROOT'),
        storage_path('app/public'),
        public_path('storage'),
        base_path('../public_html/storage'),
        base_path('../../public_html/storage'),
    ]);

    foreach ($candidateBases as $base) {
        $realBase = realpath($base);
        if ($realBase && is_dir($realBase)) {
            $candidateFile = $realBase . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
            if (file_exists($candidateFile)) {
                $realFile = realpath($candidateFile);
                if ($realFile && str_starts_with($realFile, $realBase)) {
                    clearstatcache(true, $realFile);
                    return response()->file($realFile, [
                        'Cache-Control' => 'public, max-age=86400',
                    ]);
                }
            }
        }
    }

    abort(404);
})->where('path', '.*')->name('storage.fallback');
