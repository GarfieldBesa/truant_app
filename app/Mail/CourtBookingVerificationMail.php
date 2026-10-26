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
        return new Envelope(
            subject: 'Your Court Reservation Passcode: ' . $this->booking->verification_passcode . ' — Truant Enterprises (' . $this->booking->reference_code . ')',
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
