<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On; 
use App\Services\ServicioService;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app.sidebar_emprendimiento')]
class GestorServicios extends Component
{
    public $pestanaActivaId = null;
    public $nombrePestanaActiva = '';
    public $mostrandoFormulario = false;

    // 🔥 AHORA ES UN ARRAY SIMPLE Y SEGURO
    public array $categoriasActivas = [];

    public function mount(ServicioService $service)
    {
        $emprendimiento = Auth::user()->emprendimiento;
        $categorias = $service->obtenerCategoriasActivas($emprendimiento);

        if ($categorias->isEmpty()) {
            // 🔥 SPA SPA Redirect: Prepara la navegación suave y aborta el proceso
            $this->redirectRoute('emprendimiento.servicios.seleccion', navigate: true);
            return; 
        }

        // 🔥 EL BLINDAJE: Transformamos el objeto complejo en un Array simple
        $this->categoriasActivas = $categorias->map(function($cat) {
            return [
                'pivot_id' => $cat->pivot->id,
                'nombre'   => $cat->nombre
            ];
        })->toArray();

        // 🔥 LA SOLUCIÓN: Verificamos si venimos de guardar un servicio
        if (session()->has('tab_activa')) {
            $tabGuardada = session('tab_activa');
            
            // Buscamos el nombre de esa categoría en nuestro array
            $categoriaDestino = collect($this->categoriasActivas)->firstWhere('pivot_id', $tabGuardada);
            
            if ($categoriaDestino) {
                // Abrimos la pestaña exacta de donde veníamos
                $this->seleccionarPestana($categoriaDestino['pivot_id'], $categoriaDestino['nombre']);
            }
            
        } elseif (!$this->pestanaActivaId && !empty($this->categoriasActivas)) {
            // Si no venimos de guardar nada, abrimos la primera por defecto
            $this->seleccionarPestana($this->categoriasActivas[0]['pivot_id'], $this->categoriasActivas[0]['nombre']);
        }
    }

    public function seleccionarPestana(int $pivotId, string $nombre)
    {
        $this->pestanaActivaId = $pivotId;
        $this->nombrePestanaActiva = $nombre;
        $this->mostrandoFormulario = false; 
    }
    /**
     * Determina semánticamente si la pestaña actual es de Hospedaje.
     */
    public function esHospedaje(): bool
    {
        return $this->nombrePestanaActiva === 'Hospedaje';
    }

    public function toggleFormulario()
    {
        $this->mostrandoFormulario = !$this->mostrandoFormulario;
    }

    #[On('servicio-creado')]
    public function manejarServicioCreado()
    {
        $this->mostrandoFormulario = false;
    }

    public function render(ServicioService $service)
    {
        return view('livewire.emprendimiento.gestor-servicios', [
            // 🔥 OPTIMIZACIÓN DE RENDIMIENTO: 
            // Si el ID es nulo (ej. porque está a punto de saltar a selección), 
            // no hace la consulta a la BD. Esto evita el "lag" y el parpadeo.
            'servicios' => $this->pestanaActivaId 
                ? $service->obtenerServiciosPorCategoria($this->pestanaActivaId) 
                : collect()
        ]);
    }
}