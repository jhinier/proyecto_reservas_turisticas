<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Servicio;
use App\Services\AlimentacionService;
use App\Rules\NoHtmlTags;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EditarAlimentacion extends Component
{
    public bool $abierto = false;
    public int $servicioId;

    public string $nombre = '';
    public string $descripcion = '';
    public float|int|string|null $precio = null;
    
    // Nombres exactos de tu migración:
    public string $tipo_alimentacion = '';
    public string $lugar_alimentacion = '';

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:150', new NoHtmlTags()],
            'descripcion' => ['required', 'string', 'max:300', new NoHtmlTags()],
            'precio' => 'required|numeric|min:0.01|max:100|regex:/^\d+(\.\d{1,2})?$/',
            'tipo_alimentacion' => ['required', 'string', 'max:100', new NoHtmlTags()],
            'lugar_alimentacion' => ['required', 'string', 'max:150', new NoHtmlTags()],
        ];
    }

    #[On('abrir-editar-alimentacion')]
    public function cargarDatos(int $id)
    {
        $this->servicioId = $id;
        
        // Usamos la relación definida en tu modelo Servicio
        $servicio = Servicio::with('detalleAlimentacion')->findOrFail($id);
        
        $this->nombre = $servicio->nombre;
        $this->descripcion = $servicio->descripcion;
        $this->precio = $servicio->precio;

        if ($servicio->detalleAlimentacion) {
            $this->tipo_alimentacion = $servicio->detalleAlimentacion->tipo_alimentacion;
            $this->lugar_alimentacion = $servicio->detalleAlimentacion->lugar_alimentacion;
        }

        $this->resetValidation();
        $this->abierto = true; 
    }

    public function actualizar(AlimentacionService $service)
    {
        // Verificar rol de seguridad
        $user = Auth::user();
        if (!$user instanceof User || !$user->hasRole('emprendimiento')) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'No tienes permiso para realizar esta acción.']);
            return;
        }

        $this->validate();

        try {
            // No actualizamos stock para alimentación (se mantiene en 999)
            $datosBase = $this->only(['nombre', 'descripcion', 'precio']);
            $datosDetalle = $this->only(['tipo_alimentacion', 'lugar_alimentacion']);

            $service->actualizar($this->servicioId, $datosBase, $datosDetalle);

            $this->dispatch('servicio-actualizado');
            $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Servicio de alimentación actualizado.']);
            $this->abierto = false;

        } catch (\Exception $e) {
            Log::error("Error en EditarAlimentacion: " . $e->getMessage());
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Error al guardar los cambios.']);
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.editar-alimentacion');
    }
}
