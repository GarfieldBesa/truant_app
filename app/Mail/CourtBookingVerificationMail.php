<?php

namespace App\Mail;

use App\Models\CourtBooking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CourtBookingVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public CourtBooking $booking;
    public string $verificationUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(CourtBooking $booking)
    {
        $this->booking = $booking;
        $this->verificationUrl = route('court-booking.verify', ['token' => $booking->verification_token]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->booking->isVerified()
            ? 'Court Reservation Confirmation — ' . ($this->booking->court->name ?? 'Court') . ' (' . $this->booking->reference_code . ')'
            : 'Your Court Reservation Passcode: ' . $this->booking->verification_passcode . ' — Truant Enterprises (' . $this->booking->reference_code . ')';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.court-booking-verification',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
