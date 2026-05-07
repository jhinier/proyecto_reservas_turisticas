<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; // 1. Agrega esta línea
use App\Models\Servicio;
use App\Services\ListadoServicioService; 

class ListaPaquetes extends Component
{
    use WithPagination;

    #[On('galeria-actualizada')]
    public function refrescarGaleria(): void
    {
        // Actualizamos la lista de paquetes cuando la galería reciba nuevas imágenes.
    }

    public int $pivotId;
    public string $nombreCategoria;
    public string $rutaCrear;

    public function mount(int $pivotId, string $nombreCategoria, string $rutaCrear)
    {
        $this->pivotId = $pivotId;
        $this->nombreCategoria = $nombreCategoria;
        $this->rutaCrear = $rutaCrear;
    }

    #[On('eliminarPaquete')]
    public function eliminarPaquete(int $id)
    {
        try {
            $servicio = \App\Models\Servicio::findOrFail($id);
            $servicio->delete(); 
            
            $this->resetPage();

            $this->dispatch('notificar', [
                'tipo' => 'success', 
                'mensaje' => 'Paquete turístico eliminado correctamente.'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('notificar', [
                'tipo' => 'error', 
                'mensaje' => 'No se pudo eliminar el paquete turístico.'
            ]);
        }
    }

    public function editarServicio(int $id)
{
    // 1. Quitamos el dd() para que el código siga.
    // 2. IMPORTANTE: Usamos 'detallePaqueteTuristico' (como está en tu modelo Servicio)
    $servicio = Servicio::with('categoriaPivot.tipoServicio')->findOrFail($id);
    
    $nombreTipo = $servicio->categoriaPivot?->tipoServicio?->nombre;

    $mapaEventos = [
        'Paquetes Turísticos' => 'abrir-editar-paquete',
    ];

    if (isset($mapaEventos[$nombreTipo])) {
        // Esto le manda la orden al modal
        $this->dispatch($mapaEventos[$nombreTipo], id: $id);
    } else {
        $this->dispatch('notificar', ['tipo' => 'warning', 'mensaje' => 'No se encontró el evento para: ' . $nombreTipo]);
    }
}

    public function render(ListadoServicioService $queryService)
    {
        return view('livewire.emprendimiento.lista-paquetes', [
            // Reutilizamos tu servicio de consultas para traer los paquetes de esta pestaña
            'paquetes' => $queryService->obtenerPaginadosPorCategoria($this->pivotId)
        ]);
    }
}