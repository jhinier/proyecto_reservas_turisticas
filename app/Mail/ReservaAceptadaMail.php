<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaAceptadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reserva $reserva;
    public string $telefono;
    public string $nombreEmprendimiento;

    public function __construct(Reserva $reserva, string $telefono)
    {
        $this->reserva = $reserva->loadMissing('detalles.servicio.categoriaPivot.emprendimiento');
        $this->telefono = $telefono;
        
        $detalle = $this->reserva->detalles->first();
        $this->nombreEmprendimiento = $detalle?->servicio?->categoriaPivot?->emprendimiento?->nombre ?? 'el establecimiento';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu reserva fue confirmada',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reserva-aceptada',
        );
    }
}