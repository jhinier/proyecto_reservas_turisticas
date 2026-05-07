<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Livewire\Component;
use Livewire\Attributes\{Computed, On, Reactive};
use App\Services\ServicioService;
use Illuminate\Support\Facades\Auth;

class ListaServiciosReservas extends Component
{
    /**
     * Propiedad reactiva que viene del componente padre (CrearReserva).
     * Mantiene la sincronización sin necesidad de eventos manuales.
     */
    #[Reactive]
    public string $filtroCategoria = '';

    /**
     * Estado interno para filtros que lleguen vía eventos globales.
     */
    public string $tipoSeleccionado = '';

    /**
     * Propiedad computada reactiva.
     * Centraliza la consulta al Service y cachea el resultado en el render.
     */
    #[Computed]
    public function servicios()
    {
        $categoria = $this->filtroCategoria ?: $this->tipoSeleccionado;

        if (empty($categoria)) {
            return collect();
        }

        // Usamos la variable que ya validamos arriba (línea 39 de tu código)
        $emprendimientoId = Auth::user()->emprendimiento->id ?? null;

        if (!$emprendimientoId) {
            return collect();
        }

        // Llamada limpia y rápida
        return app(ServicioService::class)->obtenerServiciosParaReserva(
            (int) $emprendimientoId,
            $categoria
        );
    }

    /**
     * Escucha eventos de filtrado externos.
     * Sincroniza el estado interno para disparar la reactividad de 'servicios'.
     */
    #[On('filtrar-categoria')]
    public function filtrarPorCategoria(string $categoria): void
    {
        $this->tipoSeleccionado = $categoria;
        // Si el padre no maneja la propiedad reactiva, la forzamos aquí
        $this->filtroCategoria = $categoria;
    }

    public function render()
    {
        return view('livewire.emprendimiento.reserva.lista-servicios-reservas');
    }
}
