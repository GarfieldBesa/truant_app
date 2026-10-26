<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Court — Truant Enterprises</title>
    <meta name="description" content="Reserve tournament-grade Pickleball and Basketball courts at Truant Enterprises. Hourly slots starting at 12:00 AM with instant online scheduling.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&family=JetBrains+Mono:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-page: #f8fafc;
            --bg-surface: #ffffff;
            --bg-subtle: #f1f5f9;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --border-hover: #cbd5e1;
            --border-active: #4f46e5;
            --text-title: #0f172a;
            --text-body: #334155;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --primary-border: #c7d2fe;
            --success-bg: #ecfdf5;
            --success-text: #065f46;
            --success-border: #a7f3d0;
            --warning-bg: #fffbeb;
            --warning-text: #92400e;
            --warning-border: #fde68a;
            --danger-bg: #fef2f2;
            --danger-text: #991b1b;
            --danger-border: #fecaca;
            --neutral-bg: #f1f5f9;
            --neutral-text: #475569;
            --neutral-border: #e2e8f0;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-full: 9999px;
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.05), 0 1px 2px rgba(15, 23, 42, 0.03);
            --shadow-md: 0 4px 16px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.04);
            --shadow-hover: 0 14px 28px -4px rgba(15, 23, 42, 0.08), 0 4px 10px -2px rgba(15, 23, 42, 0.03);
            --shadow-modal: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-display: 'Space Grotesk', var(--font-sans);
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-sans);
            background-color: var(--bg-page);
            color: var(--text-body);
            min-height: 100vh;
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
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .header-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 14px 24px;
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

        .brand-info {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--text-title);
            letter-spacing: -0.02em;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        nav.header-nav {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-body);
            font-size: 0.925rem;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.15s ease;
        }

        .nav-link:hover {
            color: var(--primary);
            background: var(--bg-subtle);
        }

        .nav-link.active {
            color: var(--primary);
            background: var(--primary-light);
            border: 1px solid var(--primary-border);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: #ffffff;
            border-color: var(--border-color);
            color: var(--text-body);
            box-shadow: var(--shadow-sm);
        }

        .btn-outline:hover {
            background: var(--bg-subtle);
            border-color: var(--border-hover);
            color: var(--text-title);
        }

        /* ─── Hero Section ─────────────────────────────────── */
        .booking-hero {
            padding: 52px 24px 40px 24px;
            text-align: center;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-bottom: 1px solid var(--border-color);
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: var(--radius-full);
            background: var(--primary-light);
            border: 1px solid var(--primary-border);
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 16px;
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2.1rem, 4.2vw, 3.1rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.15;
            color: var(--text-title);
            margin-bottom: 12px;
        }

        .hero-title span {
            color: var(--primary);
        }

        .hero-desc {
            max-width: 650px;
            margin: 0 auto;
            font-size: 1.05rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* ─── Main Content ─────────────────────────────────── */
        .booking-main {
            flex: 1;
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
            padding: 40px 24px 80px 24px;
        }

        /* ─── Section Header ──────────────────────────────── */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .section-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 28px;
            height: 28px;
            border-radius: var(--radius-full);
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 800;
            font-size: 0.85rem;
            margin-right: 10px;
            border: 1px solid var(--primary-border);
        }

        .section-title {
            display: flex;
            align-items: center;
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-title);
            letter-spacing: -0.01em;
        }

        /* ─── Courts Grid ─────────────────────────────────── */
        .courts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
            margin-bottom: 44px;
        }

        .court-card {
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 24px;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: var(--shadow-sm);
        }

        .court-card:hover {
            border-color: var(--border-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .court-card.selected {
            border-color: var(--primary);
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15), var(--shadow-md);
        }

        .court-badge-top {
            position: absolute;
            top: 18px;
            right: 18px;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: var(--radius-full);
            background: var(--neutral-bg);
            color: var(--neutral-text);
            border: 1px solid var(--neutral-border);
        }

        .court-card.selected .court-badge-top {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary-border);
        }

        .court-header {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 14px;
        }

        .court-icon-box {
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            background: var(--bg-subtle);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            flex-shrink: 0;
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .court-card.selected .court-icon-box {
            background: var(--primary-light);
            border-color: var(--primary-border);
            color: var(--primary);
        }

        .court-name {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 3px;
        }

        .court-desc {
            font-size: 0.88rem;
            color: var(--text-muted);
            line-height: 1.55;
            margin-bottom: 18px;
        }

        .court-specs-row {
            display: flex;
            align-items: center;
            gap: 16px;
            padding-top: 14px;
            border-top: 1px solid var(--border-color);
            font-size: 0.82rem;
        }

        .court-spec {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--text-muted);
        }

        .court-spec strong {
            color: var(--text-title);
            font-weight: 700;
        }

        /* ─── Date Selector ───────────────────────────────── */
        .date-selector-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            margin-bottom: 44px;
            box-shadow: var(--shadow-sm);
        }

        .date-picker-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .quick-dates {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .quick-date-btn {
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 8px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-body);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .quick-date-btn:hover {
            background: #e2e8f0;
            color: var(--text-title);
        }

        .quick-date-btn.active {
            background: var(--primary-light);
            border-color: var(--primary-border);
            color: var(--primary);
            font-weight: 700;
        }

        .custom-date-box {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .custom-date-box label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
        }

        .date-input {
            background: #ffffff;
            border: 1px solid var(--border-color);
            color: var(--text-title);
            padding: 8px 14px;
            border-radius: var(--radius-sm);
            font-size: 0.88rem;
            font-family: var(--font-sans);
            font-weight: 500;
            cursor: pointer;
            outline: none;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .date-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        /* ─── 24-Hour Slots Grid ──────────────────────────── */
        .slots-container {
            margin-bottom: 44px;
        }

        .slots-legend {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 18px;
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-bottom: 18px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .legend-dot {
            width: 9px;
            height: 9px;
            border-radius: var(--radius-full);
        }

        .slots-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 14px;
        }

        .slot-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 16px;
            transition: all 0.2s ease;
            position: relative;
            user-select: none;
            box-shadow: var(--shadow-sm);
        }

        .slot-card.selectable {
            cursor: pointer;
        }

        .slot-card.selectable:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .slot-card.disabled {
            opacity: 0.55;
            cursor: not-allowed;
            background: var(--bg-subtle);
            border-color: var(--border-color);
        }

        .slot-time {
            font-family: var(--font-mono);
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .slot-pill {
            font-family: var(--font-sans);
            font-size: 0.72rem;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: var(--radius-full);
            display: inline-block;
        }

        .pill-available {
            background: var(--success-bg);
            color: var(--success-text);
            border: 1px solid var(--success-border);
        }

        .pill-limited {
            background: var(--warning-bg);
            color: var(--warning-text);
            border: 1px solid var(--warning-border);
        }

        .pill-full {
            background: var(--danger-bg);
            color: var(--danger-text);
            border: 1px solid var(--danger-border);
        }

        .pill-closed {
            background: var(--neutral-bg);
            color: var(--neutral-text);
            border: 1px solid var(--neutral-border);
        }

        .pill-passed {
            background: #f1f5f9;
            color: #64748b;
            border: 1px solid #cbd5e1;
        }

        .slot-info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.78rem;
            color: var(--text-muted);
            margin-top: 6px;
        }

        /* ─── Modal Dialog ────────────────────────────────── */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-dialog {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 520px;
            box-shadow: var(--shadow-modal);
            overflow: hidden;
            animation: modalFadeIn 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.97) translateY(8px); }
            to { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-header {
            padding: 20px 24px;
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-title);
        }

        .modal-close-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 6px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
        }

        .modal-close-btn:hover {
            color: var(--text-title);
            background: var(--bg-subtle);
        }

        .modal-body {
            padding: 24px;
        }

        .selected-summary-banner {
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 14px 18px;
            margin-bottom: 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-body);
            margin-bottom: 6px;
        }

        .form-label span.req {
            color: var(--danger-text);
        }

        .form-input {
            width: 100%;
            background: #ffffff;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            font-size: 0.92rem;
            color: var(--text-title);
            font-family: var(--font-sans);
            outline: none;
            transition: all 0.2s;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .form-help {
            font-size: 0.76rem;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .form-error {
            font-size: 0.78rem;
            color: var(--danger-text);
            margin-top: 4px;
            display: none;
        }

        .modal-footer {
            padding: 16px 24px;
            background: var(--bg-subtle);
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
        }

        /* ─── Passcode PIN Inputs ─────────────────────────── */
        .pin-inputs-wrapper {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin: 18px 0 14px 0;
        }

        .pin-box {
            width: 46px;
            height: 56px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 800;
            font-family: var(--font-mono);
            color: var(--text-title);
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: 10px;
            transition: all 0.18s ease;
            outline: none;
            box-shadow: var(--shadow-sm);
        }

        .pin-box:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.18);
            transform: translateY(-2px);
        }

        .pin-box.filled {
            border-color: var(--primary);
            background: var(--primary-light);
            color: var(--primary);
        }

        /* ─── Verification Sent Alert Card ────────────────── */
        .verification-alert-card {
            background: var(--primary-light);
            border: 1px solid var(--primary-border);
            border-radius: var(--radius-lg);
            padding: 22px 24px;
            margin-bottom: 30px;
            display: flex;
            gap: 18px;
            align-items: flex-start;
            box-shadow: var(--shadow-sm);
        }

        .verification-icon {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-md);
            background: var(--primary);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.25);
        }

        /* ─── Footer ──────────────────────────────────────── */
        footer.site-footer {
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            padding: 32px 24px;
            margin-top: auto;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        @media (max-width: 768px) {
            .header-container { padding: 12px 16px; }
            .booking-main { padding: 24px 16px 48px 16px; }
            .court-specs-row { flex-direction: column; align-items: flex-start; gap: 8px; }
            .date-picker-row { flex-direction: column; align-items: flex-start; }
            .slots-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="site-wrapper">
        <!-- Site Header -->
        <header class="site-header">
            <div class="header-container">
                <a href="{{ url('/') }}" class="brand-link" id="header-brand-link">
                    <div class="brand-logo-icon">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div class="brand-info">
                        <span class="brand-title">Truant Enterprises</span>
                        <span class="brand-subtitle">Sports Facilities</span>
                    </div>
                </a>

                <nav class="header-nav">
                    <a href="{{ url('/') }}" class="nav-link" id="nav-events-link">Events</a>
                    <a href="{{ route('court-booking.index') }}" class="nav-link active" id="nav-book-court-link">Book a Court</a>
                </nav>

                <div class="header-actions">
                    <a href="{{ url('/admin/login') }}" class="btn btn-outline" id="btn-login-header">Admin Login</a>
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="booking-hero">
            <div class="hero-pill">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Championship Facilities &bull; Online Reservations</span>
            </div>
            <h1 class="hero-title">
                Book a <span>Court</span>
            </h1>
            <p class="hero-desc">
                Select your court, pick your preferred date, and choose from open 1-hour slots starting at 12:00 AM with up to 4 available slots per hour.
            </p>
        </section>

        <!-- Main Booking Content -->
        <main class="booking-main">
            <!-- Flash Session Alert: Verification Sent -->
            @if (session('verification_sent'))
                @php $sentData = session('verification_sent'); @endphp
                <div class="verification-alert-card" id="verification-sent-card">
                    <div class="verification-icon">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 1.1rem; font-weight: 700; color: var(--text-title); margin-bottom: 4px;">
                            Email Verification Sent &mdash; Ref #{{ $sentData['reference_code'] }}
                        </div>
                        <p style="color: var(--text-body); font-size: 0.9rem; margin-bottom: 12px;">
                            We sent a verification link to <strong style="color: var(--text-title);">{{ $sentData['email'] }}</strong> for your reservation on <strong style="color: var(--primary);">{{ $sentData['court_name'] }}</strong> ({{ $sentData['date'] }} &bull; {{ $sentData['time_slot'] }}).
                        </p>
                        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                            <a href="{{ route('court-booking.verify', ['token' => $sentData['token']]) }}" class="btn btn-primary" style="padding: 7px 16px; font-size: 0.82rem;">
                                Complete Email Verification &rarr;
                            </a>
                            <button type="button" class="btn btn-outline" style="padding: 7px 16px; font-size: 0.82rem;" onclick="resendVerification('{{ $sentData['reference_code'] }}')">
                                Resend Email
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- STEP 1: SELECT COURT -->
            <div class="section-header">
                <h2 class="section-title">
                    <span class="section-badge">1</span>
                    Select Court
                </h2>
                <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 500;">Pickleball or Basketball</span>
            </div>

            <div class="courts-grid" id="courts-selection-grid">
                @foreach ($courts as $court)
                    <div class="court-card {{ $court->id === $selectedCourt->id ? 'selected' : '' }}"
                         data-court-id="{{ $court->id }}"
                         data-court-name="{{ $court->name }}"
                         data-court-type="{{ $court->court_type }}"
                         onclick="selectCourt({{ $court->id }})">
                        <div class="court-badge-top">
                            {{ $court->court_type === 'pickleball' ? '🏸 Tournament Surface' : '🏀 FIBA Hardwood' }}
                        </div>
                        <div>
                            <div class="court-header">
                                <div class="court-icon-box">
                                    @if ($court->court_type === 'pickleball')
                                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M12 3a9 9 0 010 18M3 12a9 9 0 0118 0"/>
                                        </svg>
                                    @else
                                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <circle cx="12" cy="12" r="9"/>
                                            <path d="M3 12h18M12 3v18M5 5l14 14M5 19L19 5"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="court-name">{{ $court->name }}</h3>
                                    <div style="font-size: 0.8rem; color: var(--primary); font-weight: 600;">
                                        {{ $court->default_slots_per_hour }} Slots per hour
                                    </div>
                                </div>
                            </div>
                            <p class="court-desc">
                                {{ $court->description ?: 'Clean, tournament-grade athletic facilities equipped with modern lighting and player amenities.' }}
                            </p>
                        </div>

                        <div class="court-specs-row">
                            <div class="court-spec">
                                <span>Rate:</span>
                                <strong>₱{{ number_format($court->hourly_rate ?? 350, 2) }}/hr</strong>
                            </div>
                            <div class="court-spec">
                                <span>Capacity:</span>
                                <strong>{{ $court->default_slots_per_hour }} slots max</strong>
                            </div>
                            <div class="court-spec">
                                <span>Availability:</span>
                                <strong style="color: #065f46;">Open for Booking</strong>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- STEP 2: SELECT DATE -->
            <div class="section-header">
                <h2 class="section-title">
                    <span class="section-badge">2</span>
                    Select Date
                </h2>
                <span id="display-selected-date" style="font-size: 0.9rem; font-weight: 700; color: var(--primary);">
                    {{ \Carbon\Carbon::parse($selectedDate)->format('l, F j, Y') }}
                </span>
            </div>

            <div class="date-selector-card">
                <div class="date-picker-row">
                    <div class="quick-dates">
                        @php
                            $phNow = \App\Services\CourtBookingService::localNow();
                            $today = $phNow->toDateString();
                            $tomorrow = $phNow->copy()->addDay()->toDateString();
                            $day3 = $phNow->copy()->addDays(2)->toDateString();
                            $day4 = $phNow->copy()->addDays(3)->toDateString();
                        @endphp
                        <button type="button" class="quick-date-btn {{ $selectedDate === $today ? 'active' : '' }}" onclick="selectDate('{{ $today }}')">
                            Today ({{ $phNow->format('M d') }})
                        </button>
                        <button type="button" class="quick-date-btn {{ $selectedDate === $tomorrow ? 'active' : '' }}" onclick="selectDate('{{ $tomorrow }}')">
                            Tomorrow ({{ $phNow->copy()->addDay()->format('M d') }})
                        </button>
                        <button type="button" class="quick-date-btn {{ $selectedDate === $day3 ? 'active' : '' }}" onclick="selectDate('{{ $day3 }}')">
                            {{ $phNow->copy()->addDays(2)->format('D, M d') }}
                        </button>
                        <button type="button" class="quick-date-btn {{ $selectedDate === $day4 ? 'active' : '' }}" onclick="selectDate('{{ $day4 }}')">
                            {{ $phNow->copy()->addDays(3)->format('D, M d') }}
                        </button>
                    </div>

                    <div class="custom-date-box">
                        <label for="court-booking-date">Choose Date:</label>
                        <input type="date"
                               id="court-booking-date"
                               class="date-input"
                               min="{{ $today }}"
                               value="{{ $selectedDate }}"
                               onchange="selectDate(this.value)">
                    </div>
                </div>
            </div>

            <!-- STEP 3: SELECT TIME SLOT -->
            <div class="section-header">
                <h2 class="section-title">
                    <span class="section-badge">3</span>
                    Choose Time Slot
                </h2>
                <span style="font-size: 0.85rem; color: var(--text-muted);">
                    Hourly intervals starting at 12:00 AM
                </span>
            </div>

            <div class="slots-container">
                <div class="slots-legend">
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #10b981;"></span>
                        <span>Available Slots</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #f59e0b;"></span>
                        <span>1 Slot Left</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #ef4444;"></span>
                        <span>Fully Booked</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot" style="background: #94a3b8;"></span>
                        <span>Slot Passed</span>
                    </div>
                </div>

                <div class="slots-grid" id="slots-grid-container">
                    @foreach ($slots as $slot)
                        @php
                            $isSelectable = $slot['is_selectable'];
                            $isPassed = $slot['is_past'] || $slot['status'] === 'passed';
                            $pillClass = $isPassed
                                ? 'pill-passed'
                                : match($slot['status']) {
                                    'available' => ($slot['available_slots'] === 1 ? 'pill-limited' : 'pill-available'),
                                    'fully_booked' => 'pill-full',
                                    default => 'pill-closed',
                                };
                            $badgeLabel = $isPassed ? 'Slot Passed' : $slot['status_label'];
                        @endphp
                        <div class="slot-card {{ $isSelectable ? 'selectable' : 'disabled' }}"
                             data-hour="{{ $slot['hour'] }}"
                             data-time-label="{{ $slot['time_label'] }}"
                             data-available="{{ $slot['available_slots'] }}"
                             @if ($isSelectable)
                                onclick="openReservationModal({{ $slot['hour'] }}, '{{ $slot['time_label'] }}', {{ $slot['available_slots'] }})"
                             @endif>
                            <div class="slot-time">
                                <span>{{ $slot['time_label'] }}</span>
                                <span class="slot-pill {{ $pillClass }}">
                                    {{ $badgeLabel }}
                                </span>
                            </div>
                            <div class="slot-info-row">
                                <span>
                                    @if ($isPassed)
                                        Slot Passed
                                    @elseif ($slot['reason'])
                                        {{ $slot['reason'] }}
                                    @elseif ($slot['status'] === 'fully_booked')
                                        Capacity Reached ({{ $slot['total_capacity'] }}/{{ $slot['total_capacity'] }})
                                    @else
                                        Capacity: {{ $slot['total_capacity'] }} slots max
                                    @endif
                                </span>
                                @if ($isSelectable)
                                    <span style="color: var(--primary); font-weight: 700;">Select &rarr;</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

        <!-- RESERVATION MODAL DIALOG -->
        <div class="modal-overlay" id="reservation-modal" onclick="handleOverlayClick(event)">
            <div class="modal-dialog">
                <div class="modal-header">
                    <h3 class="modal-title" id="modal-court-title">Reserve Court Slot</h3>
                    <button type="button" class="modal-close-btn" onclick="closeReservationModal()">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- STEP 1: CUSTOMER DETAILS -->
                <div id="modal-step-details">
                    <form id="court-reservation-form" onsubmit="submitReservation(event)">
                        @csrf
                        <input type="hidden" name="court_id" id="form-court-id" value="{{ $selectedCourt->id }}">
                        <input type="hidden" name="booking_date" id="form-booking-date" value="{{ $selectedDate }}">
                        <input type="hidden" name="start_hour" id="form-start-hour" value="">

                        <div class="modal-body">
                            <!-- Summary Banner -->
                            <div class="selected-summary-banner">
                                <div>
                                    <div style="font-size: 0.75rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 0.04em;">Selected Schedule</div>
                                    <div id="modal-summary-court" style="font-size: 1.05rem; font-weight: 700; color: var(--text-title);">{{ $selectedCourt->name }}</div>
                                    <div id="modal-summary-schedule" style="font-size: 0.85rem; color: var(--primary); font-weight: 600;">&mdash;</div>
                                </div>
                                <div style="text-align: right;">
                                    <span class="slot-pill pill-available" id="modal-summary-badge">Available</span>
                                </div>
                            </div>

                            <!-- Full Name -->
                            <div class="form-group">
                                <label class="form-label" for="res-name">Full Name <span class="req">*</span></label>
                                <input type="text"
                                       id="res-name"
                                       name="customer_name"
                                       class="form-input"
                                       placeholder="e.g. Maria Santos"
                                       required>
                                <div class="form-error" id="err-customer_name"></div>
                            </div>

                            <!-- Email Address -->
                            <div class="form-group">
                                <label class="form-label" for="res-email">Email Address <span class="req">*</span></label>
                                <input type="email"
                                       id="res-email"
                                       name="customer_email"
                                       class="form-input"
                                       placeholder="e.g. maria@example.com"
                                       required>
                                <div class="form-help">A 6-digit verification passcode will be sent to this email address.</div>
                                <div class="form-error" id="err-customer_email"></div>
                            </div>

                            <!-- Contact Number -->
                            <div class="form-group">
                                <label class="form-label" for="res-contact">Contact Number <span class="req">*</span></label>
                                <input type="tel"
                                       id="res-contact"
                                       name="customer_contact"
                                       class="form-input"
                                       placeholder="e.g. 0917 123 4567"
                                       required>
                                <div class="form-error" id="err-customer_contact"></div>
                            </div>

                            <!-- Slots Count -->
                            <div class="form-group">
                                <label class="form-label" for="res-slots">Number of Slots</label>
                                <select id="res-slots" name="slots_count" class="form-input" style="cursor: pointer;">
                                    <option value="1">1 Slot</option>
                                    <option value="2">2 Slots</option>
                                    <option value="3">3 Slots</option>
                                    <option value="4">4 Slots</option>
                                </select>
                            </div>

                            <!-- Special Notes -->
                            <div class="form-group" style="margin-bottom: 0;">
                                <label class="form-label" for="res-notes">Special Requests / Notes (Optional)</label>
                                <textarea id="res-notes"
                                          name="notes"
                                          class="form-input"
                                          rows="2"
                                          placeholder="Any equipment needs, player notes, etc."></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" onclick="closeReservationModal()">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="btn-submit-reservation">
                                <span id="btn-submit-text">Send Verification Passcode &rarr;</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- STEP 2: ENTER PASSCODE -->
                <div id="modal-step-passcode" style="display: none;">
                    <div class="modal-body" style="text-align: center; padding: 26px 24px;">
                        <div style="width: 54px; height: 54px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 12px; border: 1px solid var(--primary-border);">
                            <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h4 style="font-size: 1.25rem; font-weight: 800; color: var(--text-title); margin-bottom: 4px;">Enter 6-Digit Passcode</h4>
                        <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 16px;">
                            We sent a real verification passcode to <strong id="passcode-target-email" style="color: var(--text-title);"></strong>.<br>Enter it below to proceed to payment.
                        </p>

                        <div class="pin-inputs-wrapper" id="modal-pin-inputs">
                            <input type="text" maxlength="1" class="pin-box modal-pin" data-index="0" inputmode="numeric" autocomplete="one-time-code">
                            <input type="text" maxlength="1" class="pin-box modal-pin" data-index="1" inputmode="numeric">
                            <input type="text" maxlength="1" class="pin-box modal-pin" data-index="2" inputmode="numeric">
                            <input type="text" maxlength="1" class="pin-box modal-pin" data-index="3" inputmode="numeric">
                            <input type="text" maxlength="1" class="pin-box modal-pin" data-index="4" inputmode="numeric">
                            <input type="text" maxlength="1" class="pin-box modal-pin" data-index="5" inputmode="numeric">
                        </div>

                        <div class="form-error" id="err-modal-passcode" style="text-align: center; margin: 10px 0;"></div>

                        <div style="font-size: 0.8rem; color: var(--text-muted); margin-top: 12px;">
                            Passcode expires in 30 minutes.
                        </div>
                    </div>

                    <div class="modal-footer" style="justify-content: space-between;">
                        <button type="button" class="btn btn-outline" onclick="backToStepDetails()" style="font-size: 0.85rem;">
                            &larr; Back
                        </button>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <button type="button" class="btn btn-outline" id="btn-modal-resend" onclick="resendModalPasscode()" style="font-size: 0.85rem;">
                                Resend Passcode
                            </button>
                            <button type="button" class="btn btn-primary" id="btn-modal-verify" onclick="submitModalPasscode()">
                                <span id="btn-modal-verify-text">Verify &amp; Proceed &rarr;</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="site-footer">
            <div style="max-width: 1240px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px;">
                <div>
                    &copy; {{ date('Y') }} Truant Enterprises. Court reservation and sports facilities management.
                </div>
                <div style="display: flex; gap: 20px;">
                    <a href="{{ url('/') }}" style="color: var(--text-muted); text-decoration: none;">Upcoming Events</a>
                    <a href="{{ route('court-booking.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">Book a Court</a>
                    <a href="{{ url('/admin/login') }}" style="color: var(--text-muted); text-decoration: none;">Administrator Login</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Frontend Script for Dynamic Interaction -->
    <script>
        let currentCourtId = {{ $selectedCourt->id }};
        let currentCourtName = "{{ addslashes($selectedCourt->name) }}";
        let currentDate = "{{ $selectedDate }}";

        function selectCourt(courtId) {
            currentCourtId = courtId;
            document.querySelectorAll('.court-card').forEach(card => {
                if (parseInt(card.dataset.courtId) === courtId) {
                    card.classList.add('selected');
                    currentCourtName = card.dataset.courtName;
                } else {
                    card.classList.remove('selected');
                }
            });
            document.getElementById('form-court-id').value = courtId;
            fetchSlots();
        }

        function selectDate(dateStr) {
            currentDate = dateStr;
            document.getElementById('court-booking-date').value = dateStr;
            document.getElementById('form-booking-date').value = dateStr;

            // Update Quick date active states
            document.querySelectorAll('.quick-date-btn').forEach(btn => {
                if (btn.getAttribute('onclick').includes(dateStr)) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            fetchSlots();
        }

        async function fetchSlots() {
            const container = document.getElementById('slots-grid-container');
            container.style.opacity = '0.5';

            try {
                const res = await fetch(`{{ route('court-booking.slots') }}?court_id=${currentCourtId}&date=${currentDate}`);
                const data = await res.json();

                document.getElementById('display-selected-date').textContent = data.formatted_date;

                let html = '';
                data.slots.forEach(slot => {
                    const isPassed = slot.is_past || slot.status === 'passed';
                    let pillClass = 'pill-closed';
                    if (isPassed) {
                        pillClass = 'pill-passed';
                    } else if (slot.status === 'available') {
                        pillClass = (slot.available_slots === 1 ? 'pill-limited' : 'pill-available');
                    } else if (slot.status === 'fully_booked') {
                        pillClass = 'pill-full';
                    }

                    const isSelectable = slot.is_selectable;
                    const cardClass = isSelectable ? 'selectable' : 'disabled';
                    const clickAttr = isSelectable
                        ? `onclick="openReservationModal(${slot.hour}, '${slot.time_label}', ${slot.available_slots})"`
                        : '';

                    let infoText = 'Capacity: ' + slot.total_capacity + ' slots max';
                    if (isPassed) {
                        infoText = 'Slot Passed';
                    } else if (slot.reason) {
                        infoText = slot.reason;
                    } else if (slot.status === 'fully_booked') {
                        infoText = `Capacity Reached (${slot.total_capacity}/${slot.total_capacity})`;
                    }

                    const badgeLabel = isPassed ? 'Slot Passed' : slot.status_label;
                    const actionHtml = isSelectable ? '<span style="color: var(--primary); font-weight: 700;">Select &rarr;</span>' : '';

                    html += `
                        <div class="slot-card ${cardClass}" data-hour="${slot.hour}" ${clickAttr}>
                            <div class="slot-time">
                                <span>${slot.time_label}</span>
                                <span class="slot-pill ${pillClass}">
                                    ${badgeLabel}
                                </span>
                            </div>
                            <div class="slot-info-row">
                                <span>${infoText}</span>
                                ${actionHtml}
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
            } catch (err) {
                console.error("Error loading slots:", err);
            } finally {
                container.style.opacity = '1';
            }
        }

        let activeBookingReference = null;
        let activeBookingToken = null;
        let resendCountdownTimer = null;

        function openReservationModal(hour, timeLabel, availableSlots) {
            // Reset to Step 1
            document.getElementById('modal-step-details').style.display = 'block';
            document.getElementById('modal-step-passcode').style.display = 'none';
            document.getElementById('form-start-hour').value = hour;
            document.getElementById('modal-court-title').textContent = `Reserve ${currentCourtName}`;
            document.getElementById('modal-summary-court').textContent = currentCourtName;
            document.getElementById('modal-summary-schedule').textContent = `${formatDateString(currentDate)} \u2022 ${timeLabel}`;
            document.getElementById('modal-summary-badge').textContent = `${availableSlots} slot(s) available`;

            // Adjust slots dropdown
            const slotsSelect = document.getElementById('res-slots');
            slotsSelect.innerHTML = '';
            for (let i = 1; i <= Math.min(availableSlots, 4); i++) {
                const opt = document.createElement('option');
                opt.value = i;
                opt.textContent = `${i} Slot${i > 1 ? 's' : ''}`;
                slotsSelect.appendChild(opt);
            }

            // Clear errors
            document.querySelectorAll('.form-error').forEach(el => { el.style.display = 'none'; el.textContent = ''; });

            document.getElementById('reservation-modal').classList.add('open');
        }

        function backToStepDetails() {
            document.getElementById('modal-step-passcode').style.display = 'none';
            document.getElementById('modal-step-details').style.display = 'block';
            document.getElementById('modal-court-title').textContent = `Reserve ${currentCourtName}`;
        }

        function closeReservationModal() {
            document.getElementById('reservation-modal').classList.remove('open');
            clearInterval(resendCountdownTimer);
        }

        function handleOverlayClick(event) {
            if (event.target === document.getElementById('reservation-modal')) {
                closeReservationModal();
            }
        }

        function formatDateString(str) {
            const parts = str.split('-');
            if (parts.length === 3) {
                const d = new Date(parts[0], parts[1] - 1, parts[2]);
                return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            }
            return str;
        }

        async function submitReservation(event) {
            event.preventDefault();
            const form = document.getElementById('court-reservation-form');
            const submitBtn = document.getElementById('btn-submit-reservation');
            const submitText = document.getElementById('btn-submit-text');

            submitBtn.disabled = true;
            submitText.textContent = 'Sending Verification Passcode...';

            // Clear errors
            document.querySelectorAll('.form-error').forEach(el => { el.style.display = 'none'; el.textContent = ''; });

            const formData = new FormData(form);

            try {
                const res = await fetch(`{{ route('court-booking.reserve') }}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    // Transition to Step 2: Passcode Entry
                    activeBookingReference = data.reference_code;
                    activeBookingToken = data.token;
                    document.getElementById('passcode-target-email').textContent = data.masked_email;
                    document.getElementById('modal-step-details').style.display = 'none';
                    document.getElementById('modal-step-passcode').style.display = 'block';
                    document.getElementById('modal-court-title').textContent = 'Email Passcode Verification';

                    // Clear PIN boxes and focus first
                    const pins = document.querySelectorAll('.modal-pin');
                    pins.forEach(p => { p.value = ''; p.classList.remove('filled'); });
                    pins[0]?.focus();

                    // Start 60s cooldown timer for resend
                    startResendTimer(60);
                } else if (res.status === 422 && data.errors) {
                    for (const [key, msgs] of Object.entries(data.errors)) {
                        const errEl = document.getElementById(`err-${key}`);
                        if (errEl) {
                            errEl.textContent = msgs[0];
                            errEl.style.display = 'block';
                        }
                    }
                } else {
                    alert(data.message || 'Unable to complete reservation. Please try again.');
                }
            } catch (err) {
                console.error("Submission error:", err);
                alert('A network error occurred. Please try again.');
            } finally {
                submitBtn.disabled = false;
                submitText.textContent = 'Send Verification Passcode \u2192';
            }
        }

        async function submitModalPasscode() {
            const pins = document.querySelectorAll('.modal-pin');
            let passcode = '';
            pins.forEach(p => passcode += p.value.trim());

            const errEl = document.getElementById('err-modal-passcode');
            errEl.style.display = 'none';
            errEl.textContent = '';

            if (passcode.length < 6) {
                errEl.textContent = 'Please enter all 6 digits of the passcode.';
                errEl.style.display = 'block';
                return;
            }

            const btn = document.getElementById('btn-modal-verify');
            const btnText = document.getElementById('btn-modal-verify-text');
            btn.disabled = true;
            btnText.textContent = 'Verifying...';

            try {
                const res = await fetch(`{{ route('court-booking.verifyPasscode') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        reference_code: activeBookingReference,
                        token: activeBookingToken,
                        passcode: passcode,
                    }),
                });

                const data = await res.json();

                if (res.ok && data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    errEl.textContent = data.message || 'Invalid passcode. Please try again.';
                    errEl.style.display = 'block';
                    pins.forEach(p => { p.classList.add('error'); });
                }
            } catch (err) {
                errEl.textContent = 'A network error occurred. Please try again.';
                errEl.style.display = 'block';
            } finally {
                btn.disabled = false;
                btnText.textContent = 'Verify & Proceed \u2192';
            }
        }

        async function resendModalPasscode() {
            const btn = document.getElementById('btn-modal-resend');
            if (btn.disabled) return;

            btn.disabled = true;
            btn.textContent = 'Resending...';

            try {
                const res = await fetch(`{{ route('court-booking.resendPasscode') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        reference_code: activeBookingReference,
                        token: activeBookingToken,
                    }),
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    alert(data.message);
                    startResendTimer(60);
                } else {
                    alert(data.message || 'Unable to resend passcode.');
                    btn.disabled = false;
                    btn.textContent = 'Resend Passcode';
                }
            } catch (err) {
                alert('A network error occurred while resending.');
                btn.disabled = false;
                btn.textContent = 'Resend Passcode';
            }
        }

        function startResendTimer(seconds) {
            const btn = document.getElementById('btn-modal-resend');
            if (!btn) return;
            btn.disabled = true;
            clearInterval(resendCountdownTimer);

            let remaining = seconds;
            btn.textContent = `Resend in ${remaining}s`;

            resendCountdownTimer = setInterval(() => {
                remaining--;
                if (remaining <= 0) {
                    clearInterval(resendCountdownTimer);
                    btn.disabled = false;
                    btn.textContent = 'Resend Passcode';
                } else {
                    btn.textContent = `Resend in ${remaining}s`;
                }
            }, 1000);
        }

        // Setup PIN box auto-advance, backspace, and paste handling
        document.addEventListener('DOMContentLoaded', () => {
            setupPinInputs(document.querySelectorAll('.modal-pin'), submitModalPasscode);
        });

        function setupPinInputs(inputs, autoSubmitFn) {
            inputs.forEach((input, idx) => {
                input.addEventListener('input', (e) => {
                    const val = e.target.value.replace(/\D/g, '');
                    e.target.value = val ? val[0] : '';
                    if (e.target.value) {
                        e.target.classList.add('filled');
                        if (idx < inputs.length - 1) {
                            inputs[idx + 1].focus();
                        } else if (autoSubmitFn) {
                            let allFilled = true;
                            inputs.forEach(i => { if (!i.value) allFilled = false; });
                            if (allFilled) autoSubmitFn();
                        }
                    } else {
                        e.target.classList.remove('filled');
                    }
                });

                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && idx > 0) {
                        inputs[idx - 1].focus();
                    }
                });

                input.addEventListener('paste', (e) => {
                    e.preventDefault();
                    const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                    if (!text) return;

                    inputs.forEach((inp, i) => {
                        inp.value = text[i] || '';
                        if (text[i]) inp.classList.add('filled');
                        else inp.classList.remove('filled');
                    });

                    const nextIdx = Math.min(text.length, inputs.length - 1);
                    inputs[nextIdx]?.focus();

                    if (text.length >= inputs.length && autoSubmitFn) {
                        autoSubmitFn();
                    }
                });
            });
        }
    </script>
</body>
</html>
