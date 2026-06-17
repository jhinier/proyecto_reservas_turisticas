<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Emprendimiento;
use App\Models\SitioTuristico;
use App\Models\ActividadTuristica;
use App\Models\Festividad;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $emprendimientosCount = 0;
    public $lugaresCount = 0;
    public $actividadesCount = 0;
    public $festividadesCount = 0;

    public $eventosProximos = [];
    public $eventosHoy = [];
    public $eventosPasados = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->emprendimientosCount = Emprendimiento::count();
        $this->lugaresCount = SitioTuristico::count();
        $this->actividadesCount = ActividadTuristica::count();
        $this->festividadesCount = Festividad::count();

        // 🔥 EVENTOS PRO
        $this->eventosHoy = Festividad::whereDate('fecha_inicio', '<=', Carbon::today())
            ->whereDate('fecha_fin', '>=', Carbon::today())
            ->orderBy('fecha_inicio')
            ->get();

        $this->eventosProximos = Festividad::where('fecha_inicio', '>', Carbon::today())
            ->orderBy('fecha_inicio')
            ->take(5)
            ->get();

        $this->eventosPasados = Festividad::where('fecha_fin', '<', Carbon::today())
            ->orderBy('fecha_inicio', 'desc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}