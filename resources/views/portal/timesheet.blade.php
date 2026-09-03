<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheet Portal | Truant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .portal-nav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.875rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
        }
        .portal-brand {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            font-weight: 800;
            font-size: 1.125rem;
            color: #1e293b;
            text-decoration: none;
        }
        .brand-badge {
            background: #f59e0b;
            color: #ffffff;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .user-info {
            text-align: right;
        }
        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
        }
        .user-role {
            font-size: 0.75rem;
            color: #64748b;
        }
        .btn-logout {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 0.45rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }
        .btn-logout:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        .portal-container {
            max-width: 900px;
            width: 100%;
            margin: 2.5rem auto;
            padding: 0 1.25rem;
            flex: 1;
        }
        .portal-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            text-align: center;
        }
        .portal-header {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            color: #0f172a;
            margin-bottom: 0.75rem;
        }
        .portal-subtitle {
            font-size: 1rem;
            color: #64748b;
            max-width: 540px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }
        .badge-portal {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            background: #ecfdf5;
            color: #059669;
            border: 1px solid #a7f3d0;
            padding: 0.35rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.8125rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }
        .badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
        }
    </style>
</head>
<body>

    <nav class="portal-nav">
        <a href="{{ url('/portal') }}" class="portal-brand">
            <span>Truant</span>
            <span class="brand-badge">Portal</span>
        </a>

        <div class="user-menu">
            @php
                $user = auth('employee')->user() ?? auth('web')->user();
                $displayName = $user ? ($user->first_name ? ($user->first_name . ' ' . $user->last_name) : $user->name) : 'User';
                $roleLabel = auth('employee')->check() ? ($user->position?->name ?? 'Timesheet Portal') : 'Administrator';
            @endphp
            <div class="user-info">
                <div class="user-name">{{ $displayName }}</div>
                <div class="user-role">{{ $roleLabel }}</div>
            </div>

            <form method="POST" action="{{ route('portal.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </nav>

    <main class="portal-container">
        <div class="portal-card">
            <div class="badge-portal">
                <span class="badge-dot"></span>
                <span>Active Portal Session</span>
            </div>

            <h1 class="portal-header">hello timesheet portal</h1>

            <p class="portal-subtitle">
                Welcome to the employee timesheet entry portal. This dedicated space is designed for daily attendance and timesheet logging outside the administrative dashboard.
            </p>
        </div>
    </main>

</body>
</html>
