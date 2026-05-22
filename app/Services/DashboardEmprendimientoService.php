<?php

namespace App\Services;

use App\Models\Reserva;
use App\Models\ReservaDetalle;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class DashboardEmprendimientoService
{
    public function obtenerMetricas(int $emprendimientoId, string $periodo = 'este_mes'): array
    {
        $fechas = $this->obtenerRangoFechas($periodo);

        $baseQuery = Reserva::whereHas('detalles.servicio.categoriaPivot', function ($q) use ($emprendimientoId) {
                $q->where('emprendimiento_id', $emprendimientoId);
            })
            ->whereBetween('created_at', [$fechas['inicio'], $fechas['fin']]);

        return [
            'pendientes'  => (clone $baseQuery)->where('estado', 'Pendiente')->count(),
            'reagendadas' => (clone $baseQuery)->where('estado', 'Reagendada')->count(),
            'canceladas'  => (clone $baseQuery)->whereIn('estado', ['Cancelada', 'Rechazada'])->count(),
            'confirmadas' => (clone $baseQuery)->where('estado', 'Confirmada')->count(),
            'completadas' => (clone $baseQuery)->where('estado', 'Completada')->count(),
        ];
    }

    public function obtenerAgendaHoy(int $emprendimientoId, string $search = ''): Collection
    {
        $hoy = Carbon::today();

        $query = ReservaDetalle::with(['reserva.turista', 'servicio.tipoServicio'])
            ->whereHas('servicio.categoriaPivot', function ($q) use ($emprendimientoId) {
                $q->where('emprendimiento_id', $emprendimientoId);
            })
            ->whereHas('reserva', function ($q) {
                $q->whereIn('estado', ['Confirmada', 'Reagendada']);
            })
            ->whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy);

        if ($search !== '') {
            $query->whereHas('reserva.turista', function($q) use ($search) {
                $q->where('nombres', 'like', '%' . $search . '%')
                  ->orWhere('apellidos', 'like', '%' . $search . '%')
                  ->orWhere('identificacion', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('hora_llegada', 'asc')->get();
    }

    private function obtenerRangoFechas(string $periodo): array
    {
        return match ($periodo) {
            'hoy'         => ['inicio' => Carbon::today(), 'fin' => Carbon::today()->endOfDay()],
            'esta_semana' => ['inicio' => Carbon::now()->startOfWeek(), 'fin' => Carbon::now()->endOfWeek()],
            'este_mes'    => ['inicio' => Carbon::now()->startOfMonth(), 'fin' => Carbon::now()->endOfMonth()],
            default       => ['inicio' => Carbon::now()->startOfMonth(), 'fin' => Carbon::now()->endOfMonth()],
        };
    }
}