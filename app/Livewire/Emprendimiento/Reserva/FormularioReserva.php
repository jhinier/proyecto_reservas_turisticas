<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Carbon\Carbon;
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

    public function esPaquete(): bool
    {
        $tipo = Str::slug($this->nombreCategoria ?? '', ' ');

        return str_contains($tipo, 'paquete');
    }

    public function esDiaBloqueado(string $fecha): bool
    {
        $dia = Carbon::parse($fecha)->dayOfWeek;

        return $this->esPaquete() && in_array($dia, [Carbon::SUNDAY, Carbon::MONDAY], true);
    }

    // Calcula la fecha mínima para el calendario según la categoría actual
    public function getFechaMinima(): string
    {
        $diasAnticipacion = 3;
        $fecha = now()->copy()->addDays($diasAnticipacion);

        if ($this->esPaquete()) {
            while ($this->esDiaBloqueado($fecha->toDateString())) {
                $fecha->addDay();
            }
        }

        return $fecha->toDateString();
    }

    public function buscar(): void
    {
        $fechaMinimaPermitida = $this->getFechaMinima();

        $reglas = [
            'fecha' => ['required', 'date', 'after_or_equal:' . $fechaMinimaPermitida, function ($attribute, $value, $fail) {
                if ($this->esPaquete() && $this->esDiaBloqueado($value)) {
                    $fail('Los paquetes turísticos no pueden reservarse los domingos ni los lunes.');
                }
            }],
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
