<?php

use App\Http\Controllers\TimesheetPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/portal', [TimesheetPortalController::class, 'index'])->name('portal.index');
Route::get('/timesheet-portal', [TimesheetPortalController::class, 'index'])->name('portal.alias');
Route::post('/portal/logout', [TimesheetPortalController::class, 'logout'])->name('portal.logout');

