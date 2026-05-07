<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Livewire\Component;
use Livewire\Attributes\{Layout, On, Computed};
use App\Services\ReservaService;
use App\Services\ServicioService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app.sidebar_emprendimiento')]
class CrearReserva extends Component
{
    public int $paso = 1;
    public array $carrito = [];
    public array $datosTurista = [];
    public string $filtroCategoria = '';

    #[Computed]
    public function categorias()
    {
        return app(ServicioService::class)->obtenerTipos();
    }

    #[Computed]
    public function totalCarrito(): float
    {
        return array_reduce($this->carrito, function (float $carry, array $item): float {
            return $carry + (($item['precio'] ?? 0) * ($item['cantidad'] ?? 1));
        }, 0.0);
    }

    #[On('agregar-al-carrito')]
    public function agregarAlCarrito(array $item): void
    {
        $this->carrito[] = $item;
        $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Servicio añadido al resumen']);
    }

    #[On('quitar-del-carrito')]
    public function quitarDelCarrito(int $index): void
    {
        if (isset($this->carrito[$index])) {
            unset($this->carrito[$index]);
            $this->carrito = array_values($this->carrito);
            $this->dispatch('notificar', ['tipo' => 'info', 'mensaje' => 'Servicio eliminado']);
        }
    }

    #[On('filtrar-categoria')]
    public function filtrarCategoria(string $categoria): void
    {
        $this->filtroCategoria = $categoria;
    }

    #[On('datos-turista-completados')]
    public function setTurista(array $datos): void
    {
        $this->datosTurista = $datos;
        $this->paso = 3; 
    }

    public function finalizarAgendamiento(): void
    {
        if (empty($this->carrito)) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'El resumen está vacío']);
            return;
        }

        $emprendimientoId = Auth::user()->emprendimiento->id ?? null;

        if (!$emprendimientoId) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'No tiene un emprendimiento asociado']);
            return;
        }

        try {
            app(ReservaService::class)->crearReserva(
                $this->datosTurista,
                $this->carrito,
                $emprendimientoId
            );

            session()->flash('success', 'Reserva procesada con éxito y credenciales enviadas');
            
            // Quita el return y deja solo la instrucción
            $this->redirect(route('emprendimiento.reservas'), navigate: true);

        } catch (\Exception $e) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Error: ' . $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.reserva.crear-reserva');
    }
}