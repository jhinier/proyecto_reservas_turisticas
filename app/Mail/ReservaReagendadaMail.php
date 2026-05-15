<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reserva;

class ReservaReagendadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reserva $reserva;
    public string $motivo;

    public function __construct(Reserva $reserva, string $motivo)
    {
        $this->reserva = $reserva;
        $this->motivo = $motivo;
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Actualización: Tu reserva ha sido reagendada');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.reserva-reagendada');
    }
}