<?php

namespace App\Livewire\Emprendimiento;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\{Layout, Computed};
use App\Models\Reserva;
use App\Services\ReservaService;
use App\Services\TipoServicioService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app.sidebar_emprendimiento')]
class GestorReservas extends Component
{
    use WithPagination;

    public string $filtroEstado = '';
    public string $filtroCategoria = '';
    public string $buscarCedula = '';
    
    public bool $mostrarModal = false;
    public ?Reserva $reservaSeleccionada = null;
    
    public string $motivoCancelacion = '';
    public bool $modoReagendar = false;
    public bool $intentoCancelar = false;
    public array $nuevasFechas = [];

    public function mount(): void
    {
        app(\App\Services\ReservaService::class)->procesarCancelacionesAutomaticas();
    }

    public function updated(string $propertyName): void
    {
        if (in_array($propertyName, ['filtroEstado', 'filtroCategoria', 'buscarCedula'])) {
            $this->resetPage();
        }
    }

    #[Computed]
    public function categorias()
    {
        $emprendimientoId = Auth::user()->emprendimiento->id ?? null;
        if (!$emprendimientoId) {
            return collect();
        }
        return app(TipoServicioService::class)->obtenerTiposActivosPorEmprendimiento($emprendimientoId);
    }

    #[Computed]
    public function reservas()
    {
        $user = Auth::user();
        return app(ReservaService::class)->obtenerReservasPorEmprendimiento(
            $user->emprendimiento->id,
            $this->filtroEstado,
            $this->filtroCategoria,
            $this->buscarCedula
        );
    }

    public function verDetalles(int $reservaId): void
    {
        $user = Auth::user();
        $this->reservaSeleccionada = app(ReservaService::class)->obtenerDetalleSeguro($reservaId, $user->emprendimiento->id);
        $this->mostrarModal = true;
    }

    public function cerrarModal(): void
    {
        $this->mostrarModal = false;
        $this->reservaSeleccionada = null;
        $this->motivoCancelacion = '';
        $this->modoReagendar = false;
        $this->intentoCancelar = false;
        $this->nuevasFechas = [];
        $this->resetErrorBag();
    }

    public function activarModoReagendar(): void
    {
        $this->modoReagendar = true;
        $this->intentoCancelar = false;
        $this->motivoCancelacion = ''; 
        $this->resetErrorBag();
        
        foreach ($this->reservaSeleccionada->detalles as $detalle) {
            $this->nuevasFechas[$detalle->id] = [
                'inicio' => $detalle->fecha_inicio->format('Y-m-d'),
                'fin'    => $detalle->fecha_fin ? $detalle->fecha_fin->format('Y-m-d') : $detalle->fecha_inicio->format('Y-m-d'),
                'hora_llegada' => $detalle->hora_llegada,
            ];
        }
    }

    public function intentarCancelar(): void
    {
        $this->intentoCancelar = true;
        $this->modoReagendar = false;
        $this->motivoCancelacion = '';
        $this->resetErrorBag();
    }

    public function confirmarCancelacion(): void
    {
        $this->validate(
            ['motivoCancelacion' => 'required|min:5'], 
            ['motivoCancelacion.required' => 'Es obligatorio indicar un motivo para el turista.']
        );
        $this->actualizarEstado($this->reservaSeleccionada->id, 'Cancelada');
    }

    private function esPaqueteDetalle(int $detalleId): bool
    {
        $detalle = $this->reservaSeleccionada?->detalles->firstWhere('id', $detalleId);
        $nombreCat = strtolower($detalle?->servicio?->tipoServicio?->nombre ?? '');

        return str_contains($nombreCat, 'paquete');
    }

    private function esDiaBloqueado(string $fecha, int $detalleId): bool
    {
        if (!$this->esPaqueteDetalle($detalleId)) {
            return false;
        }

        $dia = Carbon::parse($fecha)->dayOfWeek;

        return in_array($dia, [Carbon::SUNDAY, Carbon::MONDAY], true);
    }

    public function guardarReagendamiento(): void
    {
        $this->resetErrorBag();

        $rules = [];
        $messages = [];

        foreach ($this->nuevasFechas as $detalleId => $fechas) {
            $rules["nuevasFechas.{$detalleId}.inicio"] = ['required', 'date', function ($attribute, $value, $fail) use ($detalleId) {
                if ($this->esDiaBloqueado($value, $detalleId)) {
                    $fail('Los paquetes turísticos no pueden reagendarse los domingos ni los lunes.');
                }
            }];
            $rules["nuevasFechas.{$detalleId}.fin"]    = 'nullable|date|after_or_equal:nuevasFechas.' . $detalleId . '.inicio';
            
            $messages["nuevasFechas.{$detalleId}.inicio.required"] = 'La fecha de inicio es obligatoria.';
            $messages["nuevasFechas.{$detalleId}.fin.after_or_equal"] = 'La fecha de fin no puede ser menor a la de inicio.';
        }

        $this->validate($rules, $messages);

        $user = Auth::user();
        
        try {
            $exito = app(ReservaService::class)->reagendarReserva(
                $this->reservaSeleccionada->id,
                $this->nuevasFechas,
                $user->emprendimiento->id
            );

            if ($exito) {
                unset($this->reservas);
                $this->cerrarModal();
                $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Fechas actualizadas y validadas con éxito.']);
            }
        } catch (\Exception $e) {
            $this->addError('error_general', $e->getMessage());
        }
    }

    public function actualizarEstado(int $reservaId, string $nuevoEstado): void
    {
        $user = Auth::user();
        $exito = app(ReservaService::class)->cambiarEstado($reservaId, $nuevoEstado, $user->emprendimiento->id, $this->motivoCancelacion);

        if ($exito) {
            unset($this->reservas);
            $this->cerrarModal();
            $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => "Reserva marcada como $nuevoEstado."]);
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestor-reservas');
    }
}