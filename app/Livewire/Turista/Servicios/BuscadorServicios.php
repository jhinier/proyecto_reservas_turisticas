<?php

namespace App\Livewire\Turista\Servicios;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\BuscadorTuristicoService;
use App\Models\TipoServicio;

class BuscadorServicios extends Component
{
    use WithPagination;

    public string $busqueda = '';
    public ?int $tipoServicioSeleccionado = null;

    protected $queryString = [
        'busqueda' => ['except' => ''],
        'tipoServicioSeleccionado' => ['except' => null],
    ];

    public function updatingBusqueda()
    {
        $this->resetPage();
    }

    public function updatingTipoServicioSeleccionado()
    {
        $this->resetPage();
    }

    public function render(BuscadorTuristicoService $servicio)
    {
        $tiposServicio = TipoServicio::all();
        $resultados = $servicio->buscarServicios($this->busqueda, $this->tipoServicioSeleccionado);

        return view('livewire.turista.servicios.buscador-servicios', [
            'tiposServicio' => $tiposServicio,
            'resultados' => $resultados,
        ]);
    }
}