<?php

namespace App\Mail;

use App\Models\Emprendimiento;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CredencialesEmprendedorMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $usuario;

    public Emprendimiento $emprendimiento;

    public string $passwordPlano;

    public string $nombreCompleto;

    public function __construct(User $usuario, Emprendimiento $emprendimiento, string $passwordPlano)
    {
        $this->usuario = $usuario;
        $this->emprendimiento = $emprendimiento;
        $this->passwordPlano = $passwordPlano;
        $this->nombreCompleto = trim(($usuario->name ?? '') . ' ' . ($usuario->apellidos ?? ''));

        if ($this->nombreCompleto === '') {
            $this->nombreCompleto = 'Emprendedor';
        }
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Credenciales de acceso a tu panel de emprendimiento',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.credenciales-emprendedor',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
