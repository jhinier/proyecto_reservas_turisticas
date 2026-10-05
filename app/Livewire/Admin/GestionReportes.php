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

    /**
     * Cambiar el tipo de reporte seleccionado.
     */
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

    /**
     * Renderizar la vista.
     */
    public function render()
    {
        return view('livewire.admin.gestion-reportes', [
            'usuarios' => User::count(),

            'emprendimientos' => Emprendimiento::count(),

            'festividades' => Festividad::count(),

            'sitios' => SitioTuristico::count(),

            'actividades' => ActividadTuristica::count(),

            'fecha' => Carbon::now(),
        ]);
    }
}