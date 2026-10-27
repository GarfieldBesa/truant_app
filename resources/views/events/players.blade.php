<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registered Players — {{ $event->name }} | {{ config('app.name', 'Truant Enterprises') }}</title>
    <meta name="description" content="View all confirmed registered players and official team rosters for {{ $event->name }}.">

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
            --team-accent: #0284c7;
            --team-light: #f0f9ff;
            --individual-accent: #059669;
            --individual-light: #ecfdf5;
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
            background-color: var(--bg-subtle);
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

        /* Breadcrumbs */
        .breadcrumb-bar {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 14px 24px;
        }

        .breadcrumb-container {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.875rem;
            color: var(--text-muted);
            flex-wrap: wrap;
        }

        .breadcrumb-container a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .breadcrumb-container a:hover {
            text-decoration: underline;
        }

        /* Hero */
        .hero-banner {
            background: #ffffff;
            border-bottom: 1px solid var(--border-color);
            padding: 36px 24px 28px;
        }

        .hero-container {
            max-width: 1140px;
            margin: 0 auto;
        }

        .hero-meta-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .badge-event-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 0.775rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .badge-open {
            background: #ecfdf5;
            color: #065f46;
        }

        .badge-closed {
            background: #f1f5f9;
            color: #475569;
        }

        .hero-title {
            font-family: var(--font-display);
            font-size: clamp(1.75rem, 3.2vw, 2.5rem);
            font-weight: 800;
            color: var(--text-title);
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .hero-subtitle {
            color: var(--text-muted);
            font-size: 1rem;
            margin-bottom: 24px;
            max-width: 760px;
        }

        /* Summary Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 20px 22px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
            border-color: var(--border-hover);
        }

        .stat-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-number {
            font-family: var(--font-display);
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-title);
            line-height: 1;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 4px;
        }

        /* Main Content Container */
        main.main-roster-content {
            flex: 1;
            max-width: 1140px;
            width: 100%;
            margin: 0 auto;
            padding: 32px 24px 72px;
        }

        /* Interactive Filter & Search Bar */
        .roster-toolbar {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 16px 20px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
            box-shadow: var(--shadow-sm);
        }

        .search-box-wrapper {
            position: relative;
            flex: 1;
            min-width: 260px;
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 10px 14px 10px 42px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.925rem;
            color: var(--text-title);
            background: var(--bg-subtle);
            transition: all 0.2s ease;
            outline: none;
            font-family: inherit;
        }

        .search-input:focus {
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.15);
        }

        .filter-tabs-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filter-tab-btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            border: 1px solid var(--border-color);
            background: #ffffff;
            color: var(--text-body);
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
        }

        .filter-tab-btn:hover {
            border-color: var(--border-hover);
            background: var(--bg-subtle);
        }

        .filter-tab-btn.active {
            background: var(--primary);
            color: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);
        }

        /* Teams Section */
        .roster-group-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            gap: 12px;
            flex-wrap: wrap;
        }

        .group-title {
            font-family: var(--font-display);
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-title);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .group-count-chip {
            padding: 2px 10px;
            background: #f1f5f9;
            color: var(--text-muted);
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
        }

        .teams-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
            margin-bottom: 40px;
        }

        .team-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: all 0.2s ease;
        }

        .team-card:hover {
            box-shadow: var(--shadow-md);
            border-color: var(--border-hover);
        }

        .team-card-header {
            background: linear-gradient(to right, #f8fafc, #ffffff);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .team-info-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .team-icon-badge {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: var(--team-light);
            color: var(--team-accent);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .team-title {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-title);
            margin: 0;
        }

        .team-meta-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .team-ref-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f1f5f9;
            color: #334155;
            font-family: monospace;
            font-size: 0.825rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
        }

        .team-count-badge {
            background: #e0f2fe;
            color: #0369a1;
            font-size: 0.8rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 9999px;
        }

        /* Player Table */
        .player-table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .player-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9rem;
            text-align: left;
        }

        .player-table th {
            background: var(--bg-subtle);
            color: var(--text-muted);
            font-weight: 700;
            font-size: 0.775rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 12px 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .player-table td {
            padding: 14px 20px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-body);
            vertical-align: middle;
        }

        .player-table tr:last-child td {
            border-bottom: none;
        }

        .player-table tr:hover td {
            background: #fafafa;
        }

        .player-avatar-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .player-avatar-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .avatar-team {
            background: #e0e7ff;
            color: #4338ca;
        }

        .avatar-individual {
            background: #d1fae5;
            color: #065f46;
        }

        .player-name-text {
            font-weight: 700;
            color: var(--text-title);
        }

        .player-ref-pill {
            font-family: monospace;
            font-size: 0.825rem;
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            padding: 3px 8px;
            border-radius: 6px;
            color: var(--text-body);
            display: inline-block;
        }

        .badge-player-status {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .badge-status-team {
            background: #e0e7ff;
            color: #4338ca;
        }

        .badge-status-individual {
            background: #d1fae5;
            color: #065f46;
        }

        /* Individual Players Card Container */
        .individual-card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            margin-bottom: 40px;
        }

        .individual-card-header {
            background: linear-gradient(to right, #f8fafc, #ffffff);
            border-bottom: 1px solid var(--border-color);
            padding: 16px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        /* Empty States */
        .empty-roster-state {
            background: #ffffff;
            border: 1px dashed var(--border-color);
            border-radius: var(--radius-lg);
            padding: 48px 24px;
            text-align: center;
            margin-bottom: 30px;
        }

        .empty-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: #f1f5f9;
            color: var(--text-muted);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }

        .empty-title {
            font-family: var(--font-display);
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 6px;
        }

        .empty-desc {
            color: var(--text-muted);
            font-size: 0.9rem;
            max-width: 440px;
            margin: 0 auto 20px;
        }

        /* Footer */
        .site-footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 36px 24px;
            border-top: 1px solid #1e293b;
            font-size: 0.875rem;
            margin-top: auto;
        }

        .footer-container {
            max-width: 1140px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }

        @media (max-width: 768px) {
            .roster-toolbar {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-tabs-group {
                overflow-x: auto;
                padding-bottom: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="site-wrapper">
        <!-- Header -->
        <header class="site-header">
            <div class="header-container">
                <a href="{{ url('/') }}" class="brand-link">
                    <div class="brand-logo-icon">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="brand-title">{{ config('app.name', 'Truant Enterprises') }}</span>
                </a>

                <div class="header-actions">
                    <a href="{{ route('events.public.show', $event) }}" class="btn btn-outline" id="btn-back-to-event">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Event Details</span>
                    </a>
                    <a href="{{ url('/') }}" class="btn btn-outline" id="btn-all-events">
                        <span>All Events</span>
                    </a>
                    <a href="{{ url('/admin/login') }}" class="btn btn-primary">Login</a>
                </div>
            </div>
        </header>

        <!-- Breadcrumb Bar -->
        <div class="breadcrumb-bar">
            <div class="breadcrumb-container">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <a href="{{ route('events.public.show', $event) }}">{{ $event->name }}</a>
                <span>/</span>
                <span style="color: var(--text-title); font-weight: 600;">Registered Players</span>
            </div>
        </div>

        <!-- Hero Section -->
        <section class="hero-banner">
            <div class="hero-container">
                <div class="hero-meta-row">
                    <span class="badge-event-status {{ $roster['is_open'] ? 'badge-open' : 'badge-closed' }}">
                        {{ $roster['is_open'] ? '● Registration Open' : '● Registration Closed' }}
                    </span>
                    <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">
                        📅 {{ $roster['event_date'] }}
                    </span>
                    <span style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">
                        🎟️ {{ $event->admission_label }}
                    </span>
                </div>

                <h1 class="hero-title" id="page-event-heading">Registered Players — {{ $event->name }}</h1>
                <p class="hero-subtitle">
                    Complete directory of all registered players and confirmed squads for {{ $event->name }}. Players belonging to teams are grouped under their respective squads.
                </p>

                <!-- Stats Grid -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon-wrapper" style="background: #e0e7ff; color: #4338ca;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="stat-number" id="stat-total-players">{{ $roster['total_players'] }}</div>
                            <div class="stat-label">Total Registered Players</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon-wrapper" style="background: #e0f2fe; color: #0284c7;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="stat-number" id="stat-total-teams">{{ $roster['total_teams'] }}</div>
                            <div class="stat-label">Teams Formed</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon-wrapper" style="background: #ecfdf5; color: #059669;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="stat-number" id="stat-individual-players">{{ $roster['individual_players_count'] }}</div>
                            <div class="stat-label">Individual Players (No Team)</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <main class="main-roster-content">
            <!-- Toolbar: Real-time search & Filter Tabs -->
            <div class="roster-toolbar">
                <div class="search-box-wrapper">
                    <svg class="search-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input 
                        type="text" 
                        id="player-search-input" 
                        class="search-input" 
                        placeholder="Search by player name, reference code, or team..."
                        oninput="filterPlayerRoster()"
                        autocomplete="off"
                    >
                </div>

                <div class="filter-tabs-group" role="tablist">
                    <button type="button" class="filter-tab-btn active" id="tab-all" onclick="setRosterTab('all')">
                        All Registered ({{ $roster['total_players'] }})
                    </button>
                    <button type="button" class="filter-tab-btn" id="tab-teams" onclick="setRosterTab('teams')">
                        Grouped by Teams ({{ $roster['total_teams'] }})
                    </button>
                    <button type="button" class="filter-tab-btn" id="tab-individual" onclick="setRosterTab('individual')">
                        Individual Players ({{ $roster['individual_players_count'] }})
                    </button>
                </div>
            </div>

            <!-- Global Empty State if 0 Players -->
            @if ($roster['total_players'] === 0)
                <div class="empty-roster-state" id="empty-state-no-players">
                    <div class="empty-icon-wrap">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="empty-title">No Players Registered Yet</h3>
                    <p class="empty-desc">Be the first to register for this event! You can also assemble a team once you have your registration reference code.</p>
                    <a href="{{ route('events.public.show', $event) }}#registration-form-section" class="btn btn-primary" id="btn-register-empty-cta">
                        <span>Register Now</span>
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            @else
                <!-- No Search Results Container -->
                <div class="empty-roster-state" id="empty-search-state" style="display: none;">
                    <div class="empty-icon-wrap">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="empty-title">No Matching Players or Teams Found</h3>
                    <p class="empty-desc">No registered players or teams match your search criteria. Try a different search keyword.</p>
                    <button type="button" class="btn btn-outline" onclick="clearPlayerSearch()">Clear Search Filter</button>
                </div>

                <!-- 1. GROUPED BY TEAMS SECTION -->
                <section class="roster-section-container" id="section-teams-group">
                    <div class="roster-group-heading">
                        <h2 class="group-title">
                            <svg width="22" height="22" fill="none" stroke="#0284c7" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Teams Roster</span>
                            <span class="group-count-chip" id="teams-group-chip">{{ count($roster['teams']) }} Teams</span>
                        </h2>
                    </div>

                    @if (count($roster['teams']) === 0)
                        <div class="empty-roster-state" style="padding: 28px; margin-bottom: 30px;">
                            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">No official teams registered for this event yet.</p>
                        </div>
                    @else
                        <div class="teams-grid" id="teams-grid-wrapper">
                            @foreach ($roster['teams'] as $team)
                                <article class="team-card team-roster-item" id="team-card-{{ $team['id'] }}" data-team-name="{{ strtolower($team['team_name']) }}" data-team-ref="{{ strtolower($team['team_reference']) }}">
                                    <!-- Team Card Header -->
                                    <div class="team-card-header">
                                        <div class="team-info-left">
                                            <div class="team-icon-badge">
                                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="team-title">{{ $team['team_name'] }}</h3>
                                            </div>
                                        </div>

                                        <div class="team-meta-right">
                                            <span class="team-ref-badge" title="Team Reference Code">
                                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                <span>{{ $team['team_reference'] }}</span>
                                            </span>
                                            <span class="team-count-badge">
                                                {{ $team['members_count'] }} {{ Str::plural('Player', $team['members_count']) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Team Members Table -->
                                    <div class="player-table-responsive">
                                        <table class="player-table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">#</th>
                                                    <th>Player Name</th>
                                                    <th>Registration Ref#</th>
                                                    <th>Registered Date</th>
                                                    <th style="text-align: right;">Roster Role</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($team['members'] as $index => $member)
                                                    <tr class="player-row" data-player-name="{{ strtolower($member['name']) }}" data-player-ref="{{ strtolower($member['reference']) }}" data-team-name="{{ strtolower($team['team_name']) }}">
                                                        <td style="color: var(--text-light); font-weight: 700;">{{ $index + 1 }}</td>
                                                        <td>
                                                            <div class="player-avatar-cell">
                                                                <div class="player-avatar-circle avatar-team">
                                                                    {{ strtoupper(mb_substr($member['name'], 0, 1)) }}
                                                                </div>
                                                                <div>
                                                                    <div class="player-name-text">{{ $member['name'] }}</div>
                                                                    <div style="font-size: 0.775rem; color: var(--text-muted);">{{ $team['team_name'] }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="player-ref-pill">{{ $member['reference'] }}</span>
                                                        </td>
                                                        <td style="color: var(--text-muted); font-size: 0.85rem;">
                                                            {{ $member['registered_at'] }}
                                                        </td>
                                                        <td style="text-align: right;">
                                                            <span class="badge-player-status badge-status-team">
                                                                <svg width="10" height="10" fill="currentColor" viewBox="0 0 8 8">
                                                                    <circle cx="4" cy="4" r="3"/>
                                                                </svg>
                                                                <span>Team Member</span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 20px;">
                                                            No players listed for this team.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </section>

                <!-- 2. INDIVIDUAL PLAYERS (NO TEAM YET) SECTION -->
                <section class="roster-section-container" id="section-individual-group">
                    <div class="roster-group-heading">
                        <h2 class="group-title">
                            <svg width="22" height="22" fill="none" stroke="#059669" stroke-width="2.2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Individual Players (No Team Yet)</span>
                            <span class="group-count-chip" id="individual-group-chip">{{ count($roster['individual_players']) }} Players</span>
                        </h2>
                    </div>

                    @if (count($roster['individual_players']) === 0)
                        <div class="empty-roster-state" style="padding: 28px; margin-bottom: 30px;">
                            <p style="color: var(--text-muted); font-size: 0.95rem; margin: 0;">All currently registered players have joined a team.</p>
                        </div>
                    @else
                        <article class="individual-card" id="individual-players-card">
                            <div class="individual-card-header">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div class="player-avatar-circle avatar-individual" style="width: 38px; height: 38px;">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="team-title" style="font-size: 1.05rem;">Solo &amp; Individual Registrations</h3>
                                        <div style="font-size: 0.8rem; color: var(--text-muted);">Registered attendees available to form or join teams</div>
                                    </div>
                                </div>
                                <span class="badge-player-status badge-status-individual">
                                    {{ count($roster['individual_players']) }} Individual {{ Str::plural('Attendee', count($roster['individual_players'])) }}
                                </span>
                            </div>

                            <div class="player-table-responsive">
                                <table class="player-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">#</th>
                                            <th>Player Name</th>
                                            <th>Registration Ref#</th>
                                            <th>Registration Date</th>
                                            <th style="text-align: right;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="individual-players-tbody">
                                        @foreach ($roster['individual_players'] as $index => $individual)
                                            <tr class="player-row individual-player-row" data-player-name="{{ strtolower($individual['name']) }}" data-player-ref="{{ strtolower($individual['reference']) }}">
                                                <td style="color: var(--text-light); font-weight: 700;">{{ $index + 1 }}</td>
                                                <td>
                                                    <div class="player-avatar-cell">
                                                        <div class="player-avatar-circle avatar-individual">
                                                            {{ strtoupper(mb_substr($individual['name'], 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <div class="player-name-text">{{ $individual['name'] }}</div>
                                                            <div style="font-size: 0.775rem; color: var(--text-muted);">Individual Participant</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="player-ref-pill">{{ $individual['reference'] }}</span>
                                                </td>
                                                <td style="color: var(--text-muted); font-size: 0.85rem;">
                                                    {{ $individual['registered_at'] }}
                                                </td>
                                                <td style="text-align: right;">
                                                    <span class="badge-player-status badge-status-individual">
                                                        <svg width="10" height="10" fill="currentColor" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3"/>
                                                        </svg>
                                                        <span>Solo / Free Agent</span>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </article>
                    @endif
                </section>
            @endif

            <!-- Bottom Back & Register CTA Banner -->
            <div style="background: #ffffff; border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 24px; display: flex; align-items: center; justify-content: space-between; gap: 20px; flex-wrap: wrap; box-shadow: var(--shadow-sm); margin-top: 20px;">
                <div>
                    <h4 style="font-family: var(--font-display); font-size: 1.15rem; font-weight: 700; color: var(--text-title); margin-bottom: 4px;">
                        Want to compete in {{ $event->name }}?
                    </h4>
                    <p style="color: var(--text-muted); font-size: 0.875rem; margin: 0;">
                        {{ $roster['is_open'] ? 'Registration is open! Secure your spot or register your team.' : 'Registration for this event is currently closed.' }}
                    </p>
                </div>

                <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('events.public.show', $event) }}" class="btn btn-outline" id="btn-footer-view-event">
                        <span>Event Page</span>
                    </a>
                    @if ($roster['is_open'])
                        <a href="{{ route('events.public.show', $event) }}#registration-form-section" class="btn btn-primary" id="btn-footer-register">
                            <span>Register for Event</span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-container">
                <div>
                    <span>&copy; {{ date('Y') }} {{ config('app.name', 'Truant Enterprises') }}. All rights reserved.</span>
                </div>
                <div style="display: flex; gap: 16px;">
                    <a href="{{ url('/') }}" style="color: #94a3b8; text-decoration: none;">Upcoming Events</a>
                    <a href="{{ route('events.public.show', $event) }}" style="color: #94a3b8; text-decoration: none;">Event Details</a>
                    <a href="{{ url('/admin/login') }}" style="color: #94a3b8; text-decoration: none;">Admin Access</a>
                </div>
            </div>
        </footer>
    </div>

    <!-- Interactive Filtering Scripts -->
    <script>
        let currentTab = 'all';

        function setRosterTab(tab) {
            currentTab = tab;
            document.querySelectorAll('.filter-tab-btn').forEach(btn => btn.classList.remove('active'));
            const activeBtn = document.getElementById('tab-' + tab);
            if (activeBtn) activeBtn.classList.add('active');
            filterPlayerRoster();
        }

        function filterPlayerRoster() {
            const searchInput = document.getElementById('player-search-input');
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

            const teamsSection = document.getElementById('section-teams-group');
            const individualSection = document.getElementById('section-individual-group');
            const emptySearchState = document.getElementById('empty-search-state');

            let visibleTeamsCount = 0;
            let visibleIndividualsCount = 0;

            // 1. Filter Teams
            if (teamsSection) {
                if (currentTab === 'individual') {
                    teamsSection.style.display = 'none';
                } else {
                    teamsSection.style.display = 'block';
                    const teamCards = teamsSection.querySelectorAll('.team-roster-item');
                    teamCards.forEach(card => {
                        const teamName = card.dataset.teamName || '';
                        const teamRef = card.dataset.teamRef || '';
                        const rows = card.querySelectorAll('tbody tr.player-row');

                        let matchInTeam = false;
                        if (!query) {
                            matchInTeam = true;
                            rows.forEach(r => r.style.display = '');
                        } else {
                            // If team name or ref matches query, show all its rows
                            if (teamName.includes(query) || teamRef.includes(query)) {
                                matchInTeam = true;
                                rows.forEach(r => r.style.display = '');
                            } else {
                                // Check each player in the team
                                rows.forEach(row => {
                                    const pName = row.dataset.playerName || '';
                                    const pRef = row.dataset.playerRef || '';
                                    if (pName.includes(query) || pRef.includes(query)) {
                                        row.style.display = '';
                                        matchInTeam = true;
                                    } else {
                                        row.style.display = 'none';
                                    }
                                });
                            }
                        }

                        if (matchInTeam) {
                            card.style.display = '';
                            visibleTeamsCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }
            }

            // 2. Filter Individuals
            if (individualSection) {
                if (currentTab === 'teams') {
                    individualSection.style.display = 'none';
                } else {
                    individualSection.style.display = 'block';
                    const indRows = individualSection.querySelectorAll('tbody tr.player-row');
                    indRows.forEach(row => {
                        const pName = row.dataset.playerName || '';
                        const pRef = row.dataset.playerRef || '';
                        if (!query || pName.includes(query) || pRef.includes(query)) {
                            row.style.display = '';
                            visibleIndividualsCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    const indCard = document.getElementById('individual-players-card');
                    if (indCard) {
                        indCard.style.display = (visibleIndividualsCount > 0) ? '' : 'none';
                    }
                }
            }

            // Show empty search state if query is present and 0 matches
            if (emptySearchState) {
                const totalVisible = visibleTeamsCount + visibleIndividualsCount;
                if (query && totalVisible === 0) {
                    emptySearchState.style.display = 'block';
                } else {
                    emptySearchState.style.display = 'none';
                }
            }
        }

        function clearPlayerSearch() {
            const searchInput = document.getElementById('player-search-input');
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
            }
            filterPlayerRoster();
        }
    </script>
</body>
</html>
