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
    public string $telefono;
    public string $nombreEmprendimiento;

    public function __construct(Reserva $reserva, User $turista, array $carrito, string $telefono)
    {
        $this->reserva = $reserva->loadMissing('detalles.servicio.categoriaPivot.emprendimiento');
        $this->turista = $turista;
        $this->carrito = $carrito;
        $this->telefono = $telefono;
        
        $detalle = $this->reserva->detalles->first();
        $this->nombreEmprendimiento = $detalle?->servicio?->categoriaPivot?->emprendimiento?->nombre ?? 'el establecimiento';
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