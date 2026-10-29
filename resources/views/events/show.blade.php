<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" name="viewport"/>
    <meta content="mobile_tab" name="shell-type"/>
    <title>{{ $event->name }} — {{ config('app.name', 'Truant Enterprises') }}</title>
    <meta name="description" content="{{ Str::limit(strip_tags($event->description), 150) }}"/>

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


    @php
        $isOpen = $event->isRegistrationOpen();
        $statusText = $event->registration_status;
        $activeBanner = ($event->registrationForm && $event->registrationForm->banner) ? $event->registrationForm->banner : $event->banner;
        $form = $event->registrationForm;
        $roster = $event->getGroupedPlayers();
    @endphp

    <!-- Main Container -->
    <main class="flex-1 flex flex-col relative w-full pt-16 pb-28 md:pb-16 bg-background">
        <div class="max-w-6xl mx-auto w-full px-4 pt-4 flex flex-col gap-5">

            <!-- Breadcrumbs / Top Navigation Strip -->
            <div class="flex items-center gap-2 text-xs text-on-surface-variant overflow-x-auto no-scrollbar py-1">
                <a href="{{ url('/') }}" class="hover:text-primary font-semibold flex items-center gap-1 shrink-0" id="btn-back-events">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                    <span>All Events</span>
                </a>
                <span class="text-outline-variant">/</span>
                <span class="text-on-surface font-medium truncate max-w-[200px] sm:max-w-md">{{ $event->name }}</span>
            </div>

            <!-- Hero Banner Card (16:9 aspect on mobile, responsive height) -->
            <div class="relative w-full aspect-[16/9] sm:aspect-[21/9] rounded-2xl bg-surface-container overflow-hidden shadow-sm border border-outline-variant/30">
                @if ($activeBanner)
                    <img src="{{ asset('storage/' . $activeBanner) }}" alt="{{ $event->name }} Banner" class="w-full h-full object-cover"/>
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-inverse-surface to-primary text-white p-6 text-center">
                        <span class="font-extrabold text-xl sm:text-2xl">{{ $event->name }}</span>
                    </div>
                @endif

                <div class="absolute top-3 right-3">
                    @if ($isOpen)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface/90 backdrop-blur-md text-tertiary font-bold text-xs shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-tertiary animate-pulse"></span>
                            <span>Registration Open</span>
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-surface/90 backdrop-blur-md text-on-surface-variant font-bold text-xs shadow-sm">
                            <span class="material-symbols-outlined text-[14px]">lock</span>
                            <span>{{ $statusText }}</span>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Event Header Info -->
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full {{ $event->isFreeAdmission() ? 'bg-tertiary-fixed text-on-tertiary-fixed' : 'bg-surface-variant text-on-surface' }} font-semibold text-xs">
                        <span class="material-symbols-outlined text-[14px]">{{ $event->isFreeAdmission() ? 'confirmation_number' : 'payments' }}</span>
                        <span>{{ $event->admission_label }}{{ (! $event->isFreeAdmission() && $event->ticket_price) ? ' (' . $event->ticket_price . ')' : '' }}</span>
                    </span>
                    <span class="text-xs text-on-surface-variant font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-[15px] text-primary">calendar_today</span>
                        <span>{{ $event->event_date ? $event->event_date->format('l, F d, Y') : 'TBA' }}</span>
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-on-surface tracking-tight leading-tight" id="event-title-heading">
                    {{ $event->name }}
                </h1>

                <!-- Key Chips Row -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar pt-1">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-surface-container text-on-surface-variant text-xs shrink-0">
                        <span class="material-symbols-outlined text-[16px] text-primary">group</span>
                        <span>Registered Attendees: <strong class="text-on-surface">{{ $event->registrations()->count() }}</strong></span>
                        <a href="{{ route('events.public.players', $event) }}" class="text-primary font-bold underline ml-1" id="btn-chip-view-roster">(View Roster)</a>
                    </div>
                    @if ($event->registration_date)
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-surface-container text-on-surface-variant text-xs shrink-0">
                            <span class="material-symbols-outlined text-[16px] text-secondary">schedule</span>
                            <span>Deadline: <strong class="text-on-surface">{{ $event->registration_date->format('M d, Y') }}</strong></span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Layout Grid: Left Content / Forms & Right Quick Summary Sidebar -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Left 2 Columns: Description + Forms + Rosters -->
                <div class="lg:col-span-2 flex flex-col gap-6">

                    <!-- Event Description Box -->
                    <section class="bg-surface-container-lowest rounded-2xl p-5 sm:p-6 shadow-sm border border-outline-variant/30 flex flex-col gap-3">
                        <h2 class="text-lg font-bold text-on-surface tracking-tight flex items-center gap-2">
                            <span class="material-symbols-outlined text-[20px] text-primary">info</span>
                            <span>Event Overview</span>
                        </h2>
                        <div class="text-sm text-on-surface-variant leading-relaxed space-y-3 prose max-w-none">
                            {!! $event->description !!}
                        </div>
                    </section>

                    <!-- Alert: Registration Confirmed Success -->
                    @if (session('registration_success'))
                        <div class="bg-tertiary-fixed/40 border border-tertiary-fixed-dim rounded-2xl p-5 shadow-sm flex flex-col gap-3">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-[28px] text-tertiary shrink-0">check_circle</span>
                                <div class="flex flex-col gap-1">
                                    <h3 class="font-bold text-base text-on-surface">Registration Confirmed!</h3>
                                    <p class="text-xs text-on-surface-variant leading-relaxed">{{ session('message') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 bg-surface-container-lowest p-3 rounded-xl border border-outline-variant/30 justify-between flex-wrap">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider">Your Reference Code</span>
                                    <span class="font-mono text-base font-extrabold text-primary" id="success-ref-code-display">{{ session('reference_code') }}</span>
                                </div>
                                <button onclick="window.print()" type="button" class="h-9 px-3.5 rounded-xl bg-tertiary text-on-tertiary font-bold text-xs flex items-center gap-1.5 active:scale-95 transition-all">
                                    <span class="material-symbols-outlined text-[16px]">print</span>
                                    <span>Print Pass</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Alert: Team Registration Confirmed Success -->
                    @if (session('team_registration_success'))
                        <div class="bg-secondary-fixed/40 border border-secondary-fixed-dim rounded-2xl p-5 shadow-sm flex flex-col gap-3">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-[28px] text-secondary shrink-0">emoji_events</span>
                                <div class="flex flex-col gap-1">
                                    <h3 class="font-bold text-base text-on-surface">Team Successfully Registered!</h3>
                                    <p class="text-xs text-on-surface-variant leading-relaxed">{{ session('message') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 bg-surface-container-lowest p-3 rounded-xl border border-outline-variant/30 justify-between flex-wrap">
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-on-surface-variant font-bold uppercase tracking-wider">Team Reference: {{ session('team_name') }}</span>
                                    <span class="font-mono text-base font-extrabold text-secondary" id="team-ref-code-display">{{ session('team_reference') }}</span>
                                </div>
                                <button onclick="window.print()" type="button" class="h-9 px-3.5 rounded-xl bg-secondary text-on-secondary font-bold text-xs flex items-center gap-1.5 active:scale-95 transition-all">
                                    <span class="material-symbols-outlined text-[16px]">print</span>
                                    <span>Print Team Pass</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Error Alert -->
                    @if (session('error'))
                        <div class="bg-error-container/60 border border-error/20 text-on-error-container p-4 rounded-xl flex items-center gap-2 text-xs font-semibold">
                            <span class="material-symbols-outlined text-[18px] text-error shrink-0">error</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <!-- Prompt: Ref# Reuse Alert Box -->
                    @if (session('ref_reuse_prompt'))
                        <div class="bg-surface-container border-2 border-primary/40 rounded-2xl p-5 shadow-sm flex flex-col gap-3" id="reuse-ref-alert-box">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-[24px] text-primary shrink-0">published_with_changes</span>
                                <div class="flex flex-col gap-1">
                                    <h3 class="font-bold text-sm text-on-surface" id="msg-ref-reuse-title">
                                        Information already exist Ref# will be reused to register on this event. Click to confirm and register
                                    </h3>
                                    <p class="text-xs text-on-surface-variant">
                                        Existing record detected for <strong>{{ session('existing_name') }}</strong> with reference <strong>{{ session('existing_ref') }}</strong>.
                                    </p>
                                </div>
                            </div>
                            <button type="button" onclick="confirmAndSubmitReuse('{{ session('existing_ref') }}')" class="h-11 px-4 rounded-xl bg-primary text-on-primary font-bold text-xs flex items-center justify-center gap-2 shadow-sm active:scale-95 transition-all" id="btn-confirm-reuse-ref">
                                <span>Click to confirm and register</span>
                                <span class="material-symbols-outlined text-[18px]">check</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="bg-error-container/60 border border-error/20 text-on-error-container p-4 rounded-xl flex flex-col gap-1 text-xs">
                            <div class="flex items-center gap-1.5 font-bold">
                                <span class="material-symbols-outlined text-[16px] text-error">warning</span>
                                <span>Please correct the following errors:</span>
                            </div>
                            <ul class="list-disc list-inside ml-2 space-y-0.5 text-on-error-container">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($isOpen && $form)
                        <!-- Section: Quick Registration with Existing Ref# -->
                        <section class="bg-surface-container-lowest rounded-2xl p-5 sm:p-6 shadow-sm border border-outline-variant/30 flex flex-col gap-3" id="quick-register-box">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">bolt</span>
                                </div>
                                <div class="flex flex-col min-w-0 flex-1">
                                    <div class="flex items-center justify-between gap-2 flex-wrap">
                                        <h3 class="font-bold text-base text-on-surface">Already registered previously?</h3>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed">⚡ Fast Auto-Registration</span>
                                    </div>
                                    <p class="text-xs text-on-surface-variant mt-1">
                                        Enter your Registration Reference Code (Ref#) below to register for this event instantly without filling the form again.
                                    </p>
                                </div>
                            </div>

                            @if (session('quick_reg_error'))
                                <div class="bg-error-container/60 border border-error/20 text-on-error-container p-3 rounded-xl text-xs font-semibold" id="quick-reg-error-box">
                                    {{ session('quick_reg_error') }}
                                </div>
                            @endif

                            <form action="{{ route('events.public.registerByRef', $event) }}" method="POST" class="flex flex-col sm:flex-row gap-2 mt-2" id="form-quick-ref-register">
                                @csrf
                                <input 
                                    type="text" 
                                    name="ref_code" 
                                    id="quick_reg_ref_input" 
                                    class="flex-1 h-11 px-3.5 bg-surface-container-lowest rounded-xl border border-outline-variant/40 font-mono text-sm placeholder:text-outline focus:border-primary focus:outline-none transition-colors" 
                                    placeholder="Enter your Ref# (e.g. REG-20260907-XXXXX)"
                                    value="{{ old('ref_code') }}"
                                    required
                                    autocomplete="off"
                                />
                                <button type="submit" class="h-11 px-4 rounded-xl bg-primary text-on-primary font-bold text-xs flex items-center justify-center gap-1.5 active:scale-95 transition-all shadow-sm shrink-0" id="btn-quick-register-ref">
                                    <span class="material-symbols-outlined text-[16px]">bolt</span>
                                    <span>Register with Ref#</span>
                                </button>
                            </form>
                        </section>

                        <!-- Section: Official Registration Form -->
                        <section class="bg-surface-container-lowest rounded-2xl p-5 sm:p-6 shadow-sm border border-outline-variant/30 flex flex-col gap-4" id="registration-form-section">
                            <div class="flex flex-col gap-1 pb-2 border-b border-outline-variant/30">
                                <span class="font-label-sm text-label-sm text-primary uppercase tracking-wider">Attendee Pass</span>
                                <h2 class="text-xl font-bold text-on-surface tracking-tight">{{ $form->title ?: 'Reserve Your Registration Pass' }}</h2>
                                <p class="text-xs text-on-surface-variant">{{ $form->description ?: 'Please fill out the official registration form below to secure your attendance.' }}</p>
                            </div>

                            <form action="{{ route('events.public.register', $event) }}" method="POST" enctype="multipart/form-data" id="event-registration-form" class="flex flex-col gap-4">
                                @csrf
                                <input type="hidden" name="confirm_reuse_ref" id="input_confirm_reuse_ref" value="0"/>
                                <input type="hidden" name="reused_reference" id="input_reused_reference" value="{{ session('existing_ref', '') }}"/>

                                <div class="grid grid-cols-1 gap-4">
                                    @foreach ($form->fields ?? [] as $index => $field)
                                        @php
                                            $fieldName = 'field_' . $index;
                                            $label = $field['label'] ?? "Field {$index}";
                                            $isRequired = (bool) ($field['is_required'] ?? false);
                                            $type = $field['type'] ?? 'text';
                                        @endphp

                                        <div class="flex flex-col gap-1.5">
                                            <label class="font-semibold text-xs text-on-surface flex items-center gap-1" for="{{ $fieldName }}">
                                                <span>{{ $label }}</span>
                                                @if ($isRequired)
                                                    <span class="text-error font-bold">*</span>
                                                @endif
                                            </label>

                                            @if ($type === 'text')
                                                <input 
                                                    type="text" 
                                                    name="{{ $fieldName }}" 
                                                    id="{{ $fieldName }}" 
                                                    class="h-11 px-3.5 bg-surface-container-lowest rounded-xl border border-outline-variant/40 text-on-surface text-sm placeholder:text-outline focus:border-primary focus:outline-none transition-colors"
                                                    placeholder="{{ $field['placeholder'] ?? 'Enter ' . $label }}"
                                                    value="{{ old($fieldName) }}"
                                                    {{ $isRequired ? 'required' : '' }}
                                                />
                                            @elseif ($type === 'textarea')
                                                <textarea 
                                                    name="{{ $fieldName }}" 
                                                    id="{{ $fieldName }}" 
                                                    rows="3" 
                                                    class="p-3 bg-surface-container-lowest rounded-xl border border-outline-variant/40 text-on-surface text-sm placeholder:text-outline focus:border-primary focus:outline-none transition-colors resize-y"
                                                    placeholder="{{ $field['placeholder'] ?? 'Enter details' }}"
                                                    {{ $isRequired ? 'required' : '' }}
                                                >{{ old($fieldName) }}</textarea>
                                            @elseif ($type === 'select')
                                                <select 
                                                    name="{{ $fieldName }}" 
                                                    id="{{ $fieldName }}" 
                                                    class="h-11 px-3 bg-surface-container-lowest rounded-xl border border-outline-variant/40 text-on-surface text-sm focus:border-primary focus:outline-none transition-colors"
                                                    {{ $isRequired ? 'required' : '' }}
                                                >
                                                    <option value="">— Select {{ $label }} —</option>
                                                    @foreach ($field['options'] ?? [] as $opt)
                                                        <option value="{{ $opt }}" {{ old($fieldName) === $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif ($type === 'radio')
                                                <div class="flex flex-wrap gap-2 pt-1">
                                                    @foreach ($field['options'] ?? [] as $optIndex => $opt)
                                                        <label class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-surface-container-low border border-outline-variant/30 text-xs font-semibold text-on-surface cursor-pointer hover:bg-surface-container active:scale-95 transition-all">
                                                            <input 
                                                                type="radio" 
                                                                name="{{ $fieldName }}" 
                                                                value="{{ $opt }}"
                                                                class="accent-primary w-4 h-4"
                                                                {{ old($fieldName) === $opt ? 'checked' : ($optIndex === 0 && $isRequired ? 'checked' : '') }}
                                                            />
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
                                                    class="p-2 bg-surface-container-lowest rounded-xl border border-outline-variant/40 text-xs text-on-surface-variant file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-primary file:text-on-primary hover:file:opacity-90 cursor-pointer"
                                                    {{ $isRequired ? 'required' : '' }}
                                                />
                                                <span class="text-[11px] text-on-surface-variant">Upload image file (JPG, PNG, WEBP up to 5MB).</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Mandatory Consent Box -->
                                <div class="bg-surface-container-low border border-outline-variant/30 rounded-xl p-4 flex flex-col gap-2.5 mt-2">
                                    <h4 class="font-bold text-xs text-on-surface uppercase tracking-wider flex items-center gap-1.5">
                                        <span class="material-symbols-outlined text-[16px] text-primary">verified_user</span>
                                        <span>{{ $form->consent_title ?: 'Consent & Privacy Agreement' }}</span>
                                    </h4>
                                    <div class="text-xs text-on-surface-variant leading-relaxed max-h-28 overflow-y-auto pr-1">
                                        {{ $form->consent_body ?: "By submitting this registration, I agree to the processing of my personal details for event coordination, attendance reporting, and safety measures." }}
                                    </div>
                                    <label class="flex items-start gap-2.5 cursor-pointer pt-1">
                                        <input type="checkbox" name="consent_agreed" value="1" {{ old('consent_agreed') ? 'checked' : '' }} required id="consent-checkbox" class="accent-primary w-4 h-4 mt-0.5 rounded"/>
                                        <span class="text-xs font-semibold text-on-surface leading-snug">
                                            {{ $form->consent_checkbox_label ?: 'I have read, understood, and agree to the event registration guidelines and consent agreement.' }}
                                        </span>
                                    </label>
                                </div>

                                <button type="submit" class="h-12 w-full rounded-xl bg-primary text-on-primary font-bold text-sm flex items-center justify-center gap-2 active:scale-95 transition-all shadow-sm hover:opacity-95" id="btn-submit-registration">
                                    <span>Confirm &amp; Complete Registration</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </button>
                            </form>
                        </section>
                    @endif

                    @if ($isOpen)
                        <!-- Section: Team Registration -->
                        <section class="bg-surface-container-lowest rounded-2xl p-5 sm:p-6 shadow-sm border border-outline-variant/30 flex flex-col gap-4" id="team-registration-section">
                            <div class="flex items-start gap-3 pb-2 border-b border-outline-variant/30">
                                <div class="w-10 h-10 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[22px]">diversity_3</span>
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <h2 class="text-xl font-bold text-on-surface tracking-tight">Register a Team</h2>
                                    <p class="text-xs text-on-surface-variant">Assemble your squad by providing a unique team name and adding registered attendees by reference number.</p>
                                </div>
                            </div>

                            <form action="{{ route('events.public.teams.register', $event) }}" method="POST" id="team-registration-form" class="flex flex-col gap-4">
                                @csrf

                                <!-- 1. Team Name Input -->
                                <div class="flex flex-col gap-1.5">
                                    <label class="font-semibold text-xs text-on-surface flex items-center gap-1" for="team_name">
                                        <span>Team Name</span>
                                        <span class="text-error font-bold">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        name="team_name" 
                                        id="team_name" 
                                        class="h-11 px-3.5 bg-surface-container-lowest rounded-xl border border-outline-variant/40 text-on-surface text-sm placeholder:text-outline focus:border-primary focus:outline-none transition-colors"
                                        placeholder="Enter official team name (e.g. Blue Eagles, Agile Titans)"
                                        value="{{ old('team_name') }}"
                                        required
                                    />
                                    <span class="text-[11px] text-on-surface-variant">Team name must be unique for this event.</span>
                                </div>

                                <!-- 2. Member Lookup Box -->
                                <div class="bg-surface-container-low border border-outline-variant/30 rounded-xl p-4 flex flex-col gap-3">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-xs text-on-surface">Add Team Members (by Registration Reference Number)</span>
                                        <span class="text-[11px] text-on-surface-variant mt-0.5">
                                            Enter the individual registration reference code (e.g. <code>REG-YYYYMMDD-XXXXX</code>) of an attendee registered for this event.
                                        </span>
                                    </div>

                                    <div class="flex flex-col sm:flex-row gap-2">
                                        <input 
                                            type="text" 
                                            id="member_ref_input" 
                                            class="flex-1 h-11 px-3.5 bg-surface-container-lowest rounded-xl border border-outline-variant/40 font-mono text-sm placeholder:text-outline focus:border-primary focus:outline-none transition-colors"
                                            placeholder="Enter Attendee Ref# (e.g. REG-20260907-XXXXX)"
                                            autocomplete="off"
                                        />
                                        <button type="button" class="h-11 px-4 rounded-xl bg-surface-container text-on-surface font-semibold text-xs flex items-center justify-center gap-1.5 hover:bg-surface-container-high active:scale-95 transition-all shrink-0" id="btn-verify-ref" onclick="lookupMemberRef()">
                                            <span class="material-symbols-outlined text-[16px]">search</span>
                                            <span>Verify Ref#</span>
                                        </button>
                                    </div>

                                    <!-- Lookup Error Alert -->
                                    <div id="lookup-error-box" class="hidden bg-error-container/60 border border-error/20 text-on-error-container p-3 rounded-xl flex items-start gap-2 text-xs">
                                        <span class="material-symbols-outlined text-[16px] text-error shrink-0">error</span>
                                        <div class="flex flex-col">
                                            <span id="lookup-error-text" class="font-bold">Ref# is not registered to this event.</span>
                                            <span id="lookup-error-hint" class="text-[11px] text-error mt-0.5">Tip: Attendees from other events can register for this event above using their Ref# and then be added to this team.</span>
                                        </div>
                                    </div>

                                    <!-- Verified Attendee Preview Card -->
                                    <div id="verified-attendee-card" class="hidden bg-tertiary-fixed/30 border border-tertiary-fixed-dim p-3 rounded-xl flex items-center justify-between gap-3 flex-wrap">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-bold text-tertiary uppercase tracking-wider">Registered Attendee Found</span>
                                            <span class="font-bold text-sm text-on-surface" id="verified-attendee-name">—</span>
                                            <span class="font-mono text-xs text-on-surface-variant" id="verified-attendee-ref">—</span>
                                        </div>
                                        <button type="button" class="h-9 px-3.5 rounded-xl bg-tertiary text-on-tertiary font-bold text-xs flex items-center gap-1 active:scale-95 transition-all shadow-sm" id="btn-add-to-team" onclick="addCurrentMemberToTeam()">
                                            <span class="material-symbols-outlined text-[16px]">add</span>
                                            <span>Add to Team</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- 3. Team Members Roster Draft -->
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center justify-between">
                                        <h4 class="font-bold text-xs text-on-surface">
                                            Current Team Roster (<span id="roster-count">0</span> Players)
                                        </h4>
                                        <button type="button" class="text-xs text-primary font-semibold flex items-center gap-0.5 hover:underline" id="btn-add-more-players" onclick="focusRefInput()">
                                            <span class="material-symbols-outlined text-[14px]">add</span>
                                            <span>Add more</span>
                                        </button>
                                    </div>

                                    <div id="empty-roster-msg" class="p-4 text-center bg-surface-container-low rounded-xl border border-dashed border-outline-variant/40 text-xs text-on-surface-variant">
                                        No players added to the team yet. Lookup attendee reference numbers above and click "Add to Team".
                                    </div>

                                    <div class="overflow-x-auto no-scrollbar">
                                        <table class="w-full text-left text-xs border-collapse hidden" id="team-roster-table">
                                            <thead>
                                                <tr class="border-b border-outline-variant/30 text-on-surface-variant">
                                                    <th class="py-2 px-2.5">#</th>
                                                    <th class="py-2 px-2.5">Player Name</th>
                                                    <th class="py-2 px-2.5">Registration Ref#</th>
                                                    <th class="py-2 px-2.5 text-right">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="team-roster-tbody" class="divide-y divide-outline-variant/20">
                                                <!-- Dynamically populated rows -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="hidden-member-refs-container"></div>
                                </div>

                                <!-- Finality Note -->
                                <div class="bg-surface-container border border-outline-variant/30 p-3.5 rounded-xl flex items-start gap-2.5 text-xs text-on-surface-variant" id="team-finality-note">
                                    <span class="material-symbols-outlined text-[18px] text-primary shrink-0">info</span>
                                    <span>
                                        <strong>Note:</strong> Once submitted, team name and team member is final otherwise contact truant to edit.
                                    </span>
                                </div>

                                <button type="submit" class="h-12 w-full rounded-xl bg-secondary text-on-secondary font-bold text-sm flex items-center justify-center gap-2 active:scale-95 transition-all shadow-sm hover:opacity-95" id="btn-submit-team">
                                    <span>Confirm &amp; Register Team</span>
                                    <span class="material-symbols-outlined text-[18px]">group_add</span>
                                </button>
                            </form>
                        </section>
                    @endif

                    <!-- Section: Registered Players Directory (Grouped by Teams) -->
                    <section class="bg-surface-container-lowest rounded-2xl p-5 sm:p-6 shadow-sm border border-outline-variant/30 flex flex-col gap-4" id="registered-players-section">
                        <div class="flex items-center justify-between gap-3 flex-wrap pb-2 border-b border-outline-variant/30">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-xl bg-primary/10 text-primary flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-[20px]">groups</span>
                                </div>
                                <div class="flex flex-col">
                                    <h2 class="text-lg font-bold text-on-surface tracking-tight">Registered Players Directory</h2>
                                    <p class="text-xs text-on-surface-variant">Confirmed players registered for this event, grouped by official teams.</p>
                                </div>
                            </div>
                            <a href="{{ route('events.public.players', $event) }}" class="h-8 px-3 rounded-xl bg-surface-container text-on-surface font-semibold text-xs flex items-center gap-1 hover:bg-surface-container-high transition-colors" id="btn-view-full-roster">
                                <span>Full Directory</span>
                                <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                            </a>
                        </div>

                        <!-- Stats Pills -->
                        <div class="grid grid-cols-3 gap-2">
                            <div class="bg-surface-container-low p-2.5 rounded-xl border border-outline-variant/20 flex flex-col items-center text-center">
                                <span class="font-bold text-base text-primary">{{ $roster['total_players'] }}</span>
                                <span class="text-[10px] text-on-surface-variant font-medium">Total Players</span>
                            </div>
                            <div class="bg-surface-container-low p-2.5 rounded-xl border border-outline-variant/20 flex flex-col items-center text-center">
                                <span class="font-bold text-base text-secondary">{{ $roster['total_teams'] }}</span>
                                <span class="text-[10px] text-on-surface-variant font-medium">Teams Formed</span>
                            </div>
                            <div class="bg-surface-container-low p-2.5 rounded-xl border border-outline-variant/20 flex flex-col items-center text-center">
                                <span class="font-bold text-base text-tertiary">{{ $roster['individual_players_count'] }}</span>
                                <span class="text-[10px] text-on-surface-variant font-medium">Individual</span>
                            </div>
                        </div>

                        @if ($roster['total_players'] === 0)
                            <div class="p-6 text-center bg-surface-container-low rounded-xl border border-dashed border-outline-variant/40 text-xs text-on-surface-variant">
                                <span class="font-bold text-on-surface block mb-1">No players registered yet</span>
                                <span>Be the first attendee to register for this event!</span>
                            </div>
                        @else
                            <!-- Teams List -->
                            @if (count($roster['teams']) > 0)
                                <div class="flex flex-col gap-3">
                                    <h3 class="font-bold text-xs text-on-surface flex items-center gap-1.5 uppercase tracking-wider">
                                        <span class="material-symbols-outlined text-[16px] text-secondary">diversity_3</span>
                                        <span>Teams Roster ({{ count($roster['teams']) }})</span>
                                    </h3>
                                    @foreach ($roster['teams'] as $t)
                                        <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-sm">
                                            <div class="bg-surface-container-low px-3.5 py-2.5 flex items-center justify-between border-b border-outline-variant/30 gap-2 flex-wrap">
                                                <div class="flex items-center gap-2">
                                                    <span class="material-symbols-outlined text-[16px] text-secondary">shield</span>
                                                    <span class="font-bold text-xs text-on-surface">{{ $t['team_name'] }}</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-mono text-[10px] px-2 py-0.5 rounded bg-surface-container-lowest border border-outline-variant/40">{{ $t['team_reference'] }}</span>
                                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-secondary-fixed text-on-secondary-fixed">{{ $t['members_count'] }} Players</span>
                                                </div>
                                            </div>
                                            <div class="overflow-x-auto no-scrollbar">
                                                <table class="w-full text-left text-xs border-collapse">
                                                    <tbody class="divide-y divide-outline-variant/15">
                                                        @foreach ($t['members'] as $idx => $m)
                                                            <tr class="hover:bg-surface-container-low/40">
                                                                <td class="py-2 px-3 text-outline text-[11px] w-6">{{ $idx + 1 }}</td>
                                                                <td class="py-2 px-3 font-semibold text-on-surface">{{ $m['name'] }}</td>
                                                                <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">{{ $m['reference'] }}</td>
                                                                <td class="py-2 px-3 text-right">
                                                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-secondary/10 text-secondary">Team Member</span>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Individual Players List -->
                            @if (count($roster['individual_players']) > 0)
                                <div class="flex flex-col gap-3">
                                    <h3 class="font-bold text-xs text-on-surface flex items-center gap-1.5 uppercase tracking-wider">
                                        <span class="material-symbols-outlined text-[16px] text-tertiary">person</span>
                                        <span>Individual Players (No Team Yet) ({{ count($roster['individual_players']) }})</span>
                                    </h3>
                                    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-sm">
                                        <div class="overflow-x-auto no-scrollbar">
                                            <table class="w-full text-left text-xs border-collapse">
                                                <tbody class="divide-y divide-outline-variant/15">
                                                    @foreach ($roster['individual_players'] as $idx => $ind)
                                                        <tr class="hover:bg-surface-container-low/40">
                                                            <td class="py-2 px-3 text-outline text-[11px] w-6">{{ $idx + 1 }}</td>
                                                            <td class="py-2 px-3 font-semibold text-on-surface">{{ $ind['name'] }}</td>
                                                            <td class="py-2 px-3 font-mono text-[11px] text-on-surface-variant">{{ $ind['reference'] }}</td>
                                                            <td class="py-2 px-3 text-right">
                                                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-tertiary-fixed text-on-tertiary-fixed">No Team Yet</span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </section>
                </div>

                <!-- Right 1 Column: Sticky Summary & Action Card -->
                <aside class="flex flex-col gap-4 lg:sticky lg:top-20">
                    <div class="bg-surface-container-lowest rounded-2xl p-5 shadow-sm border border-outline-variant/30 flex flex-col gap-3">
                        <h3 class="text-sm font-bold text-on-surface tracking-tight flex items-center gap-1.5 pb-2 border-b border-outline-variant/30">
                            <span class="material-symbols-outlined text-[18px] text-primary">receipt_long</span>
                            <span>Registration Summary</span>
                        </h3>

                        <div class="flex flex-col divide-y divide-outline-variant/20 text-xs">
                            <div class="py-2 flex items-center justify-between">
                                <span class="text-on-surface-variant">Status</span>
                                <span class="font-bold {{ $isOpen ? 'text-tertiary' : 'text-error' }}">{{ $statusText }}</span>
                            </div>
                            <div class="py-2 flex items-center justify-between">
                                <span class="text-on-surface-variant">Event Date</span>
                                <span class="font-semibold text-on-surface">{{ $event->event_date ? $event->event_date->format('M d, Y') : 'TBA' }}</span>
                            </div>
                            <div class="py-2 flex items-center justify-between">
                                <span class="text-on-surface-variant">Registration Starts</span>
                                <span class="font-semibold text-on-surface">{{ $event->registration_start_date ? $event->registration_start_date->format('M d, Y') : 'Open' }}</span>
                            </div>
                            <div class="py-2 flex items-center justify-between">
                                <span class="text-on-surface-variant">Deadline</span>
                                <span class="font-semibold text-on-surface">{{ $event->registration_date ? $event->registration_date->format('M d, Y') : 'Until full' }}</span>
                            </div>
                            <div class="py-2 flex items-center justify-between">
                                <span class="text-on-surface-variant">Admission</span>
                                <span class="font-bold {{ $event->isFreeAdmission() ? 'text-tertiary' : 'text-primary' }}">
                                    {{ $event->admission_label }}{{ (! $event->isFreeAdmission() && $event->ticket_price) ? ' (' . $event->ticket_price . ')' : '' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 pt-2 border-t border-outline-variant/30">
                            @if ($isOpen)
                                <a href="#registration-form-section" class="h-11 px-4 rounded-xl bg-primary text-on-primary font-bold text-xs flex items-center justify-center gap-1.5 active:scale-95 transition-all shadow-sm" id="btn-register-cta">
                                    <span>Register for this Event</span>
                                    <span class="material-symbols-outlined text-[16px]">arrow_downward</span>
                                </a>

                                <a href="#team-registration-section" class="h-10 px-4 rounded-xl bg-surface-container-low text-primary border border-primary/30 font-bold text-xs flex items-center justify-center gap-1.5 hover:bg-surface-container active:scale-95 transition-all" id="btn-register-team-cta">
                                    <span class="material-symbols-outlined text-[16px]">diversity_3</span>
                                    <span>Register a team</span>
                                </a>

                                <a href="{{ route('events.public.players', $event) }}" class="h-10 px-4 rounded-xl bg-surface-container text-on-surface-variant font-bold text-xs flex items-center justify-center gap-1.5 hover:bg-surface-container-high active:scale-95 transition-all" id="btn-sidebar-view-roster">
                                    <span class="material-symbols-outlined text-[16px]">groups</span>
                                    <span>View Registered Players ({{ $event->registrations()->count() }})</span>
                                </a>
                            @else
                                <div class="text-center py-2.5 px-3 rounded-xl bg-surface-container text-on-surface-variant text-xs font-semibold">
                                    Registration is not active
                                </div>
                                <a href="{{ route('events.public.players', $event) }}" class="h-10 px-4 rounded-xl bg-surface-container-low border border-outline-variant/30 text-on-surface font-bold text-xs flex items-center justify-center gap-1.5 hover:bg-surface-container active:scale-95 transition-all" id="btn-sidebar-view-roster-closed">
                                    <span>View Registered Players ({{ $event->registrations()->count() }})</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </main>

    <!-- Global Footer Partial (Desktop Footer + Mobile Bottom Navigation) -->
    @include('partials.footer', ['active' => 'events'])

    <!-- Interactive Client Scripts for Ref# Reuse & Team Roster Management -->
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

            if (errorBox) errorBox.classList.add('hidden');
            if (verifiedCard) verifiedCard.classList.add('hidden');
            currentVerifiedMember = null;

            if (!refCode) {
                if (errorText) errorText.textContent = 'Please enter a reference number.';
                if (errorBox) errorBox.classList.remove('hidden');
                return;
            }

            // Check if already in current team draft
            if (teamMembers.some(m => m.ref.toLowerCase() === refCode.toLowerCase())) {
                if (errorText) errorText.textContent = 'This attendee has already been added to your team roster.';
                if (errorBox) errorBox.classList.remove('hidden');
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
                    btn.innerHTML = '<span class="material-symbols-outlined text-[16px]">search</span><span>Verify Ref#</span>';
                }

                if (data.success) {
                    currentVerifiedMember = data;
                    document.getElementById('verified-attendee-name').textContent = data.name;
                    document.getElementById('verified-attendee-ref').textContent = data.ref;
                    verifiedCard.classList.remove('hidden');
                } else {
                    if (errorText) errorText.textContent = data.message || 'Ref# is not registered to this event.';
                    if (errorBox) errorBox.classList.remove('hidden');
                }
            } catch (e) {
                console.error(e);
                if (errorText) errorText.textContent = 'Ref# is not registered to this event.';
                if (errorBox) errorBox.classList.remove('hidden');
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
            if (verifiedCard) verifiedCard.classList.add('hidden');
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
                if (emptyMsg) emptyMsg.classList.remove('hidden');
                if (table) table.classList.add('hidden');
            } else {
                if (emptyMsg) emptyMsg.classList.add('hidden');
                if (table) table.classList.remove('hidden');

                teamMembers.forEach((member, i) => {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-surface-container-low/40';
                    tr.innerHTML = `
                        <td class="py-2 px-2.5 font-bold text-outline">${i + 1}</td>
                        <td class="py-2 px-2.5 font-bold text-on-surface">${escapeHtml(member.name)}</td>
                        <td class="py-2 px-2.5 font-mono text-[11px] text-on-surface-variant">${escapeHtml(member.ref)}</td>
                        <td class="py-2 px-2.5 text-right">
                            <button type="button" class="text-error font-bold text-[11px] hover:underline" onclick="removeMemberFromTeam(${i})">Remove</button>
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

        function toggleShowUserDropdown(e) {
            e.stopPropagation();
            const container = document.getElementById('user-menu-wrap-show');
            if (container) {
                container.classList.toggle('open');
            }
        }
        document.addEventListener('click', function(e) {
            const container = document.getElementById('user-menu-wrap-show');
            if (container && !container.contains(e.target)) {
                container.classList.remove('open');
            }
        });
    </script>
</body>
</html>
