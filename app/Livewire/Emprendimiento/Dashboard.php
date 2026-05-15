<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Services\DashboardEmprendimientoService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app.sidebar_emprendimiento')] 
class Dashboard extends Component
{
    public string $periodoFiltro = 'este_mes';

    public function updatedPeriodoFiltro()
    {
        unset($this->metricas);
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

    public function render()
    {
        return view('livewire.emprendimiento.dashboard');
    }
}