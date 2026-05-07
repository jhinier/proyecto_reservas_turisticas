<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Layout, Computed};
use App\Models\Reserva;
use App\Services\ReservaService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app.sidebar_emprendimiento')]
class GestorReservas extends Component
{
    use WithPagination;

    public string $filtroEstado = '';
    
    // Variables para el Modal de detalles
    public bool $mostrarModal = false;
    public ?Reserva $reservaSeleccionada = null;
    public string $motivoCancelacion = '';

    // Si el usuario cambia el filtro, reseteamos la paginación
    public function updatingFiltroEstado()
    {
        $this->resetPage();
    }

    #[Computed]
    public function reservas()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Usamos el método que creamos en el ReservaService para traer la lista
        return app(ReservaService::class)->obtenerReservasPorEmprendimiento(
            $user->emprendimiento->id,
            $this->filtroEstado
        );
    }

    public function verDetalles(int $reservaId): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $this->reservaSeleccionada = app(ReservaService::class)->obtenerDetalleSeguro(
            $reservaId, 
            $user->emprendimiento->id
        );
        $this->mostrarModal = true;
    }

    public function cerrarModal(): void
    {
        $this->mostrarModal = false;
        $this->reservaSeleccionada = null;
        $this->motivoCancelacion = '';
    }

    public function actualizarEstado(int $reservaId, string $nuevoEstado): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $exito = app(ReservaService::class)->cambiarEstado(
            $reservaId,
            $nuevoEstado,
            $user->emprendimiento->id,
            $this->motivoCancelacion
        );

        if ($exito) {
            $this->cerrarModal();
            $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Estado actualizado correctamente.']);
        } else {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'No se pudo actualizar el estado.']);
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestor-reservas');
    }
}
