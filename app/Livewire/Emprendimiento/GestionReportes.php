<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use App\Models\TipoServicio;
use App\Models\Servicio;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use App\Services\ReservaService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app.sidebar_emprendimiento')]
class GestionReportes extends Component
{
    #[Url] public ?string $fechaDesde = null;
    #[Url] public ?string $fechaHasta = null;
    #[Url] public ?string $categoria_id = null;
    #[Url] public ?string $estado = null;
    #[Url] public ?string $nombreServicio = null;
    
    #[Url] public ?string $cedula = null;
    #[Url] public string $tipoReporte = 'todo';

    public function mount()
    {
        $this->fechaDesde = $this->fechaDesde ?? now()->startOfMonth()->format('Y-m-d');
        $this->fechaHasta = $this->fechaHasta ?? now()->format('Y-m-d');
    }

    public function limpiarFiltros()
    {
        $this->fechaDesde = now()->startOfMonth()->format('Y-m-d');
        $this->fechaHasta = now()->format('Y-m-d');
        $this->categoria_id = null;
        $this->estado = null;
        $this->nombreServicio = null;
        $this->cedula = null;
        $this->tipoReporte = 'todo';
    }

    public function render(ReservaService $reservaService) 
    {
        $emprendimientoId = Auth::user()->emprendimiento->id;

        $servicios = $reservaService->obtenerAgendaPorRangoYFiltros(
            $emprendimientoId, 
            $this->fechaDesde, 
            $this->fechaHasta, 
            $this->categoria_id,
            $this->estado,
            $this->cedula
        );

        if (!empty($this->nombreServicio)) {
            $servicios = $servicios->filter(function($item) {
                return stripos($item->servicio->nombre, $this->nombreServicio) !== false;
            });
        }

        $reservas = $servicios->map(function($item) {
            return $item->reserva;
        })->unique('id');

        $totalRecaudado = $reservas->whereIn('estado', ['Confirmada', 'Completada'])->sum('precio_total');
        // AQUI SEPARAMOS CONFIRMADAS DE COMPLETADAS
        $totalConfirmadas = $reservas->where('estado', 'Confirmada')->count();
        $totalCompletadas = $reservas->where('estado', 'Completada')->count();
        $totalPendientes = $reservas->where('estado', 'Pendiente')->count();
        $totalCanceladas = $reservas->whereIn('estado', ['Cancelada', 'Rechazada'])->count();

        $serviciosInventario = Servicio::with('tipoServicio')
            ->whereHas('categoriaPivot', function($q) use($emprendimientoId) {
                $q->where('emprendimiento_id', $emprendimientoId);
            })->get()->groupBy(function($s) {
                return $s->tipoServicio->nombre ?? 'Otros';
            });

        return view('livewire.emprendimiento.gestion-reportes', [
            'categorias' => TipoServicio::all(),
            'estados' => ['Confirmada', 'Pendiente', 'Completada', 'Cancelada'],
            'servicios' => $servicios,
            'serviciosInventario' => $serviciosInventario,
            'totales' => [
                'recaudado' => $totalRecaudado,
                'confirmadas' => $totalConfirmadas,
                'completadas' => $totalCompletadas,
                'pendientes' => $totalPendientes,
                'canceladas' => $totalCanceladas,
                'total' => $reservas->count()
            ]
        ]);
    }
}