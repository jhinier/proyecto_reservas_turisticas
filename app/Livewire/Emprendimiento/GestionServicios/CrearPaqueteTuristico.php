<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout; 
use Livewire\WithFileUploads; 
use Illuminate\Http\UploadedFile;
// 🔥 1. IMPORTAMOS EL SERVICIO CORRECTO
use App\Services\PaqueteTuristicoService;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app.sidebar_emprendimiento')] 
class CrearPaqueteTuristico extends Component
{
    use WithFileUploads;

    public int $pivotId;
    public string $nombre = '';
    public string $descripcion = '';
    public float $precio = 0.0;
    public int $stock = 0;

    public string $lugar_salida = '';
    public string $hora_salida = '';
    public string $servicios_incluidos = '';
    public string $lugares_actividades = '';
    public string $recomendaciones = '';
    public int $duracion_dias = 1;
    public ?string $mensaje_pago = null;
    
    public ?UploadedFile $documento = null; // Archivo PDF del itinerario
    public array $imagenes = [];

    public function mount(int $pivotId): void
    {
        $this->pivotId = $pivotId;
    }

    protected function rules()
    {
        return [
            'nombre'              => 'required|string|min:3|max:150',
            'descripcion'         => 'required|string|min:10|max:500',
            'precio'              => 'required|numeric|min:0.01',
            'stock'               => 'required|integer|min:1',
            'lugar_salida'        => 'required|string|max:150',
            'hora_salida'         => 'required',
            'servicios_incluidos' => 'required|string|max:500',
            'lugares_actividades' => 'required|string|max:500',
            'recomendaciones'     => 'required|string|max:500',
            'duracion_dias'       => 'required|integer|min:1',
            'mensaje_pago'        => 'nullable|string|max:255',
            'documento'           => 'nullable|file|mimes:pdf|max:5120',
            'imagenes.*'          => 'image|mimes:jpeg,png,jpg,webp|max:2048', 
        ];
    }

    public function eliminarImagen(int $index): void
    {
        if (isset($this->imagenes[$index])) {
            unset($this->imagenes[$index]);
            $this->imagenes = array_values($this->imagenes);
        }
    }

    // 🔥 2. INYECTAMOS EL SERVICIO CORRECTO AQUÍ
    public function guardar(PaqueteTuristicoService $service)
    {
        $this->validate();

        try {
            $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
            $datosDetalle = $this->only([
                'lugar_salida', 'hora_salida', 'servicios_incluidos', 
                'lugares_actividades', 'recomendaciones', 'duracion_dias', 'mensaje_pago'
            ]);

            // 🔥 3. USAMOS EL MÉTODO ESTANDARIZADO "crear" (Pasando el documento al final)
            $service->crear($this->pivotId, $datosBase, $datosDetalle, $this->imagenes, $this->documento);

            session()->flash('success', '¡Paquete Turístico creado con éxito!');
            
            // 🔥 4. PROTEGEMOS LA REDIRECCIÓN
            $tabDestino = $this->pivotId;
            $this->reset(); 
            
            return redirect()->route('emprendimiento.servicios.index', ['tab' => $tabDestino]);

        } catch (\Exception $e) {
            Log::error("Error en Paquete Turístico: " . $e->getMessage());
            
            // Cambia esta línea para que muestre el error exacto de la base de datos
            session()->flash('error', 'Error técnico: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.crear-paquete-turistico');
    }
}