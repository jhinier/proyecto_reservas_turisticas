<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\TipoServicioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Controlador Livewire para gestionar la relación N:M de Servicios (Capa de Presentación).
 */
#[Layout('layouts.app.sidebar_emprendimiento')]
class SeleccionarTipoServicio extends Component
{
    /**
     * @var array $seleccionados IDs de los servicios seleccionados (Data Binding reactivo).
     */
    public array $seleccionados = []; 

    /**
     * Hook de inicialización: Valida sesión y precarga los IDs activos desde la tabla pivot.
     */
    public function mount()
    {
        $user = Auth::user();

        // Carga ansiosa (Eager Loading) de los IDs filtrando por estado = true.
        $this->seleccionados = $user->emprendimiento->tiposServicios()
            ->wherePivot('estado', true)
            ->pluck('tipo_servicios.id')
            ->toArray();
    }

    /**
     * Renderiza la vista Blade inyectando los catálogos desde el Servicio (DI).
     */
    public function render(TipoServicioService $service)
    {
        return view('livewire.emprendimiento.seleccionar-tipo-servicio', [
            'catalogos' => $service->obtenerCatalogos()
        ]);
    }

    /**
     * Action: Valida el Request y delega la persistencia al Servicio (Cumple SRP).
     */
    public function guardarSeleccion(TipoServicioService $service)
    {
        // Validación estricta: Verifica que sea un array y los IDs existan en BD.
        $this->validate([
            'seleccionados'   => ['required', 'array', 'min:1'],
            'seleccionados.*' => ['integer', 'exists:tipo_servicios,id'],
        ], [
            'seleccionados.required' => 'Por favor selecciona al menos un servicio.',
            'seleccionados.*.exists' => 'Uno de los servicios seleccionados no es válido.',
        ]);

        try {
            $emprendimiento = Auth::user()->emprendimiento; 

            // Ejecuta la sincronización transaccional en la capa de negocio.
            $service->guardarTiposSeleccionados($emprendimiento, $this->seleccionados);

            // Mensaje de éxito
            session()->flash('notify', ['type' => 'success', 'title' => '¡Excelente!', 'message' => 'Tus servicios han sido configurados.']);
            
            // 🔥 CORRECCIÓN AQUÍ: Redirigimos al Gestor de Servicios (index) en lugar de la pantalla de selección
            return redirect()->route('emprendimiento.servicios.index');

        } catch (\Exception $e) {
            // Loguea la excepción interna y retorna un mensaje seguro al frontend.
            Log::error('Error de persistencia en TipoServicio: ' . $e->getMessage());
            session()->flash('notify', ['type' => 'danger', 'title' => 'Error', 'message' => 'Ocurrió un problema interno. Intenta más tarde.']);
        }
    }
}