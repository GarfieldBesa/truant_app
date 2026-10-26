<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Verification Required | Timesheet Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ───────────────────────────────────────────── */
        .portal-nav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.875rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
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
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            padding: 0.25rem 0.625rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .user-nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            color: #334155;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 9999px;
            background: #fef3c7;
            color: #d97706;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.8125rem;
        }

        .logout-btn {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #64748b;
            padding: 0.375rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .logout-btn:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        /* ── Main Container ───────────────────────────────────── */
        .portal-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1.5rem;
            position: relative;
        }

        /* Ambient background glow */
        .ambient-glow {
            position: absolute;
            pointer-events: none;
            border-radius: 9999px;
            filter: blur(80px);
            opacity: 0.45;
            z-index: 0;
        }

        .ambient-glow-1 {
            width: 360px;
            height: 360px;
            top: 10%;
            left: 20%;
            background: radial-gradient(circle, rgba(245, 158, 11, 0.35) 0%, rgba(245, 158, 11, 0) 70%);
        }

        .ambient-glow-2 {
            width: 320px;
            height: 320px;
            bottom: 10%;
            right: 20%;
            background: radial-gradient(circle, rgba(234, 88, 12, 0.3) 0%, rgba(234, 88, 12, 0) 70%);
        }

        /* ── Card Container ───────────────────────────────────── */
        .ip-card {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 620px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05), 0 20px 40px -10px rgba(245, 158, 11, 0.08);
            overflow: hidden;
        }

        .ip-card-top-bar {
            height: 5px;
            background: linear-gradient(90deg, #f59e0b 0%, #ea580c 100%);
        }

        .ip-card-body {
            padding: 2.5rem 2.25rem;
        }

        /* ── Status Pill ──────────────────────────────────────── */
        .ip-status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #fef3c7;
            border: 1px solid #fde68a;
            color: #b45309;
            margin-bottom: 1.25rem;
        }

        .ip-pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 9999px;
            background: #f59e0b;
            position: relative;
        }

        .ip-pulse-dot::after {
            content: '';
            position: absolute;
            inset: -4px;
            border-radius: 9999px;
            background: #f59e0b;
            opacity: 0.4;
            animation: pulse-ring 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.8); opacity: 0.8; }
            100% { transform: scale(2.2); opacity: 0; }
        }

        /* ── Headings ─────────────────────────────────────────── */
        .ip-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.025em;
            line-height: 1.3;
            margin-bottom: 0.5rem;
        }

        .ip-desc {
            font-size: 0.9375rem;
            line-height: 1.6;
            color: #64748b;
            margin-bottom: 1.75rem;
        }

        /* ── IP Highlight Box ─────────────────────────────────── */
        .ip-detected-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .ip-detected-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .ip-detected-value {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .ip-tag-unauthorized {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.625rem;
            border-radius: 9999px;
            font-size: 0.6875rem;
            font-weight: 800;
            text-transform: uppercase;
            background: #fee2e2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* ── Pending Request Alert ────────────────────────────── */
        .pending-box {
            background: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 1rem;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.75rem;
        }

        .pending-title {
            font-size: 0.9375rem;
            font-weight: 700;
            color: #92400e;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .pending-detail {
            font-size: 0.8125rem;
            color: #b45309;
            line-height: 1.5;
        }

        /* ── Form Controls ────────────────────────────────────── */
        .form-group {
            margin-bottom: 1.25rem;
            text-align: left;
        }

        .form-label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 0.375rem;
        }

        .form-select, .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.75rem;
            font-family: inherit;
            font-size: 0.875rem;
            color: #0f172a;
            background: #ffffff;
            outline: none;
            transition: all 0.15s ease;
        }

        .form-select:focus, .form-textarea:focus {
            border-color: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.15);
        }

        .form-textarea {
            min-height: 90px;
            resize: vertical;
        }

        .form-hint {
            font-size: 0.75rem;
            color: #64748b;
            margin-top: 0.375rem;
        }

        /* ── Submit & Action Buttons ──────────────────────────── */
        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #ffffff;
            border: none;
            padding: 0.875rem 1.5rem;
            font-size: 0.9375rem;
            font-weight: 700;
            border-radius: 0.75rem;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
            transition: all 0.15s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
            box-shadow: 0 6px 18px rgba(245, 158, 11, 0.4);
            transform: translateY(-1px);
        }

        .btn-check-again {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #334155;
            padding: 0.75rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 700;
            border-radius: 0.75rem;
            text-decoration: none;
            transition: all 0.15s ease;
            margin-top: 0.75rem;
        }

        .btn-check-again:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a;
        }

        /* ── Alerts ───────────────────────────────────────────── */
        .alert {
            padding: 0.875rem 1.25rem;
            border-radius: 0.75rem;
            font-size: 0.8125rem;
            font-weight: 600;
            margin-bottom: 1.25rem;
        }

        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
    </style>
