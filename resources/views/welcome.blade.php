<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta content="mobile_tab" name="shell-type">
    <title>Truant Enterprises — Upcoming Events &amp; Registrations</title>
    <meta name="description" content="Discover company summits, wellness marathons, and networking forums across the Truant network. Check real-time dates and registration availability.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Space+Grotesk:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CDN & Custom Theme Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#3525cd",
                        "error": "#ba1a1a",
                        "surface-variant": "#dae2fd",
                        "background": "#faf8ff",
                        "on-primary": "#ffffff",
                        "secondary-container": "#6063ee",
                        "tertiary-container": "#006e4b",
                        "surface": "#faf8ff",
                        "surface-container-highest": "#dae2fd",
                        "inverse-surface": "#283044",
                        "on-primary-fixed": "#0f0069",
                        "on-tertiary-container": "#67f4b7",
                        "secondary-fixed": "#e1e0ff",
                        "primary-container": "#4f46e5",
                        "error-container": "#ffdad6",
                        "surface-dim": "#d2d9f4",
                        "inverse-on-surface": "#eef0ff",
                        "surface-container": "#eaedff",
                        "on-error": "#ffffff",
                        "on-surface": "#131b2e",
                        "tertiary-fixed": "#6ffbbe",
                        "secondary": "#4648d4",
                        "on-secondary": "#ffffff",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-tertiary-fixed": "#002113",
                        "surface-bright": "#faf8ff",
                        "on-background": "#131b2e",
                        "on-secondary-container": "#fffbff",
                        "outline": "#777587",
                        "inverse-primary": "#c3c0ff",
                        "primary-fixed": "#e2dfff",
                        "on-secondary-fixed": "#07006c",
                        "on-primary-container": "#dad7ff",
                        "tertiary-fixed-dim": "#4edea3",
                        "surface-container-low": "#f2f3ff",
                        "secondary-fixed-dim": "#c0c1ff",
                        "outline-variant": "#c7c4d8",
                        "surface-tint": "#4d44e3",
                        "on-surface-variant": "#464555",
                        "surface-container-high": "#e2e7ff",
                        "on-tertiary-fixed-variant": "#005236",
                        "on-primary-fixed-variant": "#3323cc",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "on-secondary-fixed-variant": "#2f2ebe",
                        "on-error-container": "#93000a",
                        "tertiary": "#005338"
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "space-sm": "0.5rem",
                        "space-lg": "1.5rem",
                        "gutter": "1.5rem",
                        "margin": "2rem",
                        "space-xs": "0.25rem",
                        "space-md": "1rem",
                        "gutter-mobile": "1rem",
                        "margin-mobile": "1rem",
                        "space-xl": "2rem"
                    },
                    fontFamily: {
                        "body-md": ["Plus Jakarta Sans", "sans-serif"],
                        "label-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "label-md": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-md": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-xl": ["Plus Jakarta Sans", "sans-serif"],
                        "body-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "label-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-lg-mobile": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-xl-mobile": ["Plus Jakarta Sans", "sans-serif"],
                        "body-sm": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    fontSize: {
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "label-lg": ["14px", { "lineHeight": "20px", "fontWeight": "600" }],
                        "headline-lg": ["28px", { "lineHeight": "36px", "fontWeight": "700" }],
                        "headline-sm": ["18px", { "lineHeight": "24px", "fontWeight": "700" }],
                        "label-md": ["12px", { "lineHeight": "16px", "fontWeight": "600" }],
                        "headline-md": ["20px", { "lineHeight": "28px", "fontWeight": "700" }],
                        "headline-xl": ["40px", { "lineHeight": "48px", "fontWeight": "800" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "label-sm": ["11px", { "lineHeight": "14px", "fontWeight": "600" }],
                        "headline-lg-mobile": ["22px", { "lineHeight": "30px", "fontWeight": "700" }],
                        "headline-xl-mobile": ["28px", { "lineHeight": "36px", "fontWeight": "800" }],
                        "body-sm": ["12px", { "lineHeight": "18px", "fontWeight": "400" }]
                    }
                }
            }
        };
    </script>

    <style>
        @layer base {
            html, body {
                width: 100vw;
                min-height: 100%;
                margin: 0;
                padding: 0;
            }
            body {
                overscroll-behavior-y: none;
                -webkit-tap-highlight-color: transparent;
                min-height: max(884px, 100dvh);
            }
            .pb-safe {
                padding-bottom: env(safe-area-inset-bottom, 0px);
            }
            .pt-safe {
                padding-top: env(safe-area-inset-top, 0px);
            }
        }
        ::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* ─── Customer Header & Dropdown Styles ─── */
        .user-menu-container {
            position: relative;
            display: inline-block;
        }
        .user-menu-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px 5px 6px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 9999px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            color: #0f172a;
            transition: all 0.15s ease;
            user-select: none;
        }
        .user-menu-trigger:hover {
            border-color: #3525cd;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        }
        .user-avatar-img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #4f46e5;
        }
        .user-dropdown-panel {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 240px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 6px 0;
            text-align: left;
        }
        .user-menu-container.open .user-dropdown-panel {
            display: block;
            animation: userDropdownAnim 0.15s ease-out;
        }
        @keyframes userDropdownAnim {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .user-dropdown-header {
            padding: 10px 14px;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 4px;
        }
        .user-dropdown-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 14px;
            color: #334155;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: background 0.1s ease;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            font-family: inherit;
        }
        .user-dropdown-item:hover {
            background: #f8fafc;
            color: #3525cd;
        }
        .user-dropdown-divider {
            height: 1px;
            background: #e2e8f0;
            margin: 4px 0;
        }

        /* ─── Registered Players Modal Styles ─── */
        .roster-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 9999;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.22s ease, visibility 0.22s ease;
        }
        .roster-modal-backdrop.is-open {
            opacity: 1;
            visibility: visible;
        }
        .roster-modal-dialog {
            background: #ffffff;
            width: 100%;
            max-width: 860px;
            max-height: 90vh;
            border-radius: 18px;
            box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.28);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: scale(0.96) translateY(12px);
            transition: transform 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            border: 1px solid #e2e8f0;
        }
        .roster-modal-backdrop.is-open .roster-modal-dialog {
            transform: scale(1) translateY(0);
        }
        .roster-modal-header {
            padding: 18px 22px 14px;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(to right, #f8fafc, #ffffff);
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
        }
        .modal-badge-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
            flex-wrap: wrap;
        }
        .modal-event-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #3525cd;
            background: #eef2ff;
            padding: 3px 10px;
            border-radius: 9999px;
            letter-spacing: 0.04em;
        }
        .modal-event-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 4px 0;
            line-height: 1.3;
        }
        .modal-event-meta {
            font-size: 0.82rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .modal-close-btn {
            background: #f1f5f9;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #64748b;
            font-size: 1.4rem;
            line-height: 1;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .modal-close-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        .roster-modal-body {
            padding: 18px 22px;
            overflow-y: auto;
            flex: 1;
        }
        .modal-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 10px;
            margin-bottom: 16px;
        }
        .modal-stat-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .modal-stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .modal-stat-val {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
        }
        .modal-stat-lbl {
            font-size: 0.72rem;
            color: #64748b;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }
        .modal-toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 16px;
        }
        .modal-search-wrapper {
            position: relative;
            flex: 1;
            min-width: 200px;
        }
        .modal-search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }
        .modal-search-input {
            width: 100%;
            padding: 8px 12px 8px 36px;
            background: #ffffff;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.85rem;
            color: #0f172a;
            outline: none;
            transition: all 0.15s ease;
        }
        .modal-search-input:focus {
            border-color: #3525cd;
            box-shadow: 0 0 0 3px rgba(53, 37, 205, 0.12);
        }
        .modal-filter-tabs {
            display: flex;
            background: #f1f5f9;
            padding: 3px;
            border-radius: 8px;
            gap: 2px;
        }
        .modal-tab-btn {
            padding: 6px 12px;
            font-size: 0.78rem;
            font-weight: 600;
            color: #64748b;
            background: transparent;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .modal-tab-btn.active {
            background: #ffffff;
            color: #0f172a;
            font-weight: 700;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }
        .modal-team-block {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            margin-bottom: 14px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }
        .modal-team-header {
            padding: 10px 16px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .modal-team-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .modal-member-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.82rem;
        }
        .modal-member-table th {
            text-align: left;
            padding: 8px 14px;
            background: #ffffff;
            color: #64748b;
            font-weight: 700;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 1px solid #e2e8f0;
        }
        .modal-member-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }
        .modal-avatar-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modal-avatar-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.76rem;
            flex-shrink: 0;
        }
        .avatar-team-theme {
            background: #e0f2fe;
            color: #0369a1;
        }
        .avatar-ind-theme {
            background: #ecfdf5;
            color: #065f46;
        }
        .modal-ref-badge {
            font-family: monospace;
            background: #f1f5f9;
            color: #475569;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.72rem;
            font-weight: 700;
            border: 1px solid #e2e8f0;
        }
        .modal-role-pill {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 9999px;
            display: inline-block;
        }
        .role-team-member {
            background: #e0f2fe;
            color: #0369a1;
        }
        .role-individual {
            background: #f1f5f9;
            color: #64748b;
        }
        .roster-modal-footer {
            padding: 12px 20px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body class="bg-background text-on-surface font-body-md text-body-md antialiased flex flex-col min-h-screen selection:bg-primary-fixed selection:text-on-primary-fixed">

    <!-- Global Header Partial (Desktop + Mobile) -->
    @include('partials.header', [
        'active' => 'events',
        'searchPlaceholder' => 'Search events, topics, or dates...',
        'mobileSubtitle' => 'Events & Summits'
    ])

    <!-- ═══ MAIN SHELL (pt-16 pb-20 on mobile, lg:pb-12) ═══ -->
    <main class="flex-1 flex flex-col relative w-full pt-16 pb-20 lg:pb-12 bg-background">
        <div class="flex flex-col w-full">

            <!-- 1. Hero Intro Discovery Section -->
            <section class="px-gutter-mobile pt-space-md pb-space-sm flex flex-col gap-space-sm max-w-7xl mx-auto w-full">
                <div class="flex flex-col gap-space-xs">
                    <span class="font-label-sm text-label-sm text-primary uppercase tracking-wider font-bold">Enterprise Discovery</span>
                    <h1 class="font-headline-xl-mobile md:font-headline-xl text-headline-xl-mobile md:text-headline-xl text-on-surface tracking-tight" id="page-hero-heading">
                        Explore Upcoming Events
                    </h1>
                    <p class="font-body-md text-body-md text-on-surface-variant leading-relaxed max-w-2xl">
                        Discover company summits, wellness marathons, and networking forums across the Truant network. Check real-time dates and registration availability.
                    </p>
                </div>

                <!-- Carousel Feature Chips -->
                <div class="flex items-center gap-space-xs overflow-x-auto pb-1 pt-1 no-scrollbar">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-surface-container text-on-surface-variant shrink-0 shadow-sm border border-outline-variant/20">
                        <span class="w-2 h-2 rounded-full bg-tertiary-fixed-dim animate-pulse"></span>
                        <span class="font-label-sm text-label-sm font-semibold">Active Registrations</span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-surface-container text-on-surface-variant shrink-0 shadow-sm border border-outline-variant/20">
                        <span class="material-symbols-outlined text-[16px] text-primary">verified</span>
                        <span class="font-label-sm text-label-sm font-semibold">Instant Reference</span>
                    </div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-surface-container text-on-surface-variant shrink-0 shadow-sm border border-outline-variant/20">
                        <span class="material-symbols-outlined text-[16px] text-secondary">qr_code_2</span>
                        <span class="font-label-sm text-label-sm font-semibold">Automated Badges</span>
                    </div>
                </div>
            </section>

            <!-- 2. Sticky Search & Filter Toolbar -->
            <section class="sticky top-16 z-30 px-gutter-mobile py-space-sm bg-surface/90 backdrop-blur-md flex flex-col gap-space-sm border-y border-outline-variant/20 shadow-sm">
                <div class="max-w-7xl mx-auto w-full flex flex-col gap-space-sm">
                    <div class="relative flex items-center w-full">
                        <span class="material-symbols-outlined absolute left-3.5 text-outline text-[20px] pointer-events-none">search</span>
                        <input 
                            class="w-full h-11 pl-10 pr-11 bg-surface-container-lowest text-on-surface rounded-xl shadow-sm font-body-md text-body-md placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/25 border border-outline-variant/40 transition-all" 
                            id="eventsSearch" 
                            placeholder="Search events, topics, or dates..." 
                            type="search"
                            autocomplete="off"
                        />
                        <button aria-label="Filter events" class="absolute right-1 w-9 h-9 flex items-center justify-center rounded-lg text-on-surface-variant hover:text-primary transition-colors active:scale-95" type="button" onclick="document.getElementById('eventsSearch')?.focus()">
                            <span class="material-symbols-outlined text-[20px]">tune</span>
                        </button>
                    </div>

                    <!-- Category Filter Chips -->
                    <div class="flex items-center gap-2 overflow-x-auto pb-0.5 no-scrollbar" id="categoryChips">
                        <button class="h-8 px-3.5 rounded-full font-label-sm text-label-sm bg-primary text-on-primary shrink-0 transition-transform active:scale-95 shadow-sm font-semibold" data-category="all" type="button">
                            All ({{ $events->total() }})
                        </button>
                        <button class="h-8 px-3.5 rounded-full font-label-sm text-label-sm bg-surface-container-lowest text-on-surface-variant hover:text-on-surface shrink-0 shadow-sm transition-transform active:scale-95 border border-outline-variant/30 font-medium" data-category="free" type="button">
                            Free Admission
                        </button>
                        <button class="h-8 px-3.5 rounded-full font-label-sm text-label-sm bg-surface-container-lowest text-on-surface-variant hover:text-on-surface shrink-0 shadow-sm transition-transform active:scale-95 border border-outline-variant/30 font-medium" data-category="paid" type="button">
                            Paid Admission
                        </button>
                        <button class="h-8 px-3.5 rounded-full font-label-sm text-label-sm bg-surface-container-lowest text-on-surface-variant hover:text-on-surface shrink-0 shadow-sm transition-transform active:scale-95 border border-outline-variant/30 font-medium" data-category="open" type="button">
                            Registration Open
                        </button>
                    </div>
                </div>
            </section>

            <!-- 3. Subheader Counter -->
            <div class="max-w-7xl mx-auto w-full px-gutter-mobile pt-space-sm pb-space-xs flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                    <span class="font-headline-sm text-headline-sm text-on-surface font-bold">Scheduled Events</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">({{ $events->count() }} of {{ $events->total() }})</span>
                </div>
                <span class="font-label-sm text-label-sm px-2.5 py-1 rounded-full bg-surface-container text-on-surface-variant font-semibold">Real-time sync</span>
            </div>

            <!-- 4. Events Grid (Mobile 1-Column, Desktop 2-Column) -->
            <section class="max-w-7xl mx-auto w-full px-gutter-mobile py-space-sm grid grid-cols-1 md:grid-cols-2 gap-space-md md:gap-space-lg" id="eventsGrid">
                @forelse ($events as $event)
                    @php
                        $isOpen = $event->isRegistrationOpen();
                        $statusText = $event->registration_status;
                        $activeBanner = ($event->registrationForm && $event->registrationForm->banner) ? $event->registrationForm->banner : $event->banner;
                    @endphp
                    <article 
                        class="flex flex-col bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 border border-outline-variant/30" 
                        id="event-card-{{ $event->id }}"
                        data-category="{{ $event->isFreeAdmission() ? 'free' : 'paid' }}"
                        data-status="{{ $isOpen ? 'open' : (str_starts_with($statusText, 'Opens') ? 'upcoming' : 'closed') }}"
                    >
                        <!-- Card Banner (16:9 Aspect Ratio) -->
                        <div class="relative w-full aspect-[16/9] bg-surface-container overflow-hidden">
                            @if ($activeBanner)
                                <img 
                                    class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" 
                                    src="{{ asset('storage/' . $activeBanner) }}" 
                                    alt="{{ $event->name }} Banner"
                                    loading="lazy"
                                />
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-slate-800 to-slate-950 text-white p-4 text-center">
                                    <span class="material-symbols-outlined text-[44px] text-white/50 mb-1">event</span>
                                    <span class="font-bold text-sm tracking-wide">{{ $event->name }}</span>
                                </div>
                            @endif

                            <!-- Status Badge Top-Right -->
                            <div class="absolute top-3 right-3">
                                @if ($isOpen)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface/90 backdrop-blur-md text-tertiary font-label-sm text-label-sm shadow-sm font-bold border border-tertiary/20">
                                        <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                                        Registration Open
                                    </span>
                                @elseif (str_starts_with($statusText, 'Opens'))
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-surface/90 backdrop-blur-md text-amber-800 font-label-sm text-label-sm shadow-sm font-bold border border-amber-300">
                                        <span class="material-symbols-outlined text-[14px]">schedule</span>
                                        {{ $statusText }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-surface/90 backdrop-blur-md text-on-surface-variant font-label-sm text-label-sm shadow-sm font-bold border border-outline-variant/40">
                                        <span class="material-symbols-outlined text-[14px]">lock</span>
                                        Registration Closed
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-space-md flex flex-col gap-space-sm flex-1 justify-between">
                            <div class="flex flex-col gap-space-sm">
                                <!-- Meta: Date and Admission Tag -->
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <div class="inline-flex items-center gap-1.5 text-primary font-label-sm text-label-sm font-semibold">
                                        <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                                        <time datetime="{{ $event->event_date?->toDateString() }}">
                                            {{ $event->event_date ? $event->event_date->format('F d, Y') : 'Date TBA' }}
                                        </time>
                                    </div>

                                    @if ($event->isFreeAdmission())
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed font-label-sm text-label-sm font-bold shadow-sm">
                                            <span class="material-symbols-outlined text-[14px]">confirmation_number</span>
                                            Free Admission
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-surface-variant text-on-surface font-label-sm text-label-sm font-bold shadow-sm">
                                            <span class="material-symbols-outlined text-[14px] text-secondary">payments</span>
                                            Paid Admission{{ $event->ticket_price ? ' (' . $event->ticket_price . ')' : '' }}
                                        </span>
                                    @endif
                                </div>

                                <!-- Title -->
                                <div class="flex flex-col gap-1">
                                    <h2 class="font-headline-md text-headline-md text-on-surface tracking-tight leading-snug font-bold">
                                        <a href="{{ route('events.public.show', $event) }}" class="hover:text-primary transition-colors">
                                            {{ $event->name }}
                                        </a>
                                    </h2>

                                    <!-- Description with Admission Highlight -->
                                    <p class="font-body-md text-body-md text-on-surface-variant line-clamp-2 leading-relaxed">
                                        <strong class="text-on-surface font-label-lg">
                                            Admission: {{ $event->admission_label }}{{ (! $event->isFreeAdmission() && $event->ticket_price) ? ' (' . $event->ticket_price . ')' : '' }}
                                        </strong> &bull; {{ Str::limit(strip_tags($event->description), 140) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer Actions: Registered Players on Left + View & Register on Right -->
                            <div class="pt-space-xs flex items-center justify-between gap-space-sm border-t border-outline-variant/30 mt-auto">
                                <button 
                                    type="button" 
                                    class="flex items-center gap-1.5 text-on-surface-variant hover:text-primary font-label-sm text-label-sm font-semibold transition-colors py-1.5 px-2 rounded-lg hover:bg-surface-container active:scale-95" 
                                    onclick="openEventRoster({{ $event->id }})" 
                                    id="btn-view-players-{{ $event->id }}" 
                                    title="View registered players and team rosters"
                                >
                                    <span class="material-symbols-outlined text-[18px] text-primary">group</span>
                                    <span>Registered Players ({{ $event->registrations->count() }})</span>
                                </button>

                                @if ($isOpen || str_starts_with($statusText, 'Opens'))
                                    <a 
                                        href="{{ route('events.public.show', $event) }}" 
                                        class="h-11 px-4 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg flex items-center gap-1.5 active:scale-95 transition-all shadow-sm shrink-0 hover:bg-primary-container" 
                                        id="btn-view-event-{{ $event->id }}"
                                    >
                                        <span>View &amp; Register</span>
                                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                    </a>
                                @else
                                    <a 
                                        href="{{ route('events.public.show', $event) }}" 
                                        class="h-11 px-4 rounded-xl bg-surface-container text-on-surface-variant font-label-lg text-label-lg flex items-center gap-1.5 active:scale-95 transition-all shrink-0 hover:bg-surface-container-high" 
                                        id="btn-view-event-{{ $event->id }}"
                                    >
                                        <span>View Archive</span>
                                        <span class="material-symbols-outlined text-[18px]">history</span>
                                    </a>
                                @endif
                            </div>

                            <!-- Embedded Roster Data for Zero-Lag Popup -->
                            <script id="event-roster-data-{{ $event->id }}" type="application/json">
                                {!! json_encode($event->getGroupedPlayers(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
                            </script>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-16 px-4 bg-surface-container-lowest rounded-xl border-2 border-dashed border-outline-variant/40">
                        <span class="material-symbols-outlined text-[48px] text-outline mb-2">event_busy</span>
                        <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold mb-1">No Events Available Yet</h4>
                        <p class="font-body-md text-body-md text-on-surface-variant max-w-md mx-auto">Please check back soon for new conferences, workshops, and gatherings across Truant Enterprises.</p>
                    </div>
                @endforelse
            </section>

            <!-- 5. Mobile-Styled Pagination Section -->
            <section class="max-w-7xl mx-auto w-full px-gutter-mobile py-space-md flex flex-col items-center gap-space-md">
                @if ($events->hasPages())
                    <div class="flex items-center justify-center gap-1.5 w-full flex-wrap" aria-label="Events pagination">
                        {{-- Previous Page Link --}}
                        @if ($events->onFirstPage())
                            <button aria-label="Previous Page" class="h-10 px-3.5 rounded-xl bg-surface-container text-on-surface-variant font-label-sm text-label-sm opacity-50 flex items-center gap-1 cursor-not-allowed" disabled type="button">
                                <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                                <span>&laquo; Previous</span>
                            </button>
                        @else
                            <a href="{{ $events->previousPageUrl() }}" rel="prev" aria-label="Previous Page" class="h-10 px-3.5 rounded-xl bg-surface-container-lowest text-on-surface font-label-sm text-label-sm shadow-sm flex items-center gap-1 active:scale-95 transition-transform hover:bg-surface-container border border-outline-variant/30">
                                <span class="material-symbols-outlined text-[16px]">chevron_left</span>
                                <span>&laquo; Previous</span>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($events->getUrlRange(1, $events->lastPage()) as $page => $url)
                            @if ($page == $events->currentPage())
                                <button class="w-10 h-10 rounded-xl bg-primary text-on-primary font-label-sm text-label-sm shadow-sm flex items-center justify-center font-bold" type="button">
                                    {{ $page }}
                                </button>
                            @else
                                <a href="{{ $url }}" class="w-10 h-10 rounded-xl bg-surface-container-lowest text-on-surface-variant hover:text-on-surface font-label-sm text-label-sm shadow-sm flex items-center justify-center active:scale-95 transition-transform border border-outline-variant/30 hover:bg-surface-container">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($events->hasMorePages())
                            <a href="{{ $events->nextPageUrl() }}" rel="next" aria-label="Next Page" class="h-10 px-3.5 rounded-xl bg-surface-container-lowest text-on-surface font-label-sm text-label-sm shadow-sm flex items-center gap-1 active:scale-95 transition-transform hover:bg-surface-container border border-outline-variant/30">
                                <span>Next &raquo;</span>
                                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                            </a>
                        @else
                            <button aria-label="Next Page" class="h-10 px-3.5 rounded-xl bg-surface-container text-on-surface-variant font-label-sm text-label-sm opacity-50 flex items-center gap-1 cursor-not-allowed" disabled type="button">
                                <span>Next &raquo;</span>
                                <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                            </button>
                        @endif
                    </div>
                @endif

                <!-- All Systems Operational Status Pill -->
                <div class="w-full flex items-center justify-between p-3.5 rounded-xl bg-surface-container-low text-on-surface-variant border border-outline-variant/20 shadow-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-tertiary-fixed-dim"></span>
                        <span class="font-label-sm text-label-sm text-on-surface font-semibold">All Systems Operational</span>
                    </div>
                    <span class="font-label-sm text-label-sm opacity-80 font-mono">v2.4.6 Enterprise</span>
                </div>
            </section>
        </div>
    </main>

    <!-- Global Footer Partial (Desktop Footer + Mobile Bottom Navigation) -->
    @include('partials.footer', ['active' => 'events'])

    <!-- ═══ REGISTERED PLAYERS & TEAMS INTERACTIVE MODAL DIALOG ═══ -->
    <div class="roster-modal-backdrop" id="rosterModalBackdrop" onclick="handleBackdropClick(event)" role="dialog" aria-modal="true" aria-labelledby="modalEventTitle">
        <div class="roster-modal-dialog">
            <!-- Modal Header -->
            <div class="roster-modal-header">
                <div>
                    <div class="modal-badge-group">
                        <span class="modal-event-badge">
                            <span class="material-symbols-outlined text-[14px]">group</span>
                            <span>Official Event Roster</span>
                        </span>
                        <span id="modalEventStatus" style="font-size: 0.75rem; font-weight: 700; color: #059669;">● Registration Open</span>
                    </div>
                    <h2 id="modalEventTitle" class="modal-event-title">Event Title</h2>
                    <div class="modal-event-meta">
                        <span id="modalEventDate">📅 Date TBA</span>
                        <span>&bull;</span>
                        <span id="modalEventSummary">Confirmed registered participants grouped by team squads</span>
                    </div>
                </div>
                <button type="button" class="modal-close-btn" onclick="closeRosterModal()" aria-label="Close roster modal" id="btn-close-roster-modal">&times;</button>
            </div>

            <!-- Modal Body -->
            <div class="roster-modal-body">
                <!-- Metrics -->
                <div class="modal-stats-grid">
                    <div class="modal-stat-card">
                        <div class="modal-stat-icon" style="background: #e0e7ff; color: #4338ca;">
                            <span class="material-symbols-outlined text-[20px]">groups</span>
                        </div>
                        <div>
                            <div class="modal-stat-val" id="modalStatTotalPlayers">0</div>
                            <div class="modal-stat-lbl">Total Registered</div>
                        </div>
                    </div>

                    <div class="modal-stat-card">
                        <div class="modal-stat-icon" style="background: #e0f2fe; color: #0284c7;">
                            <span class="material-symbols-outlined text-[20px]">shield</span>
                        </div>
                        <div>
                            <div class="modal-stat-val" id="modalStatTotalTeams">0</div>
                            <div class="modal-stat-lbl">Teams Formed</div>
                        </div>
                    </div>

                    <div class="modal-stat-card">
                        <div class="modal-stat-icon" style="background: #ecfdf5; color: #059669;">
                            <span class="material-symbols-outlined text-[20px]">person</span>
                        </div>
                        <div>
                            <div class="modal-stat-val" id="modalStatIndividual">0</div>
                            <div class="modal-stat-lbl">Individual / Solo</div>
                        </div>
                    </div>
                </div>

                <!-- Search & Filter Controls -->
                <div class="modal-toolbar">
                    <div class="modal-search-wrapper">
                        <span class="material-symbols-outlined modal-search-icon text-[16px]">search</span>
                        <input 
                            type="text" 
                            id="modalRosterSearch" 
                            class="modal-search-input" 
                            placeholder="Filter player name, team, or Ref#..." 
                            oninput="filterModalRoster()"
                            autocomplete="off"
                        >
                    </div>

                    <div class="modal-filter-tabs">
                        <button type="button" class="modal-tab-btn active" id="modal-tab-all" onclick="setModalTab('all')">
                            All Players
                        </button>
                        <button type="button" class="modal-tab-btn" id="modal-tab-teams" onclick="setModalTab('teams')">
                            Teams
                        </button>
                        <button type="button" class="modal-tab-btn" id="modal-tab-individual" onclick="setModalTab('individual')">
                            Solo Players
                        </button>
                    </div>
                </div>

                <!-- Dynamic Content Container -->
                <div id="modalRosterContent">
                    <!-- Populated via JavaScript -->
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="roster-modal-footer">
                <a href="#" id="modalViewDedicatedLink" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    <span>Full Page Directory</span>
                </a>

                <div style="display: flex; gap: 8px;">
                    <button type="button" class="px-3.5 py-1.5 rounded-lg border border-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-50 transition-colors" onclick="closeRosterModal()">Close</button>
                    <a href="#" id="modalRegisterCtaLink" class="inline-flex items-center gap-1 px-4 py-1.5 rounded-lg bg-primary text-white text-xs font-bold hover:bg-primary-container shadow-sm transition-colors">
                        <span>Register for Event</span>
                        <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ═══ CLIENT-SIDE SEARCH & FILTER SCRIPT ═══ -->
    <script>
        (function () {
            const searchInput = document.getElementById('eventsSearch');
            const cards = document.querySelectorAll('#eventsGrid article');
            const categoryChips = document.querySelectorAll('#categoryChips button');
            let activeCategory = 'all';

            function filterEvents() {
                const query = (searchInput?.value || '').toLowerCase().trim();
                let visibleCount = 0;

                cards.forEach((card) => {
                    const title = card.querySelector('h2')?.innerText.toLowerCase() || '';
                    const desc = card.querySelector('p')?.innerText.toLowerCase() || '';
                    const cardCategory = card.getAttribute('data-category') || '';
                    const cardStatus = card.getAttribute('data-status') || '';

                    const matchesSearch = !query || title.includes(query) || desc.includes(query);
                    let matchesCategory = true;

                    if (activeCategory === 'free') {
                        matchesCategory = cardCategory === 'free';
                    } else if (activeCategory === 'paid') {
                        matchesCategory = cardCategory === 'paid';
                    } else if (activeCategory === 'open') {
                        matchesCategory = cardStatus === 'open';
                    }

                    if (matchesSearch && matchesCategory) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterEvents);
            }

            categoryChips.forEach((chip) => {
                chip.addEventListener('click', function () {
                    categoryChips.forEach((c) => {
                        c.classList.remove('bg-primary', 'text-on-primary');
                        c.classList.add('bg-surface-container-lowest', 'text-on-surface-variant');
                    });
                    this.classList.remove('bg-surface-container-lowest', 'text-on-surface-variant');
                    this.classList.add('bg-primary', 'text-on-primary');
                    activeCategory = this.getAttribute('data-category') || 'all';
                    filterEvents();
                });
            });
        })();
    </script>

    <!-- ═══ ROSTER MODAL LOGIC SCRIPT ═══ -->
    <script>
        let currentModalRoster = null;
        let currentModalTab = 'all';

        function openEventRoster(eventId) {
            let data = null;
            const scriptTag = document.getElementById('event-roster-data-' + eventId);

            if (scriptTag) {
                try {
                    data = JSON.parse(scriptTag.textContent);
                } catch (e) {
                    console.error('Failed to parse embedded roster JSON:', e);
                }
            }

            if (data) {
                displayRosterModal(data);
            } else {
                fetch(`/events/${eventId}/players`, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => res.json())
                .then(res => {
                    if (res && res.data) {
                        displayRosterModal(res.data);
                    }
                })
                .catch(err => {
                    console.error('Failed to fetch event roster:', err);
                });
            }
        }

        function displayRosterModal(roster) {
            currentModalRoster = roster;
            currentModalTab = 'all';

            document.getElementById('modalEventTitle').textContent = roster.event_name || 'Event Roster';
            document.getElementById('modalEventDate').textContent = '📅 ' + (roster.event_date || 'Date TBA');
            document.getElementById('modalStatTotalPlayers').textContent = roster.total_players || 0;
            document.getElementById('modalStatTotalTeams').textContent = roster.total_teams || 0;
            document.getElementById('modalStatIndividual').textContent = roster.individual_players_count || 0;

            const statusEl = document.getElementById('modalEventStatus');
            if (statusEl) {
                if (roster.is_open) {
                    statusEl.textContent = '● Registration Open';
                    statusEl.style.color = '#059669';
                } else {
                    statusEl.textContent = '● Registration Closed';
                    statusEl.style.color = '#64748b';
                }
            }

            const dedicatedLink = document.getElementById('modalViewDedicatedLink');
            if (dedicatedLink) {
                dedicatedLink.href = `/events/${roster.event_id}/players`;
            }

            const regLink = document.getElementById('modalRegisterCtaLink');
            if (regLink) {
                regLink.href = `/events/${roster.event_id}#registration-form-section`;
                regLink.style.display = roster.is_open ? 'inline-flex' : 'none';
            }

            const searchInput = document.getElementById('modalRosterSearch');
            if (searchInput) {
                searchInput.value = '';
            }

            document.querySelectorAll('.modal-tab-btn').forEach(btn => btn.classList.remove('active'));
            const allTabBtn = document.getElementById('modal-tab-all');
            if (allTabBtn) allTabBtn.classList.add('active');

            renderModalRosterHtml();

            const backdrop = document.getElementById('rosterModalBackdrop');
            if (backdrop) {
                backdrop.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeRosterModal() {
            const backdrop = document.getElementById('rosterModalBackdrop');
            if (backdrop) {
                backdrop.classList.remove('is-open');
                document.body.style.overflow = '';
            }
        }

        function handleBackdropClick(event) {
            if (event.target.id === 'rosterModalBackdrop') {
                closeRosterModal();
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeRosterModal();
            }
        });

        function setModalTab(tab) {
            currentModalTab = tab;
            document.querySelectorAll('.modal-tab-btn').forEach(btn => btn.classList.remove('active'));
            const activeBtn = document.getElementById('modal-tab-' + tab);
            if (activeBtn) activeBtn.classList.add('active');
            renderModalRosterHtml();
        }

        function filterModalRoster() {
            renderModalRosterHtml();
        }

        function renderModalRosterHtml() {
            const container = document.getElementById('modalRosterContent');
            if (!container || !currentModalRoster) return;

            const searchInput = document.getElementById('modalRosterSearch');
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';

            const teams = currentModalRoster.teams || [];
            const individuals = currentModalRoster.individual_players || [];

            if (currentModalRoster.total_players === 0) {
                container.innerHTML = `
                    <div style="padding: 36px 16px; text-align: center; color: #64748b;">
                        <span class="material-symbols-outlined text-[40px] text-slate-300 mb-2 block">group_off</span>
                        <h4 style="font-weight: 700; color: #0f172a; margin-bottom: 4px;">No Players Registered Yet</h4>
                        <p style="font-size: 0.875rem;">Be the first to sign up for this event!</p>
                    </div>
                `;
                return;
            }

            let html = '';
            let totalMatches = 0;

            // 1. TEAMS GROUPING
            if (currentModalTab !== 'individual' && teams.length > 0) {
                let teamsHtml = '';
                teams.forEach(team => {
                    const teamName = team.team_name || '';
                    const teamRef = team.team_reference || '';
                    const members = team.members || [];

                    let matchingMembers = [];
                    if (!query || teamName.toLowerCase().includes(query) || teamRef.toLowerCase().includes(query)) {
                        matchingMembers = members;
                    } else {
                        matchingMembers = members.filter(m => 
                            (m.name && m.name.toLowerCase().includes(query)) || 
                            (m.reference && m.reference.toLowerCase().includes(query))
                        );
                    }

                    if (matchingMembers.length > 0) {
                        totalMatches += matchingMembers.length;
                        let memberRows = '';
                        matchingMembers.forEach((m, idx) => {
                            const initial = m.name ? m.name.charAt(0).toUpperCase() : '?';
                            memberRows += `
                                <tr>
                                    <td style="width: 36px; color: #94a3b8; font-weight: 700;">${idx + 1}</td>
                                    <td>
                                        <div class="modal-avatar-cell">
                                            <div class="modal-avatar-circle avatar-team-theme">${initial}</div>
                                            <div>
                                                <div style="font-weight: 700; color: #0f172a;">${m.name}</div>
                                                <div style="font-size: 0.75rem; color: #64748b;">${teamName}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="modal-ref-badge">${m.reference || '—'}</span></td>
                                    <td style="color: #64748b; font-size: 0.8rem;">${m.registered_at || '—'}</td>
                                    <td style="text-align: right;">
                                        <span class="modal-role-pill role-team-member">Team Member</span>
                                    </td>
                                </tr>
                            `;
                        });

                        teamsHtml += `
                            <div class="modal-team-block">
                                <div class="modal-team-header">
                                    <div class="modal-team-title">
                                        <span class="material-symbols-outlined text-[18px] text-sky-600">shield</span>
                                        <span>${teamName}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <span class="modal-ref-badge" title="Team Ref">${teamRef}</span>
                                        <span style="background: #e0f2fe; color: #0284c7; font-size: 0.75rem; font-weight: 700; padding: 2px 8px; border-radius: 9999px;">
                                            ${matchingMembers.length} ${matchingMembers.length === 1 ? 'Player' : 'Players'}
                                        </span>
                                    </div>
                                </div>
                                <div style="overflow-x: auto;">
                                    <table class="modal-member-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Player Name</th>
                                                <th>Ref#</th>
                                                <th>Date</th>
                                                <th style="text-align: right;">Role</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${memberRows}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        `;
                    }
                });

                if (teamsHtml) {
                    html += `
                        <div style="margin-bottom: 20px;">
                            <h4 style="font-size: 0.92rem; font-weight: 700; color: #0f172a; margin-bottom: 10px; display: flex; align-items: gap: 6px;">
                                <span>Grouped by Teams</span>
                                <span style="font-size: 0.75rem; color: #64748b; font-weight: 600;">(Official Squads)</span>
                            </h4>
                            ${teamsHtml}
                        </div>
                    `;
                }
            }

            // 2. INDIVIDUAL PLAYERS (NO TEAM)
            if (currentModalTab !== 'teams' && individuals.length > 0) {
                const matchingIndividuals = individuals.filter(ind => 
                    !query || 
                    (ind.name && ind.name.toLowerCase().includes(query)) || 
                    (ind.reference && ind.reference.toLowerCase().includes(query))
                );

                if (matchingIndividuals.length > 0) {
                    totalMatches += matchingIndividuals.length;
                    let indRows = '';
                    matchingIndividuals.forEach((ind, idx) => {
                        const initial = ind.name ? ind.name.charAt(0).toUpperCase() : '?';
                        indRows += `
                            <tr>
                                <td style="width: 36px; color: #94a3b8; font-weight: 700;">${idx + 1}</td>
                                <td>
                                    <div class="modal-avatar-cell">
                                        <div class="modal-avatar-circle avatar-ind-theme">${initial}</div>
                                        <div>
                                            <div style="font-weight: 700; color: #0f172a;">${ind.name}</div>
                                            <div style="font-size: 0.75rem; color: #64748b;">Solo / Free Agent</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="modal-ref-badge">${ind.reference || '—'}</span></td>
                                <td style="color: #64748b; font-size: 0.8rem;">${ind.registered_at || '—'}</td>
                                <td style="text-align: right;">
                                    <span class="modal-role-pill role-individual">No Team Yet</span>
                                </td>
                            </tr>
                        `;
                    });

                    html += `
                        <div>
                            <h4 style="font-size: 0.92rem; font-weight: 700; color: #0f172a; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
                                <span>Individual Players (No Team Yet)</span>
                                <span style="font-size: 0.75rem; color: #64748b; font-weight: 600;">(${matchingIndividuals.length} Players)</span>
                            </h4>
                            <div class="modal-team-block">
                                <div style="overflow-x: auto;">
                                    <table class="modal-member-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Player Name</th>
                                                <th>Ref#</th>
                                                <th>Date</th>
                                                <th style="text-align: right;">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${indRows}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    `;
                }
            }

            if (totalMatches === 0) {
                container.innerHTML = `
                    <div style="padding: 32px 16px; text-align: center; color: #64748b;">
                        <p style="margin-bottom: 8px; font-weight: 600;">No players or teams match "${query}".</p>
                        <button type="button" class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-colors" onclick="document.getElementById('modalRosterSearch').value = ''; renderModalRosterHtml();">Clear Search</button>
                    </div>
                `;
            } else {
                container.innerHTML = html;
            }
        }

        function toggleWelcomeUserDropdown(event) {
            event.stopPropagation();
            const wrap = document.getElementById('user-menu-wrap-welcome');
            if (wrap) {
                wrap.classList.toggle('open');
            }
        }

        document.addEventListener('click', (event) => {
            const wrap = document.getElementById('user-menu-wrap-welcome');
            if (wrap && !wrap.contains(event.target)) {
                wrap.classList.remove('open');
            }
        });
    </script>
</body>
</html>
