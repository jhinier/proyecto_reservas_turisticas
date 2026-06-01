<?php

namespace App\Livewire\Turista\Reservas;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\ReservaService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.turista')]
class Checkout extends Component
{
    public array $carrito = [];
    public array $datosReserva = [];

    public function mount()
    {
        // 1. Si no hay sesión, guardamos la ruta actual y pedimos login
        if (!Auth::check()) {
            session()->put('url.intended', route('turista.reservas.checkout'));
            return redirect()->route('login');
        }

        // 2. Validación estricta de rol
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        if (!$user->hasRole('turista')) {
            Auth::logout();
            session()->flash('error', 'Las reservas son exclusivas para turistas. Por favor, inicia sesión con una cuenta de turista.');
            return redirect()->route('login');
        }

        // 3. Carga normal del carrito
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

        // Si no está en datosReserva, lo intentamos sacar del primer elemento del carrito
        if (!$categoriaId && !empty($this->carrito)) {
            $primerItem = reset($this->carrito);
            $categoriaId = $primerItem['categoria_id'] ?? null;
        }

        if ($emprendimientoId) {
            return redirect()->route('turista.empresa.servicios', [
                'emprendimiento' => $emprendimientoId,
                'categoria_id' => $categoriaId
            ]);
        }

        return redirect()->route('home');
    }

    public function confirmar(ReservaService $service)
    {
        if (!Auth::check()) {
            session()->put('url.intended', route('turista.reservas.checkout'));
            return redirect()->route('login');
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Corrección de la lectura de rol en minúscula
        if (!$user->hasAnyRole(['Turista', 'turista'])) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Acceso denegado. Solo los turistas pueden realizar reservas.']);
            return;
        }

        try {
            // Rescatamos el ID de la empresa y de la categoría antes de limpiar la sesión
            $emprendimientoId = $this->datosReserva['emprendimiento_id'] ?? null;
            $categoriaIdGuardada = $this->datosReserva['categoria_id'] ?? null;

            // Rescatamos las fechas y categoría del primer elemento del carrito
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
            
            // Usamos session()->flash para que el mensaje sobreviva a la redirección
            session()->flash('mensaje_exito', 'Reserva guardada y pendiente de confirmación.');
            
            // Redirigimos al catálogo enviando las fechas y la categoría por la URL
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