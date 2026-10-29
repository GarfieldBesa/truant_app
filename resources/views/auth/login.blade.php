<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login — Truant Enterprises</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;
            --text-title: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --radius-md: 12px;
            --radius-lg: 16px;
            --font-sans: 'Plus Jakarta Sans', system-ui, sans-serif;
            --font-display: 'Space Grotesk', var(--font-sans);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: var(--font-sans);
            background-color: var(--bg-page);
            color: var(--text-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 440px;
            padding: 36px 32px;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
        }

        .auth-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 22px;
            text-decoration: none;
            color: var(--text-title);
        }
        .brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }
        .brand-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 800;
        }

        .auth-title {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-title);
            text-align: center;
            margin-bottom: 6px;
        }
        .auth-sub {
            font-size: 0.88rem;
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 24px;
        }

        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            width: 100%;
            background: #ffffff;
            color: #1f2937;
            border: 1.5px solid #d1d5db;
            border-radius: 10px;
            padding: 11px 16px;
            font-size: 0.94rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .btn-google:hover {
            background: #f9fafb;
            border-color: #9ca3af;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            transform: translateY(-1px);
        }

        .auth-divider {
            display: flex;
            align-items: center;
            margin: 22px 0;
            color: var(--text-muted);
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .auth-divider::before, .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }
        .auth-divider span { padding: 0 12px; }

        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--text-body);
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            background: #ffffff;
            border: 1.5px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.92rem;
            color: var(--text-title);
            font-family: var(--font-sans);
            outline: none;
            transition: all 0.15s;
        }
        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 0.82rem;
        }
        .remember-wrap {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
            cursor: pointer;
        }

        .btn-submit {
            width: 100%;
            background: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s;
            box-shadow: 0 3px 10px rgba(79, 70, 229, 0.25);
        }
        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .auth-footer {
            margin-top: 22px;
            text-align: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        .auth-footer a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }
        .auth-footer a:hover { text-decoration: underline; }

        .alert {
            padding: 10px 14px;
            border-radius: 8px;
            font-size: 0.84rem;
            margin-bottom: 18px;
            line-height: 1.45;
        }
        .alert-danger { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    </style>
</head>
<body>
    <div class="auth-card">
        <a href="{{ url('/') }}" class="auth-brand">
            <div class="brand-icon">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <span class="brand-title">Truant Enterprises</span>
        </a>

        <h1 class="auth-title">Welcome Back</h1>
        <p class="auth-sub">Sign in to view your court bookings, history, and reservations</p>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
        @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <!-- Google Sign In Button -->
        <a href="{{ route('auth.google') }}" class="btn-google">
            <svg width="20" height="20" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
            </svg>
            <span>Continue with Google</span>
        </a>

        <div class="auth-divider">
            <span>or sign in with email</span>
        </div>

        <!-- Email & Password Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-input" placeholder="juan@example.com" required autofocus>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>

            <div class="form-options">
                <label class="remember-wrap">
                    <input type="checkbox" name="remember" style="accent-color: var(--primary);">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">
                Sign In &rarr;
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account yet? <a href="{{ route('register') }}">Create an account</a><br>
            <div style="margin-top: 10px;">
                <a href="{{ route('court-booking.index') }}" style="color: var(--text-muted); font-size: 0.8rem;">&larr; Return to Court Booking</a>
            </div>
        </div>
    </div>
</body>
</html>
