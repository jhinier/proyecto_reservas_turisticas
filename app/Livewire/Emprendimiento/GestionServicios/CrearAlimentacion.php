<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout; 
use Livewire\WithFileUploads; 
use App\Services\AlimentacionService;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app.sidebar_emprendimiento')] 
class CrearAlimentacion extends Component
{
    use WithFileUploads;

    public int $pivotId;
    public string $nombre = '';
    public string $descripcion = '';
    public float|int|null $precio = null;
    public string $tipo_alimentacion = '';
    public string $lugar_alimentacion = '';
    public array $imagenes = [];

    public function mount(int $pivotId): void
    {
        $this->pivotId = $pivotId;
    }

    protected function rules()
    {
        return [
            'nombre'             => 'required|string|min:3|max:100',
            'descripcion'        => 'required|string|min:5|max:300',
            'precio'             => 'required|numeric|min:0.01',
            'tipo_alimentacion'  => 'required|string|max:100',
            'lugar_alimentacion' => 'required|string|max:150',
            'imagenes.*'         => 'image|mimes:jpeg,png,jpg,webp|max:2048', 
        ];
    }

    public function eliminarImagen(int $index): void
    {
        if (isset($this->imagenes[$index])) {
            unset($this->imagenes[$index]);
            $this->imagenes = array_values($this->imagenes);
        }
    }

    public function guardar(AlimentacionService $service)
    {
        $this->validate();

        try {
            // Agregamos stock automáticamente a 999 para permitir reservas ilimitadas
            $datosBase = $this->only(['nombre', 'descripcion', 'precio']);
            $datosBase['stock'] = 999;
            
            $datosDetalle = $this->only(['tipo_alimentacion', 'lugar_alimentacion']);

            // 1. Guardamos el servicio
            $service->crear($this->pivotId, $datosBase, $datosDetalle, $this->imagenes);

            // 2. Preparamos el mensaje de éxito
            session()->flash('success', '¡Registro exitoso! El plato/servicio ha sido creado.');
            
            // 3. Guardamos el ID temporalmente para que el reset no lo borre
            $tabDestino = $this->pivotId;
            
            // 4. Limpiamos las variables (Opcional, pero buena práctica)
            $this->reset(); 

            // 5. Redirigimos usando la variable temporal
            return redirect()->route('emprendimiento.servicios.index', ['tab' => $tabDestino]);

        } catch (\Exception $e) {
            Log::error("Error en Alimentación: " . $e->getMessage());
            session()->flash('error', 'Ocurrió un error al guardar.');
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.crear-alimentacion');
    }
}