<?php

namespace App\Livewire\Turista\Reservas;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Reserva;
use App\Services\ReservaService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.turista')]
class HistorialReservas extends Component
{
    use WithPagination;

    public string $filtroEstado = '';
    
    // Variables para el Modal
    public bool $mostrarModal = false;
    public ?Reserva $reservaSeleccionada = null;
    public bool $intentoCancelar = false;
    public string $motivoCancelacion = '';

    public function updatingFiltroEstado()
    {
        $this->resetPage();
    }

    public function verDetalles(int $reservaId, ReservaService $reservaService): void
    {
        $turistaId = Auth::id();
        $this->reservaSeleccionada = $reservaService->obtenerDetalleSeguroTurista($reservaId, $turistaId);
        
        if ($this->reservaSeleccionada) {
            $this->mostrarModal = true;
        }
    }

    public function cerrarModal(): void
    {
        $this->mostrarModal = false;
        $this->reservaSeleccionada = null;
        $this->intentoCancelar = false;
        $this->motivoCancelacion = '';
        $this->resetErrorBag();
    }

    public function intentarCancelar(): void
    {
        $this->intentoCancelar = true;
        $this->motivoCancelacion = '';
        $this->resetErrorBag();
    }

    // Cancelación rápida desde la tabla
    public function cancelarReserva(int $id, ReservaService $reservaService)
    {
        $turistaId = Auth::id();
        $motivoGenerico = 'Cancelada por el turista desde la tabla';
        
        $exito = $reservaService->cancelarReservaTurista($id, $turistaId, $motivoGenerico);
        
        if ($exito) {
            $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Reserva cancelada correctamente.']);
        } else {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'No puedes cancelar. Faltan menos de 24 horas o el estado actual no lo permite.']);
        }
    }

    // Cancelación detallada desde el modal
    public function confirmarCancelacion(ReservaService $reservaService): void
    {
        $this->validate(
            ['motivoCancelacion' => 'required|min:5'], 
            ['motivoCancelacion.required' => 'Por favor, indícanos brevemente el motivo de la cancelación.']
        );

        $turistaId = Auth::id();
        $exito = $reservaService->cancelarReservaTurista($this->reservaSeleccionada->id, $turistaId, $this->motivoCancelacion);

        if ($exito) {
            $this->cerrarModal();
            $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Tu reserva ha sido cancelada correctamente.']);
        } else {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'No puedes cancelar. Faltan menos de 24 horas o el estado actual no lo permite.']);
        }
    }

    public function render(ReservaService $reservaService)
    {
        $turistaId = Auth::id();

        $reservas = $reservaService->obtenerReservasPorTurista(
            $turistaId,
            $this->filtroEstado
        );

        return view('livewire.turista.reservas.historial-reservas', [
            'reservas' => $reservas
        ]);
    }
}