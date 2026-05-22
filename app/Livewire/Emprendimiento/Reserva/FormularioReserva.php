<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Livewire\Component;
use Livewire\Attributes\Reactive;
use Illuminate\Support\Str;

class FormularioReserva extends Component
{
    #[Reactive] public ?string $nombreCategoria = '';

    public string $fecha    = '';
    public string $fechaFin = '';
    public ?int   $personas = 0; // Cambiado a cero para obligar el ingreso

    public function requiereFechaFin(): bool
    {
        $tipo = Str::slug($this->nombreCategoria ?? '', ' ');

        return str_contains($tipo, 'hospedaje') 
            || str_contains($tipo, 'alquiler') 
            || str_contains($tipo, 'guianza');
    }

    public function requierePersonas(): bool
    {
        $tipo = Str::slug($this->nombreCategoria ?? '', ' ');

        return str_contains($tipo, 'hospedaje')
            || str_contains($tipo, 'guianza');
    }

    // NUEVO MÉTODO: Calcula la fecha mínima según la categoría actual
    public function getFechaMinima(): string
    {
        $tipo = Str::slug($this->nombreCategoria ?? '', ' ');
        
        if (str_contains($tipo, 'paquete')) {
            // Si es paquete, suma 3 días a la fecha actual para bloquear el calendario
            return now()->addDays(3)->toDateString();
        }

        // Si no es paquete, permite desde hoy
        return now()->toDateString();
    }

    public function buscar(): void
    {
        $fechaMinimaPermitida = $this->getFechaMinima();

        $reglas = [
            // Validamos contra la fecha mínima calculada en lugar de "today"
            'fecha' => 'required|date|after_or_equal:' . $fechaMinimaPermitida,
        ];

        if ($this->requiereFechaFin()) {
            $reglas['fechaFin'] = 'required|date|after_or_equal:fecha';
        }

        if ($this->requierePersonas()) {
            $reglas['personas'] = 'required|integer|min:1'; // Obliga a ingresar un número mayor a cero
        }

        $this->validate($reglas);

        $fechaFinCalculada = $this->requiereFechaFin() ? $this->fechaFin : $this->fecha;
        $personasCalculadas = $this->requierePersonas() ? $this->personas : null;

        $this->dispatch('busqueda-ejecutada', [
            'fecha'    => $this->fecha,
            'fechaFin' => $fechaFinCalculada,
            'personas' => $personasCalculadas,
        ]);
    }

    public function render()
    {
        return view('livewire.emprendimiento.reserva.formulario-reserva');
    }
}