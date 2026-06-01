<?php

namespace App\Http\Controllers\Emprendimiento;

use App\Http\Controllers\Controller; // Asegúrate de importar el Controller base
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\ReservaService;
use Illuminate\Support\Facades\Auth;

class ReporteEmprendedorController extends Controller
{
    public function descargarReporte(Request $request)
    {
        // Obtener filtros desde la URL
        $desde = $request->query('desde', now()->format('Y-m-d'));
        $hasta = $request->query('hasta', now()->format('Y-m-d'));
        $categoria = $request->query('categoria');

        // Llamar a tu servicio
        $emprendimientoId = Auth::user()->emprendimiento->id;
        $servicios = app(ReservaService::class)->obtenerAgendaPorRangoYFiltros(
            $emprendimientoId, 
            $desde, 
            $hasta, 
            $categoria
        );

        // Generar PDF
        $pdf = Pdf::loadView('pdf.reporte-reservas', [
            'servicios' => $servicios,
            'desde' => $desde,
            'hasta' => $hasta
        ]);

        return $pdf->stream('reporte_emprendedor.pdf');
    }
}