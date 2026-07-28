<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaPendienteTuristaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;
    public string $nombreEmprendimiento;

    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva->loadMissing('detalles.servicio.categoriaPivot.emprendimiento');
        
        $detalle = $this->reserva->detalles->first();
        $this->nombreEmprendimiento = $detalle?->servicio?->categoriaPivot?->emprendimiento?->nombre ?? 'el establecimiento';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu reserva está pendiente de confirmación',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reserva_pendiente_turista',
        );
    }
}