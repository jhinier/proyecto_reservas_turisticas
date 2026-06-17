<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout; 
use App\Services\AlimentacionService;
use App\Rules\NoHtmlTags;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app.sidebar_emprendimiento')] 
class CrearAlimentacion extends Component
{
    public int $pivotId;
    public string $nombre = '';
    public string $descripcion = '';
    public float|int|null $precio = null;
    public string $tipo_alimentacion = '';
    public string $lugar_alimentacion = '';

    public function mount(int $pivotId): void
    {
        $this->pivotId = $pivotId;
    }

    protected function rules()
    {
        return [
            'nombre'             => ['required', 'string', 'min:3', 'max:100', new NoHtmlTags()],
            'descripcion'        => ['required', 'string', 'min:5', 'max:300', new NoHtmlTags()],
            'precio'             => 'required|numeric|min:0.01|max:100|regex:/^\d+(\.\d{1,2})?$/',
            'tipo_alimentacion'  => ['required', 'string', 'max:100', new NoHtmlTags()],
            'lugar_alimentacion' => ['required', 'string', 'max:150', new NoHtmlTags()],
        ];
    }

    public function guardar(AlimentacionService $service)
    {
        // Verificar rol de seguridad
        $user = Auth::user();
        if (!$user instanceof User || !$user->hasRole('emprendimiento')) {
            session()->flash('error', 'No tienes permiso para realizar esta acción.');
            return;
        }

        $this->validate();

        try {
            // Agregamos stock automáticamente a 999 para permitir reservas ilimitadas
            $datosBase = $this->only(['nombre', 'descripcion', 'precio']);
            $datosBase['stock'] = 500;
            
            $datosDetalle = $this->only(['tipo_alimentacion', 'lugar_alimentacion']);

            // 1. Guardamos el servicio
            $service->crear($this->pivotId, $datosBase, $datosDetalle);

            // 2. Preparamos el mensaje de éxito
            session()->flash('success', '¡Registro exitoso! El plato/servicio ha sido creado.');
            
            // 3. Guardamos el ID temporalmente para que el reset no lo borre
            $tabDestino = $this->pivotId;
            
            // 4. Limpiamos las variables (Opcional, pero buena práctica)
            $this->reset(); 

            // 5. Redirigimos usando la variable temporal
            return redirect()->route('emprendimiento.servicios.index', ['tab' => $tabDestino]);

        } catch (\Exception $e) {
            Log::error("Error en Alimentación: " . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al guardar.');
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.crear-alimentacion');
    }
}
