<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ComprobanteSubidoEmprendedorMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reserva $reserva;

    public string $nombreEmprendimiento;

    public string $nombreTurista;

    public int $horasRevision = 24;

    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva->loadMissing([
            'turista',
            'detalles.servicio.categoriaPivot.emprendimiento',
        ]);

        $detalle = $this->reserva->detalles->first();
        $this->nombreEmprendimiento = $detalle?->servicio?->categoriaPivot?->emprendimiento?->nombre ?? 'tu emprendimiento';
        $this->nombreTurista = trim(($this->reserva->turista->name ?? '').' '.($this->reserva->turista->apellidos ?? ''));

        if ($this->nombreTurista === '') {
            $this->nombreTurista = 'El turista';
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nuevo comprobante/factura de pago subido',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.comprobante-subido-emprendedor',
        );
    }
}
