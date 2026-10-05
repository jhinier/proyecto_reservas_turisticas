<?php

use App\Livewire\Emprendimiento\Reserva\FormularioReserva;
use Carbon\Carbon;

it('evita domingos y lunes como fecha mínima para paquetes turísticos', function () {
    $component = new FormularioReserva();
    $component->nombreCategoria = 'Paquetes Turísticos';

    $fechaMinima = Carbon::parse($component->getFechaMinima());

    expect($fechaMinima->dayOfWeek)
        ->not->toBeIn([Carbon::SUNDAY, Carbon::MONDAY]);
});
