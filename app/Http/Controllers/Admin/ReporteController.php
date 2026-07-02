<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Emprendimiento;
use App\Models\SitioTuristico;
use App\Models\ActividadTuristica;
use App\Models\Festividad;

class ReporteController extends Controller
{
    /**
     * Reporte General del Sistema
     */
    public function general()
    {
        $datos = [
            'usuarios' => User::count(),
            'emprendimientos' => Emprendimiento::count(),
            'sitios' => SitioTuristico::count(),
            'actividades' => ActividadTuristica::count(),
            'festividades' => Festividad::count(),
            'fecha' => Carbon::now(),
        ];

        $pdf = Pdf::loadView('reportes.general', $datos);

        return $pdf->download('Reporte-General.pdf');
    }
}