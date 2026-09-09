<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Truant Enterprises — Upcoming Events & Registrations</title>
    <meta name="description" content="Discover and register for upcoming conferences, summits, and corporate events on Truant Enterprises. Check real-time dates and registration availability.">

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
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.03);
            --shadow-md: 0 4px 16px -2px rgba(0, 0, 0, 0.06), 0 2px 6px -1px rgba(0, 0, 0, 0.04);
            --shadow-hover: 0 16px 32px -4px rgba(15, 23, 42, 0.08), 0 4px 12px -2px rgba(15, 23, 42, 0.04);
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
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .header-container {
            max-width: 1240px;
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

        .brand-info {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-family: var(--font-display);
            font-size: 1.25rem;
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
            gap: 20px;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-body);
            font-size: 0.925rem;
            font-weight: 600;
            padding: 8px 14px;
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
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
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
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
            transform: translateY(-1px);
        }

        /* ─── Hero Intro Section ──────────────────────────────────── */
        section.hero-section {
            background: linear-gradient(180deg, #ffffff 0%, var(--bg-subtle) 100%);
            border-bottom: 1px solid var(--border-color);
            padding: 56px 24px 44px;
            text-align: center;
        }

        .hero-container {
            max-width: 860px;
            margin: 0 auto;
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 9999px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 18px;
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(2rem, 4.5vw, 3rem);
            font-weight: 800;
            color: var(--text-title);
            line-height: 1.2;
            letter-spacing: -0.03em;
            margin-bottom: 16px;
        }

        .hero-description {
            font-size: 1.1rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .hero-stats {
            display: flex;
            justify-content: center;
            gap: 32px;
            margin-top: 20px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.925rem;
            font-weight: 600;
            color: var(--text-body);
        }

        .stat-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 8px rgba(16, 185, 129, 0.6);
        }

        /* ─── Main Content / Events Grid ──────────────────────────── */
        main.main-content {
            flex: 1;
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
            padding: 48px 24px 72px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 36px;
        }

        .section-heading-group {
            display: flex;
            flex-direction: column;
        }

        .section-title {
            font-family: var(--font-display);
            font-size: 1.65rem;
            font-weight: 700;
            color: var(--text-title);
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .events-count-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-body);
        }

        /* ─── 2 Cards Per Row Grid ────────────────────────────────── */
        .events-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 32px;
            margin-bottom: 48px;
        }

        /* ─── Event Card (Equal Height & Size) ────────────────────── */
        .event-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-md);
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .event-card:hover {
            transform: translateY(-4px);
            border-color: var(--border-hover);
            box-shadow: var(--shadow-hover);
        }

        /* Fixed Banner Display */
        .card-banner-wrapper {
            position: relative;
            width: 100%;
            height: 220px;
            background-color: #f1f5f9;
            overflow: hidden;
        }

        .card-banner-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .event-card:hover .card-banner-img {
            transform: scale(1.03);
        }

        /* Fallback Graphic Banner if No Image */
        .card-banner-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .card-banner-fallback svg {
            width: 44px;
            height: 44px;
            opacity: 0.6;
            margin-bottom: 8px;
        }

        /* Status Badge on Banner */
        .card-status-badge {
            position: absolute;
            top: 16px;
            right: 16px;
            padding: 6px 12px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
            backdrop-filter: blur(8px);
            z-index: 2;
        }

        .badge-open {
            background: rgba(236, 253, 245, 0.95);
            color: var(--success-text);
            border: 1px solid var(--success-border);
        }

        .badge-upcoming {
            background: rgba(255, 251, 235, 0.95);
            color: var(--warning-text);
            border: 1px solid var(--warning-border);
        }

        .badge-closed {
            background: rgba(241, 245, 249, 0.95);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        .live-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 6px #10b981;
        }

        /* Card Content Area */
        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 24px;
        }

        /* Date & Timeline meta */
        .card-meta-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            gap: 12px;
        }

        .event-date-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--primary);
        }

        .event-date-chip svg {
            width: 16px;
            height: 16px;
        }

        .registration-deadline {
            font-size: 0.8rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Admission Badge Pill */
        .admission-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 0.78rem;
            font-weight: 700;
            padding: 3px 9px;
            border-radius: 6px;
            letter-spacing: 0.01em;
            white-space: nowrap;
        }

        .admission-free {
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .admission-paid {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .desc-admission-highlight {
            font-weight: 700;
            color: var(--text-title);
            margin-right: 4px;
        }

        .desc-admission-val-free {
            color: #059669;
            font-weight: 700;
        }

        .desc-admission-val-paid {
            color: #2563eb;
            font-weight: 700;
        }

        /* Title */
        .card-event-title {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-title);
            line-height: 1.35;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-event-title a {
            color: inherit;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .card-event-title a:hover {
            color: var(--primary);
        }

        /* Clamped Description for Uniform Card Sizing */
        .card-event-desc {
            font-size: 0.925rem;
            color: var(--text-body);
            line-height: 1.55;
            margin-bottom: 24px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 4.3em;
        }

        /* Bottom Action Footer */
        .card-footer-action {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .btn-card-action {
            width: 100%;
            padding: 11px 18px;
            font-size: 0.925rem;
            font-weight: 600;
            border-radius: 8px;
            text-align: center;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-card-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.2);
        }

        .btn-card-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.3);
        }

        /* ─── Clean Pagination Styling ────────────────────────────── */
        .pagination-wrapper {
            margin-top: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-pagination {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
        }

        .page-item {
            display: inline-block;
        }

        .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 14px;
            border-radius: 8px;
            background: #ffffff;
            border: 1px solid var(--border-color);
            color: var(--text-body);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .page-link:hover {
            background: var(--bg-subtle);
            border-color: var(--border-hover);
            color: var(--primary);
        }

        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.25);
        }

        .page-item.disabled .page-link {
            opacity: 0.45;
            cursor: not-allowed;
            pointer-events: none;
            background: var(--bg-subtle);
        }

        /* ─── Empty State ─────────────────────────────────────────── */
        .empty-state-box {
            text-align: center;
            padding: 64px 24px;
            background: var(--bg-subtle);
            border-radius: var(--radius-lg);
            border: 2px dashed var(--border-color);
            grid-column: span 2;
        }

        .empty-state-icon {
            width: 56px;
            height: 56px;
            color: var(--text-light);
            margin: 0 auto 16px;
        }

        .empty-state-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 8px;
        }

        .empty-state-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
            max-width: 460px;
            margin: 0 auto;
        }

        /* ─── Footer ──────────────────────────────────────────────── */
        footer.site-footer {
            background: #ffffff;
            border-top: 1px solid var(--border-color);
            margin-top: auto;
            padding: 48px 24px 28px;
        }

        .footer-container {
            max-width: 1240px;
            margin: 0 auto;
        }

        .footer-top {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 36px;
        }

        .footer-brand-desc {
            font-size: 0.925rem;
            color: var(--text-muted);
            max-width: 380px;
            line-height: 1.6;
            margin-top: 12px;
        }

        .footer-col-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-title);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 16px;
        }

        .footer-links-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-link-item a {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 0.9rem;
            transition: color 0.15s ease;
        }

        .footer-link-item a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            padding-top: 24px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .footer-status-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            color: #059669;
        }

        .footer-status-chip .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #10b981;
        }

        /* ─── Responsive Media Queries ────────────────────────────── */
        @media (max-width: 900px) {
            .events-grid {
                grid-template-columns: 1fr;
            }
            .footer-top {
                grid-template-columns: 1fr;
                gap: 32px;
            }
        }

        @media (max-width: 640px) {
            .header-container {
                padding: 14px 16px;
            }
            header nav.header-nav {
                display: none;
            }
            .hero-stats {
                flex-direction: column;
                align-items: center;
                gap: 12px;
            }
            .footer-bottom {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="site-wrapper">
        <!-- Professional Header -->
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
                        <span class="brand-subtitle">Enterprise Suite</span>
                    </div>
                </a>

                <nav class="header-nav">
                    <a href="{{ url('/') }}" class="nav-link active" id="nav-events-link">Events</a>
                </nav>

                <div class="header-actions">
                    <a href="{{ url('/admin/login') }}" class="btn btn-primary" id="btn-login-header">
                        <span>Login</span>
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                    </a>
                </div>
            </div>
        </header>

        <!-- Clean Intro Hero -->
        <section class="hero-section">
            <div class="hero-container">
                <div class="hero-pill">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>Official Event Registrations &amp; Schedules</span>
                </div>

                <h1 class="hero-title" id="page-hero-heading">Explore Upcoming Events</h1>
                <p class="hero-description">
                    ####
                </p>

                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-dot"></span>
                        <span>Active Registrations Open</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" fill="none" stroke="#4f46e5" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Instant Registration Reference</span>
                    </div>
                    <div class="stat-item">
                        <svg width="16" height="16" fill="none" stroke="#4f46e5" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        <span>Automated Attendee Badges</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Body: 2-Card Per Row Grid -->
        <main class="main-content">
            <div class="section-header">
                <div class="section-heading-group">
                    <h2 class="section-title">Scheduled Events</h2>
                    <p class="section-subtitle">Showing 6 events per page with real-time status</p>
                </div>
                <div class="events-count-badge">
                    <span>Total Events: <strong>{{ $events->total() }}</strong></span>
                </div>
            </div>

            <!-- Events Grid -->
            <div class="events-grid" id="events-grid-container">
                @forelse ($events as $event)
                    @php
                        $isOpen = $event->isRegistrationOpen();
                        $statusText = $event->registration_status;
                        $activeBanner = ($event->registrationForm && $event->registrationForm->banner) ? $event->registrationForm->banner : $event->banner;
                    @endphp
                    <article class="event-card" id="event-card-{{ $event->id }}">
                        <!-- Card Banner -->
                        <div class="card-banner-wrapper">
                            @if ($activeBanner)
                                <img 
                                    src="{{ asset('storage/' . $activeBanner) }}" 
                                    alt="{{ $event->name }} Banner"
                                    class="card-banner-img"
                                    loading="lazy"
                                >
                            @else
                                <div class="card-banner-fallback">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span style="font-weight: 600; font-size: 0.95rem;">{{ $event->name }}</span>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="card-status-badge {{ $isOpen ? 'badge-open' : (str_starts_with($statusText, 'Opens') ? 'badge-upcoming' : 'badge-closed') }}">
                                @if ($isOpen)
                                    <span class="live-dot"></span>
                                    <span>Registration Open</span>
                                @elseif (str_starts_with($statusText, 'Opens'))
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $statusText }}</span>
                                @else
                                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span>Registration Closed</span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body (Uniform Size) -->
                        <div class="card-body">
                            <!-- Meta: Event Date & Admission Tag -->
                            <div class="card-meta-row">
                                <span class="event-date-chip">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <time datetime="{{ $event->event_date?->toDateString() }}">
                                        {{ $event->event_date ? $event->event_date->format('F d, Y') : 'Date TBA' }}
                                    </time>
                                </span>

                                <span class="admission-pill {{ $event->isFreeAdmission() ? 'admission-free' : 'admission-paid' }}">
                                    @if ($event->isFreeAdmission())
                                        <span>🎟️ Free Admission</span>
                                    @else
                                        <span>💳 Paid Admission{{ $event->ticket_price ? ' (' . $event->ticket_price . ')' : '' }}</span>
                                    @endif
                                </span>
                            </div>

                            <!-- Title -->
                            <h3 class="card-event-title">
                                <a href="{{ route('events.public.show', $event) }}">
                                    {{ $event->name }}
                                </a>
                            </h3>

                            <!-- Description with Admission Status -->
                            <p class="card-event-desc">
                                <span class="desc-admission-highlight">
                                    Admission: 
                                    <span class="{{ $event->isFreeAdmission() ? 'desc-admission-val-free' : 'desc-admission-val-paid' }}">
                                        {{ $event->admission_label }}{{ (! $event->isFreeAdmission() && $event->ticket_price) ? ' (' . $event->ticket_price . ')' : '' }}
                                    </span>
                                    &bull;
                                </span>
                                {{ Str::limit(strip_tags($event->description), 140) }}
                            </p>

                            <!-- Bottom Action Button linking to Event Page Content -->
                            <div class="card-footer-action">
                                <a href="{{ route('events.public.show', $event) }}" class="btn-card-action btn-card-primary" id="btn-view-event-{{ $event->id }}">
                                    <span>View Event &amp; Register</span>
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-state-box">
                        <svg class="empty-state-icon" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h4 class="empty-state-title">No Events Available Yet</h4>
                        <p class="empty-state-desc">Please check back soon for new conferences, workshops, and gatherings.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination (6 events per page) -->
            @if ($events->hasPages())
                <div class="pagination-wrapper" aria-label="Events pagination">
                    <ul class="custom-pagination">
                        {{-- Previous Page Link --}}
                        @if ($events->onFirstPage())
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">&laquo; Previous</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $events->previousPageUrl() }}" rel="prev">&laquo; Previous</a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                            @if ($page == $events->currentPage())
                                <li class="page-item active" aria-current="page">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($events->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $events->nextPageUrl() }}" rel="next">Next &raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled" aria-disabled="true">
                                <span class="page-link">Next &raquo;</span>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </main>

        <!-- Professional Footer -->
        <footer class="site-footer">
            <div class="footer-container">
                <div class="footer-top">
                    <div>
                        <a href="{{ url('/') }}" class="brand-link" style="margin-bottom: 8px;">
                            <div class="brand-logo-icon" style="width: 32px; height: 32px; border-radius: 8px;">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <span class="brand-title" style="font-size: 1.15rem;">Truant Enterprises</span>
                        </a>
                        <p class="footer-brand-desc">
                            A unified enterprise management suite integrating modern workforce records, biometric timesheets, automated payroll computations, and dynamic event registrations.
                        </p>
                    </div>

                    <div>
                        <h4 class="footer-col-title">Quick Links</h4>
                        <ul class="footer-links-list">
                            <li class="footer-link-item"><a href="{{ url('/') }}">Upcoming Events</a></li>
                            <li class="footer-link-item"><a href="{{ url('/admin/login') }}">Administrator Login</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="footer-col-title">Administration</h4>
                        <ul class="footer-links-list">
                            <li class="footer-link-item"><a href="{{ url('/admin/login') }}">Administrator Login</a></li>
                            <li class="footer-link-item"><a href="{{ url('/admin/events') }}">Event Form Builder</a></li>
                            <li class="footer-link-item"><a href="{{ url('/admin/payroll') }}">Payroll Management</a></li>
                        </ul>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div>
                        <span>&copy; {{ date('Y') }} Truant Enterprises. All rights reserved.</span>
                    </div>
                    <div class="footer-status-chip">
                        <span class="dot"></span>
                        <span>All Systems Operational</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
