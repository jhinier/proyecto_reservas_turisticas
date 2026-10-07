<?php

namespace App\Services;

use App\Models\Reserva;
use App\Models\ReservaDetalle;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardEmprendimientoService
{
    public function obtenerMetricas(int $emprendimientoId): array
    {
        $baseQuery = Reserva::whereHas('detalles.servicio.categoriaPivot', function ($q) use ($emprendimientoId) {
            $q->where('emprendimiento_id', $emprendimientoId);
        });

        return [
            'confirmadas' => (clone $baseQuery)->where('estado', 'Confirmada')->count(),
            'pendientes' => (clone $baseQuery)->where('estado', 'Pendiente')->count(),
            'en_revision_comprobantes' => (clone $baseQuery)->where('estado', 'Pago en revisión')->count(),
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
            $query->whereHas('reserva.turista', function ($q) use ($search) {
                $q->where('nombres', 'like', '%' . $search . '%')
                  ->orWhere('apellidos', 'like', '%' . $search . '%')
                  ->orWhere('identificacion', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('hora_llegada', 'asc')->get();
    }

    public function obtenerServicioMasVendido(int $emprendimientoId)
    {
        return ReservaDetalle::with('servicio.tipoServicio')
            ->whereHas('servicio.categoriaPivot', function ($q) use ($emprendimientoId) {
                $q->where('emprendimiento_id', $emprendimientoId);
            })
            ->whereHas('reserva', function ($q) {
                $q->whereIn('estado', ['Confirmada', 'Pendiente', 'Pago en revisión', 'Completada']);
            })
            ->select('servicio_id', DB::raw('count(*) as total_ventas'))
            ->groupBy('servicio_id')
            ->orderByDesc('total_ventas')
            ->first();
    }
}
