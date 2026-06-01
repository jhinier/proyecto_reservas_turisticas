<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use App\Models\TipoServicio;

class GestionReportes extends Component
{
    // DEFINIMOS EL LAYOUT AQUÍ, ES MÁS SEGURO
    public $layout = 'layouts.app'; 

    public $fechaDesde;
    public $fechaHasta;
    public $categoria_id;

    public function mount()
    {
        $this->fechaDesde = now()->startOfMonth()->format('Y-m-d');
        $this->fechaHasta = now()->format('Y-m-d');
    }

    public function render()
    {

        return view('livewire.emprendimiento.gestion-reportes', [
            'categorias' => TipoServicio::all()
        ]);
    }
}