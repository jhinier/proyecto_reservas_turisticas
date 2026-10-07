<?php

namespace App\Http\Controllers\Emprendimiento;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use App\Models\TipoServicio;
use App\Services\ReservaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReporteEmprendedorController extends Controller
{
    public function descargarReporte(Request $request)
    {
        $desde = $request->query('desde') ?: now()->startOfMonth()->format('Y-m-d');
        $hasta = $request->query('hasta') ?: now()->format('Y-m-d');
        $categoria = $request->query('categoria');
        $estado = $request->query('estado');
        $cedula = $request->query('cedula');
        $tipoReporte = $request->query('tipo_reporte', 'todo');

        $user = Auth::user();
        $emprendimiento = $user->emprendimiento;

        // Consulta de agenda
        $servicios = app(ReservaService::class)->obtenerAgendaPorRangoYFiltros(
            $emprendimiento->id,
            $desde,
            $hasta,
            $categoria,
            $estado,
            $cedula
        );

        $reservas = $servicios->map(function ($item) {
            return $item->reserva;
        })->unique('id');

        $totalRecaudado = $reservas->whereIn('estado', ['Confirmada', 'Completada'])->sum('precio_total');
        $totalCanceladas = $reservas->whereIn('estado', ['Cancelada', 'Rechazada'])->count();
        $totalPendientes = $reservas->where('estado', 'Pendiente')->count();
        $totalConfirmadas = $reservas->whereIn('estado', ['Confirmada', 'Completada'])->count();
        $totalReservas = $reservas->count();

        $nombreCatFiltro = 'Todas';
        if (! empty($categoria)) {
            $cat = TipoServicio::find($categoria);
            $nombreCatFiltro = $cat ? $cat->nombre : 'Todas';
        }

        // Consulta de inventario agrupada por categoría
        $serviciosInventario = Servicio::with('tipoServicio')
            ->whereHas('categoriaPivot', function ($q) use ($emprendimiento) {
                $q->where('emprendimiento_id', $emprendimiento->id);
            })->get()->groupBy(function ($s) {
                return $s->tipoServicio->nombre ?? 'Otros';
            });

        $fechaDesdeFormato = Carbon::parse($desde)->format('Ymd');
        $fechaHastaFormato = Carbon::parse($hasta)->format('Ymd');
        $nombreArchivo = "Reporte_{$tipoReporte}_{$fechaDesdeFormato}_{$fechaHastaFormato}.pdf";

        $pdf = Pdf::loadView('pdf.reporte-reservas', [
            'servicios' => $servicios,
            'reservas' => $reservas,
            'serviciosInventario' => $serviciosInventario,
            'tipoReporte' => $tipoReporte,
            'desde' => $desde,
            'hasta' => $hasta,
            'emprendimientoNombre' => $emprendimiento->nombre ?? 'Mi Emprendimiento',
            'usuarioGenerador' => $user->name,
            'emailGenerador' => $user->email,
            'filtroCategoria' => $nombreCatFiltro,
            'filtroEstado' => $estado ?: 'Todos',
            'filtroCedula' => $cedula ?: 'Todos',
            'analisis' => [
                'recaudado' => $totalRecaudado,
                'canceladas' => $totalCanceladas,
                'pendientes' => $totalPendientes,
                'confirmadas' => $totalConfirmadas,
                'total' => $totalReservas,
            ],
        ]);

        return $pdf->stream($nombreArchivo);
    }
}
