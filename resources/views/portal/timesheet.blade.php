<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timesheet Portal | Truant</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f1f5f9;
            color: #0f172a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Navbar ───────────────────────────────────────────── */
        .portal-nav {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.875rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .portal-brand {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            font-weight: 800;
            font-size: 1.25rem;
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

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-size: 0.9375rem;
            font-weight: 700;
            color: #1e293b;
        }

        .user-role {
            font-size: 0.75rem;
            color: #64748b;
            font-weight: 500;
        }

        .btn-logout {
            background: #f8fafc;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 0.45rem 0.875rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
        }

        .btn-logout:hover {
            background: #fee2e2;
            color: #b91c1c;
            border-color: #fca5a5;
        }

        /* ── Layout Container ─────────────────────────────────── */
        .portal-container {
            max-width: 1060px;
            width: 100%;
            margin: 2rem auto;
            padding: 0 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 1.75rem;
        }

        /* ── Alerts ───────────────────────────────────────────── */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        /* ── Header & Live Clock Card ─────────────────────────── */
        .clock-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 2rem 2.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.04), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.75rem;
        }

        .clock-left {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
            min-width: 280px;
        }

        .portal-title {
            font-size: 1.875rem;
            font-weight: 800;
            letter-spacing: -0.025em;
            color: #0f172a;
        }

        .portal-desc {
            font-size: 0.9375rem;
            color: #64748b;
        }

        .clock-right-wrap {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .clock-display {
            background: #0f172a;
            color: #ffffff;
            border-radius: 1rem;
            padding: 1.25rem 1.75rem;
            text-align: center;
            min-width: 290px;
            box-shadow: 0 10px 15px -3px rgba(15, 23, 42, 0.15);
        }

        .clock-ph-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.6875rem;
            font-weight: 700;
            color: #38bdf8;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 0.35rem;
        }

        .clock-time {
            font-size: 2.25rem;
            font-weight: 900;
            letter-spacing: 0.05em;
            font-variant-numeric: tabular-nums;
            color: #f8fafc;
            line-height: 1.1;
        }

        .clock-date {
            font-size: 0.8125rem;
            color: #94a3b8;
            font-weight: 500;
            margin-top: 0.4rem;
        }

        /* ── Action Buttons beside clock ──────────────────────── */
        .request-btns-stack {
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
            min-width: 170px;
        }

        .btn-portal-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            border-radius: 0.625rem;
            font-size: 0.8125rem;
            font-weight: 700;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.15s ease;
            text-decoration: none;
            width: 100%;
        }

        .btn-leave-req {
            background: #3b82f6;
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.25);
        }

        .btn-leave-req:hover {
            background: #2563eb;
        }

        .btn-advance-req {
            background: #f59e0b;
            color: #ffffff;
            box-shadow: 0 2px 4px rgba(245, 158, 11, 0.25);
        }

        .btn-advance-req:hover {
            background: #d97706;
        }

        /* ── Action Punch Grid ────────────────────────────────── */
        .action-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.25rem;
        }

        @media (max-width: 768px) {
            .action-grid { grid-template-columns: 1fr; }
            .clock-card { flex-direction: column; align-items: stretch; text-align: center; }
            .clock-right-wrap { flex-direction: column; width: 100%; }
            .clock-display { width: 100%; min-width: auto; }
            .request-btns-stack { width: 100%; flex-direction: row; }
        }

        .action-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 1.25rem;
        }

        .action-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .action-badge {
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            padding: 0.2rem 0.55rem;
            border-radius: 0.375rem;
            letter-spacing: 0.05em;
        }

        .badge-in-pending { background: #dbeafe; color: #1e40af; }
        .badge-in-done    { background: #dcfce7; color: #15803d; }
        .badge-out-pending{ background: #fef3c7; color: #92400e; }
        .badge-out-done   { background: #fed7aa; color: #9a3412; }

        .action-status-text {
            font-size: 0.875rem;
            color: #64748b;
        }

        .action-timestamp {
            font-size: 1.375rem;
            font-weight: 800;
            color: #0f172a;
            font-variant-numeric: tabular-nums;
            margin-top: 0.25rem;
        }

        .btn-punch {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border-radius: 0.625rem;
            font-size: 1rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-time-in {
            background: #10b981;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.25);
        }
        .btn-time-in:hover:not(:disabled) {
            background: #059669;
        }

        .btn-time-out {
            background: #f59e0b;
            color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.25);
        }
        .btn-time-out:hover:not(:disabled) {
            background: #d97706;
        }

        .btn-punch:disabled {
            background: #e2e8f0;
            color: #94a3b8;
            cursor: not-allowed;
            box-shadow: none;
        }

        /* ── Tabs Navigation ──────────────────────────────────── */
        .portal-tabs-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        .tabs-header-bar {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
            padding: 0 1rem;
            overflow-x: auto;
        }

        .portal-tab-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
            font-weight: 700;
            color: #64748b;
            text-decoration: none;
            border-bottom: 2px solid transparent;
            transition: all 0.15s ease;
            white-space: nowrap;
        }

        .portal-tab-btn:hover {
            color: #1e293b;
        }

        .portal-tab-btn.active {
            color: #f59e0b;
            border-bottom-color: #f59e0b;
            background: #ffffff;
        }

        .tab-counter {
            background: #e2e8f0;
            color: #475569;
            font-size: 0.6875rem;
            font-weight: 800;
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
        }

        .portal-tab-btn.active .tab-counter {
            background: #fef3c7;
            color: #92400e;
        }

        /* ── History Header & Filter ──────────────────────────── */
        .history-top {
            padding: 1.25rem 1.75rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .history-title {
            font-size: 1.0625rem;
            font-weight: 800;
            color: #0f172a;
        }

        .history-filter-form {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            flex-wrap: wrap;
        }

        .select-filter {
            padding: 0.45rem 0.75rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #1e293b;
            background: #ffffff;
            cursor: pointer;
        }

        .cutoff-toggle-group {
            display: inline-flex;
            background: #f1f5f9;
            padding: 0.2rem;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
        }

        .cutoff-btn {
            padding: 0.35rem 0.75rem;
            border-radius: 0.375rem;
            font-size: 0.75rem;
            font-weight: 700;
            color: #64748b;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .cutoff-btn.active {
            background: #ffffff;
            color: #0f172a;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }

        .btn-print-dtr {
            background: #1e293b;
            color: #ffffff;
            border: 1px solid #0f172a;
            padding: 0.45rem 0.95rem;
            border-radius: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            transition: background 0.15s ease;
        }

        .btn-print-dtr:hover {
            background: #334155;
        }

        /* ── Cutoff KPI Summary ───────────────────────────────── */
        .cutoff-kpi-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1px;
            background: #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }

        .kpi-cell {
            background: #f8fafc;
            padding: 1rem 1.5rem;
            text-align: center;
        }

        .kpi-label {
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        .kpi-val {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            font-variant-numeric: tabular-nums;
            margin-top: 0.2rem;
        }

        /* ── Table Layout ─────────────────────────────────────── */
        .table-wrap {
            overflow-x: auto;
        }

        .timesheet-tbl {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8125rem;
            text-align: left;
        }

        .timesheet-tbl thead th {
            background: #f8fafc;
            color: #64748b;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .timesheet-tbl tbody td {
            padding: 0.875rem 1rem;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            vertical-align: middle;
        }

        .timesheet-tbl tbody tr:last-child td {
            border-bottom: none;
        }

        .timesheet-tbl tbody tr:hover {
            background: #f8fafc;
        }

        .today-row {
            background: #fffbeb !important;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.6rem;
            border-radius: 0.375rem;
            font-size: 0.6875rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-late    { background: #fee2e2; color: #991b1b; }
        .badge-leave   { background: #dbeafe; color: #1e40af; }
        .badge-none    { color: #94a3b8; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-approved{ background: #dcfce7; color: #166534; }
        .badge-declined{ background: #fee2e2; color: #991b1b; }

        /* ── Interactive Modals ───────────────────────────────── */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-box {
            background: #ffffff;
            border-radius: 1.25rem;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: modalPop 0.15s ease-out;
        }

        @keyframes modalPop {
            from { transform: scale(0.96); opacity: 0; }
            to   { transform: scale(1); opacity: 1; }
        }

        .modal-head {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-size: 1.125rem;
            font-weight: 800;
            color: #0f172a;
        }

        .modal-close {
            background: transparent;
            border: none;
            color: #94a3b8;
            font-size: 1.5rem;
            cursor: pointer;
            line-height: 1;
        }
        .modal-close:hover { color: #0f172a; }

        .modal-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.125rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }

        .form-label {
            font-size: 0.8125rem;
            font-weight: 700;
            color: #334155;
        }

        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1.5px solid #cbd5e1;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #0f172a;
            outline: none;
            font-family: inherit;
        }

        .form-input:focus, .form-textarea:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .form-helper {
            font-size: 0.75rem;
            color: #64748b;
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        .btn-secondary {
            padding: 0.5rem 1rem;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 0.8125rem;
            cursor: pointer;
        }

        .btn-primary-submit {
            padding: 0.5rem 1.25rem;
            background: #3b82f6;
            color: #ffffff;
            border: none;
            border-radius: 0.5rem;
            font-weight: 700;
            font-size: 0.8125rem;
            cursor: pointer;
        }
        .btn-primary-submit:hover { background: #2563eb; }

        .btn-advance-submit {
            background: #f59e0b;
        }
        .btn-advance-submit:hover { background: #d97706; }

        /* ── Printable DTR (Hidden by default, shown during print) ── */
        .dtr-print-container {
            display: none;
        }

        @media print {
            body {
                background: #ffffff !important;
                color: #000000 !important;
            }

            .no-print {
                display: none !important;
            }

            .dtr-print-container {
                display: block !important;
                padding: 1.5cm 1.5cm;
                font-family: Arial, Helvetica, sans-serif;
                color: #000000;
            }

            .dtr-header {
                text-align: center;
                margin-bottom: 1.5rem;
                border-bottom: 2px solid #000000;
                padding-bottom: 0.75rem;
            }

            .dtr-company {
                font-size: 1.25rem;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .dtr-title {
                font-size: 1.1rem;
                font-weight: bold;
                margin-top: 0.25rem;
            }

            .dtr-meta-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 0.5rem 2rem;
                font-size: 0.85rem;
                margin-bottom: 1.25rem;
            }

            .dtr-meta-item {
                display: flex;
                gap: 0.5rem;
            }

            .dtr-meta-label {
                font-weight: bold;
                min-width: 90px;
            }

            .dtr-table {
                width: 100%;
                border-collapse: collapse;
                font-size: 0.75rem;
                margin-bottom: 1.5rem;
            }

            .dtr-table th, .dtr-table td {
                border: 1px solid #000000;
                padding: 0.35rem 0.5rem;
                text-align: center;
            }

            .dtr-table th {
                background: #f1f1f1 !important;
                font-weight: bold;
                text-transform: uppercase;
                -webkit-print-color-adjust: exact;
            }

            .dtr-table .text-left {
                text-align: left;
            }

            .dtr-cert {
                font-size: 0.75rem;
                line-height: 1.5;
                font-style: italic;
                margin-bottom: 2rem;
                text-align: justify;
            }

            .dtr-signatures {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 3rem;
                text-align: center;
                margin-top: 2rem;
            }

            .sig-line {
                border-top: 1px solid #000000;
                margin-top: 2.5rem;
                padding-top: 0.4rem;
                font-size: 0.85rem;
                font-weight: bold;
            }

            .sig-title {
                font-size: 0.75rem;
                color: #555555;
            }
        }
    </style>
</head>
<body>

    <!-- ── Header Bar ────────────────────────────────────────── -->
    <nav class="portal-nav no-print">
        <a href="{{ url('/portal') }}" class="portal-brand">
            <span>Truant</span>
            <span class="brand-badge">Portal</span>
        </a>

        <div class="user-menu">
            <div class="user-info">
                <div class="user-name">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                <div class="user-role">{{ $employee->position?->name ?? 'Timesheet Portal' }}</div>
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

    <!-- ── Main Screen Container ─────────────────────────────── -->
    <main class="portal-container no-print">

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="alert alert-error">
                <div>
                    @foreach($errors->all() as $err)
                        <div>• {{ $err }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Live Clock & Greeting Card with Request Buttons -->
        <section class="clock-card">
            <div class="clock-left">
                <h1 class="portal-title">hello timesheet portal</h1>
                <p class="portal-desc">
                    Welcome back, <strong>{{ $employee->first_name }}</strong>. Track your shift attendance or submit leave and cash advance requests below.
                </p>
            </div>

            <div class="clock-right-wrap">
                <!-- Clock Display -->
                <div class="clock-display">
                    <div class="clock-ph-tag">
                        <span>🇵🇭 Philippine Time (UTC+8)</span>
                    </div>
                    <div id="liveClockTime" class="clock-time">--:--:-- --</div>
                    <div id="liveClockDate" class="clock-date">Loading date...</div>
                </div>

                <!-- Request Action Buttons Beside Clock -->
                <div class="request-btns-stack">
                    <button type="button" class="btn-portal-action btn-leave-req" onclick="openModal('leaveModal')">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>Request Leave</span>
                    </button>

                    <button type="button" class="btn-portal-action btn-advance-req" onclick="openModal('advanceModal')">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                            <circle cx="12" cy="12" r="2"></circle>
                            <path d="M6 12h.01M18 12h.01"></path>
                        </svg>
                        <span>Cash Advance</span>
                    </button>
                </div>
            </div>
        </section>

        <!-- Time In & Time Out Action Buttons -->
        <section class="action-grid">
            <!-- TIME IN CARD -->
            <div class="action-card">
                <div>
                    <div class="action-header">
                        <span class="action-badge {{ $timedIn ? 'badge-in-done' : 'badge-in-pending' }}">
                            {{ $timedIn ? 'Timed In' : 'Ready' }}
                        </span>
                        <span class="action-status-text">Step 1</span>
                    </div>

                    <div style="margin-top: 0.75rem;">
                        <span class="action-status-text">Morning / Shift Arrival</span>
                        <div class="action-timestamp">
                            @if($timedIn)
                                {{ Carbon\Carbon::parse($todayTimesheet->time_in)->format('h:i:s A') }}
                            @else
                                Not Recorded Today
                            @endif
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('portal.timeIn') }}">
                    @csrf
                    <button type="submit" class="btn-punch btn-time-in" {{ $canTimeIn ? '' : 'disabled' }}>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 11 12 14 22 4"></polyline>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                        <span>{{ $timedIn ? 'Time In Recorded' : 'Record Time In' }}</span>
                    </button>
                </form>
            </div>

            <!-- TIME OUT CARD -->
            <div class="action-card">
                <div>
                    <div class="action-header">
                        <span class="action-badge {{ $timedOut ? 'badge-out-done' : 'badge-out-pending' }}">
                            {{ $timedOut ? 'Timed Out' : ($timedIn ? 'Shift In Progress' : 'Awaiting Time In') }}
                        </span>
                        <span class="action-status-text">Step 2</span>
                    </div>

                    <div style="margin-top: 0.75rem;">
                        <span class="action-status-text">Evening / Shift Departure</span>
                        <div class="action-timestamp">
                            @if($timedOut)
                                {{ Carbon\Carbon::parse($todayTimesheet->time_out)->format('h:i:s A') }}
                            @elseif($timedIn)
                                In Progress...
                            @else
                                Awaiting Time In
                            @endif
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('portal.timeOut') }}">
                    @csrf
                    <button type="submit" class="btn-punch btn-time-out" {{ $canTimeOut ? '' : 'disabled' }}>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" y1="12" x2="3" y2="12"></line>
                        </svg>
                        <span>{{ $timedOut ? 'Time Out Recorded' : 'Record Time Out' }}</span>
                    </button>
                </form>
            </div>
        </section>

        <!-- ── Portal Tabs Card (Attendance History, Leave Requests, Cash Advances) ── -->
        <section class="portal-tabs-card">
            <!-- Tabs Navigation Bar -->
            <div class="tabs-header-bar">
                <a href="{{ route('portal.index', ['year' => $year, 'month' => $month, 'cutoff' => $cutoff, 'tab' => 'attendance']) }}" 
                   class="portal-tab-btn {{ $activeTab === 'attendance' ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12 6 12 12 16 14"></polyline>
                    </svg>
                    <span>Attendance History</span>
                </a>

                <a href="{{ route('portal.index', ['year' => $year, 'month' => $month, 'cutoff' => $cutoff, 'tab' => 'leaves']) }}" 
                   class="portal-tab-btn {{ $activeTab === 'leaves' ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    <span>Leave Requests</span>
                    <span class="tab-counter">{{ $leaveRequests->count() }}</span>
                </a>

                <a href="{{ route('portal.index', ['year' => $year, 'month' => $month, 'cutoff' => $cutoff, 'tab' => 'cash_advances']) }}" 
                   class="portal-tab-btn {{ $activeTab === 'cash_advances' ? 'active' : '' }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                        <circle cx="12" cy="12" r="2"></circle>
                    </svg>
                    <span>Cash Advances</span>
                    <span class="tab-counter">{{ $cashAdvances->count() }}</span>
                </a>
            </div>

            <!-- TAB 1: ATTENDANCE HISTORY -->
            @if($activeTab === 'attendance')
                <div>
                    <div class="history-top">
                        <div class="history-title">
                            Daily Time Records & Cutoff Breakdown
                        </div>

                        <div class="history-filter-form">
                            <!-- Cutoff Toggle (1-15 vs 16-30) -->
                            <div class="cutoff-toggle-group">
                                <a href="{{ route('portal.index', ['year' => $year, 'month' => $month, 'cutoff' => '1-15', 'tab' => 'attendance']) }}" 
                                   class="cutoff-btn {{ $cutoff === '1-15' ? 'active' : '' }}">
                                    1st – 15th
                                </a>
                                <a href="{{ route('portal.index', ['year' => $year, 'month' => $month, 'cutoff' => '16-30', 'tab' => 'attendance']) }}" 
                                   class="cutoff-btn {{ $cutoff === '16-30' ? 'active' : '' }}">
                                    16th – End
                                </a>
                            </div>

                            <!-- Month Selector -->
                            <form method="GET" action="{{ route('portal.index') }}" style="display:inline-flex; gap:0.5rem;">
                                <input type="hidden" name="tab" value="attendance">
                                <input type="hidden" name="cutoff" value="{{ $cutoff }}">
                                <select name="month" class="select-filter" onchange="this.form.submit()">
                                    @for($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                            {{ Carbon\Carbon::create(null, $m, 1)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                                <select name="year" class="select-filter" onchange="this.form.submit()">
                                    @for($y = $phNow->year - 1; $y <= $phNow->year + 1; $y++)
                                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </form>

                            <!-- Print DTR Button -->
                            <button type="button" class="btn-print-dtr" onclick="window.print()">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                    <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                                    <rect x="6" y="14" width="12" height="8"></rect>
                                </svg>
                                <span>Print DTR</span>
                            </button>
                        </div>
                    </div>

                    <!-- Cutoff KPI Summary -->
                    <div class="cutoff-kpi-row">
                        <div class="kpi-cell">
                            <div class="kpi-label">Days Logged</div>
                            <div class="kpi-val">
                                {{ collect($dailyLogs)->where('has_record', true)->count() }}
                            </div>
                        </div>
                        <div class="kpi-cell">
                            <div class="kpi-label">Total Regular Hours</div>
                            <div class="kpi-val">
                                {{ number_format($cutoffRecord['total_regular_hours'] ?? 0, 2) }} hrs
                            </div>
                        </div>
                        <div class="kpi-cell">
                            <div class="kpi-label">Total Overtime Hours</div>
                            <div class="kpi-val" style="color:#d97706;">
                                {{ number_format($cutoffRecord['total_ot_hours'] ?? 0, 2) }} hrs
                            </div>
                        </div>
                    </div>

                    <!-- Records Table -->
                    <div class="table-wrap">
                        <table class="timesheet-tbl">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th style="text-align:center;">Break</th>
                                    <th style="text-align:right;">Regular Hours</th>
                                    <th style="text-align:right;">OT Hours</th>
                                    <th style="text-align:center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dailyLogs as $day)
                                    @php
                                        $isToday = $day['date'] === $todayDate;
                                    @endphp
                                    <tr class="{{ $isToday ? 'today-row' : '' }}">
                                        <td style="font-weight:700;">
                                            {{ Carbon\Carbon::parse($day['date'])->format('M d, Y (D)') }}
                                            @if($isToday)
                                                <span class="badge-status" style="background:#fef3c7; color:#92400e; margin-left:0.25rem;">Today</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($day['time_in'])
                                                {{ Carbon\Carbon::parse($day['time_in'])->format('h:i A') }}
                                                @if($day['is_late'])
                                                    <span class="badge-status badge-late" style="margin-left:0.25rem;">Late</span>
                                                @endif
                                            @else
                                                <span class="badge-none">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($day['time_out'])
                                                {{ Carbon\Carbon::parse($day['time_out'])->format('h:i A') }}
                                            @else
                                                <span class="badge-none">—</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center; color:#64748b;">
                                            {{ ($day['total_breaks'] ?? 0) > 0 ? $day['total_breaks'] . 'h' : '—' }}
                                        </td>
                                        <td style="text-align:right; font-weight:700;">
                                            {{ $day['regular_hours'] > 0 ? number_format($day['regular_hours'], 2) : '—' }}
                                        </td>
                                        <td style="text-align:right; font-weight:700; color:#d97706;">
                                            {{ $day['ot_hours'] > 0 ? number_format($day['ot_hours'], 2) : '—' }}
                                        </td>
                                        <td style="text-align:center;">
                                            @if($day['is_on_leave'])
                                                <span class="badge-status badge-leave">Leave</span>
                                            @elseif($day['time_in'] && $day['time_out'])
                                                <span class="badge-status" style="background:#ecfdf5; color:#065f46;">Complete</span>
                                            @elseif($day['time_in'])
                                                <span class="badge-status" style="background:#eff6ff; color:#1d4ed8;">Timed In</span>
                                            @else
                                                <span class="badge-status badge-none">No Log</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align:center; padding:2.5rem; color:#94a3b8;">
                                            No attendance records found for this cutoff period.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- TAB 2: LEAVE REQUESTS HISTORY -->
            @if($activeTab === 'leaves')
                <div>
                    <div class="history-top">
                        <div>
                            <div class="history-title">My Leave Requests</div>
                            <p style="font-size:0.8125rem; color:#64748b; margin-top:0.2rem;">
                                Submitted leave applications subject to administrator approval.
                            </p>
                        </div>

                        <button type="button" class="btn-portal-action btn-leave-req" style="width:auto; padding:0.5rem 1rem;" onclick="openModal('leaveModal')">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span>New Leave Request</span>
                        </button>
                    </div>

                    <div class="table-wrap">
                        <table class="timesheet-tbl">
                            <thead>
                                <tr>
                                    <th>Leave Type</th>
                                    <th>Date Range</th>
                                    <th>Duration</th>
                                    <th>Reason / Notes</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:right;">Submitted Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($leaveRequests as $leave)
                                    @php
                                        $sDate = Carbon\Carbon::parse($leave->start_date);
                                        $eDate = Carbon\Carbon::parse($leave->end_date);
                                        $daysCount = $sDate->diffInDays($eDate) + 1;
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong style="color:#1e293b;">{{ $leave->leave_type }}</strong>
                                        </td>
                                        <td>
                                            {{ $sDate->format('M d, Y') }} — {{ $eDate->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <strong>{{ $daysCount }}</strong> {{ $daysCount > 1 ? 'days' : 'day' }}
                                        </td>
                                        <td style="color:#475569; max-width:280px;">
                                            {{ $leave->reason ?: '—' }}
                                        </td>
                                        <td style="text-align:center;">
                                            <span class="badge-status badge-{{ $leave->status }}">
                                                {{ ucfirst($leave->status) }}
                                            </span>
                                        </td>
                                        <td style="text-align:right; color:#64748b; font-size:0.75rem;">
                                            {{ $leave->created_at->format('M d, Y h:i A') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align:center; padding:3rem; color:#94a3b8;">
                                            <div style="font-size:1.75rem; margin-bottom:0.5rem;">🏖️</div>
                                            <div style="font-weight:700; color:#475569; margin-bottom:0.25rem;">No Leave Requests Found</div>
                                            <p style="font-size:0.8125rem;">You have not submitted any leave applications yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- TAB 3: CASH ADVANCES HISTORY -->
            @if($activeTab === 'cash_advances')
                <div>
                    <div class="history-top">
                        <div>
                            <div class="history-title">My Cash Advance Requests</div>
                            <p style="font-size:0.8125rem; color:#64748b; margin-top:0.2rem;">
                                Approved cash advances are automatically applied to your payroll timesheet deductions.
                            </p>
                        </div>

                        <button type="button" class="btn-portal-action btn-advance-req" style="width:auto; padding:0.5rem 1rem;" onclick="openModal('advanceModal')">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            <span>New Cash Advance</span>
                        </button>
                    </div>

                    <div class="table-wrap">
                        <table class="timesheet-tbl">
                            <thead>
                                <tr>
                                    <th>Requested Amount</th>
                                    <th>Reason / Purpose</th>
                                    <th style="text-align:center;">Status</th>
                                    <th style="text-align:right;">Submitted Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($cashAdvances as $advance)
                                    <tr>
                                        <td style="font-size:0.9375rem; font-weight:800; color:#0f172a;">
                                            ₱{{ number_format($advance->amount, 2) }}
                                        </td>
                                        <td style="color:#475569; max-width:320px;">
                                            {{ $advance->reason ?: '—' }}
                                        </td>
                                        <td style="text-align:center;">
                                            <span class="badge-status badge-{{ $advance->status }}">
                                                {{ ucfirst($advance->status) }}
                                            </span>
                                        </td>
                                        <td style="text-align:right; color:#64748b; font-size:0.75rem;">
                                            {{ $advance->created_at->format('M d, Y h:i A') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align:center; padding:3rem; color:#94a3b8;">
                                            <div style="font-size:1.75rem; margin-bottom:0.5rem;">💵</div>
                                            <div style="font-weight:700; color:#475569; margin-bottom:0.25rem;">No Cash Advances Found</div>
                                            <p style="font-size:0.8125rem;">You have not requested any cash advances yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </section>

    </main>

    <!-- ── LEAVE REQUEST MODAL ──────────────────────────────── -->
    <div id="leaveModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-head">
                <div class="modal-title">New Leave Request</div>
                <button type="button" class="modal-close" onclick="closeModal('leaveModal')">&times;</button>
            </div>

            <form method="POST" action="{{ route('portal.requestLeave') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Leave Type <span style="color:#ef4444;">*</span></label>
                        <select name="leave_type" class="form-select" required>
                            <option value="Vacation Leave">Vacation Leave</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Emergency Leave">Emergency Leave</option>
                            <option value="Personal Leave">Personal Leave</option>
                        </select>
                    </div>

                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.875rem;">
                        <div class="form-group">
                            <label class="form-label">Start Date <span style="color:#ef4444;">*</span></label>
                            <input type="date" name="start_date" class="form-input" 
                                   min="{{ $todayDate }}" value="{{ old('start_date', $todayDate) }}" 
                                   id="leaveStartDate" onchange="syncEndDateMin()" required>
                            <span class="form-helper">Past dates disabled</span>
                        </div>

                        <div class="form-group">
                            <label class="form-label">End Date <span style="color:#ef4444;">*</span></label>
                            <input type="date" name="end_date" class="form-input" 
                                   min="{{ $todayDate }}" value="{{ old('end_date', $todayDate) }}" 
                                   id="leaveEndDate" required>
                            <span class="form-helper">Single or multi-day</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Reason / Purpose</label>
                        <textarea name="reason" rows="3" class="form-textarea" placeholder="State reason for leave request (optional)..."></textarea>
                    </div>

                    <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:0.5rem; padding:0.75rem; font-size:0.75rem; color:#64748b;">
                        ℹ️ <strong>Note:</strong> Submitted leave requests are subject to approval by the administrator. Once approved, timesheets for these dates will automatically be tagged as On Leave.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('leaveModal')">Cancel</button>
                    <button type="submit" class="btn-primary-submit">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ── CASH ADVANCE MODAL ───────────────────────────────── -->
    <div id="advanceModal" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-head">
                <div class="modal-title">New Cash Advance Request</div>
                <button type="button" class="modal-close" onclick="closeModal('advanceModal')">&times;</button>
            </div>

            <form method="POST" action="{{ route('portal.requestCashAdvance') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Requested Amount (₱) <span style="color:#ef4444;">*</span></label>
                        <input type="number" name="amount" step="0.01" min="1" class="form-input" placeholder="0.00" required>
                        <span class="form-helper">Enter the amount you wish to advance</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Purpose / Reason</label>
                        <textarea name="reason" rows="3" class="form-textarea" placeholder="Explain the purpose of this cash advance request..."></textarea>
                    </div>

                    <div style="background:#fef3c7; border:1px solid #fde68a; border-radius:0.5rem; padding:0.75rem; font-size:0.75rem; color:#92400e;">
                        ℹ️ <strong>Note:</strong> Cash advances are subject to administrator approval. Once approved, the advance will be automatically deducted from your timesheet within the corresponding cutoff.
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeModal('advanceModal')">Cancel</button>
                    <button type="submit" class="btn-primary-submit btn-advance-submit">Submit Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ── Printable Official Daily Time Record (DTR) ────────── -->
    <div class="dtr-print-container">
        <div class="dtr-header">
            <div class="dtr-company">Truant Enterprises</div>
            <div class="dtr-title">DAILY TIME RECORD (DTR)</div>
        </div>

        <div class="dtr-meta-grid">
            <div class="dtr-meta-item">
                <span class="dtr-meta-label">Employee:</span>
                <span><strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong></span>
            </div>
            <div class="dtr-meta-item">
                <span class="dtr-meta-label">Period:</span>
                <span>
                    <strong>
                        {{ Carbon\Carbon::parse($payrollData['start_date'])->format('F d, Y') }} — 
                        {{ Carbon\Carbon::parse($payrollData['end_date'])->format('F d, Y') }}
                    </strong>
                </span>
            </div>
            <div class="dtr-meta-item">
                <span class="dtr-meta-label">Position:</span>
                <span>{{ $employee->position?->name ?? 'Staff' }}</span>
            </div>
            <div class="dtr-meta-item">
                <span class="dtr-meta-label">Printed On:</span>
                <span>{{ Carbon\Carbon::now('Asia/Manila')->format('F d, Y h:i A') }} (PH Time)</span>
            </div>
        </div>

        <table class="dtr-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width:18%;">Date</th>
                    <th colspan="2">Official Work Hours</th>
                    <th rowspan="2" style="width:12%;">Break</th>
                    <th rowspan="2" style="width:14%;">Regular Hrs</th>
                    <th rowspan="2" style="width:14%;">Overtime Hrs</th>
                    <th rowspan="2" style="width:14%;">Remarks</th>
                </tr>
                <tr>
                    <th style="width:14%;">Arrival (In)</th>
                    <th style="width:14%;">Departure (Out)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailyLogs as $log)
                    <tr>
                        <td class="text-left">
                            {{ Carbon\Carbon::parse($log['date'])->format('M d (D)') }}
                        </td>
                        <td>
                            {{ $log['time_in'] ? Carbon\Carbon::parse($log['time_in'])->format('h:i A') : '—' }}
                        </td>
                        <td>
                            {{ $log['time_out'] ? Carbon\Carbon::parse($log['time_out'])->format('h:i A') : '—' }}
                        </td>
                        <td>
                            {{ ($log['total_breaks'] ?? 0) > 0 ? $log['total_breaks'] . ' hr' : '—' }}
                        </td>
                        <td>
                            {{ $log['regular_hours'] > 0 ? number_format($log['regular_hours'], 2) : '—' }}
                        </td>
                        <td>
                            {{ $log['ot_hours'] > 0 ? number_format($log['ot_hours'], 2) : '—' }}
                        </td>
                        <td>
                            @if($log['is_on_leave'])
                                Leave
                            @elseif($log['is_late'])
                                Late
                            @elseif($log['time_in'] && $log['time_out'])
                                OK
                            @else
                                —
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="font-weight:bold; background:#f9f9f9;">
                    <td colspan="4" style="text-align:right; text-transform:uppercase;">Cutoff Totals:</td>
                    <td>{{ number_format($cutoffRecord['total_regular_hours'] ?? 0, 2) }} hrs</td>
                    <td>{{ number_format($cutoffRecord['total_ot_hours'] ?? 0, 2) }} hrs</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>

        <div class="dtr-cert">
            I certify on my honor that the above is a true and correct report of the hours of work performed, record of which was made daily at the time of arrival and departure from office.
        </div>

        <div class="dtr-signatures">
            <div>
                <div class="sig-line">{{ $employee->first_name }} {{ $employee->last_name }}</div>
                <div class="sig-title">Employee Signature</div>
            </div>
            <div>
                <div class="sig-line">Authorized Supervisor / In-Charge</div>
                <div class="sig-title">Verified & Approved</div>
            </div>
        </div>
    </div>

    <!-- ── Live Philippine Clock & Modal Scripts ─────────────── -->
    <script>
        function updateLivePHClock() {
            try {
                const now = new Date();
                
                // Format strictly in Philippine Standard Time (Asia/Manila)
                const timeFormatter = new Intl.DateTimeFormat('en-US', {
                    timeZone: 'Asia/Manila',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: true
                });

                const dateFormatter = new Intl.DateTimeFormat('en-US', {
                    timeZone: 'Asia/Manila',
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                const timeElem = document.getElementById('liveClockTime');
                const dateElem = document.getElementById('liveClockDate');

                if (timeElem) {
                    timeElem.textContent = timeFormatter.format(now);
                }

                if (dateElem) {
                    dateElem.textContent = dateFormatter.format(now);
                }
            } catch (err) {
                console.error('Clock error:', err);
            }
        }

        // Initialize clock immediately and tick every second
        updateLivePHClock();
        setInterval(updateLivePHClock, 1000);

        // Modal Helpers
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('active');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('active');
            }
        }

        function syncEndDateMin() {
            const startDate = document.getElementById('leaveStartDate').value;
            const endDateInput = document.getElementById('leaveEndDate');
            if (startDate && endDateInput) {
                endDateInput.min = startDate;
                if (endDateInput.value < startDate) {
                    endDateInput.value = startDate;
                }
            }
        }

        // Close on background overlay click
        window.addEventListener('click', function (e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
            }
        });
    </script>
</body>
</html>
