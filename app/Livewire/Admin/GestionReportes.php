<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class GestionReportes extends Component
{
    public $reporte = 'general';

    public function cambiarReporte($reporte)
    {
        $this->reporte = $reporte;
    }

    public function render()
    {
        return view('livewire.admin.gestion-reportes');
    }
}