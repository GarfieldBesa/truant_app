<!DOCTYPE html>
<html class="h-full" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" name="viewport"/>
    <title>My Court Bookings &amp; History — Truant Enterprises</title>
    <meta name="description" content="View your court reservations, schedule history, and payment details at Truant Enterprises."/>
    
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
    @include('partials.header', ['active' => 'my-registrations'])

    <!-- ═══ 3. MAIN CONTENT (pt-16 pb-20 on mobile, lg:pb-12) ═══ -->
    <main class="w-full pt-16 pb-20 lg:pb-12 bg-surface min-h-[calc(100vh-16rem)] flex-1">
        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-12 py-6 sm:py-8 flex flex-col gap-6 sm:gap-8">

            <!-- Breadcrumb Navigation -->
            <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md">
                <a href="{{ url('/') }}" class="hover:text-primary cursor-pointer transition-colors">Truant Recreation</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="hover:text-primary cursor-pointer transition-colors">Portal</span>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="text-primary font-semibold">My Bookings &amp; History</span>
            </div>

            <!-- Profile Overview Card -->
            <div class="p-6 sm:p-8 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-2xl object-cover border-2 border-primary/20 shadow-xs"/>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h1 class="font-headline-md text-headline-md text-on-surface font-bold">{{ $user->name }}</h1>
                            @if($user->google_id)
                                <span class="px-2.5 py-0.5 rounded-full text-label-sm font-label-sm bg-tertiary-fixed text-on-tertiary-fixed font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">check</span> Google Verified
                                </span>
                            @endif
                        </div>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">
                            {{ $user->email }} &bull; {{ $user->phone_number ?? 'No contact phone recorded' }}
                        </p>
                    </div>
                </div>

                <!-- Live Booking Metrics -->
                <div class="flex items-center gap-4 sm:gap-6 flex-wrap">
                    <div class="p-3.5 px-5 rounded-xl bg-surface-container-low border border-outline-variant/20 flex flex-col items-center">
                        <span class="font-headline-md text-headline-md text-primary font-extrabold">{{ $stats['upcoming_count'] }}</span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Upcoming</span>
                    </div>
                    <div class="p-3.5 px-5 rounded-xl bg-surface-container-low border border-outline-variant/20 flex flex-col items-center">
                        <span class="font-headline-md text-headline-md text-on-surface font-extrabold">{{ $stats['total_bookings'] }}</span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Total Bookings</span>
                    </div>
                    <div class="p-3.5 px-5 rounded-xl bg-surface-container-low border border-outline-variant/20 flex flex-col items-center">
                        <span class="font-headline-md text-headline-md text-tertiary-container font-extrabold">₱{{ number_format($stats['total_spent'], 2) }}</span>
                        <span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Total Invested</span>
                    </div>
                </div>
            </div>

            <!-- Booking History Section -->
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <h2 class="font-headline-sm text-headline-sm text-on-surface">Reservation Records</h2>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Live confirmation tracking and schedule receipts</p>
                    </div>
                    <a href="{{ route('court-booking.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-primary text-on-primary font-label-md text-label-md font-bold hover:bg-primary-container transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">add_circle</span>
                        <span>Book New Slot</span>
                    </a>
                </div>

                <!-- Bookings Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($bookings as $booking)
                        <div class="p-5 rounded-xl bg-surface-container-lowest border border-outline-variant/30 shadow-sm flex flex-col justify-between gap-4 hover:shadow-md transition-shadow">
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center justify-between gap-2 flex-wrap">
                                    <span class="px-2.5 py-0.5 rounded-lg bg-surface-container text-primary font-mono text-xs font-bold">
                                        #{{ $booking->reference_code }}
                                    </span>
                                    <span class="px-2.5 py-0.5 rounded-full text-label-sm font-label-sm font-bold uppercase tracking-wider {{ $booking->status === 'confirmed' ? 'bg-tertiary-fixed text-on-tertiary-fixed' : ($booking->status === 'verified' ? 'bg-primary-container text-on-primary' : 'bg-surface-container-high text-on-surface-variant') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <div>
                                    <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">{{ $booking->court->name }}</h3>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1.5 mt-0.5">
                                        <span class="material-symbols-outlined text-[16px] text-primary">event</span>
                                        <span>{{ $booking->booking_date->format('l, F d, Y') }}</span>
                                    </div>
                                    <div class="font-body-sm text-body-sm text-on-surface-variant flex items-center gap-1.5 mt-0.5">
                                        <span class="material-symbols-outlined text-[16px] text-primary">schedule</span>
                                        <span class="font-semibold text-primary">{{ $booking->time_slot }}</span>
                                    </div>
                                </div>
                                @if($booking->rentals && $booking->rentals->isNotEmpty())
                                    <div class="flex flex-wrap gap-1.5 pt-1">
                                        @foreach($booking->rentals as $rental)
                                            <span class="px-2 py-0.5 rounded-md bg-surface-container-low text-on-surface-variant text-[11px] font-semibold border border-outline-variant/20">
                                                {{ $rental->item->name ?? 'Gear' }} &times; {{ $rental->quantity }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-outline-variant/20">
                                <div class="flex flex-col">
                                    <span class="font-label-sm text-label-sm text-on-surface-variant">Amount Paid</span>
                                    <span class="font-label-lg text-label-lg text-primary font-extrabold">₱{{ number_format($booking->total_amount, 2) }}</span>
                                </div>
                                <a href="{{ route('court-booking.verify', ['token' => $booking->verification_token]) }}" class="px-3.5 py-1.5 rounded-lg bg-surface-container-low hover:bg-surface-container text-on-surface font-label-sm text-label-sm font-semibold transition-colors">
                                    View Receipt &rarr;
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 p-12 rounded-2xl bg-surface-container-lowest border border-dashed border-outline-variant/40 text-center flex flex-col items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-surface-container-high text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined text-[24px]">sports_tennis</span>
                            </div>
                            <h3 class="font-headline-sm text-headline-sm text-on-surface font-bold">No Court Bookings Yet</h3>
                            <p class="font-body-sm text-body-sm text-on-surface-variant max-w-sm">
                                You haven't booked any court schedules yet. Check out available courts to reserve a session.
                            </p>
                            <a href="{{ route('court-booking.index') }}" class="mt-2 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary text-on-primary font-label-md text-label-md font-bold hover:bg-primary-container transition-all shadow-sm">
                                <span>Explore &amp; Book Court</span>
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    <!-- Global Footer Partial (Desktop Footer + Mobile Bottom Navigation) -->
    @include('partials.footer', ['active' => 'my-registrations'])
</body>
</html>
