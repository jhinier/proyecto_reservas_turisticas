<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Festividad;
use App\Models\SitioTuristico;
use App\Models\ActividadTuristica;
use App\Models\Emprendimiento;
use Carbon\Carbon;

class GestionReportes extends Component
{
    public $reporte = 'general';

    public function cambiarReporte($reporte)
    {
        $reportesPermitidos = [
            'general',
            'festividades',
            'sitios',
            'actividades',
            'emprendimientos',
        ];

        if (in_array($reporte, $reportesPermitidos)) {
            $this->reporte = $reporte;
        }
    }

    public function generarPDF()
    {
        return redirect()->route(
            'admin.reportes.pdf',
            ['tipo' => $this->reporte]
        );
    }

    public function render()
    {
        return view('livewire.admin.gestion-reportes', [

            // Totales
            'usuarios' => User::count(),

            'emprendimientos' => Emprendimiento::count(),

            'festividades' => Festividad::count(),

            'sitios' => SitioTuristico::count(),

            'actividades' => ActividadTuristica::count(),

            // Registros completos para la vista previa
            'listaFestividades' => Festividad::with('publicacion')
                ->latest()
                ->get(),

            'listaSitios' => SitioTuristico::with('publicacion')
                ->latest()
                ->get(),

            'listaActividades' => ActividadTuristica::with('publicacion')
                ->latest()
                ->get(),

            'listaEmprendimientos' => Emprendimiento::with([
                'user',
                'tiposServicios'
            ])
                ->latest()
                ->get(),

            'fecha' => Carbon::now(),
        ]);
    }
}