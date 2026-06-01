<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Services\DashboardEmprendimientoService;
use App\Models\TipoServicio;
use App\Models\Servicio;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app.sidebar_emprendimiento')] 
class Dashboard extends Component
{
    // 1. Cambiamos el periodo por defecto a 'hoy'
    public string $periodoFiltro = 'hoy';

    public function updatedPeriodoFiltro()
    {
        unset($this->metricas);
        unset($this->servicioTop);
    }

    #[Computed]
    public function categorias()
    {
        $emprendimientoId = Auth::user()->emprendimiento->id;
        
        return TipoServicio::whereHas('emprendimientos', function ($q) use ($emprendimientoId) {
            $q->where('emprendimientos.id', $emprendimientoId);
            $q->where('emprendimiento_tipo_servicios.estado', 1);
        })->get()->map(function ($tipo) use ($emprendimientoId) {
            $tipo->servicios_count = Servicio::whereHas('categoriaPivot', function ($q) use ($emprendimientoId, $tipo) {
                $q->where('emprendimiento_id', $emprendimientoId)
                  ->where('tipo_servicio_id', $tipo->id);
            })->count();
            
            return $tipo;
        });
    }
    
    #[Computed]
    public function metricas()
    {
        $user = Auth::user();
        return app(DashboardEmprendimientoService::class)->obtenerMetricas($user->emprendimiento->id, $this->periodoFiltro);
    }

    #[Computed]
    public function agendaHoy()
    {
        $user = Auth::user();
        return app(DashboardEmprendimientoService::class)->obtenerAgendaHoy($user->emprendimiento->id);
    }

    // 2. Nueva función para capturar el servicio más vendido
    #[Computed]
    public function servicioTop()
    {
        $user = Auth::user();
        return app(DashboardEmprendimientoService::class)->obtenerServicioMasVendido($user->emprendimiento->id, $this->periodoFiltro);
    }

    public function render()
    {
        return view('livewire.emprendimiento.dashboard');
    }
}