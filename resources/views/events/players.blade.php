<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" name="viewport"/>
    <meta content="mobile_tab" name="shell-type"/>
    <title>Registered Players — {{ $event->name }} | {{ config('app.name', 'Truant Enterprises') }}</title>
    <meta name="description" content="View all confirmed registered players and official team rosters for {{ $event->name }}."/>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>

    <!-- Tailwind CSS with Design Tokens matching the template -->
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
                        "2xl": "1rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "space-xs": "0.25rem",
                        "space-sm": "0.5rem",
                        "space-md": "1rem",
                        "space-lg": "1.5rem",
                        "space-xl": "2rem",
                        "gutter-mobile": "1rem",
                        "gutter": "1.5rem"
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
                        "body-sm": ["Plus Jakarta Sans", "sans-serif"],
                        sans: ["Plus Jakarta Sans", "sans-serif"]
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
            padding: 4px 10px 4px 5px;
            border-radius: 9999px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            font-size: 0.825rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .user-menu-trigger:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
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
    </style>
</head>
<body class="bg-background text-on-surface font-sans text-sm antialiased flex flex-col min-h-screen selection:bg-primary-fixed selection:text-on-primary-fixed">

    <!-- Global Header Partial (Desktop + Mobile) -->
    @include('partials.header', ['active' => 'events'])

    <!-- Main Content Container -->
    <main class="flex-1 flex flex-col relative w-full pt-16 pb-28 md:pb-16 bg-background">
        <div class="max-w-6xl mx-auto w-full px-4 pt-4 flex flex-col gap-5">

            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 text-xs text-on-surface-variant overflow-x-auto no-scrollbar py-1">
                <a href="{{ url('/') }}" class="hover:text-primary font-semibold flex items-center gap-1 shrink-0" id="btn-all-events">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                    <span>All Events</span>
                </a>
                <span class="text-outline-variant">/</span>
                <a href="{{ route('events.public.show', $event) }}" class="hover:text-primary font-medium truncate max-w-[150px] sm:max-w-xs shrink-0" id="btn-back-to-event">
                    {{ $event->name }}
                </a>
                <span class="text-outline-variant">/</span>
                <span class="text-on-surface font-semibold truncate shrink-0">Registered Players</span>
            </div>

            <!-- Hero Section -->
            <section class="bg-surface-container-lowest rounded-2xl p-5 sm:p-6 shadow-sm border border-outline-variant/30 flex flex-col gap-4">
                <div class="flex flex-col gap-1.5">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $roster['is_open'] ? 'bg-tertiary-fixed text-on-tertiary-fixed' : 'bg-surface-variant text-on-surface' }} font-bold text-xs shadow-sm">
                            <span class="w-2 h-2 rounded-full {{ $roster['is_open'] ? 'bg-tertiary animate-pulse' : 'bg-outline' }}"></span>
                            <span>{{ $roster['is_open'] ? 'Registration Open' : 'Registration Closed' }}</span>
                        </span>
                        <span class="text-xs text-on-surface-variant font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px] text-primary">calendar_today</span>
                            <span>{{ $roster['event_date'] }}</span>
                        </span>
                        <span class="text-xs text-on-surface-variant font-medium flex items-center gap-1">
                            <span class="material-symbols-outlined text-[15px] text-secondary">confirmation_number</span>
                            <span>{{ $event->admission_label }}</span>
                        </span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-on-surface tracking-tight mt-1" id="page-event-heading">
                        Registered Players — {{ $event->name }}
                    </h1>
                    <p class="text-xs sm:text-sm text-on-surface-variant leading-relaxed max-w-3xl">
                        Complete directory of all registered players and confirmed squads for {{ $event->name }}. Players belonging to teams are grouped under their respective squads.
                    </p>
                </div>

                <!-- Stats Grid (3 summary cards) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                    <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/30 flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[24px]">group</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-xl text-primary leading-none" id="stat-total-players">{{ $roster['total_players'] }}</span>
                            <span class="text-xs text-on-surface-variant font-semibold mt-1">Total Registered Players</span>
                        </div>
                    </div>

                    <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/30 flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[24px]">diversity_3</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-xl text-secondary leading-none" id="stat-total-teams">{{ $roster['total_teams'] }}</span>
                            <span class="text-xs text-on-surface-variant font-semibold mt-1">Teams Formed</span>
                        </div>
                    </div>

                    <div class="bg-surface-container-low p-4 rounded-xl border border-outline-variant/30 flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-tertiary/10 text-tertiary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[24px]">person</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-xl text-tertiary leading-none" id="stat-individual-players">{{ $roster['individual_players_count'] }}</span>
                            <span class="text-xs text-on-surface-variant font-semibold mt-1">Individual Players (No Team)</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Search & Filter Tab Toolbar -->
            <div class="bg-surface-container-lowest rounded-2xl p-4 shadow-sm border border-outline-variant/30 flex flex-col sm:flex-row gap-3 items-stretch sm:items-center justify-between">
                <!-- Search Input -->
                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-outline text-[20px] pointer-events-none">search</span>
                    <input 
                        type="text" 
                        id="player-search-input" 
                        class="w-full h-11 pl-10 pr-4 bg-surface-container-lowest text-on-surface rounded-xl border border-outline-variant/40 text-xs sm:text-sm placeholder:text-outline focus:border-primary focus:outline-none transition-colors"
                        placeholder="Search by player name, reference code, or team..."
                        oninput="filterPlayerRoster()"
                        autocomplete="off"
                    />
                </div>

                <!-- Tabs -->
                <div class="flex items-center gap-1.5 overflow-x-auto no-scrollbar shrink-0" role="tablist">
                    <button type="button" class="h-9 px-3.5 rounded-xl font-bold text-xs bg-primary text-on-primary shrink-0 transition-transform active:scale-95 shadow-sm" id="tab-all" onclick="setRosterTab('all')">
                        All ({{ $roster['total_players'] }})
                    </button>
                    <button type="button" class="h-9 px-3.5 rounded-xl font-bold text-xs bg-surface-container text-on-surface-variant hover:text-on-surface shrink-0 transition-transform active:scale-95" id="tab-teams" onclick="setRosterTab('teams')">
                        Teams ({{ $roster['total_teams'] }})
                    </button>
                    <button type="button" class="h-9 px-3.5 rounded-xl font-bold text-xs bg-surface-container text-on-surface-variant hover:text-on-surface shrink-0 transition-transform active:scale-95" id="tab-individual" onclick="setRosterTab('individual')">
                        Solo ({{ $roster['individual_players_count'] }})
                    </button>
                </div>
            </div>

            <!-- Global Empty State if 0 Players in Event -->
            @if ($roster['total_players'] === 0)
                <div class="bg-surface-container-lowest rounded-2xl p-8 sm:p-12 text-center border border-dashed border-outline-variant/40 flex flex-col items-center gap-3" id="empty-state-no-players">
                    <div class="w-14 h-14 rounded-2xl bg-surface-container text-on-surface-variant flex items-center justify-center">
                        <span class="material-symbols-outlined text-[32px]">group_off</span>
                    </div>
                    <h3 class="text-base font-bold text-on-surface">No Players Registered Yet</h3>
                    <p class="text-xs text-on-surface-variant max-w-sm">
                        Be the first to register for this event! You can also assemble a team once you have your registration reference code.
                    </p>
                    <a href="{{ route('events.public.show', $event) }}#registration-form-section" class="h-10 px-5 rounded-xl bg-primary text-on-primary font-bold text-xs flex items-center gap-1.5 active:scale-95 transition-all shadow-sm mt-2" id="btn-register-empty-cta">
                        <span>Register Now</span>
                        <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                    </a>
                </div>
            @else
                <!-- Empty Search Results State -->
                <div class="hidden bg-surface-container-lowest rounded-2xl p-8 text-center border border-dashed border-outline-variant/40 flex flex-col items-center gap-3" id="empty-search-state">
                    <div class="w-12 h-12 rounded-2xl bg-surface-container text-on-surface-variant flex items-center justify-center">
                        <span class="material-symbols-outlined text-[28px]">search_off</span>
                    </div>
                    <h3 class="text-base font-bold text-on-surface">No Matching Players or Teams Found</h3>
                    <p class="text-xs text-on-surface-variant">No registered players or teams match your search criteria. Try a different search keyword.</p>
                    <button type="button" class="h-9 px-4 rounded-xl bg-surface-container text-on-surface font-semibold text-xs active:scale-95 transition-all" onclick="clearPlayerSearch()">
                        Clear Search Filter
                    </button>
                </div>

                <!-- 1. GROUPED BY TEAMS SECTION -->
                <section class="flex flex-col gap-3" id="section-teams-group">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-secondary">shield</span>
                            <span>Teams Roster</span>
                            <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed ml-1" id="teams-group-chip">{{ count($roster['teams']) }} Teams</span>
                        </h2>
                    </div>

                    @if (count($roster['teams']) === 0)
                        <div class="bg-surface-container-lowest rounded-xl p-6 text-center border border-dashed border-outline-variant/30 text-xs text-on-surface-variant">
                            No official teams registered for this event yet.
                        </div>
                    @else
                        <div class="grid grid-cols-1 gap-4" id="teams-grid-wrapper">
                            @foreach ($roster['teams'] as $team)
                                <article class="team-card team-roster-item bg-surface-container-lowest rounded-2xl border border-outline-variant/30 overflow-hidden shadow-sm" id="team-card-{{ $team['id'] }}" data-team-name="{{ strtolower($team['team_name']) }}" data-team-ref="{{ strtolower($team['team_reference']) }}">
                                    <!-- Team Card Header -->
                                    <div class="bg-surface-container-low px-4 py-3 flex items-center justify-between border-b border-outline-variant/30 gap-2 flex-wrap">
                                        <div class="flex items-center gap-2.5">
                                            <div class="w-8 h-8 rounded-lg bg-secondary/15 text-secondary flex items-center justify-center shrink-0">
                                                <span class="material-symbols-outlined text-[18px]">groups</span>
                                            </div>
                                            <h3 class="font-bold text-sm text-on-surface team-title">{{ $team['team_name'] }}</h3>
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <span class="font-mono text-[11px] px-2 py-0.5 rounded bg-surface-container-lowest border border-outline-variant/40" title="Team Reference Code">{{ $team['team_reference'] }}</span>
                                            <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed">
                                                {{ $team['members_count'] }} {{ Str::plural('Player', $team['members_count']) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Team Members Table -->
                                    <div class="overflow-x-auto no-scrollbar">
                                        <table class="w-full text-left text-xs border-collapse">
                                            <thead>
                                                <tr class="border-b border-outline-variant/20 text-on-surface-variant bg-surface-container-lowest/50">
                                                    <th class="py-2.5 px-3.5 w-10">#</th>
                                                    <th class="py-2.5 px-3.5">Player Name</th>
                                                    <th class="py-2.5 px-3.5">Registration Ref#</th>
                                                    <th class="py-2.5 px-3.5">Registered Date</th>
                                                    <th class="py-2.5 px-3.5 text-right">Roster Role</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-outline-variant/15">
                                                @forelse ($team['members'] as $index => $member)
                                                    <tr class="player-row hover:bg-surface-container-low/40" data-player-name="{{ strtolower($member['name']) }}" data-player-ref="{{ strtolower($member['reference']) }}" data-team-name="{{ strtolower($team['team_name']) }}">
                                                        <td class="py-2.5 px-3.5 text-outline text-[11px] font-bold">{{ $index + 1 }}</td>
                                                        <td class="py-2.5 px-3.5 font-bold text-on-surface">
                                                            <div class="flex items-center gap-2">
                                                                <div class="w-7 h-7 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold text-[11px] shrink-0">
                                                                    {{ strtoupper(mb_substr($member['name'], 0, 1)) }}
                                                                </div>
                                                                <span>{{ $member['name'] }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="py-2.5 px-3.5 font-mono text-[11px] text-on-surface-variant">{{ $member['reference'] }}</td>
                                                        <td class="py-2.5 px-3.5 text-[11px] text-on-surface-variant">{{ $member['registered_at'] }}</td>
                                                        <td class="py-2.5 px-3.5 text-right">
                                                            <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-secondary/10 text-secondary">
                                                                <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                                                <span>Team Member</span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="py-4 text-center text-on-surface-variant">No players listed for this team.</td>
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
                <section class="flex flex-col gap-3" id="section-individual-group">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-bold text-on-surface uppercase tracking-wider flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[18px] text-tertiary">person</span>
                            <span>Individual Players (No Team Yet)</span>
                            <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed ml-1" id="individual-group-chip">{{ count($roster['individual_players']) }} Players</span>
                        </h2>
                    </div>

                    @if (count($roster['individual_players']) === 0)
                        <div class="bg-surface-container-lowest rounded-xl p-6 text-center border border-dashed border-outline-variant/30 text-xs text-on-surface-variant">
                            All currently registered players have joined a team.
                        </div>
                    @else
                        <article class="individual-card bg-surface-container-lowest rounded-2xl border border-outline-variant/30 overflow-hidden shadow-sm" id="individual-players-card">
                            <div class="bg-surface-container-low px-4 py-3 flex items-center justify-between border-b border-outline-variant/30 gap-2 flex-wrap">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-lg bg-tertiary/15 text-tertiary flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[18px]">badge</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <h3 class="font-bold text-sm text-on-surface">Solo &amp; Individual Registrations</h3>
                                        <span class="text-[11px] text-on-surface-variant">Registered attendees available to form or join teams</span>
                                    </div>
                                </div>
                                <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed">
                                    {{ count($roster['individual_players']) }} Individual {{ Str::plural('Attendee', count($roster['individual_players'])) }}
                                </span>
                            </div>

                            <div class="overflow-x-auto no-scrollbar">
                                <table class="w-full text-left text-xs border-collapse">
                                    <thead>
                                        <tr class="border-b border-outline-variant/20 text-on-surface-variant bg-surface-container-lowest/50">
                                            <th class="py-2.5 px-3.5 w-10">#</th>
                                            <th class="py-2.5 px-3.5">Player Name</th>
                                            <th class="py-2.5 px-3.5">Registration Ref#</th>
                                            <th class="py-2.5 px-3.5">Registration Date</th>
                                            <th class="py-2.5 px-3.5 text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="individual-players-tbody" class="divide-y divide-outline-variant/15">
                                        @foreach ($roster['individual_players'] as $index => $individual)
                                            <tr class="player-row individual-player-row hover:bg-surface-container-low/40" data-player-name="{{ strtolower($individual['name']) }}" data-player-ref="{{ strtolower($individual['reference']) }}">
                                                <td class="py-2.5 px-3.5 text-outline text-[11px] font-bold">{{ $index + 1 }}</td>
                                                <td class="py-2.5 px-3.5 font-bold text-on-surface">
                                                    <div class="flex items-center gap-2">
                                                        <div class="w-7 h-7 rounded-full bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center font-bold text-[11px] shrink-0">
                                                            {{ strtoupper(mb_substr($individual['name'], 0, 1)) }}
                                                        </div>
                                                        <span>{{ $individual['name'] }}</span>
                                                    </div>
                                                </td>
                                                <td class="py-2.5 px-3.5 font-mono text-[11px] text-on-surface-variant">{{ $individual['reference'] }}</td>
                                                <td class="py-2.5 px-3.5 text-[11px] text-on-surface-variant">{{ $individual['registered_at'] }}</td>
                                                <td class="py-2.5 px-3.5 text-right">
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-tertiary"></span>
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

            <!-- Bottom CTA Banner -->
            <div class="bg-surface-container-lowest rounded-2xl p-5 border border-outline-variant/30 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4 mt-2">
                <div class="flex flex-col text-center sm:text-left">
                    <h4 class="font-bold text-sm text-on-surface">Want to compete in {{ $event->name }}?</h4>
                    <p class="text-xs text-on-surface-variant mt-0.5">
                        {{ $roster['is_open'] ? 'Registration is open! Secure your spot or register your team.' : 'Registration for this event is currently closed.' }}
                    </p>
                </div>

                <div class="flex items-center gap-2 flex-wrap">
                    <a href="{{ route('events.public.show', $event) }}" class="h-10 px-4 rounded-xl bg-surface-container text-on-surface font-semibold text-xs flex items-center gap-1.5 hover:bg-surface-container-high active:scale-95 transition-all" id="btn-footer-view-event">
                        <span>Event Details</span>
                    </a>
                    @if ($roster['is_open'])
                        <a href="{{ route('events.public.show', $event) }}#registration-form-section" class="h-10 px-4 rounded-xl bg-primary text-on-primary font-bold text-xs flex items-center gap-1.5 active:scale-95 transition-all shadow-sm" id="btn-footer-register">
                            <span>Register for Event</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Global Footer Partial (Desktop Footer + Mobile Bottom Navigation) -->
    @include('partials.footer', ['active' => 'events'])

    <!-- Interactive Filtering Scripts -->
    <script>
        let currentTab = 'all';

        function setRosterTab(tab) {
            currentTab = tab;
            const tabs = ['all', 'teams', 'individual'];
            tabs.forEach(t => {
                const btn = document.getElementById('tab-' + t);
                if (btn) {
                    if (t === tab) {
                        btn.className = 'h-9 px-3.5 rounded-xl font-bold text-xs bg-primary text-on-primary shrink-0 transition-transform active:scale-95 shadow-sm';
                    } else {
                        btn.className = 'h-9 px-3.5 rounded-xl font-bold text-xs bg-surface-container text-on-surface-variant hover:text-on-surface shrink-0 transition-transform active:scale-95';
                    }
                }
            });
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
                    teamsSection.classList.add('hidden');
                } else {
                    teamsSection.classList.remove('hidden');
                    const teamCards = teamsSection.querySelectorAll('.team-roster-item');
                    teamCards.forEach(card => {
                        const teamName = card.dataset.teamName || '';
                        const teamRef = card.dataset.teamRef || '';
                        const rows = card.querySelectorAll('tbody tr.player-row');

                        let matchInTeam = false;
                        if (!query) {
                            matchInTeam = true;
                            rows.forEach(r => r.classList.remove('hidden'));
                        } else {
                            if (teamName.includes(query) || teamRef.includes(query)) {
                                matchInTeam = true;
                                rows.forEach(r => r.classList.remove('hidden'));
                            } else {
                                rows.forEach(row => {
                                    const pName = row.dataset.playerName || '';
                                    const pRef = row.dataset.playerRef || '';
                                    if (pName.includes(query) || pRef.includes(query)) {
                                        row.classList.remove('hidden');
                                        matchInTeam = true;
                                    } else {
                                        row.classList.add('hidden');
                                    }
                                });
                            }
                        }

                        if (matchInTeam) {
                            card.classList.remove('hidden');
                            visibleTeamsCount++;
                        } else {
                            card.classList.add('hidden');
                        }
                    });
                }
            }

            // 2. Filter Individuals
            if (individualSection) {
                if (currentTab === 'teams') {
                    individualSection.classList.add('hidden');
                } else {
                    individualSection.classList.remove('hidden');
                    const indRows = individualSection.querySelectorAll('tbody tr.player-row');
                    indRows.forEach(row => {
                        const pName = row.dataset.playerName || '';
                        const pRef = row.dataset.playerRef || '';
                        if (!query || pName.includes(query) || pRef.includes(query)) {
                            row.classList.remove('hidden');
                            visibleIndividualsCount++;
                        } else {
                            row.classList.add('hidden');
                        }
                    });

                    const indCard = document.getElementById('individual-players-card');
                    if (indCard) {
                        if (visibleIndividualsCount > 0) {
                            indCard.classList.remove('hidden');
                        } else {
                            indCard.classList.add('hidden');
                        }
                    }
                }
            }

            // Show empty search state if query is present and 0 matches
            if (emptySearchState) {
                const totalVisible = visibleTeamsCount + visibleIndividualsCount;
                if (query && totalVisible === 0) {
                    emptySearchState.classList.remove('hidden');
                } else {
                    emptySearchState.classList.add('hidden');
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

        function togglePlayersUserDropdown(e) {
            e.stopPropagation();
            const container = document.getElementById('user-menu-wrap-players');
            if (container) {
                container.classList.toggle('open');
            }
        }
        document.addEventListener('click', function(e) {
            const container = document.getElementById('user-menu-wrap-players');
            if (container && !container.contains(e.target)) {
                container.classList.remove('open');
            }
        });
    </script>
</body>
</html>
