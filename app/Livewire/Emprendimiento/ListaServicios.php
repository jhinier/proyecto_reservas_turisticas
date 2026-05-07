<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Servicio;
use App\Services\ListadoServicioService;
use App\Services\ServicioBaseService;
use Livewire\Attributes\On; // 🔥 AGREGADO: Importamos el atributo On de Livewire

class ListaServicios extends Component
{
    use WithPagination;

    #[On('galeria-actualizada')]
    public function refrescarGaleria(): void
    {
        // Este método se ejecuta cuando se actualiza la galería desde el modal.
        // Livewire vuelve a renderizar automáticamente y recarga el listado con las imágenes nuevas.
    }

    public int $pivotId;
    public string $nombreCategoria;
    public string $rutaCrear;

    /**
     * Elimina un servicio usando el Service Base.
     */
    #[On('ejecutar-eliminacion')] // 🔥 NUEVO: Reemplaza a 'ejecutar-eliminacion' => 'eliminarServicio'
    public function eliminarServicio(int $id, ServicioBaseService $service)
    {
        try {
            $service->eliminar($id);

            $this->dispatch('notificar', [
                'tipo' => 'success', 
                'mensaje' => 'Servicio eliminado correctamente.'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('notificar', [
                'tipo' => 'error', 
                'mensaje' => 'No se pudo eliminar el servicio.'
            ]);
        }
    }

    /**
     * Redirige al formulario de edición dinámicamente según el tipo de servicio.
     */
    public function editarServicio(int $id)
{
    $servicio = Servicio::with('categoriaPivot.tipoServicio')->findOrFail($id);
    $nombreTipo = $servicio->categoriaPivot->tipoServicio->nombre;

    $mapaEventos = [
        'Hospedaje'           => 'abrir-editar-hospedaje',
        'Alimentación'        => 'abrir-editar-alimentacion', // 🔥 Pon la tilde
        'Guianza'             => 'abrir-editar-guianza',
        'Alquiler de Equipos' => 'abrir-editar-alquiler-equipo',
    ];

    if (isset($mapaEventos[$nombreTipo])) {
        $this->dispatch($mapaEventos[$nombreTipo], id: $id);
    } else {
        // 🔥 Si esto sale en pantalla, es que el nombre de la BD no coincide
        $this->dispatch('notificar', [
            'tipo' => 'warning', 
            'mensaje' => 'No coincide: "' . $nombreTipo . '" con el mapa.'
        ]);
    }
}

    /**
     * Renderiza la vista del listado usando el service de consultas.
     */
    public function render(ListadoServicioService $service)
    {
        return view('livewire.emprendimiento.lista-servicios', [
            'servicios' => $service->obtenerPaginadosPorCategoria($this->pivotId)
        ]);
    }
}