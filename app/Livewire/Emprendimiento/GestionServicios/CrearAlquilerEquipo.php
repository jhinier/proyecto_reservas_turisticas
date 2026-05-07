<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Services\AlquilerEquipoService;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app.sidebar_emprendimiento')]
class CrearAlquilerEquipo extends Component
{
    use WithFileUploads;

    public int $pivotId;
    
    // Datos Base de la tabla Servicio
    public string $nombre = '';
    public string $descripcion = '';
    public float|int|string|null $precio = null;
    public int|string|null $stock = null;
    
    // Archivos (Se deja preparado aunque no se use en la vista actualmente)
    public array $imagenes = [];

    public function mount(int $pivotId): void
    {
        $this->pivotId = $pivotId;
    }

    protected array $rules = [
        'nombre'      => 'required|string|max:255',
        'descripcion' => 'required|string|max:1000',
        'precio'      => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:1', 
        'imagenes.*'  => 'image|max:2048' 
    ];

    public function guardar(AlquilerEquipoService $alquilerService)
    {
        $this->validate();

        try {
            // Mandamos a llamar a nuestro servicio limpio
            $alquilerService->crear(
                $this->pivotId,
                [
                    'nombre'      => $this->nombre,
                    'descripcion' => $this->descripcion,
                    'precio'      => $this->precio,
                    'stock'       => $this->stock,
                ],
                $this->imagenes
            );

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
