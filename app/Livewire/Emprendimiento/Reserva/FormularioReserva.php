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

    public function requiereFechaFin(): bool
    {
        $tipo = Str::slug($this->nombreCategoria ?? '', ' ');

        return str_contains($tipo, 'hospedaje') 
            || str_contains($tipo, 'alquiler') 
            || str_contains($tipo, 'guianza');
    }

    // Calcula la fecha mínima para el calendario según la categoría actual
    public function getFechaMinima(): string
    {
        $tipo = Str::slug($this->nombreCategoria ?? '', ' ');
        
        if (str_contains($tipo, 'paquete')) {
            // Si es paquete, suma 3 días a la fecha actual
            return now()->addDays(3)->toDateString();
        }

        // Si no es paquete, todos los demás servicios bloquean hoy y mañana (suma 2 días)
        return now()->addDays(2)->toDateString();
    }

    public function buscar(): void
    {
        $fechaMinimaPermitida = $this->getFechaMinima();

        $reglas = [
            // Validamos contra la fecha mínima calculada para que no puedan forzar fechas pasadas
            'fecha' => 'required|date|after_or_equal:' . $fechaMinimaPermitida,
        ];

        if ($this->requiereFechaFin()) {
            $reglas['fechaFin'] = 'required|date|after_or_equal:fecha';
        }

        $this->validate($reglas);

        $fechaFinCalculada = $this->requiereFechaFin() ? $this->fechaFin : $this->fecha;

        // Emitimos la búsqueda sin el filtro de personas
        $this->dispatch('busqueda-ejecutada', [
            'fecha'    => $this->fecha,
            'fechaFin' => $fechaFinCalculada,
            'personas' => null, 
        ]);
    }

    public function render()
    {
        return view('livewire.emprendimiento.reserva.formulario-reserva');
    }
}