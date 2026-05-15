<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Servicio;
use App\Services\GuianzaService;
use Illuminate\Support\Facades\Auth;

class EditarGuianza extends Component
{
    public bool $abierto = false;
    public int $servicioId;

    public string $nombre = '';
    public string $descripcion = '';
    public $precio;
    public $stock;
    public $numero_max_persona;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|max:150',
            'descripcion' => 'required|string|max:300',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'numero_max_persona' => 'required|integer|min:1',
        ];
    }

    #[On('abrir-editar-guianza')]
    public function cargarDatos(int $id)
    {
        $this->servicioId = $id;
        $servicio = Servicio::with('detalleGuianza')->findOrFail($id);
        
        $this->nombre = $servicio->nombre;
        $this->descripcion = $servicio->descripcion;
        $this->precio = $servicio->precio;
        $this->stock = $servicio->stock;

        if ($servicio->detalleGuianza) {
            $this->numero_max_persona = $servicio->detalleGuianza->numero_max_persona;
        }

        $this->resetValidation();
        $this->abierto = true;
    }

    public function actualizar(GuianzaService $service)
    {
        $this->validate();
        $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
        $datosDetalle = ['numero_max_persona' => $this->numero_max_persona];

        $service->actualizar($this->servicioId, $datosBase, $datosDetalle);

        $this->dispatch('servicio-actualizado');
        $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Guianza actualizada con éxito.']);
        $this->abierto = false;
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.editar-guianza');
    }
}