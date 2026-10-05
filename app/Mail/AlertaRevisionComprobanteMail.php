<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Reserva;

class AlertaRevisionComprobanteMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reserva $reserva;

    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva->loadMissing('detalles.servicio');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Urgente: Revisa un comprobante de pago pendiente',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.alerta-revision',
        );
    }
}