</head>
<body>

    <!-- ── Navbar ── -->
    <header class="portal-nav">
        <a href="{{ route('portal.index') }}" class="portal-brand">
            <span>TRUANT</span>
            <span class="brand-badge">Timesheet</span>
        </a>

        <div class="user-nav-actions">
            <div class="user-badge">
                <div class="user-avatar">
                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                </div>
                <span>{{ $employee->first_name }} {{ $employee->last_name }}</span>
            </div>

            <form action="{{ route('portal.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Log Out</button>
            </form>
        </div>
    </header>

    <!-- ── Main Content ── -->
    <main class="portal-main">
        <div class="ambient-glow ambient-glow-1"></div>
        <div class="ambient-glow ambient-glow-2"></div>

        <div class="ip-card">
            <div class="ip-card-top-bar"></div>

            <div class="ip-card-body">
                <!-- Status Pill -->
                <div class="ip-status-pill">
                    <span class="ip-pulse-dot"></span>
                    Location Verification Required
                </div>

                <!-- Headings -->
                <h1 class="ip-title">Network Location Unverified</h1>
                <p class="ip-desc">
                    Your current network connection is not authorized for recording attendance. To time in or time out, you must be connected to an approved location network.
                </p>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-error">
                        <ul style="list-style: none;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Detected IP Box -->
                <div class="ip-detected-box">
                    <div>
                        <div class="ip-detected-label">Your Current IP Address</div>
                        <div class="ip-detected-value">
                            {{ $clientIp }}
                        </div>
                    </div>
                    <div>
                        <span class="ip-tag-unauthorized">Unregistered</span>
                    </div>
                </div>

                <!-- Assigned Locations Info -->
                @if($assignedLocations->isNotEmpty())
                    <div style="font-size: 0.8125rem; color: #64748b; margin-bottom: 1.5rem; line-height: 1.5;">
                        <strong style="color: #334155;">Your Assigned Location(s):</strong>
                        {{ $assignedLocations->pluck('name')->implode(', ') }}
                    </div>
                @endif

                <!-- If Pending Request Exists -->
                @if($pendingRequest)
                    <div class="pending-box">
                        <div class="pending-title">
                            <svg style="width:18px;height:18px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Pending Approval from Administrator
                        </div>
                        <div class="pending-detail">
                            You submitted an IP registration request for <strong>{{ $pendingRequest->location?->name ?? $pendingRequest->location_name }}</strong> with IP <code>{{ $pendingRequest->ip_address }}</code> on {{ $pendingRequest->created_at->format('M d, Y h:i A') }}.
                        </div>
                        <div class="pending-detail" style="margin-top: 0.375rem;">
                            <strong>Note:</strong> "{{ $pendingRequest->description }}"
                        </div>
                    </div>

                    <a href="{{ route('portal.index') }}" class="btn-check-again">
                        <svg style="width:16px;height:16px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Check Again / Refresh Status
                    </a>
                @else
                    <!-- Submission Form -->
                    <form action="{{ route('portal.submitIpRequest') }}" method="POST">
                        @csrf

                        <!-- Choose Location -->
                        <div class="form-group">
                            <label class="form-label" for="location_id">Select Location</label>
                            <select name="location_id" id="location_id" class="form-select">
                                @if($assignedLocations->isNotEmpty())
                                    <optgroup label="Your Assigned Locations">
                                        @foreach($assignedLocations as $loc)
                                            <option value="{{ $loc->id }}" selected>{{ $loc->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif

                                @if($allLocations->isNotEmpty())
                                    <optgroup label="All Locations">
                                        @foreach($allLocations as $loc)
                                            @if(!$assignedLocations->contains('id', $loc->id))
                                                <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                @else
                                    <option value="">No configured locations found</option>
                                @endif
                            </select>
                            <div class="form-hint">Choose which office or branch you are connecting from.</div>
                        </div>

                        <!-- Description / Note -->
                        <div class="form-group">
                            <label class="form-label" for="description">Note / Reason for Request <span style="color:#ef4444;">*</span></label>
                            <textarea
                                name="description"
                                id="description"
                                class="form-textarea"
                                placeholder="Explain why you are connecting from this IP (e.g., Office Wi-Fi router was restarted, Working from Crystal Cave branch, etc.)"
                                required
                            >{{ old('description') }}</textarea>
                            <div class="form-hint">Admin will review this description before approving your IP registration.</div>
                        </div>

                        <button type="submit" class="btn-submit">
                            Submit IP Registration Request
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </main>

</body>
</html>
