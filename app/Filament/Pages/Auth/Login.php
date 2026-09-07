<?php

namespace App\Filament\Pages\Auth;

use App\Models\Employee;
use App\Models\User;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function mount(): void
    {
        if (Filament::auth()->check()) {
            redirect()->intended(Filament::getUrl());
        }

        if (Auth::guard('employee')->check()) {
            $employee = Auth::guard('employee')->user();
            if ($employee && $employee->isAdmin()) {
                redirect()->intended(Filament::getUrl());
            }

            redirect()->intended('/portal');
        }

        $this->form->fill();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Email or Username')
            ->required()
            ->autocomplete()
            ->autofocus();
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $this->rateLimit(5);
        } catch (TooManyRequestsException $exception) {
            $this->getRateLimitedNotification($exception)?->send();

            return null;
        }

        $data = $this->form->getState();
        $login = trim($data['email'] ?? '');
        $password = $data['password'] ?? '';
        $remember = (bool) ($data['remember'] ?? false);

        // 1. Check if credentials match an Admin (User)
        $adminUser = User::where('email', $login)->first();
        if ($adminUser && Hash::check($password, $adminUser->password)) {
            Filament::auth()->login($adminUser, $remember);
            session()->regenerate();

            return app(LoginResponse::class);
        }

        // 2. Check if credentials match an Employee
        $employee = Employee::where('username', $login)->first();
        if ($employee && Hash::check($password, $employee->password)) {
            // If employee has administrator privileges
            if ($employee->isAdmin()) {
                $user = User::firstOrNew(['email' => $employee->username]);
                $user->name = "{$employee->first_name} {$employee->last_name}";
                $user->password = $employee->password;
                $user->save();

                Filament::auth()->login($user, $remember);
                Auth::guard('employee')->login($employee, $remember);
                session()->regenerate();

                return app(LoginResponse::class);
            }

            // If employee has timesheet portal access
            if ($employee->hasTimesheetPortalAccess()) {
                Auth::guard('employee')->login($employee, $remember);
                session()->regenerate();

                return new class implements LoginResponse {
                    public function toResponse($request)
                    {
                        return redirect()->intended('/portal');
                    }
                };
            }

            throw ValidationException::withMessages([
                'data.email' => 'Your account does not have access permissions. Please contact an administrator.',
            ]);
        }

        $this->throwFailureValidationException();
    }
}
