<?php

use App\Http\Controllers\TimesheetPortalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/portal', [TimesheetPortalController::class, 'index'])->name('portal.index');
Route::get('/timesheet-portal', [TimesheetPortalController::class, 'index'])->name('portal.alias');
Route::post('/portal/time-in', [TimesheetPortalController::class, 'timeIn'])->name('portal.timeIn');
Route::post('/portal/time-out', [TimesheetPortalController::class, 'timeOut'])->name('portal.timeOut');
Route::post('/portal/request-leave', [TimesheetPortalController::class, 'requestLeave'])->name('portal.requestLeave');
Route::post('/portal/request-cash-advance', [TimesheetPortalController::class, 'requestCashAdvance'])->name('portal.requestCashAdvance');
Route::post('/portal/logout', [TimesheetPortalController::class, 'logout'])->name('portal.logout');



