<!DOCTYPE html>
<html class="h-full" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" name="viewport"/>
    <title>Book a Court — Truant Enterprises</title>
    <meta name="description" content="Reserve sports courts at Truant Enterprises with live availability calendar, hourly time slots, equipment rentals, and instant corporate confirmation."/>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet"/>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "surface-container-high": "#e2e7ff",
                    "primary": "#3525cd",
                    "secondary-fixed": "#e1e0ff",
                    "surface-container-low": "#f2f3ff",
                    "tertiary-fixed": "#6ffbbe",
                    "tertiary-container": "#006e4b",
                    "surface": "#faf8ff",
                    "inverse-on-surface": "#eef0ff",
                    "surface-container-lowest": "#ffffff",
                    "on-secondary-fixed": "#07006c",
                    "on-surface-variant": "#464555",
                    "on-tertiary-fixed": "#002113",
                    "on-background": "#131b2e",
                    "on-surface": "#131b2e",
                    "surface-container-highest": "#dae2fd",
                    "on-primary-fixed": "#0f0069",
                    "on-primary-container": "#dad7ff",
                    "surface-variant": "#dae2fd",
                    "error": "#ba1a1a",
                    "on-secondary": "#ffffff",
                    "outline": "#777587",
                    "background": "#faf8ff",
                    "tertiary-fixed-dim": "#4edea3",
                    "outline-variant": "#c7c4d8",
                    "surface-bright": "#faf8ff",
                    "surface-tint": "#4d44e3",
                    "on-tertiary": "#ffffff",
                    "on-error": "#ffffff",
                    "surface-container": "#eaedff",
                    "primary-container": "#4f46e5",
                    "on-primary": "#ffffff",
                    "inverse-surface": "#283044",
                    "inverse-primary": "#c3c0ff",
                    "error-container": "#ffdad6",
                    "on-tertiary-container": "#67f4b7",
                    "on-secondary-container": "#fffbff",
                    "secondary": "#4648d4",
                    "on-primary-fixed-variant": "#3323cc",
                    "tertiary": "#005338",
                    "surface-dim": "#d2d9f4",
                    "secondary-fixed-dim": "#c0c1ff",
                    "primary-fixed-dim": "#c3c0ff",
                    "on-secondary-fixed-variant": "#2f2ebe",
                    "on-error-container": "#93000a",
                    "primary-fixed": "#e2dfff",
                    "on-tertiary-fixed-variant": "#005236",
                    "secondary-container": "#6063ee"
                },
                borderRadius: {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
                },
                spacing: {
                    "gutter-mobile": "1rem",
                    "space-xs": "0.25rem",
                    "margin": "2rem",
                    "margin-mobile": "1rem",
                    "space-lg": "1.5rem",
                    "gutter": "1.5rem",
                    "space-sm": "0.5rem",
                    "space-xl": "2rem",
                    "space-md": "1rem"
                },
                fontFamily: {
                    "headline-sm": ["Plus Jakarta Sans"],
                    "headline-md": ["Plus Jakarta Sans"],
                    "label-lg": ["Plus Jakarta Sans"],
                    "label-md": ["Plus Jakarta Sans"],
                    "headline-xl-mobile": ["Plus Jakarta Sans"],
                    "headline-lg-mobile": ["Plus Jakarta Sans"],
                    "body-md": ["Plus Jakarta Sans"],
                    "headline-xl": ["Plus Jakarta Sans"],
                    "body-lg": ["Plus Jakarta Sans"],
                    "body-sm": ["Plus Jakarta Sans"],
                    "label-sm": ["Plus Jakarta Sans"],
                    "headline-lg": ["Plus Jakarta Sans"]
                },
                fontSize: {
                    "headline-sm": ["18px", { "lineHeight": "24px", "fontWeight": "700" }],
                    "headline-md": ["20px", { "lineHeight": "28px", "fontWeight": "700" }],
                    "label-lg": ["14px", { "lineHeight": "20px", "fontWeight": "600" }],
                    "label-md": ["12px", { "lineHeight": "16px", "fontWeight": "600" }],
                    "headline-xl-mobile": ["28px", { "lineHeight": "36px", "fontWeight": "800" }],
                    "headline-lg-mobile": ["22px", { "lineHeight": "30px", "fontWeight": "700" }],
                    "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                    "headline-xl": ["40px", { "lineHeight": "48px", "fontWeight": "800" }],
                    "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                    "body-sm": ["12px", { "lineHeight": "18px", "fontWeight": "400" }],
                    "label-sm": ["11px", { "lineHeight": "14px", "fontWeight": "600" }],
                    "headline-lg": ["28px", { "lineHeight": "36px", "fontWeight": "700" }]
                }
            }
        }
    };
    </script>
    <style>
        @layer base {
            html, body { margin: 0; padding: 0; }
            body { overscroll-behavior-y: none; -webkit-tap-highlight-color: transparent; }
            .pb-safe { padding-bottom: env(safe-area-inset-bottom, 0px); }
            .pt-safe { padding-top: env(safe-area-inset-top, 0px); }
        }
        ::-webkit-scrollbar { display: none; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased flex flex-col min-h-screen">

    <!-- Global Header Partial (Desktop + Mobile) -->
    @include('partials.header', [
        'active' => 'book-a-court',
        'searchPlaceholder' => 'Quick search courts...',
        'searchInputOninput' => 'filterSlotsQuick(this.value)'
    ])

    <!-- ═══ 3. MAIN PAGE CONTENT (pt-16 pb-20 on mobile, lg:pb-12) ═══ -->
    <main class="w-full pt-16 pb-20 lg:pb-12 bg-surface min-h-[calc(100vh-16rem)]">
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-12 py-6 sm:py-8">

            <!-- Top Meta & Title Breadcrumb Section -->
            <div class="flex flex-col gap-3 mb-6 sm:mb-8">
                <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md">
                    <a href="{{ url('/') }}" class="hover:text-primary cursor-pointer transition-colors">Truant Recreation</a>
                    <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                    <span class="hover:text-primary cursor-pointer transition-colors">Facilities</span>
                    <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                    <span class="text-primary font-semibold">Book a Court</span>
                </div>
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4">
                    <div>
                        <span class="font-label-sm text-label-sm uppercase tracking-wider text-primary font-bold">Facility Reservation</span>
                        <h1 class="font-headline-xl-mobile lg:font-headline-xl text-headline-xl-mobile lg:text-headline-xl text-on-surface tracking-tight" id="courtHeroHeading">
                            Reserve {{ $selectedCourt->name }}
                        </h1>
                        <p class="font-body-md lg:font-body-lg text-body-md lg:text-body-lg text-on-surface-variant max-w-2xl mt-1">
                            Check live facility availability, secure reserved courts in real time, and coordinate executive recreation sessions.
                        </p>
                    </div>
                    <!-- Live Quick Stats Badges -->
                    <div class="flex flex-wrap items-center gap-2.5">
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-surface-container-high text-primary font-label-md text-label-md">
                            <span class="w-2 h-2 rounded-full bg-tertiary-container animate-pulse"></span>
                            {{ $courts->count() }} Facilities Active
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-surface-container-high text-on-surface-variant font-label-md text-label-md">
                            <span class="material-symbols-outlined text-[16px] text-primary">verified</span>
                            Instant Confirmation
                        </div>
                        <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-surface-container-high text-on-surface-variant font-label-md text-label-md">
                            <span class="material-symbols-outlined text-[16px] text-primary">sports_tennis</span>
                            Complimentary Gear Check-in
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Two-Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                <!-- ─── LEFT COLUMN: Main Booking Flow (Approx 65%) ─── -->
                <div class="lg:col-span-8 flex flex-col gap-6 sm:gap-8">

                    <!-- Location & Sport Type Filter Bar -->
                    <div class="bg-surface-container-lowest p-4 sm:p-5 rounded-xl shadow-sm border border-outline-variant/30 flex flex-col gap-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex items-center gap-2 text-on-surface font-headline-sm text-headline-sm">
                                <span class="material-symbols-outlined text-primary text-[22px]">location_on</span>
                                <span>Campus Facility</span>
                            </div>
                            <!-- Location Dropdown Selector -->
                            <div class="relative w-full sm:w-80">
                                <select id="courtSelector" onchange="switchCourt(this.value)" class="w-full appearance-none bg-surface-container-low px-4 py-2.5 pr-10 rounded-xl font-label-lg text-label-lg text-on-surface outline-none cursor-pointer border border-outline-variant/30 focus:ring-2 focus:ring-primary/25">
                                    @foreach($courts as $court)
                                        <option value="{{ $court->id }}" {{ $selectedCourt->id == $court->id ? 'selected' : '' }}>
                                            {{ $court->name }} (₱{{ number_format($court->hourly_rate, 2) }}/hr)
                                        </option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-2.5 text-[20px] pointer-events-none text-on-surface-variant">expand_more</span>
                            </div>
                        </div>

                        <!-- Sport Category Tabs -->
                        <div class="flex items-center gap-2 overflow-x-auto pb-1 no-scrollbar -mx-gutter-mobile px-gutter-mobile sm:mx-0 sm:px-0" id="sportFilters">
                            <button type="button" class="sport-filter-btn px-4 py-2 rounded-xl font-label-md text-label-md bg-primary text-on-primary transition-all shadow-sm shrink-0 font-semibold" data-type="all" onclick="filterByCourtType('all', this)">
                                All Courts ({{ $courts->count() }})
                            </button>
                            @php
                                $courtTypes = $courts->pluck('court_type')->unique()->filter();
                            @endphp
                            @foreach($courtTypes as $type)
                                <button type="button" class="sport-filter-btn px-4 py-2 rounded-xl font-label-md text-label-md bg-surface-container-low hover:bg-surface-container text-on-surface-variant transition-all shrink-0 font-medium border border-outline-variant/20" data-type="{{ $type }}" onclick="filterByCourtType('{{ $type }}', this)">
                                    {{ ucfirst($type) }} ({{ $courts->where('court_type', $type)->count() }})
                                </button>
                            @endforeach
                        </div>

                        <!-- Quick Amenities Filter Pills -->
                        <div class="flex flex-wrap items-center gap-2 pt-2 text-on-surface-variant font-label-sm text-label-sm border-t border-outline-variant/20">
                            <span class="text-outline">Amenities Included:</span>
                            <span class="px-2.5 py-1 rounded-lg bg-surface-container flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-tertiary-container">check</span> Climate Controlled</span>
                            <span class="px-2.5 py-1 rounded-lg bg-surface-container flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-tertiary-container">check</span> Hardwood Parquet Floors</span>
                            <span class="px-2.5 py-1 rounded-lg bg-surface-container flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-tertiary-container">check</span> Spectator Balcony</span>
                            <span class="px-2.5 py-1 rounded-lg bg-surface-container flex items-center gap-1"><span class="material-symbols-outlined text-[14px] text-tertiary-container">check</span> Gear Rental Desk</span>
                        </div>
                    </div>

                    <!-- Featured Arena Visual Showcase -->
                    <div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm border border-outline-variant/30 flex flex-col">
                        <div class="relative w-full h-56 sm:h-72 lg:h-80 overflow-hidden group">
                            <img id="courtShowcaseImage" class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-500" alt="{{ $selectedCourt->name }} Visual Arena" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD2AZVOnryXOfjZ-CRwHqwFPCBnlht1t0xtfxH4Z4YmX5Fy1Z1dU17Z7VIQhQfqpWNfUr6d23oVRdsqK2qzJIhQeiyhg7FAEXqouOlONxpUhxr5c-OfsJW7pk6naFTdCbQM3C2tMtnfr1di4lurBtEgy2pAqrFpX3TBC3AYJjuP4xt7Yea1h4vzOaXTGpjk19A1IyMqbUEKBYW1dU0q8_z1eISxvU6zI_7KbK7J4jlhx_DWxiK-GpU6"/>
                            <div class="absolute inset-0 bg-gradient-to-t from-on-surface/85 via-on-surface/25 to-transparent flex items-end p-5 sm:p-6">
                                <div class="flex flex-col text-on-primary">
                                    <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                                        <span class="px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-tertiary-fixed text-on-tertiary-fixed flex items-center gap-1 font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-tertiary-container animate-pulse"></span>
                                            Live Facility Online
                                        </span>
                                        <span id="showcaseCourtBadge" class="px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-surface-container-lowest/80 backdrop-blur text-on-surface font-semibold">
                                            {{ $selectedCourt->name }} • Arena Court
                                        </span>
                                    </div>
                                    <h3 id="showcaseCourtTitle" class="font-headline-md text-headline-md text-on-primary font-bold">
                                        Truant {{ $selectedCourt->name }} Arena
                                    </h3>
                                    <p class="font-body-sm text-body-sm text-surface-container-highest max-w-lg mt-0.5">
                                        Dual-regulation court setup with electronic scoreboards, climate control, and mezzanine seating.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive Monthly Calendar Section -->
                    <div class="bg-surface-container-lowest p-5 sm:p-6 rounded-xl shadow-sm border border-outline-variant/30 flex flex-col gap-5 sm:gap-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div class="flex flex-col">
                                <span class="font-headline-sm text-headline-sm text-on-surface">Choose Date</span>
                                <span class="font-body-sm text-body-sm text-on-surface-variant">Selected: <strong class="text-primary font-semibold" id="selected-date-display">{{ \Carbon\Carbon::parse($selectedDate)->format('l, F d, Y') }}</strong></span>
                            </div>
                            <!-- Calendar Month Switcher -->
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="navigateMonth(-1)" class="w-9 h-9 rounded-xl bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface transition-colors border border-outline-variant/20 active:scale-95" title="Previous Month">
                                    <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                                </button>
                                <span id="calendar-month-title" class="font-label-lg text-label-lg text-on-surface font-semibold tracking-wide">
                                    {{ \Carbon\Carbon::create($currentYear, $currentMonth, 1)->format('F Y') }}
                                </span>
                                <button type="button" onclick="navigateMonth(1)" class="w-9 h-9 rounded-xl bg-surface-container-low hover:bg-surface-container flex items-center justify-center text-on-surface transition-colors border border-outline-variant/20 active:scale-95" title="Next Month">
                                    <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                                </button>
                            </div>
                        </div>

                        <!-- Calendar Grid -->
                        <div class="w-full">
                            <!-- Day labels (Sun-Sat) -->
                            <div class="grid grid-cols-7 gap-1 text-center font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2">
                                <span class="py-1">Sun</span>
                                <span class="py-1">Mon</span>
                                <span class="py-1">Tue</span>
                                <span class="py-1">Wed</span>
                                <span class="py-1">Thu</span>
                                <span class="py-1">Fri</span>
                                <span class="py-1">Sat</span>
                            </div>
                            <!-- Month Days Matrix -->
                            <div class="grid grid-cols-7 gap-1 sm:gap-2" id="calendarDaysGrid">
                                <!-- Populated dynamically by renderCalendarGrid() -->
                            </div>
                            <!-- Calendar legend -->
                            <div class="flex items-center gap-4 mt-4 pt-3 text-label-sm font-label-sm text-on-surface-variant border-t border-outline-variant/20 flex-wrap">
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-tertiary-container"></span> Slots Available
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-outline"></span> Fully Booked / Closed
                                </span>
                                <span class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-primary"></span> Selected Date
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Available Time Slots Matrix -->
                    <div class="bg-surface-container-lowest p-5 sm:p-6 rounded-xl shadow-sm border border-outline-variant/30 flex flex-col gap-5 sm:gap-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface">Available Time Slots</h3>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Showing schedule for <strong class="text-on-surface font-semibold" id="slotScheduleCourtName">{{ $selectedCourt->name }}</strong></p>
                            </div>
                            <!-- Time Segment Filters -->
                            <div class="flex items-center gap-1.5 p-1 bg-surface-container-low rounded-xl border border-outline-variant/20 overflow-x-auto no-scrollbar">
                                <button type="button" class="slot-filter-btn px-3 py-1.5 rounded-lg font-label-md text-label-md bg-surface-container-lowest text-primary font-bold shadow-xs transition-colors shrink-0" data-filter="all" onclick="filterSlotSegment('all', this)">All Slots (24)</button>
                                <button type="button" class="slot-filter-btn px-3 py-1.5 rounded-lg font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors shrink-0" data-filter="morning" onclick="filterSlotSegment('morning', this)">Morning</button>
                                <button type="button" class="slot-filter-btn px-3 py-1.5 rounded-lg font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors shrink-0" data-filter="afternoon" onclick="filterSlotSegment('afternoon', this)">Afternoon</button>
                                <button type="button" class="slot-filter-btn px-3 py-1.5 rounded-lg font-label-md text-label-md text-on-surface-variant hover:text-on-surface transition-colors shrink-0" data-filter="evening" onclick="filterSlotSegment('evening', this)">Evening (Peak)</button>
                            </div>
                        </div>

                        <!-- Slot Selector Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5" id="slotContainer">
                            @foreach ($slots as $slot)
                                @php
                                    $isSelectable = $slot['is_selectable'];
                                    $isPassed = $slot['is_past'] ?? false;
                                    $isClosed = ($slot['status'] === 'closed');
                                    $isBooked = ($slot['status'] === 'fully_booked');
                                @endphp
                                <div class="slot-card p-4 rounded-xl transition-all border border-outline-variant/30 flex items-center justify-between group relative overflow-hidden {{ $isSelectable ? 'bg-surface-container-low hover:bg-surface-container cursor-pointer' : 'bg-surface-container-low/50 opacity-60 pointer-events-none' }}"
                                     data-hour="{{ $slot['hour'] }}"
                                     data-label="{{ $slot['time_label'] }}"
                                     data-rate="{{ $selectedCourt->hourly_rate }}"
                                     data-status="{{ $slot['status'] }}"
                                     data-selectable="{{ $isSelectable ? '1' : '0' }}"
                                     onclick="handleSlotClick(this, {{ $slot['hour'] }}, '{{ $slot['time_label'] }}')">
                                    <div class="flex flex-col gap-1 min-w-0 pr-2">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-label-lg text-label-lg font-bold text-on-surface">{{ $slot['time_label'] }}</span>
                                            <span class="px-2 py-0.5 rounded-md text-label-sm font-label-sm bg-surface-container-high text-primary">{{ $selectedCourt->name }}</span>
                                        </div>
                                        <span class="font-body-sm text-body-sm text-on-surface-variant truncate">
                                            @if($isPassed)
                                                Past schedule window
                                            @elseif($isClosed)
                                                {{ $slot['reason'] ?: 'Maintenance window' }}
                                            @elseif($isBooked)
                                                Reserved by other players
                                            @else
                                                Regulation Play • {{ $slot['available_slots'] }} court{{ $slot['available_slots'] == 1 ? '' : 's' }} open
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex flex-col items-end shrink-0">
                                        <span class="font-label-lg text-label-lg font-bold text-on-surface">₱{{ number_format($selectedCourt->hourly_rate, 2) }}</span>
                                        @if($isPassed)
                                            <span class="text-label-sm font-label-sm text-outline font-medium">Slot Passed</span>
                                        @elseif($isClosed)
                                            <span class="text-label-sm font-label-sm text-error font-medium">Closed</span>
                                        @elseif($isBooked)
                                            <span class="text-label-sm font-label-sm text-error font-medium">Booked</span>
                                        @elseif($slot['available_slots'] == 1)
                                            <span class="text-label-sm font-label-sm text-error font-bold flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-error"></span> 1 Left
                                            </span>
                                        @else
                                            <span class="text-label-sm font-label-sm text-tertiary-container font-semibold flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-tertiary-container"></span> Available
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Add-on Equipment Options Section -->
                    <div class="bg-surface-container-lowest p-5 sm:p-6 rounded-xl shadow-sm border border-outline-variant/30 flex flex-col gap-4">
                        <div class="flex items-center justify-between">
                            <h3 class="font-headline-sm text-headline-sm text-on-surface">Add-on Amenities &amp; Equipment</h3>
                            <span class="font-label-sm text-label-sm text-on-surface-variant">Optional rental items</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
                            <!-- Included Amenity -->
                            <label class="p-4 rounded-xl bg-surface-container-low flex flex-col justify-between gap-3 border border-outline-variant/20">
                                <div class="flex items-start justify-between">
                                    <div class="w-9 h-9 rounded-lg bg-surface-container-high flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined text-[20px]">lightbulb</span>
                                    </div>
                                    <input checked="" class="accent-primary w-4 h-4 rounded" disabled="" type="checkbox"/>
                                </div>
                                <div>
                                    <span class="font-label-md text-label-md text-on-surface block font-semibold">Arena High-Bay Lighting</span>
                                    <span class="font-body-sm text-body-sm text-tertiary-container font-medium">Included (Complimentary)</span>
                                </div>
                            </label>

                            <!-- Dynamic Rental Items from DB -->
                            @forelse($rentalItems as $item)
                                <div class="p-4 rounded-xl bg-surface-container-low hover:bg-surface-container transition-colors flex flex-col justify-between gap-3 border border-outline-variant/20 rental-item-card" id="rental-card-{{ $item->id }}">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex items-center gap-2.5 min-w-0">
                                            @if($item->picture_url)
                                                <img src="{{ $item->picture_url }}" alt="{{ $item->name }}" class="w-10 h-10 rounded-lg object-cover border border-outline-variant/30 shrink-0">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-surface-container-high flex items-center justify-center text-primary shrink-0">
                                                    <span class="material-symbols-outlined text-[20px]">sports_tennis</span>
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <span class="font-label-md text-label-md text-on-surface block font-semibold truncate">{{ $item->name }}</span>
                                                <span class="font-label-sm text-label-sm text-on-surface-variant block">{{ $item->available_stock }} available</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between pt-2 border-t border-outline-variant/10">
                                        <span class="font-body-sm text-body-sm text-primary font-bold">+₱{{ number_format($item->rental_price, 2) }}</span>
                                        <div class="flex items-center gap-1.5 bg-surface-container-lowest rounded-lg border border-outline-variant/30 px-1 py-0.5">
                                            <button type="button" class="w-6 h-6 rounded flex items-center justify-center text-on-surface hover:bg-surface-container font-bold text-sm" onclick="changeRentalQty({{ $item->id }}, -1)">-</button>
                                            <span class="w-6 text-center font-label-md text-label-md font-bold" id="rental-qty-{{ $item->id }}">0</span>
                                            <button type="button" class="w-6 h-6 rounded flex items-center justify-center text-on-surface hover:bg-surface-container font-bold text-sm" onclick="changeRentalQty({{ $item->id }}, 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 p-4 rounded-xl bg-surface-container-low text-center text-on-surface-variant font-body-sm text-body-sm">
                                    No equipment rentals currently available.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

                <!-- ─── RIGHT COLUMN: Sticky Reservation & Authentication Sidebar (Approx 35%) ─── -->
                <div class="lg:col-span-4 flex flex-col gap-6 lg:sticky lg:top-20">

                    <!-- Reservation Details Summary Card -->
                    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-md border border-outline-variant/30 flex flex-col gap-5">
                        <div class="flex items-center justify-between pb-3 bg-surface-container-low -mx-6 -mt-6 p-6 rounded-t-xl border-b border-outline-variant/20">
                            <div class="flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-tertiary-container animate-pulse"></span>
                                <h3 class="font-headline-sm text-headline-sm text-on-surface">Reservation Details</h3>
                            </div>
                            <!-- Live Expiration Timer -->
                            <div class="px-2.5 py-1 rounded-full bg-error-container text-on-error-container font-label-sm text-label-sm flex items-center gap-1 font-bold">
                                <span class="material-symbols-outlined text-[14px]">timer</span>
                                <span id="reservationTimer">Reserved 10:00</span>
                            </div>
                        </div>

                        <!-- Summary breakdown details -->
                        <div class="flex flex-col gap-3 font-body-sm text-body-sm">
                            <div class="flex justify-between items-start pb-2 border-b border-surface-container-low">
                                <span class="text-on-surface-variant">Facility</span>
                                <span class="font-semibold text-on-surface text-right">Truant Recreation Complex<br/><span class="text-on-surface-variant font-normal">Arena Building C</span></span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-surface-container-low">
                                <span class="text-on-surface-variant">Court Allocation</span>
                                <span class="font-semibold text-on-surface" id="summaryCourtAlloc">{{ $selectedCourt->name }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-surface-container-low">
                                <span class="text-on-surface-variant">Date</span>
                                <span class="font-semibold text-on-surface" id="summaryDateVal">{{ \Carbon\Carbon::parse($selectedDate)->format('l, M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-surface-container-low">
                                <span class="text-on-surface-variant">Time &amp; Duration</span>
                                <span class="font-semibold text-primary" id="summaryTimeSlot">Select a time slot below</span>
                            </div>

                            <!-- Price Breakdown Calculation -->
                            <div class="flex flex-col gap-1.5 pt-1">
                                <div class="flex justify-between text-on-surface-variant">
                                    <span>Court Slot Hourly Fee</span>
                                    <span id="summaryCourtRate">₱{{ number_format($selectedCourt->hourly_rate, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-on-surface-variant">
                                    <span>Equipment Rentals</span>
                                    <span id="summaryRentalsRate">₱0.00</span>
                                </div>
                                <div class="flex justify-between text-on-surface-variant">
                                    <span>Arena Facility Fee</span>
                                    <span class="text-tertiary-container font-semibold">WAIVED</span>
                                </div>
                                <div class="flex justify-between text-tertiary font-semibold hidden" id="summaryVoucherRow">
                                    <span id="summaryVoucherLabel">Voucher Discount</span>
                                    <span id="summaryVoucherDiscount">-₱0.00</span>
                                </div>
                            </div>

                            <!-- Voucher Secret Field -->
                            <div class="pt-2">
                                <label for="voucher-code-input" class="font-label-md text-label-md font-bold text-on-surface block mb-1">
                                    Have a Voucher Code?
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="text" id="voucher-code-input" placeholder="Secret Voucher Code" class="flex-1 uppercase font-body-sm text-body-sm px-3 py-2 bg-surface-container-low rounded-lg border border-outline-variant/30 text-on-surface outline-none focus:ring-1 focus:ring-primary"/>
                                    <button type="button" onclick="applySecretVoucher()" class="px-3 py-2 bg-surface-container-high text-primary hover:bg-primary hover:text-on-primary rounded-lg font-label-sm text-label-sm font-bold transition-colors">Apply</button>
                                </div>
                                <p id="voucherMsg" class="font-label-sm text-label-sm mt-1 hidden"></p>
                            </div>

                            <div class="flex justify-between items-center pt-3 border-t border-surface-container-high">
                                <span class="font-headline-sm text-headline-sm text-on-surface">Total Due</span>
                                <div class="text-right">
                                    <span class="font-headline-sm text-headline-sm text-primary font-bold" id="summaryTotalPrice">₱{{ number_format($selectedCourt->hourly_rate, 2) }}</span>
                                    <span class="block text-label-sm font-label-sm text-on-surface-variant">PHP (Tax included)</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 p-2.5 rounded-lg bg-surface-container-low text-on-surface-variant text-label-sm font-label-sm mt-1">
                                <span class="material-symbols-outlined text-[16px] text-tertiary-container">policy</span>
                                <span>Free cancellation up to 4 hours before session.</span>
                            </div>
                        </div>
                    </div>

                    <!-- Authentication & Fast Checkout Box -->
                    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-md border border-outline-variant/30 flex flex-col gap-4" id="player-info-section">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="font-label-sm text-label-sm text-on-surface-variant font-semibold">Player information</div>
                                <h4 class="font-headline-sm text-headline-sm text-on-surface font-bold">Contact details</h4>
                            </div>
                            @auth
                                <span class="px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">check</span> Verified
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-surface-container-high text-primary font-bold">
                                    Required
                                </span>
                            @endauth
                        </div>

                        @auth
                            <!-- Authenticated Profile View -->
                            <div class="p-4 rounded-xl bg-surface-container-low border border-outline-variant/20 flex items-center gap-3">
                                <img src="{{ auth()->user()->avatar_url }}" class="w-12 h-12 rounded-full object-cover border-2 border-primary/20" alt="{{ auth()->user()->name }}"/>
                                <div class="flex flex-col min-w-0 flex-1">
                                    <span class="font-label-lg text-label-lg text-on-surface font-bold truncate">{{ auth()->user()->name }}</span>
                                    <span class="font-body-sm text-body-sm text-on-surface-variant truncate">{{ auth()->user()->email }}</span>
                                    <span class="text-label-sm font-label-sm text-tertiary-container font-semibold mt-0.5 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">verified</span> Verified Member
                                    </span>
                                </div>
                            </div>

                            <form id="courtBookingForm" onsubmit="handleReservationSubmit(event)" class="flex flex-col gap-3">
                                <div class="flex items-center gap-2 pt-1">
                                    <input checked="" required="" class="accent-primary w-4 h-4 rounded cursor-pointer" id="authWaiverCheck" type="checkbox"/>
                                    <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer" for="authWaiverCheck">
                                        I agree to the Truant Safety Guidelines and Court Etiquette.
                                    </label>
                                </div>

                                <button id="btnConfirmReservation" class="w-full mt-2 py-3.5 px-4 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold hover:bg-primary-container transition-all flex items-center justify-center gap-2 shadow-md active:scale-95" type="submit">
                                    <span id="btnConfirmText">Confirm &amp; Book Court</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </button>
                            </form>
                        @else
                            <!-- Guest Notice Box -->
                            <div class="p-3.5 rounded-xl bg-surface-container-low border border-dashed border-outline-variant/60 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-surface-container-high flex items-center justify-center text-primary shrink-0">
                                    <span class="material-symbols-outlined text-[20px]">badge</span>
                                </div>
                                <div class="min-w-0">
                                    <div class="font-label-md text-label-md font-bold text-on-surface">Sign in to book</div>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant">Your profile fills in contact details automatically</div>
                                </div>
                            </div>

                            <!-- Segmented Tabs: I have an account / I'm new here -->
                            <div class="grid grid-cols-2 gap-1 p-1 bg-surface-container-low rounded-xl border border-outline-variant/20">
                                <button type="button" id="tabBtnAccount" onclick="switchGuestAuthTab('account')" class="py-1.5 px-2 rounded-lg font-label-sm text-label-sm font-bold bg-surface-container-lowest text-on-surface shadow-xs transition-all">
                                    I have an account
                                </button>
                                <button type="button" id="tabBtnNew" onclick="switchGuestAuthTab('new')" class="py-1.5 px-2 rounded-lg font-label-sm text-label-sm text-on-surface-variant hover:text-on-surface transition-all">
                                    I'm new here
                                </button>
                            </div>

                            <!-- Social SSO: Log in with Gmail -->
                            <a href="{{ route('auth.google') }}?redirect={{ urlencode(request()->fullUrl()) }}" class="w-full flex items-center justify-center gap-2.5 py-3 px-4 rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface font-label-md text-label-md font-bold transition-all shadow-xs border border-outline-variant/20">
                                <svg class="w-4 h-4" viewBox="0 0 24 24">
                                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"></path>
                                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"></path>
                                </svg>
                                <span>Log in with Gmail</span>
                            </a>

                            <!-- Divider: OR USE EMAIL -->
                            <div class="relative flex items-center justify-center my-1">
                                <div class="w-full h-px bg-surface-container-high"></div>
                                <span class="absolute bg-surface-container-lowest px-2.5 text-[11px] font-bold text-outline uppercase tracking-wider">OR USE EMAIL</span>
                            </div>

                            <form id="courtBookingForm" onsubmit="handleReservationSubmit(event)" class="flex flex-col gap-3">
                                <div id="newUserNameGroup" class="hidden flex flex-col gap-1">
                                    <label class="font-label-md text-label-md text-on-surface">Full Name</label>
                                    <input id="guestNameInput" class="bg-surface-container-low px-3.5 py-2.5 rounded-xl font-body-md text-body-md text-on-surface outline-none focus:ring-2 focus:ring-primary border border-outline-variant/30" placeholder="e.g. Marcus Vance" type="text" value="Guest Player"/>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="font-label-md text-label-md text-on-surface">Corporate Email</label>
                                    <input id="guestEmailInput" required="" class="bg-surface-container-low px-3.5 py-2.5 rounded-xl font-body-md text-body-md text-on-surface outline-none focus:ring-2 focus:ring-primary border border-outline-variant/30" placeholder="name@company.com" type="email"/>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="font-label-md text-label-md text-on-surface">Password</label>
                                    <input id="guestPasswordInput" class="bg-surface-container-low px-3.5 py-2.5 rounded-xl font-body-md text-body-md text-on-surface outline-none focus:ring-2 focus:ring-primary border border-outline-variant/30" placeholder="••••••••" type="password"/>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <label class="font-label-md text-label-md text-on-surface">Contact Number</label>
                                    <input id="guestPhoneInput" class="bg-surface-container-low px-3.5 py-2.5 rounded-xl font-body-md text-body-md text-on-surface outline-none focus:ring-2 focus:ring-primary border border-outline-variant/30" placeholder="0917-123-4567" type="tel"/>
                                </div>
                                <div class="flex items-center gap-2 pt-1">
                                    <input checked="" required="" class="accent-primary w-4 h-4 rounded cursor-pointer" id="guestWaiverCheck" type="checkbox"/>
                                    <label class="font-body-sm text-body-sm text-on-surface-variant cursor-pointer" for="guestWaiverCheck">
                                        I agree to the Truant Safety Guidelines and Court Etiquette.
                                    </label>
                                </div>

                                <button id="btnConfirmReservation" class="w-full mt-2 py-3.5 px-4 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold hover:bg-primary-container transition-all flex items-center justify-center gap-2 shadow-md active:scale-95" type="submit">
                                    <span id="btnConfirmText">Sign in with email</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </button>
                            </form>

                            <div class="text-center pt-1" id="switchAuthNotice">
                                <span class="font-body-sm text-body-sm text-on-surface-variant">New to Truant Enterprises?</span>
                                <button type="button" onclick="switchGuestAuthTab('new')" class="font-label-sm text-label-sm text-primary font-bold hover:underline ml-1">Create Account</button>
                            </div>
                        @endauth
                    </div>

                    <!-- Venue Support & Contact Card -->
                    <div class="p-4 rounded-xl bg-surface-container-low flex items-center gap-3 border border-outline-variant/20">
                        <div class="w-10 h-10 rounded-xl bg-surface-container-high flex items-center justify-center text-primary shrink-0">
                            <span class="material-symbols-outlined text-[20px]">headset_mic</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-label-md text-label-md text-on-surface font-semibold">Arena Operations Desk</span>
                            <span class="font-body-sm text-body-sm text-on-surface-variant">Building C Concierge: ext. 4410</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </main>

    <!-- ═══ 4. PASSCODE VERIFICATION MODAL ═══ -->
    <div id="passcodeModal" class="fixed inset-0 z-50 bg-on-surface/50 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-surface-container-lowest max-w-md w-full rounded-2xl shadow-xl p-6 sm:p-8 flex flex-col items-center text-center gap-4 border border-outline-variant/30">
            <div class="w-12 h-12 rounded-full bg-primary-container text-on-primary flex items-center justify-center shadow-sm">
                <span class="material-symbols-outlined text-[24px]">lock</span>
            </div>
            <div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface">Enter Verification Passcode</h3>
                <p class="font-body-sm text-body-sm text-on-surface-variant mt-1" id="passcodeModalSubtitle">
                    A 6-digit verification code has been sent to your email.
                </p>
            </div>
            <div class="flex items-center gap-2 my-2" id="modalPinInputs">
                <input type="text" maxlength="1" class="pin-box w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-idx="0" inputmode="numeric"/>
                <input type="text" maxlength="1" class="pin-box w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-idx="1" inputmode="numeric"/>
                <input type="text" maxlength="1" class="pin-box w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-idx="2" inputmode="numeric"/>
                <input type="text" maxlength="1" class="pin-box w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-idx="3" inputmode="numeric"/>
                <input type="text" maxlength="1" class="pin-box w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-idx="4" inputmode="numeric"/>
                <input type="text" maxlength="1" class="pin-box w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-idx="5" inputmode="numeric"/>
            </div>
            <p id="passcodeError" class="font-label-sm text-label-sm text-error hidden"></p>
            <button type="button" onclick="submitPasscodeVerification()" id="btnVerifyPasscode" class="w-full py-3 px-4 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold hover:bg-primary-container transition-all">
                Verify Passcode &amp; Proceed &rarr;
            </button>
            <div class="flex items-center justify-between w-full text-label-sm font-label-sm pt-2">
                <button type="button" onclick="resendPasscode()" class="text-primary hover:underline font-semibold" id="btnResendPasscode">Resend code</button>
                <button type="button" onclick="closePasscodeModal()" class="text-on-surface-variant hover:text-on-surface">Cancel</button>
            </div>
        </div>
    </div>

    <!-- Global Footer Partial (Desktop Footer + Mobile Bottom Navigation) -->
    @include('partials.footer', ['active' => 'book-a-court'])

    <!-- ═══ 7. CLIENT-SIDE INTERACTIVITY SCRIPTS ═══ -->
    <script>
        // State variables
        let currentCourtId = {{ $selectedCourt->id }};
        let currentCourtName = "{{ addslashes($selectedCourt->name) }}";
        let currentCourtRate = {{ $selectedCourt->hourly_rate }};
        let currentDate = "{{ $selectedDate }}";
        let currentYear = {{ $currentYear }};
        let currentMonth = {{ $currentMonth }};
        let selectedHour = null;
        let selectedTimeLabel = null;
        let activeVoucher = null;
        let rentalQuantities = {};
        let pendingReservation = null;

        const rentalItemsData = @json($rentalItems);
        let monthAvailabilityData = @json($monthAvailability);

        // Calendar month generator
        function renderCalendarGrid() {
            const container = document.getElementById('calendarDaysGrid');
            if (!container) return;
            container.innerHTML = '';

            const firstDay = new Date(currentYear, currentMonth - 1, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth, 0).getDate();
            const prevMonthDays = new Date(currentYear, currentMonth - 1, 0).getDate();

            // Previous month trailing days
            for (let i = firstDay - 1; i >= 0; i--) {
                const dayNum = prevMonthDays - i;
                const div = document.createElement('div');
                div.className = "p-2 sm:p-2.5 rounded-lg text-center opacity-30 pointer-events-none text-body-sm";
                div.textContent = dayNum;
                container.appendChild(div);
            }

            // Days of the active month
            const todayStr = "{{ \Carbon\Carbon::now('Asia/Manila')->toDateString() }}";
            for (let d = 1; d <= daysInMonth; d++) {
                const monthPad = String(currentMonth).padStart(2, '0');
                const dayPad = String(d).padStart(2, '0');
                const dateKey = `${currentYear}-${monthPad}-${dayPad}`;
                const isSelected = (dateKey === currentDate);
                const isPast = (dateKey < todayStr);

                const dayAvail = monthAvailabilityData ? monthAvailabilityData[dateKey] : null;
                const hasSlots = dayAvail ? dayAvail.has_available_slots : true;

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.onclick = () => selectDate(dateKey);

                if (isSelected) {
                    btn.className = "p-2 sm:p-2.5 rounded-xl text-center font-label-md text-label-md bg-primary text-on-primary shadow-md relative flex flex-col items-center transform scale-105 transition-transform";
                    btn.innerHTML = `<span class="font-bold">${d}</span><span class="w-1.5 h-1.5 rounded-full bg-tertiary-fixed mt-0.5"></span>`;
                } else if (isPast) {
                    btn.className = "p-2 sm:p-2.5 rounded-lg text-center font-label-md text-label-md bg-surface-container-low/40 opacity-40 text-outline relative flex flex-col items-center pointer-events-none";
                    btn.innerHTML = `<span>${d}</span><span class="w-1.5 h-1.5 rounded-full bg-outline mt-0.5"></span>`;
                } else {
                    btn.className = "p-2 sm:p-2.5 rounded-lg text-center font-label-md text-label-md bg-surface-container-low hover:bg-surface-container text-on-surface transition-colors relative flex flex-col items-center border border-outline-variant/10 active:scale-95";
                    const dotClass = hasSlots ? "bg-tertiary-container" : "bg-outline";
                    btn.innerHTML = `<span>${d}</span><span class="w-1.5 h-1.5 rounded-full ${dotClass} mt-0.5"></span>`;
                }
                container.appendChild(btn);
            }
        }

        // Navigate Month
        async function navigateMonth(delta) {
            currentMonth += delta;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            } else if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }

            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            document.getElementById('calendar-month-title').textContent = `${monthNames[currentMonth - 1]} ${currentYear}`;

            try {
                const res = await fetch(`{{ route('court-booking.monthAvailability') }}?court_id=${currentCourtId}&year=${currentYear}&month=${currentMonth}`);
                if (res.ok) {
                    const data = await res.json();
                    monthAvailabilityData = data.availability || {};
                }
            } catch (err) {
                console.error("Month availability fetch error:", err);
            }

            renderCalendarGrid();
        }

        // Select Date
        async function selectDate(dateStr) {
            currentDate = dateStr;
            const d = new Date(dateStr + "T00:00:00");
            const opts = { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' };
            const formatted = d.toLocaleDateString('en-US', opts);
            document.getElementById('selected-date-display').textContent = formatted;
            document.getElementById('summaryDateVal').textContent = d.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });

            renderCalendarGrid();
            await loadSlotsForDate(dateStr);
        }

        // Load Slots for Date
        async function loadSlotsForDate(dateStr) {
            const container = document.getElementById('slotContainer');
            if (!container) return;
            container.innerHTML = `<div class="col-span-2 py-8 text-center text-on-surface-variant font-label-md">Loading court slots...</div>`;

            try {
                const res = await fetch(`{{ route('court-booking.slots') }}?court_id=${currentCourtId}&date=${dateStr}`);
                if (res.ok) {
                    const data = await res.json();
                    renderSlotCards(data.slots || []);
                }
            } catch (err) {
                container.innerHTML = `<div class="col-span-2 py-8 text-center text-error font-label-md">Unable to load slots. Please retry.</div>`;
            }
        }

        function renderSlotCards(slots) {
            const container = document.getElementById('slotContainer');
            if (!container) return;
            container.innerHTML = '';

            slots.forEach(slot => {
                const isSelectable = slot.is_selectable;
                const isPassed = slot.is_past;
                const isClosed = (slot.status === 'closed');
                const isBooked = (slot.status === 'fully_booked');

                const div = document.createElement('div');
                div.className = `slot-card p-4 rounded-xl transition-all border border-outline-variant/30 flex items-center justify-between group relative overflow-hidden ${isSelectable ? 'bg-surface-container-low hover:bg-surface-container cursor-pointer' : 'bg-surface-container-low/50 opacity-60 pointer-events-none'}`;
                div.setAttribute('data-hour', slot.hour);
                div.setAttribute('data-label', slot.time_label);
                div.setAttribute('data-rate', currentCourtRate);
                div.setAttribute('data-status', slot.status);
                div.setAttribute('data-selectable', isSelectable ? '1' : '0');
                if (isSelectable) {
                    div.onclick = () => handleSlotClick(div, slot.hour, slot.time_label);
                }

                let subText = "Regulation Play • " + slot.available_slots + " court" + (slot.available_slots === 1 ? '' : 's') + " open";
                if (isPassed) subText = "Past schedule window";
                else if (isClosed) subText = slot.reason || "Maintenance window";
                else if (isBooked) subText = "Reserved by other players";

                let statusBadge = `<span class="text-label-sm font-label-sm text-tertiary-container font-semibold flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-tertiary-container"></span> Available</span>`;
                if (isPassed) {
                    statusBadge = `<span class="text-label-sm font-label-sm text-outline font-medium">Slot Passed</span>`;
                } else if (isClosed) {
                    statusBadge = `<span class="text-label-sm font-label-sm text-error font-medium">Closed</span>`;
                } else if (isBooked) {
                    statusBadge = `<span class="text-label-sm font-label-sm text-error font-medium">Booked</span>`;
                } else if (slot.available_slots === 1) {
                    statusBadge = `<span class="text-label-sm font-label-sm text-error font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 rounded-full bg-error"></span> 1 Left</span>`;
                }

                div.innerHTML = `
                    <div class="flex flex-col gap-1 min-w-0 pr-2">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-label-lg text-label-lg font-bold text-on-surface">${slot.time_label}</span>
                            <span class="px-2 py-0.5 rounded-md text-label-sm font-label-sm bg-surface-container-high text-primary">${currentCourtName}</span>
                        </div>
                        <span class="font-body-sm text-body-sm text-on-surface-variant truncate">${subText}</span>
                    </div>
                    <div class="flex flex-col items-end shrink-0">
                        <span class="font-label-lg text-label-lg font-bold text-on-surface">₱${currentCourtRate.toFixed(2)}</span>
                        ${statusBadge}
                    </div>
                `;
                container.appendChild(div);
            });
        }

        // Switch Court
        function switchCourt(courtId) {
            window.location.href = `{{ route('court-booking.index') }}?court_id=${courtId}&date=${currentDate}`;
        }

        // Filter by Court Type
        function filterByCourtType(type, btn) {
            document.querySelectorAll('.sport-filter-btn').forEach(b => {
                b.classList.remove('bg-primary', 'text-on-primary', 'font-semibold');
                b.classList.add('bg-surface-container-low', 'text-on-surface-variant', 'font-medium');
            });
            btn.classList.remove('bg-surface-container-low', 'text-on-surface-variant', 'font-medium');
            btn.classList.add('bg-primary', 'text-on-primary', 'font-semibold');

            const select = document.getElementById('courtSelector');
            if (!select) return;
            const options = Array.from(select.options);
            const match = options.find(opt => type === 'all' || opt.text.toLowerCase().includes(type.toLowerCase()));
            if (match && match.value != currentCourtId) {
                switchCourt(match.value);
            }
        }

        // Filter Slot Segment (Morning, Afternoon, Evening)
        function filterSlotSegment(segment, btn) {
            document.querySelectorAll('.slot-filter-btn').forEach(b => {
                b.classList.remove('bg-surface-container-lowest', 'text-primary', 'font-bold', 'shadow-xs');
                b.classList.add('text-on-surface-variant');
            });
            btn.classList.add('bg-surface-container-lowest', 'text-primary', 'font-bold', 'shadow-xs');
            btn.classList.remove('text-on-surface-variant');

            document.querySelectorAll('.slot-card').forEach(card => {
                const hour = parseInt(card.getAttribute('data-hour'));
                let show = true;
                if (segment === 'morning') show = (hour >= 6 && hour < 12);
                else if (segment === 'afternoon') show = (hour >= 12 && hour < 18);
                else if (segment === 'evening') show = (hour >= 18 || hour < 6);
                card.style.display = show ? 'flex' : 'none';
            });
        }

        // Quick Search Filter Slots
        function filterSlotsQuick(query) {
            const q = query.trim().toLowerCase();
            document.querySelectorAll('.slot-card').forEach(card => {
                const label = (card.getAttribute('data-label') || '').toLowerCase();
                card.style.display = (!q || label.includes(q)) ? 'flex' : 'none';
            });
        }

        // Handle Slot Selection
        function handleSlotClick(el, hour, timeLabel) {
            document.querySelectorAll('.slot-card').forEach(card => {
                if (card.getAttribute('data-selectable') === '1') {
                    card.classList.remove('bg-primary-fixed/30', 'ring-2', 'ring-primary');
                    card.classList.add('bg-surface-container-low');
                }
            });

            el.classList.remove('bg-surface-container-low');
            el.classList.add('bg-primary-fixed/30', 'ring-2', 'ring-primary');

            selectedHour = hour;
            selectedTimeLabel = timeLabel;

            document.getElementById('summaryTimeSlot').textContent = `${timeLabel} (1h)`;
            updateTotalCalculation();
        }

        // Rental items stepper
        function changeRentalQty(itemId, delta) {
            const current = rentalQuantities[itemId] || 0;
            const item = rentalItemsData.find(i => i.id == itemId);
            const max = item ? item.available_stock : 99;
            const next = Math.max(0, Math.min(max, current + delta));
            rentalQuantities[itemId] = next;

            const el = document.getElementById(`rental-qty-${itemId}`);
            if (el) el.textContent = next;

            const card = document.getElementById(`rental-card-${itemId}`);
            if (card) {
                if (next > 0) {
                    card.classList.add('ring-1', 'ring-primary', 'bg-primary-fixed/15');
                } else {
                    card.classList.remove('ring-1', 'ring-primary', 'bg-primary-fixed/15');
                }
            }

            updateTotalCalculation();
        }

        // Secret Voucher
        async function applySecretVoucher() {
            const input = document.getElementById('voucherCodeInput');
            const code = (input.value || '').trim().toUpperCase();
            const msg = document.getElementById('voucherMsg');

            if (!code) {
                msg.textContent = 'Please enter a voucher code.';
                msg.className = 'font-label-sm text-label-sm mt-1 text-error';
                msg.classList.remove('hidden');
                return;
            }

            try {
                const rentalsPayload = [];
                Object.keys(rentalQuantities).forEach(k => {
                    if (rentalQuantities[k] > 0) rentalsPayload.push({ item_id: k, quantity: rentalQuantities[k] });
                });

                const res = await fetch(`{{ route('court-booking.applyVoucher') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        voucher_code: code,
                        court_id: currentCourtId,
                        slots_count: 1,
                        rentals: rentalsPayload,
                    }),
                });
                const data = await res.json();
                if (res.ok && data.success && data.voucher) {
                    activeVoucher = data.voucher;
                    msg.textContent = data.voucher.message || `Voucher ${code} applied!`;
                    msg.className = 'font-label-sm text-label-sm mt-1 text-tertiary-container font-semibold';
                    msg.classList.remove('hidden');
                    updateTotalCalculation();
                } else {
                    activeVoucher = null;
                    msg.textContent = data.message || 'Invalid or expired voucher.';
                    msg.className = 'font-label-sm text-label-sm mt-1 text-error';
                    msg.classList.remove('hidden');
                    updateTotalCalculation();
                }
            } catch (err) {
                msg.textContent = 'Error verifying voucher.';
                msg.className = 'font-label-sm text-label-sm mt-1 text-error';
                msg.classList.remove('hidden');
            }
        }

        // Total Calculation
        function updateTotalCalculation() {
            const courtFee = currentCourtRate;
            let rentalsFee = 0;
            Object.keys(rentalQuantities).forEach(k => {
                const qty = rentalQuantities[k];
                const item = rentalItemsData.find(i => i.id == k);
                if (item && qty > 0) rentalsFee += qty * parseFloat(item.rental_price);
            });

            const subtotal = courtFee + rentalsFee;
            let discount = 0;
            if (activeVoucher && activeVoucher.discount_amount) {
                discount = Math.min(subtotal, parseFloat(activeVoucher.discount_amount));
                document.getElementById('summaryVoucherRow').classList.remove('hidden');
                document.getElementById('summaryVoucherLabel').textContent = `Voucher (${activeVoucher.code})`;
                document.getElementById('summaryVoucherDiscount').textContent = `-₱${discount.toFixed(2)}`;
            } else {
                document.getElementById('summaryVoucherRow').classList.add('hidden');
            }

            const grandTotal = Math.max(0, subtotal - discount);
            document.getElementById('summaryRentalsRate').textContent = `₱${rentalsFee.toFixed(2)}`;
            document.getElementById('summaryTotalPrice').textContent = `₱${grandTotal.toFixed(2)}`;
            const btnText = document.getElementById('btnConfirmText');
            if (btnText) btnText.textContent = `Confirm & Book Court (₱${grandTotal.toFixed(2)})`;
        }

        // Reservation Form Submission
        async function handleReservationSubmit(event) {
            event.preventDefault();
            if (selectedHour === null) {
                alert('Please select an available time slot before continuing.');
                return;
            }

            const btn = document.getElementById('btnConfirmReservation');
            btn.disabled = true;

            const isAuth = {{ auth()->check() ? 'true' : 'false' }};
            const name = isAuth ? "{{ auth()->user()?->name }}" : document.getElementById('guestNameInput')?.value;
            const email = isAuth ? "{{ auth()->user()?->email }}" : document.getElementById('guestEmailInput')?.value;
            const phone = isAuth ? "{{ auth()->user()?->phone_number ?? '0917-000-0000' }}" : (document.getElementById('guestPhoneInput')?.value || '0917-000-0000');

            const payload = {
                court_id: currentCourtId,
                booking_date: currentDate,
                start_hour: selectedHour,
                slots_count: 1,
                customer_name: name,
                customer_email: email,
                customer_contact: phone,
                voucher_code: activeVoucher ? activeVoucher.code : null,
                terms_agreed: true,
                rentals: [],
            };

            Object.keys(rentalQuantities).forEach(k => {
                if (rentalQuantities[k] > 0) payload.rentals.push({ item_id: k, quantity: rentalQuantities[k] });
            });

            try {
                const res = await fetch(`{{ route('court-booking.reserve') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    if (data.is_verified) {
                        window.location.href = data.verification_url;
                    } else {
                        pendingReservation = data;
                        openPasscodeModal(data.masked_email || email);
                    }
                } else {
                    alert(data.message || 'Unable to reserve court. Please check selected time slot.');
                    btn.disabled = false;
                }
            } catch (err) {
                alert('A network error occurred. Please try again.');
                btn.disabled = false;
            }
        }

        // Passcode Modal Controls
        function openPasscodeModal(maskedEmail) {
            document.getElementById('passcodeModalSubtitle').textContent = `A 6-digit verification code was sent to ${maskedEmail}.`;
            const modal = document.getElementById('passcodeModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            const first = modal.querySelector('.pin-box');
            if (first) first.focus();
        }

        function closePasscodeModal() {
            const modal = document.getElementById('passcodeModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            const btn = document.getElementById('btnConfirmReservation');
            if (btn) btn.disabled = false;
        }

        async function submitPasscodeVerification() {
            const pins = document.querySelectorAll('#modalPinInputs .pin-box');
            let code = '';
            pins.forEach(p => code += p.value.trim());

            const err = document.getElementById('passcodeError');
            if (code.length < 6) {
                err.textContent = 'Please enter all 6 digits.';
                err.classList.remove('hidden');
                return;
            }
            err.classList.add('hidden');

            const btn = document.getElementById('btnVerifyPasscode');
            btn.disabled = true;

            try {
                const res = await fetch(`{{ route('court-booking.verifyPasscode') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        token: pendingReservation.token,
                        reference_code: pendingReservation.reference_code,
                        passcode: code,
                    }),
                });
                const data = await res.json();
                if (res.ok && data.success) {
                    window.location.href = data.redirect_url;
                } else {
                    err.textContent = data.message || 'Invalid passcode.';
                    err.classList.remove('hidden');
                    btn.disabled = false;
                }
            } catch (e) {
                err.textContent = 'Network error. Please try again.';
                err.classList.remove('hidden');
                btn.disabled = false;
            }
        }

        async function resendPasscode() {
            if (!pendingReservation) return;
            const btn = document.getElementById('btnResendPasscode');
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
                        token: pendingReservation.token,
                        reference_code: pendingReservation.reference_code,
                    }),
                });
                const data = await res.json();
                alert(data.message || 'New passcode sent!');
            } catch (err) {
                alert('Failed to resend passcode.');
            } finally {
                btn.disabled = false;
                btn.textContent = 'Resend code';
            }
        }

        function switchGuestAuthTab(tab) {
            const tabAccount = document.getElementById('tabBtnAccount');
            const tabNew = document.getElementById('tabBtnNew');
            const nameGroup = document.getElementById('newUserNameGroup');
            const btnText = document.getElementById('btnConfirmText');
            const notice = document.getElementById('switchAuthNotice');

            if (tab === 'account') {
                tabAccount?.classList.add('bg-surface-container-lowest', 'text-on-surface', 'shadow-xs', 'font-bold');
                tabAccount?.classList.remove('text-on-surface-variant');
                tabNew?.classList.remove('bg-surface-container-lowest', 'text-on-surface', 'shadow-xs', 'font-bold');
                tabNew?.classList.add('text-on-surface-variant');
                if (nameGroup) nameGroup.classList.add('hidden');
                if (btnText) btnText.textContent = `Sign in with email`;
                if (notice) notice.innerHTML = `<span class="font-body-sm text-body-sm text-on-surface-variant">New to Truant Enterprises?</span> <button type="button" onclick="switchGuestAuthTab('new')" class="font-label-sm text-label-sm text-primary font-bold hover:underline ml-1">Create Account</button>`;
            } else {
                tabNew?.classList.add('bg-surface-container-lowest', 'text-on-surface', 'shadow-xs', 'font-bold');
                tabNew?.classList.remove('text-on-surface-variant');
                tabAccount?.classList.remove('bg-surface-container-lowest', 'text-on-surface', 'shadow-xs', 'font-bold');
                tabAccount?.classList.add('text-on-surface-variant');
                if (nameGroup) nameGroup.classList.remove('hidden');
                if (btnText) btnText.textContent = `Register & Book Court`;
                if (notice) notice.innerHTML = `<span class="font-body-sm text-body-sm text-on-surface-variant">Already have an account?</span> <button type="button" onclick="switchGuestAuthTab('account')" class="font-label-sm text-label-sm text-primary font-bold hover:underline ml-1">Sign In</button>`;
            }
        }

        // Pin inputs setup
        document.addEventListener('DOMContentLoaded', () => {
            renderCalendarGrid();
            updateTotalCalculation();

            const pinInputs = document.querySelectorAll('#modalPinInputs .pin-box');
            pinInputs.forEach((input, i) => {
                input.addEventListener('input', (e) => {
                    const val = e.target.value.replace(/\D/g, '');
                    e.target.value = val ? val[0] : '';
                    if (e.target.value && i < pinInputs.length - 1) {
                        pinInputs[i + 1].focus();
                    }
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && i > 0) {
                        pinInputs[i - 1].focus();
                    }
                });
            });
        });
    </script>
</body>
</html>
