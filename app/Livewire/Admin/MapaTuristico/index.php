<?php
namespace App\Livewire\Admin\MapaTuristico;

use Livewire\Component;

class Index extends Component
{
    public $lugares = [];

    public function mount()
    {
        $this->cargarLugares();
    }

    public function cargarLugares()
    {
        // si aún no tienes BD, puedes usar JSON o array temporal
        $this->lugares = [];
    }

    public function guardarLugar($data)
    {
        $nuevo = [
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'tipo' => $data['tipo'],
            'imagen' => $data['imagen'],
            'lat' => $data['lat'],
            'lng' => $data['lng'],
        ];

        $this->lugares[] = $nuevo;

        // 🔥 aquí notificas al frontend
        $this->dispatch('recargarMapa', lugares: $this->lugares);
    }

    public function render()
    {
        return view('livewire.admin.MapaTuristico.index');
    }
}