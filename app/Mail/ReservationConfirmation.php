<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Restaurant Reservation Confirmation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservation-confirmation',
            with: [
                'reservation' => $this->reservation,
                'sessionLabel' => ucfirst($this->reservation->session),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
