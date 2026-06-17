<?php

namespace App\Livewire\Turista\Reservas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Services\ReservaService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.turista')]
class Checkout extends Component
{
    public function boot(): void
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            session()->put('url.intended', request()->fullUrl());
            session()->put('reserva_login_pendiente', true);
            $this->redirectRoute('login', ['reserva' => 1], navigate: false);

            return;
        }

        if (!$user->hasRole('turista')) {
            session()->forget(['url.intended', 'reserva_login_pendiente']);
            session()->flash('error', 'Solo los usuarios con rol turista pueden realizar reservas.');
            $this->redirectRoute('home', navigate: false);
        }
    }

    public array $carrito = [];
    public array $datosReserva = [];

    public function mount()
    {
        if (!Auth::check()) {
            session()->put('url.intended', route('turista.reservas.checkout'));
            session()->put('reserva_login_pendiente', true);

            return redirect()->route('login', ['reserva' => 1]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->hasRole('turista')) {
            session()->forget(['url.intended', 'reserva_login_pendiente']);
            session()->flash('error', 'Solo los usuarios con rol turista pueden realizar reservas.');

            return redirect()->route('home');
        }

        $this->carrito = session()->get('reserva_turista_carrito', []);
        $this->datosReserva = session()->get('reserva_turista_datos', []);
        
        if (empty($this->carrito)) {
            return redirect()->route('home');
        }
    }

    public function volver()
    {
        $emprendimientoId = $this->datosReserva['emprendimiento_id'] ?? null;
        $categoriaId = $this->datosReserva['categoria_id'] ?? null;

        $fechaInicioGuardada = $this->datosReserva['fechaInicio'] ?? null;
        $fechaFinGuardada = $this->datosReserva['fechaFin'] ?? null;

        if (!$categoriaId && !empty($this->carrito)) {
            $primerItem = reset($this->carrito);
            $categoriaId = $primerItem['categoria_id'] ?? null;
            $fechaInicioGuardada = $fechaInicioGuardada ?: ($primerItem['fecha_inicio'] ?? null);
            $fechaFinGuardada = $fechaFinGuardada ?: ($primerItem['fecha_fin'] ?? null);
        }

        if ($emprendimientoId) {
            return redirect()->route('turista.empresa.servicios', [
                'emprendimiento' => $emprendimientoId,
                'categoria_id' => $categoriaId,
                'fechaInicio' => $fechaInicioGuardada,
                'fechaFin' => $fechaFinGuardada,
                'restaurarCarrito' => 1
            ]);
        }

        return redirect()->route('home');
    }

    public function confirmar(ReservaService $service)
    {
        if (!Auth::check()) {
            session()->put('url.intended', route('turista.reservas.checkout'));
            session()->put('reserva_login_pendiente', true);

            return redirect()->route('login', ['reserva' => 1]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->hasAnyRole(['Turista', 'turista'])) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Acceso denegado. Solo los turistas pueden realizar reservas.']);
            return;
        }

        try {
            $emprendimientoId = $this->datosReserva['emprendimiento_id'] ?? null;
            $categoriaIdGuardada = $this->datosReserva['categoria_id'] ?? null;

            $fechaInicioGuardada = null;
            $fechaFinGuardada = null;
            if (!empty($this->carrito)) {
                $primerItem = reset($this->carrito);
                $fechaInicioGuardada = $primerItem['fecha_inicio'] ?? null;
                $fechaFinGuardada = $primerItem['fecha_fin'] ?? null;
                
                if (!$categoriaIdGuardada) {
                    $categoriaIdGuardada = $primerItem['categoria_id'] ?? null;
                }
            }

            $service->registrarReservaTurista($this->carrito, $user->id);
            
            session()->forget(['reserva_turista_carrito', 'reserva_turista_datos']);
            
            session()->flash('mensaje_exito', 'Reserva guardada y pendiente de confirmación.');
            
            if ($emprendimientoId) {
                return redirect()->route('turista.empresa.servicios', [
                    'emprendimiento' => $emprendimientoId,
                    'categoria_id' => $categoriaIdGuardada,
                    'fechaInicio' => $fechaInicioGuardada,
                    'fechaFin' => $fechaFinGuardada
                ]);
            }
            
            return redirect()->route('home');
            
        } catch (\Exception $e) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Hubo un error al procesar tu reserva.']);
        }
    }

    public function render()
    {
        return view('livewire.turista.reservas.checkout');
    }
}