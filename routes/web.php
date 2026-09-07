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
Route::post('/portal/time-in', [TimesheetPortalController::class, 'timeIn'])->name('portal.timeIn');
Route::post('/portal/time-out', [TimesheetPortalController::class, 'timeOut'])->name('portal.timeOut');
Route::post('/portal/request-leave', [TimesheetPortalController::class, 'requestLeave'])->name('portal.requestLeave');
Route::post('/portal/request-cash-advance', [TimesheetPortalController::class, 'requestCashAdvance'])->name('portal.requestCashAdvance');
Route::post('/portal/logout', [TimesheetPortalController::class, 'logout'])->name('portal.logout');



