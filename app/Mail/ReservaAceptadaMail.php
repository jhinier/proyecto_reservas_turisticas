<?php

namespace App\Mail;

use App\Models\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ReservaAceptadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reserva $reserva;

    public string $telefono;

    public string $nombreEmprendimiento;

    public Collection $cuentasBancarias;

    public function __construct(Reserva $reserva, string $telefono)
    {
        $this->reserva = $reserva->loadMissing('detalles.servicio.categoriaPivot.emprendimiento');
        $this->telefono = $telefono;

        $detalle = $this->reserva->detalles->first();
        $emprendimiento = $detalle?->servicio?->categoriaPivot?->emprendimiento;
        $this->nombreEmprendimiento = $emprendimiento?->nombre ?? 'el establecimiento';
        $this->cuentasBancarias = $emprendimiento
            ? $emprendimiento->cuentasBancarias()->orderBy('id')->get(['nombre_banco', 'numero_cuenta', 'titular'])
            : collect();
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
