<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\TipoServicioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Componente Livewire para la selección de tipos de servicio.
 * Maneja estado de UI y delega persistencia al servicio.
 */
#[Layout('layouts.app.sidebar_emprendimiento')]
class SeleccionarTipoServicio extends Component
{
    /**
     * IDs seleccionados (binding con la vista).
     */
    public array $seleccionados = []; 

    /**
     * Inicializa selección desde la relación pivot.
     */
    public function mount(): void
    {
        $user = Auth::user();

        // Valida usuario y emprendimiento
        if (!$user || !$user->emprendimiento) {
            abort(403, 'Acceso denegado. No tienes un emprendimiento asignado.');
        }

        $this->seleccionados = $user->emprendimiento->tiposServicios()
            ->wherePivot('estado', true)
            ->pluck('tipo_servicios.id')
            ->toArray();
    }

    /**
     * Renderiza la vista con el catálogo.
     */
    public function render(TipoServicioService $service)
    {
        return view('livewire.emprendimiento.seleccionar-tipo-servicio', [
            'catalogos' => $service->obtenerCatalogo()
        ]);
    }

    /**
     * Valida entrada y sincroniza selección.
     */
    public function guardarSeleccion(array $seleccionados, TipoServicioService $service)
    {
        $this->seleccionados = array_values(array_unique(array_map('intval', $seleccionados)));

        $this->ejecutarValidacion();

        try {
            $emprendimiento = Auth::user()?->emprendimiento;

            if (!$emprendimiento) {
                abort(403, 'Acceso denegado. No tienes un emprendimiento asignado.');
            }

            /** @var \App\Models\Emprendimiento $emprendimiento */
            // Persistencia delegada al servicio
            $service->sincronizarTipos($emprendimiento, $this->seleccionados);

            session()->flash('notify', [
                'type' => 'success', 
                'title' => '¡Excelente!', 
                'message' => 'Tus servicios han sido configurados.'
            ]);
            
            return redirect()->route('emprendimiento.servicios.index');

        } catch (\Exception $e) {
            Log::error('Error de persistencia en TipoServicio: ' . $e->getMessage());
            
            session()->flash('notify', [
                'type' => 'danger', 
                'title' => 'Error', 
                'message' => 'Ocurrió un problema interno. Intenta más tarde.'
            ]);
        }
    }

    /**
     * Reglas de validación.
     */
    private function ejecutarValidacion(): void
    {
        $this->validate([
            'seleccionados'   => ['required', 'array', 'min:1'],
            'seleccionados.*' => ['integer', 'exists:tipo_servicios,id'],
        ], [
            'seleccionados.required' => 'Por favor selecciona al menos un servicio.',
            'seleccionados.*.exists' => 'Uno de los servicios seleccionados no es válido.',
        ]);
    }
}
