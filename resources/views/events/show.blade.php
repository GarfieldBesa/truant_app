<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $event->name }} — {{ config('app.name', 'Truant Enterprises') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($event->description), 150) }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-page: #ffffff;
            --bg-subtle: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;
            --text-title: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --success-bg: #ecfdf5;
            --success-text: #065f46;
            --success-border: #a7f3d0;
            --warning-bg: #fffbeb;
            --warning-text: #92400e;
            --warning-border: #fde68a;
            --danger-bg: #fef2f2;
            --danger-text: #991b1b;
            --danger-border: #fecaca;
            --radius-md: 10px;
            --radius-lg: 16px;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 16px -2px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 12px 30px -4px rgba(15, 23, 42, 0.08);
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-display: 'Space Grotesk', var(--font-sans);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            min-height: 100vh;
            background-color: var(--bg-page);
            color: var(--text-body);
            font-family: var(--font-sans);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        .site-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ─── Header ─────────────────────────────────────────────── */
        header.site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
        }

        .header-container {
            max-width: 1140px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text-title);
        }

        .brand-logo-icon {
            width: 40px;
            height: 40px;
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
            font-weight: 700;
            color: var(--text-title);
            letter-spacing: -0.02em;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 18px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: var(--radius-md);
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-outline {
            color: var(--text-body);
            background: #ffffff;
            border-color: var(--border-color);
        }

        .btn-outline:hover {
            background: var(--bg-subtle);
            border-color: var(--border-hover);
            color: var(--text-title);
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
        }

        .btn-lg {
            padding: 13px 26px;
            font-size: 1rem;
            border-radius: 12px;
        }

        /* ─── Breadcrumb & Navigation Bar ─────────────────────────── */
        .breadcrumb-bar {
            background: var(--bg-subtle);
            border-bottom: 1px solid var(--border-color);
            padding: 14px 24px;
        }

        .breadcrumb-container {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.9rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        /* ─── Main Content Container ──────────────────────────────── */
        main.event-detail-main {
            flex: 1;
            max-width: 1140px;
            width: 100%;
            margin: 0 auto;
            padding: 36px 24px 72px;
        }

        /* ─── Event Banner ────────────────────────────────────────── */
        .event-banner-card {
            width: 100%;
            height: 380px;
            border-radius: var(--radius-lg);
            overflow: hidden;
            background: #f1f5f9;
            box-shadow: var(--shadow-md);
            margin-bottom: 36px;
            position: relative;
        }

        .event-banner-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-overlay-status {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 8px 16px;
            border-radius: 9999px;
            font-size: 0.85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* ─── Event Summary Grid (2 cols: Content + Action Sidebar) ── */
        .event-layout-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 36px;
            align-items: start;
        }

        .event-content-column {
            background: #ffffff;
        }

        .event-title-h1 {
            font-family: var(--font-display);
            font-size: clamp(2rem, 3.5vw, 2.75rem);
            font-weight: 800;
            color: var(--text-title);
            line-height: 1.25;
            letter-spacing: -0.025em;
            margin-bottom: 20px;
        }

        /* Highlight Info Chips */
        .event-meta-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 28px;
            padding-bottom: 24px;
            border-bottom: 1px solid var(--border-color);
        }

        .meta-chip {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            font-size: 0.9rem;
            color: var(--text-body);
        }

        .meta-chip strong {
            color: var(--text-title);
        }

        .meta-chip svg {
            width: 18px;
            height: 18px;
            color: var(--primary);
        }

        /* Rich Text / Description */
        .event-description-box {
            font-size: 1.05rem;
            color: var(--text-body);
            line-height: 1.7;
            margin-bottom: 40px;
        }

        .event-description-box p {
            margin-bottom: 16px;
        }

        /* ─── Sticky Sidebar Card ─────────────────────────────────── */
        .registration-sidebar-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 28px;
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 96px;
        }

        .sidebar-card-title {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 16px;
        }

        .sidebar-info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.9rem;
        }

        .sidebar-info-label {
            color: var(--text-muted);
        }

        .sidebar-info-val {
            font-weight: 600;
            color: var(--text-title);
        }

        .sidebar-cta-wrapper {
            margin-top: 24px;
        }

        .sidebar-cta-btn {
            width: 100%;
            padding: 14px 20px;
            font-size: 1rem;
            font-weight: 700;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            cursor: pointer;
        }

        /* ─── Registration Form Section ───────────────────────────── */
        .registration-section {
            margin-top: 48px;
            padding-top: 40px;
            border-top: 2px solid var(--border-color);
        }

        .form-card {
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 36px;
        }

        .form-section-title {
            font-family: var(--font-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 8px;
        }

        .form-section-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-bottom: 28px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-title);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .required-star {
            color: #dc2626;
            font-weight: 700;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: var(--font-sans);
            font-size: 0.95rem;
            color: var(--text-title);
            transition: all 0.15s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        /* Radio group styling */
        .radio-options-row {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 4px;
        }

        .radio-card {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.15s;
        }

        .radio-card:hover {
            border-color: var(--primary);
            background: var(--primary-light);
        }

        .radio-card input[type="radio"] {
            accent-color: var(--primary);
        }

        /* Consent Box */
        .consent-box {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 20px;
            margin: 24px 0 20px;
        }

        .consent-header-title {
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .consent-scroll-body {
            font-size: 0.875rem;
            color: var(--text-body);
            background: var(--bg-subtle);
            border-radius: 6px;
            padding: 12px;
            max-height: 120px;
            overflow-y: auto;
            margin-bottom: 16px;
            white-space: pre-line;
            border: 1px solid var(--border-color);
        }

        .consent-check-label {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-title);
        }

        .consent-check-label input[type="checkbox"] {
            margin-top: 3px;
            width: 18px;
            height: 18px;
            accent-color: var(--primary);
        }

        /* Alerts */
        .alert-success {
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 28px;
        }

        .success-ref-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--success-text);
            margin-bottom: 8px;
        }

        .ref-code-display {
            display: inline-block;
            padding: 8px 16px;
            background: #ffffff;
            border: 2px dashed #059669;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: 800;
            color: #065f46;
            letter-spacing: 0.05em;
            margin: 10px 0 16px;
        }

        .alert-danger {
            background: var(--danger-bg);
            border: 1px solid var(--danger-border);
            border-radius: 10px;
            padding: 16px 20px;
            color: var(--danger-text);
            margin-bottom: 24px;
            font-size: 0.925rem;
        }

        /* ─── Team Registration & Member Lookup ───────────────────── */
        .team-reg-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 36px;
            box-shadow: var(--shadow-sm);
            margin-top: 36px;
        }

        .team-section-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .team-icon-badge {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .member-lookup-box {
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
        }

        .lookup-input-group {
            display: flex;
            gap: 10px;
        }

        .lookup-input-group .form-control {
            flex: 1;
        }

        .lookup-status-msg {
            margin-top: 10px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .lookup-error {
            color: #dc2626;
            background: #fef2f2;
            padding: 12px 16px;
            border-radius: 8px;
            border: 1px solid #fecaca;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
        }

        .verified-member-card {
            margin-top: 12px;
            background: #ffffff;
            border: 1.5px solid #10b981;
            border-radius: 10px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
        }

        .team-roster-box {
            margin-top: 20px;
        }

        .team-roster-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .team-roster-table th {
            text-align: left;
            padding: 10px 14px;
            background: var(--bg-subtle);
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 1px solid var(--border-color);
        }

        .team-roster-table td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem;
            color: var(--text-title);
        }

        .btn-remove-member {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s;
        }

        .btn-remove-member:hover {
            background: #dc2626;
            color: #ffffff;
        }

        .team-finality-note {
            margin: 24px 0 20px;
            padding: 16px 20px;
            background: #fffbeb;
            border: 1.5px solid #fde68a;
            border-radius: 10px;
            color: #92400e;
            font-size: 0.925rem;
            line-height: 1.5;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-info-reuse {
            margin-bottom: 24px;
            padding: 20px;
            background: #ecfdf5;
            border: 2px solid #6ee7b7;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.12);
        }

        /* ─── Quick Registration by Reference Number ──────────────── */
        .quick-register-box {
            background: #ffffff;
            border: 1.5px solid #cbd5e1;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .quick-register-box:hover,
        .quick-register-box:focus-within {
            border-color: var(--primary);
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.08);
        }

        .quick-reg-icon-badge {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #eef2ff;
            color: #4f46e5;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .badge-quick-tag {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            background: #eef2ff;
            color: #4f46e5;
            border: 1px solid #c7d2fe;
        }

        .registration-form-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 26px 0 22px;
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .registration-form-divider::before,
        .registration-form-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px dashed var(--border-color);
        }

        .registration-form-divider span {
            padding: 0 14px;
            background: var(--bg-subtle);
        }

        /* ─── Footer ──────────────────────────────────────────────── */
        footer.site-footer {
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            margin-top: auto;
            padding: 40px 24px 24px;
        }

        .footer-container {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        @media (max-width: 860px) {
            .event-layout-grid {
                grid-template-columns: 1fr;
            }
            .registration-sidebar-card {
                position: static;
            }
        }
    </style>
</head>
<body>
    <div class="site-wrapper">
        <!-- Header -->
        <header class="site-header">
            <div class="header-container">
                <a href="{{ url('/') }}" class="brand-link" id="header-brand-link">
                    <div class="brand-logo-icon">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="brand-title">{{ config('app.name', 'truant_application') }}</span>
                </a>

                <div class="header-actions">
                    <a href="{{ url('/') }}" class="btn btn-outline" id="btn-back-events">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>All Events</span>
                    </a>
                    <a href="{{ url('/admin/login') }}" class="btn btn-primary">Login</a>
                </div>
            </div>
        </header>

        <!-- Breadcrumb Bar -->
        <div class="breadcrumb-bar">
            <div class="breadcrumb-container">
                <a href="{{ url('/') }}" class="back-link">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span>Back to Events List</span>
                </a>
                <span style="color: var(--text-light);">{{ $event->name }}</span>
            </div>
        </div>

        <!-- Main Content -->
        <main class="event-detail-main">
            @php
                $isOpen = $event->isRegistrationOpen();
                $statusText = $event->registration_status;
                $activeBanner = ($event->registrationForm && $event->registrationForm->banner) ? $event->registrationForm->banner : $event->banner;
                $form = $event->registrationForm;
            @endphp

            <!-- Event Hero Banner -->
            <div class="event-banner-card">
                @if ($activeBanner)
                    <img src="{{ asset('storage/' . $activeBanner) }}" alt="{{ $event->name }} Banner">
                @else
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1e293b, #0f172a); color: #fff; font-size: 1.5rem; font-weight: 700;">
                        {{ $event->name }}
                    </div>
                @endif

                <div class="banner-overlay-status" style="background: {{ $isOpen ? 'rgba(236, 253, 245, 0.95)' : 'rgba(241, 245, 249, 0.95)' }}; color: {{ $isOpen ? '#065f46' : '#475569' }};">
                    @if ($isOpen)
                        <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; box-shadow: 0 0 8px #10b981;"></span>
                        <span>Registration Open</span>
                    @else
                        <span>{{ $statusText }}</span>
                    @endif
                </div>
            </div>

            <!-- Content & Registration Grid -->
            <div class="event-layout-grid">
                <!-- Left: Full Event Content -->
                <div class="event-content-column">
                    <h1 class="event-title-h1" id="event-title-heading">{{ $event->name }}</h1>

                    <!-- Key Event Information Chips -->
                    <div class="event-meta-chips">
                        <div class="meta-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Event Date: <strong>{{ $event->event_date ? $event->event_date->format('l, F d, Y') : 'TBA' }}</strong></span>
                        </div>

                        @if ($event->registration_date)
                            <div class="meta-chip">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Registration Deadline: <strong>{{ $event->registration_date->format('M d, Y') }}</strong></span>
                            </div>
                        @endif

                        <div class="meta-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                            </svg>
                            <span>Admission: <strong style="color: {{ $event->isFreeAdmission() ? '#059669' : '#2563eb' }};">{{ $event->admission_label }}{{ (! $event->isFreeAdmission() && $event->ticket_price) ? ' (' . $event->ticket_price . ')' : '' }}</strong></span>
                        </div>

                        <div class="meta-chip">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Registered Attendees: <strong>{{ $event->registrations()->count() }}</strong></span>
                        </div>
                    </div>

                    <!-- Event Description -->
                    <div class="event-description-box">
                        {!! $event->description !!}
                    </div>

                    <!-- Registration Form Area (if Open) -->
                    @if ($isOpen && $form)
                        <section class="registration-section" id="registration-form-section">
                            <div class="form-card">
                                <h2 class="form-section-title">{{ $form->title ?: 'Reserve Your Registration Pass' }}</h2>
                                <p class="form-section-desc">{{ $form->description ?: 'Please fill out the official registration form below to secure your attendance.' }}</p>

                                @if (session('registration_success'))
                                    <div class="alert-success">
                                        <h3 class="success-ref-title">🎉 Registration Confirmed!</h3>
                                        <p>{{ session('message') }}</p>
                                        <div>
                                            <span class="ref-code-display">{{ session('reference_code') }}</span>
                                        </div>
                                        <p style="font-size: 0.875rem; color: #065f46; margin-bottom: 16px;">
                                            Please present this reference code or print your registration pass upon entry at the event reception.
                                        </p>
                                        <button onclick="window.print()" class="btn btn-primary" style="background: #059669;">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                            </svg>
                                            <span>Print Pass</span>
                                        </button>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert-danger" style="margin-bottom: 20px;">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('ref_reuse_prompt'))
                                    <div class="alert-info-reuse" id="reuse-ref-alert-box">
                                        <div style="display: flex; align-items: flex-start; gap: 14px;">
                                            <div style="background: #10b981; color: #fff; width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div style="flex: 1;">
                                                <h3 style="font-size: 1.05rem; font-weight: 700; color: #065f46; margin-bottom: 6px;" id="msg-ref-reuse-title">
                                                    Information already exist Ref# will be reused to register on this event. Click to confirm and register
                                                </h3>
                                                <p style="font-size: 0.9rem; color: #047857; margin-bottom: 12px;">
                                                    Existing record detected for <strong>{{ session('existing_name') }}</strong> with reference <strong>{{ session('existing_ref') }}</strong>.
                                                </p>
                                                <button type="button" onclick="confirmAndSubmitReuse('{{ session('existing_ref') }}')" class="btn btn-primary" style="background: #059669; border-color: #059669; font-weight: 700;" id="btn-confirm-reuse-ref">
                                                    <span>Click to confirm and register</span>
                                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert-danger">
                                        <strong>Please correct the following errors:</strong>
                                        <ul style="margin-left: 20px; margin-top: 6px;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Option: Quick Registration with Existing Reference Number -->
                                <div class="quick-register-box" id="quick-register-box">
                                    <div style="display: flex; align-items: flex-start; gap: 14px;">
                                        <div class="quick-reg-icon-badge">
                                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                            </svg>
                                        </div>
                                        <div style="flex: 1;">
                                            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                                                <h3 style="font-size: 1.05rem; font-weight: 700; color: var(--text-title); margin: 0;">
                                                    Already registered for a previous event?
                                                </h3>
                                                <span class="badge-quick-tag">⚡ Fast Auto-Registration</span>
                                            </div>
                                            <p style="font-size: 0.875rem; color: var(--text-muted); margin: 6px 0 14px 0;">
                                                If you already have a Registration Reference Number (Ref#), enter it below to automatically register for this event. Your attendee details will be reused and you can be added to any team!
                                            </p>

                                            @if (session('quick_reg_error'))
                                                <div class="alert-danger" style="margin-bottom: 14px; padding: 10px 14px; font-size: 0.85rem;" id="quick-reg-error-box">
                                                    {{ session('quick_reg_error') }}
                                                </div>
                                            @endif

                                            <form action="{{ route('events.public.registerByRef', $event) }}" method="POST" id="form-quick-ref-register">
                                                @csrf
                                                <div class="lookup-input-group">
                                                    <input 
                                                        type="text" 
                                                        name="ref_code" 
                                                        id="quick_reg_ref_input" 
                                                        class="form-control" 
                                                        placeholder="Enter your Ref# (e.g. REG-20260907-XXXXX)"
                                                        value="{{ old('ref_code') }}"
                                                        required
                                                        autocomplete="off"
                                                    >
                                                    <button type="submit" class="btn btn-primary" id="btn-quick-register-ref" style="background: #4f46e5; border-color: #4f46e5; font-weight: 700; white-space: nowrap;">
                                                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                        </svg>
                                                        <span>Register with Ref#</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Divider -->
                                <div class="registration-form-divider">
                                    <span>OR complete new registration form below</span>
                                </div>

                                <form action="{{ route('events.public.register', $event) }}" method="POST" enctype="multipart/form-data" id="event-registration-form">
                                    @csrf
                                    <input type="hidden" name="confirm_reuse_ref" id="input_confirm_reuse_ref" value="0">
                                    <input type="hidden" name="reused_reference" id="input_reused_reference" value="{{ session('existing_ref', '') }}">

                                    <div class="form-grid">
                                        @foreach ($form->fields ?? [] as $index => $field)
                                            @php
                                                $fieldName = 'field_' . $index;
                                                $label = $field['label'] ?? "Field {$index}";
                                                $isRequired = (bool) ($field['is_required'] ?? false);
                                                $type = $field['type'] ?? 'text';
                                            @endphp

                                            <div class="form-group">
                                                <label class="form-label" for="{{ $fieldName }}">
                                                    <span>{{ $label }}</span>
                                                    @if ($isRequired)
                                                        <span class="required-star">*</span>
                                                    @endif
                                                </label>

                                                @if ($type === 'text')
                                                    <input 
                                                        type="text" 
                                                        name="{{ $fieldName }}" 
                                                        id="{{ $fieldName }}" 
                                                        class="form-control" 
                                                        placeholder="{{ $field['placeholder'] ?? 'Enter ' . $label }}"
                                                        value="{{ old($fieldName) }}"
                                                        {{ $isRequired ? 'required' : '' }}
                                                    >
                                                @elseif ($type === 'textarea')
                                                    <textarea 
                                                        name="{{ $fieldName }}" 
                                                        id="{{ $fieldName }}" 
                                                        rows="3" 
                                                        class="form-control" 
                                                        placeholder="{{ $field['placeholder'] ?? 'Enter details' }}"
                                                        {{ $isRequired ? 'required' : '' }}
                                                    >{{ old($fieldName) }}</textarea>
                                                @elseif ($type === 'select')
                                                    <select 
                                                        name="{{ $fieldName }}" 
                                                        id="{{ $fieldName }}" 
                                                        class="form-control"
                                                        {{ $isRequired ? 'required' : '' }}
                                                    >
                                                        <option value="">— Select {{ $label }} —</option>
                                                        @foreach ($field['options'] ?? [] as $opt)
                                                            <option value="{{ $opt }}" {{ old($fieldName) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                        @endforeach
                                                    </select>
                                                @elseif ($type === 'radio')
                                                    <div class="radio-options-row">
                                                        @foreach ($field['options'] ?? [] as $optIndex => $opt)
                                                            <label class="radio-card">
                                                                <input 
                                                                    type="radio" 
                                                                    name="{{ $fieldName }}" 
                                                                    value="{{ $opt }}"
                                                                    {{ old($fieldName) === $opt ? 'checked' : ($optIndex === 0 && $isRequired ? 'checked' : '') }}
                                                                >
                                                                <span>{{ $opt }}</span>
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                @elseif ($type === 'image_upload')
                                                    <input 
                                                        type="file" 
                                                        name="{{ $fieldName }}" 
                                                        id="{{ $fieldName }}" 
                                                        accept="image/*"
                                                        class="form-control"
                                                        {{ $isRequired ? 'required' : '' }}
                                                    >
                                                    <small style="color: var(--text-muted); font-size: 0.8rem;">
                                                        Upload clear image file (JPG, PNG, WEBP up to 5MB).
                                                    </small>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Mandatory Consent Section -->
                                    <div class="consent-box">
                                        <h4 class="consent-header-title">{{ $form->consent_title ?: 'Consent & Privacy Agreement' }}</h4>
                                        <div class="consent-scroll-body">
                                            {{ $form->consent_body ?: "By submitting this registration, I agree to the processing of my personal details for event coordination, attendance reporting, and safety measures." }}
                                        </div>

                                        <label class="consent-check-label">
                                            <input type="checkbox" name="consent_agreed" value="1" {{ old('consent_agreed') ? 'checked' : '' }} required id="consent-checkbox">
                                            <span>{{ $form->consent_checkbox_label ?: 'I have read, understood, and agree to the event registration guidelines and consent agreement.' }}</span>
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; font-weight: 700;" id="btn-submit-registration">
                                        <span>Confirm &amp; Complete Registration</span>
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </section>
                    @endif

                    @if ($isOpen)
                        <!-- Team Registration Section -->
                        <section class="team-reg-card" id="team-registration-section">
                            <div class="team-section-header">
                                <div class="team-icon-badge">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="form-section-title" style="margin-bottom: 2px;">Register a Team</h2>
                                    <p class="form-section-desc" style="margin-bottom: 0;">Assemble your squad by providing a unique team name and adding registered attendees by reference number.</p>
                                </div>
                            </div>

                            @if (session('team_registration_success'))
                                <div class="alert-success" style="margin-bottom: 24px;">
                                    <h3 class="success-ref-title">🎉 Team Successfully Registered!</h3>
                                    <p>{{ session('message') }}</p>
                                    <div style="margin: 12px 0;">
                                        <span class="ref-code-display" id="team-ref-code-display">{{ session('team_reference') }}</span>
                                    </div>
                                    <p style="font-size: 0.875rem; color: #065f46; margin-bottom: 16px;">
                                        Official Team: <strong>{{ session('team_name') }}</strong> ({{ session('team_members_count') }} players registered).
                                    </p>
                                    <button onclick="window.print()" class="btn btn-primary" style="background: #059669;">
                                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                        </svg>
                                        <span>Print Team Pass</span>
                                    </button>
                                </div>
                            @endif

                            @if ($errors->has('team_name') || $errors->has('member_refs'))
                                <div class="alert-danger" style="margin-bottom: 20px;">
                                    <strong>Please correct the following errors:</strong>
                                    <ul style="margin-left: 20px; margin-top: 6px;">
                                        @foreach ($errors->get('team_name') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                        @foreach ($errors->get('member_refs') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('events.public.teams.register', $event) }}" method="POST" id="team-registration-form">
                                @csrf

                                <!-- 1. Team Name -->
                                <div class="form-group" style="margin-bottom: 22px;">
                                    <label class="form-label" for="team_name">
                                        <span>Team Name</span>
                                        <span class="required-star">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="team_name" 
                                        id="team_name" 
                                        class="form-control @error('team_name') is-invalid @enderror" 
                                        placeholder="Enter official team name (e.g. Blue Eagles, Agile Titans)" 
                                        value="{{ old('team_name') }}"
                                        required
                                    >
                                    <small style="color: var(--text-muted); font-size: 0.825rem; margin-top: 4px; display: block;">
                                        Team name must be unique for this event.
                                    </small>
                                </div>

                                <!-- 2. Member Lookup Box -->
                                <div class="member-lookup-box">
                                    <label class="form-label" for="member_ref_input" style="font-weight: 700; color: var(--text-title); margin-bottom: 6px; display: block;">
                                        <span>Add Team Members (by Registration Reference Number)</span>
                                    </label>
                                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 12px;">
                                        Enter the individual registration reference code (e.g. <code>REG-YYYYMMDD-XXXXX</code>) of an attendee registered for this event. <em>(Players registered in other events can quickly register for this event above using their Ref#).</em>
                                    </p>

                                    <div class="lookup-input-group">
                                        <input 
                                            type="text" 
                                            id="member_ref_input" 
                                            class="form-control" 
                                            placeholder="Enter Attendee Ref# (e.g. REG-20260907-XXXXX)"
                                            autocomplete="off"
                                        >
                                        <button type="button" class="btn btn-outline" id="btn-verify-ref" onclick="lookupMemberRef()">
                                            <span>Verify Ref#</span>
                                        </button>
                                    </div>

                                    <!-- Error message container (Exact requirement: 'Ref# is not registered to this event.') -->
                                    <div id="lookup-error-box" class="lookup-error" style="display: none;">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <div>
                                            <span id="lookup-error-text">Ref# is not registered to this event.</span>
                                            <div id="lookup-error-hint" style="font-size: 0.8rem; margin-top: 4px; color: #b91c1c;">
                                                Tip: Attendees from other events can register for this event above using their Ref# and then be added to this team.
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Verified Attendee Card Container -->
                                    <div id="verified-attendee-card" class="verified-member-card" style="display: none;">
                                        <div>
                                            <div style="font-size: 0.78rem; font-weight: 700; color: #059669; text-transform: uppercase; letter-spacing: 0.05em;">Registered Attendee Found</div>
                                            <div style="font-size: 1.05rem; font-weight: 700; color: var(--text-title); margin-top: 2px;" id="verified-attendee-name">—</div>
                                            <div style="font-size: 0.85rem; color: var(--text-muted); font-family: monospace;" id="verified-attendee-ref">—</div>
                                        </div>
                                        <button type="button" class="btn btn-primary btn-sm" id="btn-add-to-team" onclick="addCurrentMemberToTeam()" style="background: #059669; border-color: #059669; padding: 8px 16px;">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            <span>Add to Team</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- 3. Team Members Roster -->
                                <div class="team-roster-box">
                                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
                                        <h4 style="font-size: 0.95rem; font-weight: 700; color: var(--text-title); margin: 0;">
                                            Current Team Roster (<span id="roster-count">0</span> Players)
                                        </h4>
                                        <button type="button" class="btn btn-outline btn-sm" id="btn-add-more-players" onclick="focusRefInput()" style="font-size: 0.8rem; padding: 5px 12px;">
                                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            <span>Add more</span>
                                        </button>
                                    </div>

                                    <div id="empty-roster-msg" style="padding: 20px; text-align: center; background: var(--bg-subtle); border-radius: 8px; border: 1px dashed var(--border-color); color: var(--text-muted); font-size: 0.875rem;">
                                        No players added to the team yet. Lookup attendee reference numbers above and click "Add to Team".
                                    </div>

                                    <table class="team-roster-table" id="team-roster-table" style="display: none;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Player Name</th>
                                                <th>Registration Ref#</th>
                                                <th style="text-align: right;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="team-roster-tbody">
                                            <!-- Dynamically populated rows -->
                                        </tbody>
                                    </table>

                                    <!-- Hidden input container for submitted member refs -->
                                    <div id="hidden-member-refs-container"></div>
                                </div>

                                <!-- 4. Finality Note (Exact requirement) -->
                                <div class="team-finality-note" id="team-finality-note">
                                    <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink: 0;">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <span>
                                        <strong>Note:</strong> Once submitted, team name and team member is final otherwise contact truant to edit.
                                    </span>
                                </div>

                                <!-- 5. Submit Team Button -->
                                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; font-weight: 700;" id="btn-submit-team">
                                    <span>Confirm &amp; Register Team</span>
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </button>
                            </form>
                        </section>
                    @endif
                </div>

                <!-- Right: Action Sidebar -->
                <aside class="event-sidebar-column">
                    <div class="registration-sidebar-card">
                        <h3 class="sidebar-card-title">Registration Summary</h3>

                        <div class="sidebar-info-row">
                            <span class="sidebar-info-label">Status</span>
                            <span class="sidebar-info-val" style="color: {{ $isOpen ? '#059669' : '#dc2626' }};">
                                {{ $statusText }}
                            </span>
                        </div>

                        <div class="sidebar-info-row">
                            <span class="sidebar-info-label">Event Date</span>
                            <span class="sidebar-info-val">
                                {{ $event->event_date ? $event->event_date->format('M d, Y') : 'TBA' }}
                            </span>
                        </div>

                        <div class="sidebar-info-row">
                            <span class="sidebar-info-label">Registration Starts</span>
                            <span class="sidebar-info-val">
                                {{ $event->registration_start_date ? $event->registration_start_date->format('M d, Y') : 'Open' }}
                            </span>
                        </div>

                        <div class="sidebar-info-row">
                            <span class="sidebar-info-label">Deadline</span>
                            <span class="sidebar-info-val">
                                {{ $event->registration_date ? $event->registration_date->format('M d, Y') : 'Until full' }}
                            </span>
                        </div>

                        <div class="sidebar-info-row">
                            <span class="sidebar-info-label">Admission</span>
                            <span class="sidebar-info-val" style="color: {{ $event->isFreeAdmission() ? '#059669' : '#2563eb' }};">
                                {{ $event->admission_label }}{{ (! $event->isFreeAdmission() && $event->ticket_price) ? ' (' . $event->ticket_price . ')' : '' }}
                            </span>
                        </div>

                        <div class="sidebar-cta-wrapper">
                            @if ($isOpen)
                                <a href="#registration-form-section" class="sidebar-cta-btn btn-primary" id="btn-register-cta">
                                    <span>Register for this Event</span>
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                    </svg>
                                </a>

                                <a href="#team-registration-section" class="sidebar-cta-btn btn-outline" id="btn-register-team-cta" style="margin-top: 10px; border-color: var(--primary); color: var(--primary); background: #ffffff;">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span>Register a team</span>
                                </a>
                            @else
                                <div style="text-align: center; padding: 12px; background: var(--bg-subtle); border-radius: 8px; color: var(--text-muted); font-size: 0.9rem; font-weight: 600;">
                                    Registration is not active
                                </div>
                            @endif
                        </div>
                    </div>
                </aside>
            </div>
        </main>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-container">
                <div>
                    <span>&copy; {{ date('Y') }} {{ config('app.name', 'truant_application') }}. All rights reserved.</span>
                </div>
                <div>
                    <a href="{{ url('/') }}" style="color: var(--text-muted); text-decoration: none; margin-right: 16px;">All Events</a>
                    <a href="{{ url('/admin/login') }}" style="color: var(--text-muted); text-decoration: none;">Admin Access</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Interactive Scripts for Ref# Reuse & Team Roster -->
    <script>
        // 1. Ref# Reuse Confirmation for Individual Registration
        function confirmAndSubmitReuse(ref) {
            document.getElementById('input_confirm_reuse_ref').value = '1';
            document.getElementById('input_reused_reference').value = ref;
            document.getElementById('event-registration-form').submit();
        }

        // 2. Team Member Lookup & Roster Management
        let currentVerifiedMember = null;
        let teamMembers = [];

        function focusRefInput() {
            const input = document.getElementById('member_ref_input');
            if (input) {
                input.focus();
                input.select();
            }
        }

        async function lookupMemberRef() {
            const input = document.getElementById('member_ref_input');
            const refCode = input ? input.value.trim() : '';
            const errorBox = document.getElementById('lookup-error-box');
            const errorText = document.getElementById('lookup-error-text');
            const verifiedCard = document.getElementById('verified-attendee-card');

            if (errorBox) errorBox.style.display = 'none';
            if (verifiedCard) verifiedCard.style.display = 'none';
            currentVerifiedMember = null;

            if (!refCode) {
                if (errorText) errorText.textContent = 'Please enter a reference number.';
                if (errorBox) errorBox.style.display = 'flex';
                return;
            }

            // Check if already in current team draft
            if (teamMembers.some(m => m.ref.toLowerCase() === refCode.toLowerCase())) {
                if (errorText) errorText.textContent = 'This attendee has already been added to your team roster.';
                if (errorBox) errorBox.style.display = 'flex';
                return;
            }

            try {
                const btn = document.getElementById('btn-verify-ref');
                if (btn) {
                    btn.disabled = true;
                    btn.innerText = 'Checking...';
                }

                const response = await fetch("{{ route('events.public.teams.checkMember', $event) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify({ ref_code: refCode })
                });

                const data = await response.json();
                if (btn) {
                    btn.disabled = false;
                    btn.innerText = 'Verify Ref#';
                }

                if (data.success) {
                    currentVerifiedMember = data;
                    document.getElementById('verified-attendee-name').textContent = data.name;
                    document.getElementById('verified-attendee-ref').textContent = data.ref;
                    verifiedCard.style.display = 'flex';
                } else {
                    if (errorText) errorText.textContent = data.message || 'Ref# is not registered to this event.';
                    if (errorBox) errorBox.style.display = 'flex';
                }
            } catch (e) {
                console.error(e);
                if (errorText) errorText.textContent = 'Ref# is not registered to this event.';
                if (errorBox) errorBox.style.display = 'flex';
            }
        }

        function addCurrentMemberToTeam() {
            if (!currentVerifiedMember) return;

            // Check duplicate in draft
            if (teamMembers.some(m => m.ref.toLowerCase() === currentVerifiedMember.ref.toLowerCase())) {
                alert('This attendee is already added to the team.');
                return;
            }

            teamMembers.push(currentVerifiedMember);
            currentVerifiedMember = null;
            const verifiedCard = document.getElementById('verified-attendee-card');
            if (verifiedCard) verifiedCard.style.display = 'none';
            const input = document.getElementById('member_ref_input');
            if (input) input.value = '';
            renderTeamRoster();
            focusRefInput();
        }

        function removeMemberFromTeam(index) {
            teamMembers.splice(index, 1);
            renderTeamRoster();
        }

        function renderTeamRoster() {
            const countSpan = document.getElementById('roster-count');
            const emptyMsg = document.getElementById('empty-roster-msg');
            const table = document.getElementById('team-roster-table');
            const tbody = document.getElementById('team-roster-tbody');
            const hiddenContainer = document.getElementById('hidden-member-refs-container');

            if (countSpan) countSpan.textContent = teamMembers.length;
            if (tbody) tbody.innerHTML = '';
            if (hiddenContainer) hiddenContainer.innerHTML = '';

            if (teamMembers.length === 0) {
                if (emptyMsg) emptyMsg.style.display = 'block';
                if (table) table.style.display = 'none';
            } else {
                if (emptyMsg) emptyMsg.style.display = 'none';
                if (table) table.style.display = 'table';

                teamMembers.forEach((member, i) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td style="font-weight: 600; color: var(--text-muted);">${i + 1}</td>
                        <td style="font-weight: 700; color: var(--text-title);">${escapeHtml(member.name)}</td>
                        <td><code style="background: var(--bg-subtle); padding: 2px 6px; border-radius: 4px; font-weight: 600;">${escapeHtml(member.ref)}</code></td>
                        <td style="text-align: right;">
                            <button type="button" class="btn-remove-member" onclick="removeMemberFromTeam(${i})">Remove</button>
                        </td>
                    `;
                    tbody.appendChild(tr);

                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'member_refs[]';
                    hidden.value = member.ref;
                    hiddenContainer.appendChild(hidden);
                });
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.innerText = text || '';
            return div.innerHTML;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const refInput = document.getElementById('member_ref_input');
            if (refInput) {
                refInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        lookupMemberRef();
                    }
                });
            }

            const teamForm = document.getElementById('team-registration-form');
            if (teamForm) {
                teamForm.addEventListener('submit', (e) => {
                    if (teamMembers.length === 0) {
                        e.preventDefault();
                        alert('Please add at least one registered player to the team roster before submitting.');
                        focusRefInput();
                    }
                });
            }
        });
    </script>
</body>
</html>
