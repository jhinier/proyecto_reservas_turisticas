<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Servicio;
use App\Services\GuianzaService;
use App\Rules\NoHtmlTags;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EditarGuianza extends Component
{
    public bool $abierto = false;
    public int $servicioId;

    public string $nombre = '';
    public string $descripcion = '';
    public float|int|null $precio = null;
    public int $stock = 0;
    public int $numero_max_persona = 1;

    protected function rules()
    {
        return [
            'nombre' => ['required', 'string', 'max:150', new NoHtmlTags()],
            'descripcion' => ['required', 'string', 'max:1000', new NoHtmlTags()],
            'precio' => 'required|numeric|min:0.01|max:1000|regex:/^\d+(\.\d{1,2})?$/',
            'stock' => 'required|integer|min:1|max:1000',
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
        // Verificar rol de seguridad
        $user = Auth::user();
        if (!$user instanceof User || !$user->hasRole('emprendimiento')) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'No tienes permiso para realizar esta acción.']);
            return;
        }

        $this->validate();
        $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
        $datosDetalle = ['numero_max_persona' => $this->numero_max_persona];

        try {
            $service->actualizar($this->servicioId, $datosBase, $datosDetalle);

            $this->dispatch('servicio-actualizado');
            $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Guianza actualizada con éxito.']);
            $this->abierto = false;
        } catch (\Exception $e) {
            Log::error("Error al actualizar Guianza: " . $e->getMessage());
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Ocurrió un error al guardar.']);
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.editar-guianza');
    }
}