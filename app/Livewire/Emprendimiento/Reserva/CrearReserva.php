<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Livewire\Component;
use Livewire\Attributes\{Layout, On, Computed};
use App\Services\ReservaService;
use App\Services\TipoServicioService;
use App\Models\TipoServicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

#[Layout('layouts.app.sidebar_emprendimiento')]
class CrearReserva extends Component
{
    // --- Estado de la Reserva ---
    public int $paso = 1;
    public array $carrito = [];
    public array $datosTurista = [];

    // --- Estado de Búsqueda y Filtros ---
    public string $filtroCategoria = '';
    public string $nombreCategoriaFiltro = '';
    public string $fechaBusqueda = '';
    public string $fechaFinBusqueda = '';
    public ?int $personasBusqueda = 1;

    // --- UI State ---
    public bool $busquedaActiva = false;
    public bool $metaAlcanzada = false;
    public int $capacidadActual = 0;

    /**
     * Obtiene categorías activas mediante el Service.
     */
    #[Computed]
    public function categorias(): Collection
    {
        $emprendimientoId = Auth::user()->emprendimiento->id ?? null;
        if (!$emprendimientoId) return collect();

        return app(TipoServicioService::class)->obtenerTiposActivosPorEmprendimiento($emprendimientoId);
    }

    /**
     * Cálculo reactivo del total del carrito.
     */
    #[Computed]
    public function totalCarrito(): float
    {
        return array_reduce($this->carrito, fn($carry, $item) => $carry + ($item['subtotal'] ?? 0), 0.0);
    }

    /**
     * Listener: Selección de categoría.
     */
    #[On('filtrar-categoria')]
    public function seleccionarCategoria(string $categoria): void
    {
        $this->filtroCategoria = $categoria;
        $this->nombreCategoriaFiltro = $this->normalizarNombreCategoria($categoria);
        
        // Reset de búsqueda al cambiar categoría por seguridad
        $this->reset(['busquedaActiva', 'fechaBusqueda', 'fechaFinBusqueda', 'personasBusqueda']);
        $this->evaluarMetaCapacidad();
    }

    /**
     * Listener: Ejecución de búsqueda desde el formulario.
     */
    #[On('busqueda-ejecutada')]
    public function procesarBusqueda(array $datos): void
    {
        $this->fechaBusqueda = $datos['fecha'] ?? '';
        $this->fechaFinBusqueda = $datos['fechaFin'] ?? '';
        $this->personasBusqueda = isset($datos['personas']) ? (int) $datos['personas'] : null;
        
        $this->busquedaActiva = true;
        $this->evaluarMetaCapacidad();
    }

    /**
     * Listener: Agregar ítem al carrito.
     */
    #[On('agregar-al-carrito')]
    public function agregarAlCarrito(array $item): void
    {
        $this->carrito[] = $item;
        $this->evaluarMetaCapacidad();
        $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Servicio añadido']);
    }

    /**
     * Listener: Quitar ítem del carrito.
     */
    #[On('quitar-del-carrito')]
    public function quitarDelCarrito(int $index): void
    {
        if (isset($this->carrito[$index])) {
            unset($this->carrito[$index]);
            $this->carrito = array_values($this->carrito);
            $this->evaluarMetaCapacidad();
            $this->dispatch('notificar', ['tipo' => 'info', 'mensaje' => 'Servicio eliminado']);
        }
    }

    /**
     * Listener: Datos del turista validados (Paso 2).
     */
    #[On('datos-turista-completados')]
    public function setTurista(array $datos): void
    {
        $this->datosTurista = $datos;
        $this->paso = 3;
    }

    /**
     * Lógica de negocio para control de meta (Aislamiento por categoría).
     */
    private function evaluarMetaCapacidad(): void
    {
        $cat = $this->nombreCategoriaFiltro;
        $esHospedaje = str_contains($cat, 'hospedaje');
        $esGuianza = str_contains($cat, 'guianza');

        if (!$esHospedaje && !$esGuianza) {
            $this->reset(['metaAlcanzada', 'capacidadActual']);
            return;
        }

        $this->capacidadActual = 0;
        foreach ($this->carrito as $item) {
            $itemCat = Str::slug($item['categoria_nombre'] ?? '', ' ');
            
            // Solo sumamos capacidad si el ítem coincide con la categoría que el usuario está viendo
            if (($esHospedaje && str_contains($itemCat, 'hospedaje')) || 
                ($esGuianza && str_contains($itemCat, 'guianza'))) {
                $this->capacidadActual += ($item['capacidad_aportada'] ?? 0);
            }
        }

        $this->metaAlcanzada = $this->personasBusqueda !== null && $this->capacidadActual >= $this->personasBusqueda;
    }

    /**
     * Finalización del agendamiento.
     */
    /**
     * Finalización del agendamiento.
     */
    public function finalizarAgendamiento(ReservaService $reservaService): void
    {
        if (empty($this->carrito)) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'El carrito está vacío']);
            return;
        }

        $emprendimientoId = Auth::user()->emprendimiento->id ?? null;

        if (!$emprendimientoId) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Error: No tiene un emprendimiento asociado']);
            return;
        }

        try {
            $reservaService->crearReserva($this->datosTurista, $this->carrito, (int)$emprendimientoId);

            session()->flash('success', '¡Reserva realizada con éxito y correo enviado!');
            
            $this->redirect(route('emprendimiento.reservas'), navigate: true);

        } catch (\Exception $e) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Error al guardar: ' . $e->getMessage()]);
        }
    }

    /**
     * Normaliza nombres de categoría para lógica interna.
     */
    private function normalizarNombreCategoria($valor): string
    {
        if (empty($valor)) return '';
        $nombre = is_numeric($valor) ? (TipoServicio::find($valor)->nombre ?? '') : $valor;
        return Str::slug($nombre, ' ');
    }

    public function render()
    {
        return view('livewire.emprendimiento.reserva.crear-reserva');
    }
}