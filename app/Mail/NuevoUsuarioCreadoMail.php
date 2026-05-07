<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NuevoUsuarioCreadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $turista;
    public Reserva $reserva;
    public string $passwordTemporal;

    public function __construct(User $turista, Reserva $reserva, string $passwordTemporal)
    {
        $this->turista = $turista;
        $this->reserva = $reserva;
        $this->passwordTemporal = $passwordTemporal;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ ¡Reserva Confirmada y Cuenta Creada!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.nuevo-usuario-reserva',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}