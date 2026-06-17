<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout; 
use Livewire\WithFileUploads; 
use Illuminate\Http\UploadedFile;
// 🔥 1. IMPORTAMOS EL SERVICIO CORRECTO
use App\Services\PaqueteTuristicoService;
use App\Rules\NoHtmlTags;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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

    public function mount(int $pivotId): void
    {
        $this->pivotId = $pivotId;
    }

    protected function rules()
    {
        return [
            'nombre'              => ['required', 'string', 'min:3', 'max:150', new NoHtmlTags()],
            'descripcion'         => ['required', 'string', 'min:10', 'max:500', new NoHtmlTags()],
            'precio'              => 'required|numeric|min:0.01|max:1000|regex:/^\d+(\.\d{1,2})?$/',
            'stock'               => 'required|integer|min:1|max:1000',
            'lugar_salida'        => ['required', 'string', 'max:150', new NoHtmlTags()],
            'hora_salida'         => 'required',
            'servicios_incluidos' => ['required', 'string', 'max:500', new NoHtmlTags()],
            'lugares_actividades' => ['required', 'string', 'max:500', new NoHtmlTags()],
            'recomendaciones'     => ['required', 'string', 'max:500', new NoHtmlTags()],
            'duracion_dias'       => 'required|integer|min:1',
            'mensaje_pago'        => ['nullable', 'string', 'max:255', new NoHtmlTags()],
            'documento'           => 'nullable|file|mimes:pdf|max:5120',
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del paquete es obligatorio.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede exceder 150 caracteres.',
            'precio.required' => 'Debes indicar el precio del paquete.',
            'precio.min' => 'El precio no puede ser negativo.',
            'precio.numeric' => 'El precio debe ser un número válido.',
            'precio.max' => 'El precio no puede exceder $1000.',
            'precio.regex' => 'El precio debe tener máximo 2 decimales.',
            'stock.required' => 'El stock de cupos es obligatorio.',
            'stock.min' => 'El stock debe ser al menos 1.',
            'stock.max' => 'El stock no puede exceder 1000 unidades.',
            'duracion_dias.required' => 'Indica los días de duración.',
            'duracion_dias.min' => 'La duración debe ser mínimo de 1 día.',
            'lugar_salida.required' => 'El punto de encuentro es obligatorio.',
            'hora_salida.required' => 'Debes definir la hora de inicio.',
            'descripcion.required' => 'El resumen general es obligatorio.',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres.',
            'descripcion.max' => 'La descripción no puede exceder 500 caracteres.',
            'lugares_actividades.required' => 'El itinerario detallado es obligatorio.',
            'servicios_incluidos.required' => 'Debes detallar qué incluye el paquete.',
            'recomendaciones.required' => 'Las recomendaciones son obligatorias.',
            'documento.mimes' => 'El documento debe ser un archivo PDF.',
            'documento.max' => 'El documento no debe pesar más de 5MB.',
        ];
    }

    // 🔥 2. INYECTAMOS EL SERVICIO CORRECTO AQUÍ
    public function guardar(PaqueteTuristicoService $service)
    {
        // Verificar rol de seguridad
        $user = Auth::user();
        if (!$user instanceof User || !$user->hasRole('emprendimiento')) {
            session()->flash('error', 'No tienes permiso para realizar esta acción.');
            return;
        }

        $this->validate();

        try {
            $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
            $datosDetalle = $this->only([
                'lugar_salida', 'hora_salida', 'servicios_incluidos', 
                'lugares_actividades', 'recomendaciones', 'duracion_dias', 'mensaje_pago'
            ]);

            // 🔥 3. USAMOS EL MÉTODO ESTANDARIZADO "crear" (Pasando el documento al final)
            $service->crear($this->pivotId, $datosBase, $datosDetalle, [], $this->documento);

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
