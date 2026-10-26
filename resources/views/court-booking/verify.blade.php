<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Reservation &amp; Payment — Truant Enterprises</title>
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
            --danger-bg: #fef2f2;
            --danger-text: #991b1b;
            --danger-border: #fecaca;
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-full: 9999px;
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.05), 0 1px 2px rgba(15, 23, 42, 0.03);
            --shadow-md: 0 4px 16px -2px rgba(15, 23, 42, 0.06), 0 2px 6px -1px rgba(15, 23, 42, 0.04);
            --font-sans: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --font-display: 'Space Grotesk', var(--font-sans);
            --font-mono: 'JetBrains Mono', monospace;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: var(--font-sans);
            background-color: var(--bg-page);
            color: var(--text-body);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── Header ─────────────────────────────────────────────── */
        header.site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            height: 70px;
        }

        .header-container {
            max-width: 1000px;
            margin: 0 auto;
            height: 100%;
            padding: 0 24px;
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
            width: 38px;
            height: 38px;
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
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-title);
        }

        .verify-main {
            flex: 1;
            max-width: 720px;
            width: 100%;
            margin: 0 auto;
            padding: 40px 24px 60px 24px;
        }

        .card {
            background: #ffffff;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 36px 32px;
            box-shadow: var(--shadow-md);
            margin-bottom: 24px;
        }

        .badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--success-bg);
            color: var(--success-text);
            border: 1px solid var(--success-border);
            font-size: 0.8rem;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: var(--radius-full);
            margin-bottom: 16px;
        }

        .card-title {
            font-family: var(--font-display);
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-title);
            letter-spacing: -0.02em;
            margin-bottom: 8px;
        }

        .card-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
            margin-bottom: 24px;
        }

        .summary-box {
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 20px 22px;
            margin-bottom: 28px;
        }

        .summary-title {
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--primary);
            margin-bottom: 14px;
        }

        .summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.92rem;
        }

        .summary-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .summary-label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .summary-value {
            color: var(--text-title);
            font-weight: 600;
            text-align: right;
        }

        .reference-chip {
            font-family: var(--font-mono);
            background: var(--primary-light);
            color: var(--primary);
            padding: 3px 9px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.88rem;
            border: 1px solid var(--primary-border);
        }

        /* ─── Payment Mode Options ────────────────────────── */
        .payment-options-group {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 24px;
        }

        .payment-option-label {
            display: flex;
            align-items: flex-start;
            gap: 14px;
            background: #ffffff;
            border: 2px solid var(--border-color);
            border-radius: var(--radius-md);
            padding: 16px 18px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .payment-option-label:hover {
            border-color: var(--border-hover);
            background: var(--bg-subtle);
        }

        .payment-option-label.active {
            border-color: var(--primary);
            background: #faf5ff;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        }

        .payment-radio {
            margin-top: 3px;
            accent-color: var(--primary);
            cursor: pointer;
            width: 18px;
            height: 18px;
        }

        .payment-option-content {
            flex: 1;
        }

        .payment-name {
            font-size: 0.98rem;
            font-weight: 700;
            color: var(--text-title);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .payment-desc {
            font-size: 0.84rem;
            color: var(--text-muted);
            line-height: 1.45;
        }

        .payment-instruction-box {
            display: none;
            background: var(--bg-subtle);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-sm);
            padding: 10px 14px;
            margin-top: 10px;
            font-size: 0.82rem;
            color: var(--text-body);
            font-family: var(--font-mono);
        }

        .payment-option-label.active .payment-instruction-box {
            display: block;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 22px;
            border-radius: var(--radius-sm);
            font-size: 0.92rem;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid transparent;
            transition: all 0.2s;
        }

        .btn-primary {
            background: var(--primary);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);
            width: 100%;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
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

        /* ─── Confirmed State Styling ─────────────────────── */
        .confirmed-card {
            text-align: center;
            padding: 44px 32px;
        }

        .success-icon-box {
            width: 64px;
            height: 64px;
            border-radius: var(--radius-full);
            background: var(--success-bg);
            border: 2px solid var(--success-border);
            color: var(--success-text);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        }

        .print-btn {
            background: #ffffff;
            border: 1px solid var(--border-color);
            color: var(--text-title);
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: var(--shadow-sm);
            transition: all 0.15s;
        }

        .print-btn:hover {
            background: var(--bg-subtle);
            border-color: var(--border-hover);
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

        @media print {
            .site-header, .btn-wrapper, .print-btn, footer { display: none !important; }
            body { background: #fff !important; color: #000 !important; }
            .card, .summary-box { background: #fff !important; color: #000 !important; border: 1px solid #ccc !important; box-shadow: none !important; }
            .card-title, .summary-value { color: #000 !important; }
            .reference-chip { background: #eee !important; color: #000 !important; border: none !important; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-container">
            <a href="{{ url('/') }}" class="brand-link">
                <div class="brand-logo-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="brand-title">Truant Enterprises</span>
            </a>
            <div>
                <a href="{{ route('court-booking.index') }}" class="btn btn-outline" style="padding: 7px 16px; font-size: 0.85rem;">
                    &larr; Back to Booking
                </a>
            </div>
        </div>
    </header>

    <main class="verify-main">
        @if (isset($error) || !$booking)
            <!-- Error State -->
            <div class="card" style="text-align: center; padding: 48px 32px;">
                <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--danger-bg); color: var(--danger-text); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; border: 1px solid var(--danger-border);">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h2 class="card-title">Reservation Not Found</h2>
                <p class="card-desc">{{ $error ?? 'This verification link is invalid or has expired.' }}</p>
                <div>
                    <a href="{{ route('court-booking.index') }}" class="btn btn-primary" style="display: inline-flex; width: auto;">
                        Start a New Court Booking
                    </a>
                </div>
            </div>
        @elseif ($isConfirmed || $booking->isConfirmed())
            <!-- CONFIRMED STATE (RECEIPT) -->
            <div class="card confirmed-card">
                <div class="success-icon-box">
                    <svg width="34" height="34" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div class="badge-verified">
                    &#9989; Email Validated &amp; Schedule Confirmed
                </div>
                <h1 class="card-title">Court Reservation Confirmed!</h1>
                <p class="card-desc">
                    Your reservation has been recorded in the system. The admin has been notified of your schedule.
                </p>

                <!-- Receipt Summary Box -->
                <div class="summary-box" style="text-align: left;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span class="summary-title" style="margin-bottom: 0;">Reservation Receipt</span>
                        <button type="button" class="print-btn" onclick="window.print()">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print Receipt
                        </button>
                    </div>

                    <div class="summary-row">
                        <span class="summary-label">Reference Number:</span>
                        <span class="reference-chip">{{ $booking->reference_code }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Court:</span>
                        <span class="summary-value" style="color: var(--primary);">{{ $booking->court->name }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Date:</span>
                        <span class="summary-value">{{ $booking->booking_date->format('l, F d, Y') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Time Slot:</span>
                        <span class="summary-value" style="color: var(--primary);">{{ $booking->time_slot }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Reserved Slots:</span>
                        <span class="summary-value">{{ $booking->slots_count }} slot</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Customer Name:</span>
                        <span class="summary-value">{{ $booking->customer_name }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Email:</span>
                        <span class="summary-value">{{ $booking->customer_email }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Contact Number:</span>
                        <span class="summary-value">{{ $booking->customer_contact }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Payment Mode:</span>
                        <span class="summary-value" style="color: #065f46;">{{ $booking->payment_mode_label }}</span>
                    </div>
                    @if ($booking->payment_notes)
                    <div class="summary-row">
                        <span class="summary-label">Payment Note:</span>
                        <span class="summary-value">{{ $booking->payment_notes }}</span>
                    </div>
                    @endif
                </div>

                <div class="btn-wrapper" style="display: flex; gap: 14px; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('court-booking.index') }}" class="btn btn-outline" style="width: auto;">
                        Book Another Court
                    </a>
                    <a href="{{ url('/') }}" class="btn btn-primary" style="width: auto;">
                        Back to Homepage &rarr;
                    </a>
                </div>
            </div>
        @elseif (!$isVerified)
            <!-- UNVERIFIED STATE: PASSCODE REQUIRED -->
            <div class="card" style="text-align: center; padding: 44px 32px; max-width: 580px; margin: 0 auto;">
                <div style="width: 56px; height: 56px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px auto; border: 1px solid var(--primary-border);">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h1 class="card-title">Enter Verification Passcode</h1>
                <p class="card-desc" style="max-width: 440px; margin: 0 auto 20px auto;">
                    A 6-digit verification passcode was sent to <strong>{{ $maskedEmail }}</strong>.<br>Enter it below to verify your email and unlock payment options.
                </p>

                <!-- Passcode Input Form -->
                <form id="verify-passcode-form" onsubmit="submitPagePasscode(event)" style="max-width: 380px; margin: 0 auto;">
                    @csrf
                    <input type="hidden" id="page-token" value="{{ $booking->verification_token }}">
                    <input type="hidden" id="page-ref" value="{{ $booking->reference_code }}">

                    <div class="pin-inputs-wrapper" id="page-pin-inputs">
                        <input type="text" maxlength="1" class="pin-box page-pin" data-index="0" inputmode="numeric" autocomplete="one-time-code" autofocus>
                        <input type="text" maxlength="1" class="pin-box page-pin" data-index="1" inputmode="numeric">
                        <input type="text" maxlength="1" class="pin-box page-pin" data-index="2" inputmode="numeric">
                        <input type="text" maxlength="1" class="pin-box page-pin" data-index="3" inputmode="numeric">
                        <input type="text" maxlength="1" class="pin-box page-pin" data-index="4" inputmode="numeric">
                        <input type="text" maxlength="1" class="pin-box page-pin" data-index="5" inputmode="numeric">
                    </div>

                    <div class="form-error" id="err-page-passcode" style="color: var(--danger-text); font-size: 0.85rem; margin-bottom: 14px; display: none;"></div>

                    <button type="submit" class="btn btn-primary" id="btn-page-verify" style="width: 100%; justify-content: center; padding: 13px 20px;">
                        <span id="btn-page-verify-text">Verify Passcode &amp; Unlock Payment &rarr;</span>
                    </button>

                    <div style="margin-top: 18px; font-size: 0.88rem; color: var(--text-muted);">
                        Didn't receive the email?
                        <button type="button" id="btn-page-resend" onclick="resendPagePasscode()" style="background: none; border: none; color: var(--primary); font-weight: 700; cursor: pointer; text-decoration: underline; padding: 0;">
                            Resend Passcode
                        </button>
                    </div>
                </form>
            </div>
        @else
            <!-- VERIFIED STATE: SUMMARY & PAYMENT MODE SELECTION -->
            <div class="card">
                <div class="badge-verified">
                    &#9989; Email Verified &mdash; Ref #{{ $booking->reference_code }}
                </div>
                <h1 class="card-title">Schedule Summary &amp; Payment</h1>
                <p class="card-desc">
                    Your email address has been verified. Please review your schedule details below and select your preferred payment mode to finalize the reservation.
                </p>

                <!-- Schedule Summary Box -->
                <div class="summary-box">
                    <div class="summary-title">Reservation Summary</div>
                    <div class="summary-row">
                        <span class="summary-label">Court:</span>
                        <span class="summary-value" style="color: var(--primary);">{{ $booking->court->name }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Date:</span>
                        <span class="summary-value">{{ $booking->booking_date->format('l, F d, Y') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Time Slot:</span>
                        <span class="summary-value" style="color: var(--primary);">{{ $booking->time_slot }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Slots:</span>
                        <span class="summary-value">{{ $booking->slots_count }} slot</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Customer Name:</span>
                        <span class="summary-value">{{ $booking->customer_name }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Email:</span>
                        <span class="summary-value">{{ $booking->customer_email }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Contact:</span>
                        <span class="summary-value">{{ $booking->customer_contact }}</span>
                    </div>
                </div>

                <!-- Form: Select Mode of Payment -->
                <form action="{{ route('court-booking.confirmPayment', ['token' => $booking->verification_token]) }}" method="POST">
                    @csrf
                    <div style="font-family: var(--font-display); font-size: 1.15rem; font-weight: 700; color: var(--text-title); margin-bottom: 14px;">
                        Select Mode of Payment <span style="color: var(--danger-text);">*</span>
                    </div>

                    <div class="payment-options-group">
                        <!-- Option 1: Cash on Site -->
                        <label class="payment-option-label active" onclick="setPaymentOption(this)">
                            <input type="radio" name="payment_mode" value="cash_on_site" class="payment-radio" checked>
                            <div class="payment-option-content">
                                <div class="payment-name">
                                    <span>Cash on Site / Over the Counter</span>
                                    <span style="font-size: 0.78rem; color: #065f46; font-weight: 600;">Recommended</span>
                                </div>
                                <div class="payment-desc">
                                    Pay at our reception desk when you arrive at Truant Enterprises for your court schedule.
                                </div>
                            </div>
                        </label>

                        <!-- Option 2: GCash -->
                        <label class="payment-option-label" onclick="setPaymentOption(this)">
                            <input type="radio" name="payment_mode" value="gcash" class="payment-radio">
                            <div class="payment-option-content">
                                <div class="payment-name">
                                    <span>GCash / E-Wallet</span>
                                    <span style="font-size: 0.78rem; color: var(--primary); font-weight: 600;">Fast E-Wallet</span>
                                </div>
                                <div class="payment-desc">
                                    Send payment via GCash. Transaction reference will be recorded.
                                </div>
                                <div class="payment-instruction-box">
                                    GCash Number: 0917-123-4567<br>
                                    Account Name: Truant Enterprises Inc.
                                </div>
                            </div>
                        </label>

                        <!-- Option 3: Bank Transfer -->
                        <label class="payment-option-label" onclick="setPaymentOption(this)">
                            <input type="radio" name="payment_mode" value="bank_transfer" class="payment-radio">
                            <div class="payment-option-content">
                                <div class="payment-name">
                                    <span>Bank Transfer (BDO / BPI)</span>
                                </div>
                                <div class="payment-desc">
                                    Direct bank deposit or online fund transfer.
                                </div>
                                <div class="payment-instruction-box">
                                    Bank: BDO Unibank<br>
                                    Account No: 0012-3456-7890<br>
                                    Account Name: Truant Enterprises Inc.
                                </div>
                            </div>
                        </label>
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label for="payment-notes" style="display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-body); margin-bottom: 6px;">
                            Payment Notes / Reference No. (Optional)
                        </label>
                        <input type="text"
                               id="payment-notes"
                               name="payment_notes"
                               class="form-input"
                               style="width: 100%; background: #ffffff; border: 1.5px solid var(--border-color); border-radius: var(--radius-sm); padding: 10px 14px; font-size: 0.92rem; color: var(--text-title); outline: none;"
                               placeholder="e.g. GCash Ref #123456789 or expected arrival time">
                    </div>

                    <button type="submit" class="btn btn-primary" id="btn-confirm-payment">
                        <span>Confirm &amp; Finalize Reservation &rarr;</span>
                    </button>
                </form>
            </div>
        @endif
    </main>

    <footer style="background: #ffffff; border-top: 1px solid var(--border-color); padding: 24px; text-align: center; font-size: 0.82rem; color: var(--text-muted); margin-top: auto;">
        &copy; {{ date('Y') }} Truant Enterprises. All rights reserved.
    </footer>

    <script>
        function setPaymentOption(labelEl) {
            document.querySelectorAll('.payment-option-label').forEach(el => el.classList.remove('active'));
            labelEl.classList.add('active');
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
            errEl.style.display = 'none';
            errEl.textContent = '';

            if (passcode.length < 6) {
                errEl.textContent = 'Please enter all 6 digits of the passcode.';
                errEl.style.display = 'block';
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
                    errEl.style.display = 'block';
                }
            } catch (err) {
                errEl.textContent = 'A network error occurred. Please try again.';
                errEl.style.display = 'block';
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
                    if (btn) {
                        btn.disabled = false;
                        btn.textContent = 'Resend Passcode';
                    }
                }
            } catch (err) {
                alert('A network error occurred while resending.');
                if (btn) {
                    btn.disabled = false;
                    btn.textContent = 'Resend Passcode';
                }
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
                        if (e.target.value) {
                            e.target.classList.add('filled');
                            if (idx < pagePins.length - 1) {
                                pagePins[idx + 1].focus();
                            } else {
                                let allFilled = true;
                                pagePins.forEach(p => { if (!p.value) allFilled = false; });
                                if (allFilled) submitPagePasscode();
                            }
                        } else {
                            e.target.classList.remove('filled');
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
                            if (text[i]) inp.classList.add('filled');
                            else inp.classList.remove('filled');
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
