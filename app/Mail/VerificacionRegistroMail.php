<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificacionRegistroMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $nombre;
    public string $email;
    public string $token;

    public function __construct(string $nombre, string $email, string $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirma tu cuenta',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verificacion-registro',
            with: [
                'nombre' => $this->nombre,
                'email' => $this->email,
                'url' => route('registro.confirmar', ['token' => $this->token]),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
