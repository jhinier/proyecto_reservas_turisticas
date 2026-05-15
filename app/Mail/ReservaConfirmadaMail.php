<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reserva;
use App\Models\User;

class ReservaConfirmadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reserva $reserva;
    public User $turista;
    public array $carrito;

    public function __construct(Reserva $reserva, User $turista, array $carrito)
    {
        $this->reserva = $reserva;
        $this->turista = $turista;
        $this->carrito = $carrito;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmación de tu reserva turística',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reserva-confirmada',
        );
    }
}