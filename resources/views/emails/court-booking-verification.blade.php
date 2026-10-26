<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Your Court Reservation</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            color: #334155;
        }
        .container {
            max-width: 600px;
            margin: 36px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.06);
        }
        .header {
            background: #ffffff;
            padding: 32px 30px 24px 30px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
        }
        .brand-badge {
            display: inline-block;
            background: #eef2ff;
            color: #4f46e5;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding: 4px 12px;
            border-radius: 9999px;
            margin-bottom: 8px;
        }
        .brand-title {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
            margin: 0;
        }
        .brand-subtitle {
            font-size: 13.5px;
            color: #64748b;
            font-weight: 500;
            margin-top: 4px;
        }
        .content {
            padding: 32px 30px;
        }
        h2 {
            font-size: 19px;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 12px;
            font-weight: 700;
        }
        p {
            font-size: 14.5px;
            line-height: 1.65;
            color: #475569;
            margin: 0 0 18px 0;
        }
        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 22px;
            margin: 22px 0 28px 0;
        }
        .summary-row {
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13.5px;
        }
        .summary-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .btn-wrapper {
            text-align: center;
            margin: 32px 0 26px 0;
        }
        .btn-action {
            display: inline-block;
            background: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            font-weight: 700;
            font-size: 14.5px;
            padding: 14px 32px;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25);
        }
        .footer {
            background: #f8fafc;
            padding: 24px 30px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #e2e8f0;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="brand-badge">Court Reservation</span>
            <h1 class="brand-title">Truant Enterprises</h1>
            <div class="brand-subtitle">Email Verification &amp; Schedule Confirmation</div>
        </div>

        <div class="content">
            <h2>Hello {{ $booking->customer_name }},</h2>
            <p>
                Thank you for reserving a court slot at Truant Enterprises. To complete your reservation and proceed to payment, please enter the 6-digit passcode below into the booking window:
            </p>

            <!-- Prominent 6-Digit Passcode Box -->
            <div style="background: #f8fafc; border: 2px dashed #c7d2fe; border-radius: 14px; padding: 22px 20px; text-align: center; margin: 22px 0 26px 0;">
                <div style="font-size: 11px; text-transform: uppercase; color: #4f46e5; font-weight: 700; letter-spacing: 1px; margin-bottom: 6px;">Your 6-Digit Verification Passcode</div>
                <div style="font-size: 36px; font-weight: 800; color: #0f172a; letter-spacing: 8px; font-family: monospace; margin: 8px 0;">
                    {{ $booking->verification_passcode }}
                </div>
                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                    This passcode will expire in 30 minutes. Do not share this code.
                </div>
            </div>

            <div class="summary-card">
                <table width="100%" cellpadding="6" cellspacing="0" style="font-size: 13.5px;">
                    <tr>
                        <td style="color: #64748b; font-weight: 500;">Reference Code:</td>
                        <td style="color: #4f46e5; font-weight: 700; text-align: right; font-family: monospace;">{{ $booking->reference_code }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; font-weight: 500;">Court:</td>
                        <td style="color: #0f172a; font-weight: 600; text-align: right;">{{ $booking->court->name }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; font-weight: 500;">Date:</td>
                        <td style="color: #0f172a; font-weight: 600; text-align: right;">{{ $booking->booking_date->format('l, F d, Y') }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; font-weight: 500;">Time Slot:</td>
                        <td style="color: #0f172a; font-weight: 600; text-align: right;">{{ $booking->time_slot }}</td>
                    </tr>
                    <tr>
                        <td style="color: #64748b; font-weight: 500;">Slots:</td>
                        <td style="color: #0f172a; font-weight: 600; text-align: right;">{{ $booking->slots_count }} slot</td>
                    </tr>
                </table>
            </div>

            <div class="btn-wrapper">
                <a href="{{ $verificationUrl }}" class="btn-action">
                    Proceed to Reservation Screen &rarr;
                </a>
            </div>

            <p style="font-size: 12.5px; color: #64748b; text-align: center;">
                If you did not request this reservation, you can safely ignore this email.
            </p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Truant Enterprises. All rights reserved.<br>
            If the button doesn't work, copy and paste this URL into your browser:<br>
            <span style="color: #4f46e5; word-break: break-all;">{{ $verificationUrl }}</span>
        </div>
    </div>
</body>
</html>
