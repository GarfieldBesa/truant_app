<!DOCTYPE html>
<html class="h-full" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover" name="viewport"/>
    <title>Verify Reservation &amp; Payment — Truant Enterprises</title>
    <meta name="description" content="Verify reservation passcode and confirm payment mode for your court booking at Truant Enterprises."/>
    
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
    @include('partials.header', ['active' => 'book-a-court'])

    <!-- ═══ 3. MAIN CONTENT (pt-16 pb-20 on mobile, lg:pb-12) ═══ -->
    <main class="w-full pt-16 pb-20 lg:pb-12 bg-surface min-h-[calc(100vh-16rem)] flex-1">
        <div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

            <!-- Breadcrumb Navigation -->
            <div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-6">
                <a href="{{ url('/') }}" class="hover:text-primary cursor-pointer transition-colors">Truant Recreation</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <a href="{{ route('court-booking.index') }}" class="hover:text-primary cursor-pointer transition-colors">Book a Court</a>
                <span class="material-symbols-outlined text-[14px] text-outline">chevron_right</span>
                <span class="text-primary font-semibold">Verification &amp; Payment</span>
            </div>

            @if(isset($error) || !$booking)
                <!-- ═══ ERROR / EXPIRED STATE ═══ -->
                <div class="p-8 sm:p-12 rounded-2xl bg-surface-container-lowest border border-error/30 shadow-sm text-center flex flex-col items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-error-container text-on-error-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-[32px]">warning</span>
                    </div>
                    <h2 class="font-headline-md text-headline-md text-on-surface font-bold">Invalid or Expired Link</h2>
                    <p class="font-body-md text-body-md text-on-surface-variant max-w-md">
                        {{ $error ?? 'This court reservation link is invalid, cancelled, or has expired. Please make a new reservation.' }}
                    </p>
                    <a href="{{ route('court-booking.index') }}" class="mt-2 inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold hover:bg-primary-container transition-all shadow-md">
                        <span class="material-symbols-outlined text-[18px]">sports_tennis</span>
                        <span>Book a Court Now</span>
                    </a>
                </div>

            @elseif ($isConfirmed)
                <!-- ═══ CONFIRMED RESERVATION RECEIPT STATE ═══ -->
                <div class="p-6 sm:p-8 rounded-2xl bg-surface-container-lowest border border-tertiary-container/30 shadow-md flex flex-col gap-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-outline-variant/20">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-tertiary-fixed text-on-tertiary-fixed flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[28px] text-tertiary-container">check_circle</span>
                            </div>
                            <div>
                                <h1 class="font-headline-md text-headline-md text-on-surface font-bold">Court Reservation Confirmed!</h1>
                                <p class="font-body-sm text-body-sm text-tertiary-container font-semibold">Schedule is officially secured in real time.</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-surface-container font-mono text-sm font-bold text-primary">
                            <span>Ref:</span>
                            <span>#{{ $booking->reference_code }}</span>
                        </div>
                    </div>

                    <!-- Breakdown Table -->
                    <div class="bg-surface-container-low p-5 rounded-xl border border-outline-variant/20 flex flex-col gap-3 font-body-sm text-body-sm">
                        <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                            <span class="text-on-surface-variant">Court Facility:</span>
                            <span class="font-bold text-on-surface">{{ $booking->court->name }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                            <span class="text-on-surface-variant">Booking Date:</span>
                            <span class="font-semibold text-on-surface">{{ $booking->booking_date->format('l, F d, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                            <span class="text-on-surface-variant">Time Slot:</span>
                            <span class="font-bold text-primary">{{ $booking->time_slot }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                            <span class="text-on-surface-variant">Customer Name:</span>
                            <span class="font-semibold text-on-surface">{{ $booking->customer_name }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                            <span class="text-on-surface-variant">Email Address:</span>
                            <span class="font-semibold text-on-surface">{{ $booking->customer_email }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                            <span class="text-on-surface-variant">Payment Mode:</span>
                            <span class="font-bold text-tertiary-container">{{ $booking->payment_mode_label }}</span>
                        </div>
                        @if ($booking->payment_notes)
                            <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                                <span class="text-on-surface-variant">Payment Note:</span>
                                <span class="font-semibold text-on-surface">{{ $booking->payment_notes }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center pt-2">
                            <span class="font-headline-sm text-headline-sm text-on-surface">Total Amount Paid</span>
                            <span class="font-headline-sm text-headline-sm text-primary font-bold">₱{{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-3 justify-end pt-2">
                        <a href="{{ route('court-booking.index') }}" class="w-full sm:w-auto px-5 py-3 rounded-xl bg-surface-container-low hover:bg-surface-container text-on-surface font-label-md text-label-md font-semibold text-center transition-colors">
                            Book Another Court
                        </a>
                        <a href="{{ route('customer.bookings') }}" class="w-full sm:w-auto px-5 py-3 rounded-xl bg-primary text-on-primary font-label-md text-label-md font-bold text-center hover:bg-primary-container transition-all shadow-sm">
                            View My Registrations &rarr;
                        </a>
                    </div>
                </div>

            @elseif (!$isVerified)
                <!-- ═══ UNVERIFIED STATE: PASSCODE REQUIRED ═══ -->
                <div class="p-6 sm:p-10 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-md flex flex-col items-center text-center gap-5 max-w-lg mx-auto">
                    <div class="w-14 h-14 rounded-2xl bg-primary-container text-on-primary flex items-center justify-center shadow-sm">
                        <span class="material-symbols-outlined text-[28px]">mail_lock</span>
                    </div>
                    <div>
                        <h1 class="font-headline-md text-headline-md text-on-surface font-bold">Enter Verification Passcode</h1>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1.5 max-w-sm">
                            A 6-digit verification code was sent to <strong>{{ $maskedEmail }}</strong>. Enter it below to unlock payment options.
                        </p>
                    </div>

                    <form id="verify-passcode-form" onsubmit="submitPagePasscode(event)" class="w-full flex flex-col items-center gap-4">
                        @csrf
                        <input type="hidden" id="page-token" value="{{ $booking->verification_token }}"/>
                        <input type="hidden" id="page-ref" value="{{ $booking->reference_code }}"/>

                        <div class="flex items-center gap-2 sm:gap-2.5 my-1" id="page-pin-inputs">
                            <input type="text" maxlength="1" class="page-pin w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-index="0" inputmode="numeric" autofocus/>
                            <input type="text" maxlength="1" class="page-pin w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-index="1" inputmode="numeric"/>
                            <input type="text" maxlength="1" class="page-pin w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-index="2" inputmode="numeric"/>
                            <input type="text" maxlength="1" class="page-pin w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-index="3" inputmode="numeric"/>
                            <input type="text" maxlength="1" class="page-pin w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-index="4" inputmode="numeric"/>
                            <input type="text" maxlength="1" class="page-pin w-11 h-14 text-center font-headline-md text-headline-md font-bold rounded-xl bg-surface-container-low border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest" data-index="5" inputmode="numeric"/>
                        </div>

                        <p id="err-page-passcode" class="font-label-sm text-label-sm text-error hidden"></p>

                        <button type="submit" id="btn-page-verify" class="w-full py-3.5 px-4 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold hover:bg-primary-container transition-all shadow-md">
                            <span id="btn-page-verify-text">Verify Passcode &amp; Unlock Payment &rarr;</span>
                        </button>

                        <div class="text-label-sm font-label-sm text-on-surface-variant pt-2">
                            Didn't receive the email?
                            <button type="button" id="btn-page-resend" onclick="resendPagePasscode()" class="text-primary hover:underline font-bold ml-1">
                                Resend Passcode
                            </button>
                        </div>
                    </form>
                </div>

            @else
                <!-- ═══ VERIFIED STATE: SCHEDULE SUMMARY & PAYMENT MODE ═══ -->
                <div class="p-6 sm:p-8 rounded-2xl bg-surface-container-lowest border border-outline-variant/30 shadow-md flex flex-col gap-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-outline-variant/20">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-tertiary-container animate-pulse"></span>
                            <span class="font-label-md text-label-md text-tertiary-container font-bold">Email Verified &bull; Ref #{{ $booking->reference_code }}</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-surface-container font-label-sm text-label-sm font-semibold text-on-surface-variant">
                            Live Reservation Active
                        </span>
                    </div>

                    <div>
                        <h1 class="font-headline-md text-headline-md text-on-surface font-bold">Schedule Summary &amp; Payment</h1>
                        <p class="font-body-sm text-body-sm text-on-surface-variant mt-1">
                            Your reservation is on hold. Select your preferred payment mode below to finalize confirmation.
                        </p>
                    </div>

                    <!-- Summary Box -->
                    <div class="bg-surface-container-low p-5 rounded-xl border border-outline-variant/20 flex flex-col gap-3 font-body-sm text-body-sm">
                        <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                            <span class="text-on-surface-variant">Court Facility:</span>
                            <span class="font-bold text-on-surface">{{ $booking->court->name }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                            <span class="text-on-surface-variant">Date:</span>
                            <span class="font-semibold text-on-surface">{{ $booking->booking_date->format('l, F d, Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                            <span class="text-on-surface-variant">Time Slot:</span>
                            <span class="font-bold text-primary">{{ $booking->time_slot }}</span>
                        </div>
                        @if($booking->court_fee > 0)
                            <div class="flex justify-between items-center pb-2 border-b border-surface-container-high">
                                <span class="text-on-surface-variant">Court Slot Fee:</span>
                                <span class="font-semibold text-on-surface">₱{{ number_format($booking->court_fee, 2) }}</span>
                            </div>
                        @endif
                        @if($booking->rentals && $booking->rentals->isNotEmpty())
                            <div class="flex justify-between items-start pb-2 border-b border-surface-container-high">
                                <span class="text-on-surface-variant">Equipment Rentals:</span>
                                <div class="text-right">
                                    @foreach($booking->rentals as $rental)
                                        <div class="font-semibold text-on-surface">{{ $rental->item->name ?? 'Equipment' }} &times; {{ $rental->quantity }} (₱{{ number_format($rental->subtotal, 2) }})</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if(($booking->discount_amount ?? 0) > 0 || !empty($booking->voucher_code))
                            <div class="flex justify-between items-center pb-2 border-b border-surface-container-high text-tertiary-container font-semibold">
                                <span>Voucher Discount{{ !empty($booking->voucher_code) ? ' (' . $booking->voucher_code . ')' : '' }}:</span>
                                <span>-₱{{ number_format($booking->discount_amount ?? 0, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center pt-2">
                            <span class="font-headline-sm text-headline-sm text-on-surface">Total Due</span>
                            <span class="font-headline-sm text-headline-sm text-primary font-bold">₱{{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>

                    <!-- Payment Mode Form -->
                    <form action="{{ route('court-booking.confirmPayment', ['token' => $booking->verification_token]) }}" method="POST" class="flex flex-col gap-4">
                        @csrf
                        <div class="font-headline-sm text-headline-sm text-on-surface">
                            Select Mode of Payment <span class="text-error">*</span>
                        </div>

                        <div class="grid grid-cols-1 gap-3" id="paymentOptionsGroup">
                            <!-- Option 1: Cash on Site -->
                            <label class="payment-option-card p-4 rounded-xl border-2 border-primary bg-primary-fixed/15 flex items-start gap-3 cursor-pointer transition-all" onclick="setPaymentOption(this)">
                                <input type="radio" name="payment_mode" value="cash_on_site" checked class="mt-1 accent-primary w-4 h-4"/>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-lg text-label-lg font-bold text-on-surface">Cash on Site / Over the Counter</span>
                                        <span class="px-2 py-0.5 rounded text-label-sm font-label-sm bg-tertiary-container text-on-tertiary-container font-semibold">Recommended</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Pay at our reception desk when you arrive at Truant Enterprises for your court session.</p>
                                </div>
                            </label>

                            <!-- Option 2: GCash -->
                            <label class="payment-option-card p-4 rounded-xl border border-outline-variant/30 bg-surface-container-low hover:bg-surface-container flex items-start gap-3 cursor-pointer transition-all" onclick="setPaymentOption(this)">
                                <input type="radio" name="payment_mode" value="gcash" class="mt-1 accent-primary w-4 h-4"/>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-lg text-label-lg font-bold text-on-surface">GCash / E-Wallet</span>
                                        <span class="px-2 py-0.5 rounded text-label-sm font-label-sm bg-surface-container-high text-primary font-semibold">Fast E-Wallet</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Instant mobile transfer. Transaction reference will be recorded.</p>
                                    <div class="mt-2 p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/20 font-mono text-xs text-on-surface">
                                        GCash No: <strong>0917-123-4567</strong> &bull; Name: <strong>Truant Enterprises Inc.</strong>
                                    </div>
                                </div>
                            </label>

                            <!-- Option 3: Bank Transfer -->
                            <label class="payment-option-card p-4 rounded-xl border border-outline-variant/30 bg-surface-container-low hover:bg-surface-container flex items-start gap-3 cursor-pointer transition-all" onclick="setPaymentOption(this)">
                                <input type="radio" name="payment_mode" value="bank_transfer" class="mt-1 accent-primary w-4 h-4"/>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <span class="font-label-lg text-label-lg font-bold text-on-surface">Bank Transfer (BDO / BPI)</span>
                                    </div>
                                    <p class="font-body-sm text-body-sm text-on-surface-variant mt-0.5">Direct bank deposit or online fund transfer.</p>
                                    <div class="mt-2 p-2.5 rounded-lg bg-surface-container-lowest border border-outline-variant/20 font-mono text-xs text-on-surface">
                                        Bank: <strong>BDO Unibank</strong> &bull; Acct: <strong>0012-3456-7890</strong> &bull; Name: <strong>Truant Enterprises Inc.</strong>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="flex flex-col gap-1 mt-2">
                            <label for="payment-notes" class="font-label-md text-label-md text-on-surface font-semibold">
                                Payment Notes / Reference No. (Optional)
                            </label>
                            <input type="text" id="payment-notes" name="payment_notes" class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low text-on-surface border border-outline-variant/30 outline-none focus:ring-2 focus:ring-primary font-body-md text-body-md" placeholder="e.g. GCash Ref #123456789 or expected arrival time"/>
                        </div>

                        <button type="submit" class="w-full mt-2 py-3.5 px-4 rounded-xl bg-primary text-on-primary font-label-lg text-label-lg font-bold hover:bg-primary-container transition-all flex items-center justify-center gap-2 shadow-md active:scale-95">
                            <span>Confirm &amp; Finalize Reservation &rarr;</span>
                        </button>
                    </form>
                </div>
            @endif

        </div>
    </main>

    <!-- Global Footer Partial (Desktop Footer + Mobile Bottom Navigation) -->
    @include('partials.footer', ['active' => 'book-a-court'])

    <!-- ═══ 6. CLIENT SCRIPTS ═══ -->
    <script>
        function setPaymentOption(labelEl) {
            document.querySelectorAll('.payment-option-card').forEach(el => {
                el.classList.remove('border-primary', 'bg-primary-fixed/15', 'border-2');
                el.classList.add('border-outline-variant/30', 'bg-surface-container-low', 'border');
            });
            labelEl.classList.remove('border-outline-variant/30', 'bg-surface-container-low', 'border');
            labelEl.classList.add('border-primary', 'bg-primary-fixed/15', 'border-2');
            const radio = labelEl.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
        }

        let pageResendTimer = null;

        async function submitPagePasscode(event) {
            if (event) event.preventDefault();
            const pins = document.querySelectorAll('.page-pin');
            let passcode = '';
            pins.forEach(p => passcode += p.value.trim());

            const errEl = document.getElementById('err-page-passcode');
            if (!errEl) return;
            errEl.classList.add('hidden');
            errEl.textContent = '';

            if (passcode.length < 6) {
                errEl.textContent = 'Please enter all 6 digits of the passcode.';
                errEl.classList.remove('hidden');
                return;
            }

            const btn = document.getElementById('btn-page-verify');
            const btnText = document.getElementById('btn-page-verify-text');
            if (btn) btn.disabled = true;
            if (btnText) btnText.textContent = 'Verifying...';

            try {
                const res = await fetch(`{{ route('court-booking.verifyPasscode') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        reference_code: document.getElementById('page-ref')?.value,
                        token: document.getElementById('page-token')?.value,
                        passcode: passcode,
                    }),
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    window.location.reload();
                } else {
                    errEl.textContent = data.message || 'Invalid passcode. Please try again.';
                    errEl.classList.remove('hidden');
                }
            } catch (err) {
                errEl.textContent = 'A network error occurred. Please try again.';
                errEl.classList.remove('hidden');
            } finally {
                if (btn) btn.disabled = false;
                if (btnText) btnText.textContent = 'Verify Passcode & Unlock Payment \u2192';
            }
        }

        async function resendPagePasscode() {
            const btn = document.getElementById('btn-page-resend');
            if (btn && btn.disabled) return;
            if (btn) btn.disabled = true;

            try {
                const res = await fetch(`{{ route('court-booking.resendPasscode') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        reference_code: document.getElementById('page-ref')?.value,
                        token: document.getElementById('page-token')?.value,
                    }),
                });

                const data = await res.json();
                if (res.ok && data.success) {
                    alert(data.message);
                    startPageResendTimer(60);
                } else {
                    alert(data.message || 'Unable to resend passcode.');
                    if (btn) btn.disabled = false;
                }
            } catch (err) {
                alert('A network error occurred while resending.');
                if (btn) btn.disabled = false;
            }
        }

        function startPageResendTimer(seconds) {
            const btn = document.getElementById('btn-page-resend');
            if (!btn) return;
            btn.disabled = true;
            clearInterval(pageResendTimer);

            let remaining = seconds;
            btn.textContent = `Resend in ${remaining}s`;

            pageResendTimer = setInterval(() => {
                remaining--;
                if (remaining <= 0) {
                    clearInterval(pageResendTimer);
                    btn.disabled = false;
                    btn.textContent = 'Resend Passcode';
                } else {
                    btn.textContent = `Resend in ${remaining}s`;
                }
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const pagePins = document.querySelectorAll('.page-pin');
            if (pagePins.length > 0) {
                pagePins.forEach((input, idx) => {
                    input.addEventListener('input', (e) => {
                        const val = e.target.value.replace(/\D/g, '');
                        e.target.value = val ? val[0] : '';
                        if (e.target.value && idx < pagePins.length - 1) {
                            pagePins[idx + 1].focus();
                        } else if (idx === pagePins.length - 1 && e.target.value) {
                            let allFilled = true;
                            pagePins.forEach(p => { if (!p.value) allFilled = false; });
                            if (allFilled) submitPagePasscode();
                        }
                    });

                    input.addEventListener('keydown', (e) => {
                        if (e.key === 'Backspace' && !e.target.value && idx > 0) {
                            pagePins[idx - 1].focus();
                        }
                    });

                    input.addEventListener('paste', (e) => {
                        e.preventDefault();
                        const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
                        if (!text) return;
                        pagePins.forEach((inp, i) => {
                            inp.value = text[i] || '';
                        });
                        const nextIdx = Math.min(text.length, pagePins.length - 1);
                        pagePins[nextIdx]?.focus();
                        if (text.length >= pagePins.length) submitPagePasscode();
                    });
                });
            }
        });
    </script>
</body>
</html>
