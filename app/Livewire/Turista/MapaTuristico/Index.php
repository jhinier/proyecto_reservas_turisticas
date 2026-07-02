<?php

namespace App\Livewire\Turista\MapaTuristico;

use Livewire\Component;

class Index extends Component
{
    public $lugares = [];

    public function mount()
    {
        $ruta = storage_path('app/public/mapa/lugares.json');

        if (file_exists($ruta)) {
            $this->lugares = json_decode(file_get_contents($ruta), true);
        }
    }

    public function render()
    {
        return view('livewire.turista.MapaTuristico.index')->layout('layouts.turista');
    }
}