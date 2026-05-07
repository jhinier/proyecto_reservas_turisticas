<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Livewire\Component;
use Livewire\Attributes\Reactive;

class CarritoReserva extends Component
{
    #[Reactive]
    public array $items = [];

    #[Reactive]
    public int $pasoActual = 1;

    public function eliminar(int $index): void
    {
        $this->dispatch('quitar-del-carrito', index: $index);
    }

    public function render()
    {
        return view('livewire.emprendimiento.reserva.carrito-reserva');
    }
}
