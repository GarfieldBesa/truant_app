<?php

namespace App\Http\Controllers;

use App\Models\CashAdvance;
use App\Models\Employee;
use App\Models\IpRequest;
use App\Models\LeaveRequest;
use App\Models\Location;
use App\Models\Timesheet;
use App\Services\PayrollCalculator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimesheetPortalController extends Controller
{
    /**
     * Check if employee's current IP is authorized for their assigned locations.
     */
    protected function verifyEmployeeIp(Employee $employee, Request $request): bool
    {
        $clientIp = $request->ip();

        return $employee->isIpAuthorized($clientIp);
    }

    /**
     * Display the timesheet portal.
     */
    public function index(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        // If an administrator is viewing without employee session
        if (! $employee && Auth::guard('web')->check()) {
            $employee = Employee::where('role', 'timesheet_portal')->first() ?? Employee::first();
        }

        if (! $employee) {
            return redirect('/admin/login');
        }

        if (Auth::guard('employee')->check() && ! $employee->hasTimesheetPortalAccess()) {
            Auth::guard('employee')->logout();

            return redirect('/admin/login')->withErrors([
                'email' => 'Your account does not have access to the timesheet portal.',
            ]);
        }

        // Verify IP address for employee's assigned locations
        if (! $this->verifyEmployeeIp($employee, $request)) {
            return redirect()->route('portal.ipRequest');
        }

        // Philippine Time Context
        $phNow = Carbon::now('Asia/Manila');
        $todayDate = $phNow->toDateString();

        // Check Today's Timesheet Status
        $todayTimesheet = Timesheet::where('employee_id', $employee->id)
            ->where('date', $todayDate)
            ->first();

        $timedIn = !empty($todayTimesheet?->time_in);
        $timedOut = !empty($todayTimesheet?->time_out);
        $canTimeIn = !$timedIn;
        $canTimeOut = $timedIn && !$timedOut;
        $isCompletedToday = $timedIn && $timedOut;

        // Cutoff selection parameters
        $year = (int) $request->input('year', $phNow->year);
        $month = (int) $request->input('month', $phNow->month);
        $defaultCutoff = $phNow->day <= 15 ? '1-15' : '16-30';
        $cutoff = $request->input('cutoff', $defaultCutoff);
        if (!in_array($cutoff, ['1-15', '16-30'])) {
            $cutoff = $defaultCutoff;
        }

        // Fetch payroll and timesheet calculations for the selected cutoff
        $calculator = app(PayrollCalculator::class);
        $payrollData = $calculator->calculate($year, $month, $cutoff, $employee->id);
        $cutoffRecord = $payrollData['employees'][0] ?? null;
        $dailyLogs = $cutoffRecord['days'] ?? [];

        // Active tab
        $activeTab = $request->input('tab', session('tab', 'attendance'));
        if (!in_array($activeTab, ['attendance', 'leaves', 'cash_advances'])) {
            $activeTab = 'attendance';
        }

        // Fetch requests history
        $leaveRequests = LeaveRequest::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $cashAdvances = CashAdvance::where('employee_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('portal.timesheet', compact(
            'employee',
            'phNow',
            'todayDate',
            'todayTimesheet',
            'timedIn',
            'timedOut',
            'canTimeIn',
            'canTimeOut',
            'isCompletedToday',
            'year',
            'month',
            'cutoff',
            'payrollData',
            'cutoffRecord',
            'dailyLogs',
            'activeTab',
            'leaveRequests',
            'cashAdvances'
        ));
    }

    /**
     * Record Time In (Strictly Philippine Time, single entry per day).
     */
    public function timeIn(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        if (! $employee && Auth::guard('web')->check()) {
            $employee = Employee::where('role', 'timesheet_portal')->first() ?? Employee::first();
        }

        if (! $employee) {
            return redirect('/admin/login');
        }

        // Verify IP address for employee's assigned locations
        if (! $this->verifyEmployeeIp($employee, $request)) {
            return redirect()->route('portal.ipRequest')->with('error', 'Unauthorized location IP address. Please submit an IP registration request.');
        }

        $phNow = Carbon::now('Asia/Manila');
        $todayDate = $phNow->toDateString();
        $currentTime = $phNow->format('H:i:s');

        // Check or create timesheet record
        $timesheet = Timesheet::firstOrNew([
            'employee_id' => $employee->id,
            'date' => $todayDate,
        ]);

        // Validation: duplicate prevention
        if (!empty($timesheet->time_in)) {
            return redirect()->back()->with('error', 'You have already timed in for today (' . Carbon::parse($timesheet->time_in)->format('h:i A') . ').');
        }

        $timesheet->time_in = $currentTime;
        $timesheet->save();

        return redirect()->back()->with('success', 'Time In successfully recorded at ' . $phNow->format('h:i:s A') . ' (Philippine Time).');
    }

    /**
     * Record Time Out (Strictly Philippine Time, single entry per day).
     */
    public function timeOut(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        if (! $employee && Auth::guard('web')->check()) {
            $employee = Employee::where('role', 'timesheet_portal')->first() ?? Employee::first();
        }

        if (! $employee) {
            return redirect('/admin/login');
        }

        // Verify IP address for employee's assigned locations
        if (! $this->verifyEmployeeIp($employee, $request)) {
            return redirect()->route('portal.ipRequest')->with('error', 'Unauthorized location IP address. Please submit an IP registration request.');
        }

        $phNow = Carbon::now('Asia/Manila');
        $todayDate = $phNow->toDateString();
        $currentTime = $phNow->format('H:i:s');

        $timesheet = Timesheet::where('employee_id', $employee->id)
            ->where('date', $todayDate)
            ->first();

        // Validation: must have timed in first
        if (! $timesheet || empty($timesheet->time_in)) {
            return redirect()->back()->with('error', 'You cannot time out without timing in first.');
        }

        // Validation: duplicate prevention
        if (!empty($timesheet->time_out)) {
            return redirect()->back()->with('error', 'You have already timed out for today (' . Carbon::parse($timesheet->time_out)->format('h:i A') . ').');
        }

        $timesheet->time_out = $currentTime;
        $timesheet->save();

        return redirect()->back()->with('success', 'Time Out successfully recorded at ' . $phNow->format('h:i:s A') . ' (Philippine Time).');
    }

    /**
     * Show IP Registration Request Page.
     */
    public function showIpRequest(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        if (! $employee && Auth::guard('web')->check()) {
            $employee = Employee::where('role', 'timesheet_portal')->first() ?? Employee::first();
        }

        if (! $employee) {
            return redirect('/admin/login');
        }

        $clientIp = $request->ip();

        // If IP is already authorized, redirect straight to portal
        if ($this->verifyEmployeeIp($employee, $request)) {
            return redirect()->route('portal.index')->with('success', 'Your location and IP address are verified.');
        }

        $assignedLocations = $employee->locations;
        $allLocations = Location::orderBy('name')->get();

        $pendingRequest = IpRequest::where('employee_id', $employee->id)
            ->where('status', 'pending')
            ->latest()
            ->first();

        return view('portal.ip-request', compact(
            'employee',
            'clientIp',
            'assignedLocations',
            'allLocations',
            'pendingRequest'
        ));
    }

    /**
     * Submit an IP Registration Request.
     */
    public function submitIpRequest(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        if (! $employee && Auth::guard('web')->check()) {
            $employee = Employee::where('role', 'timesheet_portal')->first() ?? Employee::first();
        }

        if (! $employee) {
            return redirect('/admin/login');
        }

        $validated = $request->validate([
            'location_id' => 'nullable',
            'location_name' => 'nullable|string|max:255',
            'description' => 'required|string|max:1000',
        ], [
            'description.required' => 'Please provide a note or description for this IP request.',
        ]);

        $clientIp = $request->ip();

        $locationName = null;
        $locationId = null;

        if (! empty($validated['location_id'])) {
            $location = Location::find($validated['location_id']);
            if ($location) {
                $locationId = $location->id;
                $locationName = $location->name;
            }
        }

        if (empty($locationName)) {
            $locationName = $validated['location_name'] ?? 'Requested Location';
        }

        IpRequest::create([
            'employee_id' => $employee->id,
            'location_id' => $locationId,
            'location_name' => $locationName,
            'ip_address' => $clientIp,
            'description' => $validated['description'],
            'status' => 'pending',
        ]);

        return redirect()->route('portal.ipRequest')->with('success', 'Your IP registration request has been submitted to the administrator. You will be able to access the portal once approved.');
    }

    /**
     * Submit a Leave Request.
     */
    public function requestLeave(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        if (! $employee && Auth::guard('web')->check()) {
            $employee = Employee::where('role', 'timesheet_portal')->first() ?? Employee::first();
        }

        if (! $employee) {
            return redirect('/admin/login');
        }

        $todayPH = Carbon::now('Asia/Manila')->toDateString();

        $validated = $request->validate([
            'leave_type' => 'required|string|in:Vacation Leave,Sick Leave,Emergency Leave,Personal Leave',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'nullable|string|max:500',
        ]);

        // Strict Philippine Time past date validation
        if ($validated['start_date'] < $todayPH) {
            return redirect()->route('portal.index', ['tab' => 'leaves'])
                ->withInput()
                ->with('error', 'Past dates are not available for requesting leaves. Please select today or a future date.');
        }

        LeaveRequest::create([
            'employee_id' => $employee->id,
            'leave_type' => $validated['leave_type'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'reason' => $validated['reason'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('portal.index', ['tab' => 'leaves'])
            ->with('success', 'Leave request submitted successfully. Awaiting administrator approval.');
    }

    /**
     * Submit a Cash Advance Request.
     */
    public function requestCashAdvance(Request $request)
    {
        $employee = Auth::guard('employee')->user();

        if (! $employee && Auth::guard('web')->check()) {
            $employee = Employee::where('role', 'timesheet_portal')->first() ?? Employee::first();
        }

        if (! $employee) {
            return redirect('/admin/login');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'reason' => 'nullable|string|max:500',
        ]);

        CashAdvance::create([
            'employee_id' => $employee->id,
            'amount' => $validated['amount'],
            'reason' => $validated['reason'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('portal.index', ['tab' => 'cash_advances'])
            ->with('success', 'Cash advance request for ₱' . number_format($validated['amount'], 2) . ' submitted successfully. Awaiting administrator approval.');
    }

    /**
     * Log out of the portal session.
     */
    public function logout(Request $request)
    {
        Auth::guard('employee')->logout();
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
