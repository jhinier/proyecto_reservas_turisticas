<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Servicio;
use App\Services\AlquilerEquipoService;

class EditarAlquilerEquipo extends Component
{
    public bool $abierto = false;
    public int $servicioId;
    public string $nombre = '';
    public string $descripcion = '';
    public float|int|string|null $precio = null;
    public int|string|null $stock = null;

    protected $rules = [
        'nombre' => 'required|string|max:150',
        'descripcion' => 'required|string|max:300',
        'precio' => 'required|numeric|min:0.01',
        'stock' => 'required|integer|min:0',
    ];

    // 🔥 CAMBIO AQUÍ: Debe ser igual al nombre que pusiste en el mapa de ListaServicios
    #[On('abrir-editar-alquiler-equipo')] 
    public function cargarDatos(int $id)
    {
        $this->servicioId = $id;
        $servicio = Servicio::findOrFail($id);
        
        $this->nombre = $servicio->nombre;
        $this->descripcion = $servicio->descripcion;
        $this->precio = $servicio->precio;
        $this->stock = $servicio->stock;

        $this->resetValidation();
        $this->abierto = true;
    }

    public function actualizar(AlquilerEquipoService $service)
    {
        $this->validate();
        
        $service->actualizar($this->servicioId, [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'stock' => $this->stock,
        ]);

        $this->dispatch('servicio-actualizado');
        $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Equipo actualizado con éxito.']);
        $this->abierto = false;
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.editar-alquiler-equipo');
    }
}