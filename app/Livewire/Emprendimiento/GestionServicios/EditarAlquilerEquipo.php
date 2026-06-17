<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Servicio;
use App\Services\AlquilerEquipoService;
use App\Rules\NoHtmlTags;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EditarAlquilerEquipo extends Component
{
    public bool $abierto = false;
    public int $servicioId;
    public string $nombre = '';
    public string $descripcion = '';
    public float|int|string|null $precio = null;
    public int|string|null $stock = null;

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'min:3', 'max:255', new NoHtmlTags()],
            'descripcion' => ['required', 'string', 'min:5', 'max:1000', new NoHtmlTags()],
            'precio' => 'required|numeric|min:0.01|max:1000|regex:/^\d+(\.\d{1,2})?$/',
            'stock' => 'required|integer|min:1|max:1000',
        ];
    }

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
        // Verificar rol de seguridad
        $user = Auth::user();
        if (!$user instanceof User || !$user->hasRole('emprendimiento')) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'No tienes permiso para realizar esta acción.']);
            return;
        }

        $this->validate();
        
        try {
            $service->actualizar($this->servicioId, [
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio' => $this->precio,
                'stock' => $this->stock,
            ]);

            $this->dispatch('servicio-actualizado');
            $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Equipo actualizado con éxito.']);
            $this->abierto = false;
        } catch (\Exception $e) {
            Log::error("Error al actualizar Alquiler: " . $e->getMessage());
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Ocurrió un error al guardar.']);
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.editar-alquiler-equipo');
    }
}