<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimesheetPortalController extends Controller
{
    public function index()
    {
        if (Auth::guard('employee')->check()) {
            $employee = Auth::guard('employee')->user();

            if (! $employee->hasTimesheetPortalAccess()) {
                Auth::guard('employee')->logout();

                return redirect('/admin/login')->withErrors([
                    'email' => 'Your account does not have access to the timesheet portal.',
                ]);
            }

            return view('portal.timesheet', compact('employee'));
        }

        if (Auth::guard('web')->check()) {
            return view('portal.timesheet');
        }

        return redirect('/admin/login');
    }

    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
