<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Services\AlquilerEquipoService;
use App\Rules\NoHtmlTags;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app.sidebar_emprendimiento')]
class CrearAlquilerEquipo extends Component
{
    public int $pivotId;
    
    // Datos Base de la tabla Servicio
    public string $nombre = '';
    public string $descripcion = '';
    public float|int|string|null $precio = null;
    public int|string|null $stock = null;

    public function mount(int $pivotId): void
    {
        $this->pivotId = $pivotId;
    }

    protected function rules()
    {
        return [
            'nombre'      => ['required', 'string', 'min:3', 'max:255', new NoHtmlTags()],
            'descripcion' => ['required', 'string', 'min:5', 'max:1000', new NoHtmlTags()],
            'precio'      => 'required|numeric|min:0.01|max:1000|regex:/^\d+(\.\d{1,2})?$/',
            'stock'       => 'required|integer|min:1|max:1000', 
        ];
    }

    public function guardar(AlquilerEquipoService $alquilerService)
    {
        // Verificar rol de seguridad
        $user = Auth::user();
        if (!$user instanceof User || !$user->hasRole('emprendimiento')) {
            session()->flash('error', 'No tienes permiso para realizar esta acción.');
            return;
        }

        $this->validate();

        try {
            // Mandamos a llamar a nuestro servicio limpio
            $alquilerService->crear($this->pivotId, [
                'nombre'      => $this->nombre,
                'descripcion' => $this->descripcion,
                'precio'      => $this->precio,
                'stock'       => $this->stock,
            ]);

            // 🔥 CORREGIDO: Ahora enviamos solo un String, no un Array
            session()->flash('success', 'Equipo de alquiler registrado correctamente.');
            
            // Redireccionamos al dashboard de servicios manteniendo la pestaña activa
            return $this->redirectRoute('emprendimiento.servicios.index', ['tab' => $this->pivotId], navigate: true);

        } catch (\Exception $e) {
            Log::error('Error al crear Alquiler de Equipo: ' . $e->getMessage());
            
            // 🔥 CORREGIDO: Ahora enviamos solo un String
            session()->flash('error', 'Ocurrió un problema al guardar el equipo.');
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.crear-alquiler-equipo');
    }
}
