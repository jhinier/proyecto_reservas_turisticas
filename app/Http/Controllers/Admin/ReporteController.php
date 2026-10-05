<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Festividad;
use App\Models\SitioTuristico;
use App\Models\ActividadTuristica;
use App\Models\Emprendimiento;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    public function generarPDF($tipo)
    {
        $fecha = Carbon::now();

        switch ($tipo) {

           case 'general':

               $festividades = Festividad::with('publicacion')
                   ->latest()
                   ->get();
                    
               $sitios = SitioTuristico::with('publicacion')
                   ->latest()
                   ->get();
                    
               $actividades = ActividadTuristica::with('publicacion')
                   ->latest()
                   ->get();
                    
               $emprendimientos = Emprendimiento::with([
                   'user',
                   'tiposServicios'
               ])
                   ->latest()
                   ->get();
                    
               $datos = [
                   'fecha' => $fecha,
                    
                   // Totales
                   'usuarios' => User::count(),
                   'totalFestividades' => $festividades->count(),
                   'totalSitios' => $sitios->count(),
                   'totalActividades' => $actividades->count(),
                   'totalEmprendimientos' => $emprendimientos->count(),
                    
                   // Registros completos
                   'festividades' => $festividades,
                   'sitios' => $sitios,
                   'actividades' => $actividades,
                   'emprendimientos' => $emprendimientos,
               ];
                    
               $pdf = Pdf::loadView(
                   'Admin.reportes.general',
                   $datos
               );
                    
               return $pdf->download(
                   'reporte-general-' . $fecha->format('Y-m-d') . '.pdf'
               );


            case 'festividades':

                $registros = Festividad::with('publicacion')
                    ->latest()
                    ->get();

                $pdf = Pdf::loadView(
                    'Admin.reportes.detallado',
                    [
                        'fecha' => $fecha,
                        'titulo' => 'REPORTE DE FESTIVIDADES',
                        'modulo' => 'Festividades',
                        'tipo' => 'festividades',
                        'registros' => $registros,
                        'total' => $registros->count(),
                    ]
                );

                return $pdf->download(
                    'reporte-festividades-' . $fecha->format('Y-m-d') . '.pdf'
                );


            case 'sitios':

                $registros = SitioTuristico::with('publicacion')
                    ->latest()
                    ->get();

                $pdf = Pdf::loadView(
                    'Admin.reportes.detallado',
                    [
                        'fecha' => $fecha,
                        'titulo' => 'REPORTE DE SITIOS TURÍSTICOS',
                        'modulo' => 'Sitios Turísticos',
                        'tipo' => 'sitios',
                        'registros' => $registros,
                        'total' => $registros->count(),
                    ]
                );

                return $pdf->download(
                    'reporte-sitios-turisticos-' . $fecha->format('Y-m-d') . '.pdf'
                );


            case 'actividades':

                $registros = ActividadTuristica::with('publicacion')
                    ->latest()
                    ->get();

                $pdf = Pdf::loadView(
                    'Admin.reportes.detallado',
                    [
                        'fecha' => $fecha,
                        'titulo' => 'REPORTE DE ACTIVIDADES TURÍSTICAS',
                        'modulo' => 'Actividades Turísticas',
                        'tipo' => 'actividades',
                        'registros' => $registros,
                        'total' => $registros->count(),
                    ]
                );

                return $pdf->download(
                    'reporte-actividades-turisticas-' . $fecha->format('Y-m-d') . '.pdf'
                );


            case 'emprendimientos':

                $registros = Emprendimiento::with([
                    'user',
                    'tiposServicios'
                ])
                    ->latest()
                    ->get();

                $pdf = Pdf::loadView(
                    'Admin.reportes.detallado',
                    [
                        'fecha' => $fecha,
                        'titulo' => 'REPORTE DE EMPRENDIMIENTOS',
                        'modulo' => 'Emprendimientos',
                        'tipo' => 'emprendimientos',
                        'registros' => $registros,
                        'total' => $registros->count(),
                    ]
                );

                return $pdf->download(
                    'reporte-emprendimientos-' . $fecha->format('Y-m-d') . '.pdf'
                );


            default:

                abort(404);
        }
    }
}
