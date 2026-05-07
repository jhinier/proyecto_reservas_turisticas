<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout; 
use Livewire\WithFileUploads; 
// 🔥 1. IMPORTAMOS EL SERVICIO CORRECTO
use App\Services\HospedajeService; 
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app.sidebar_emprendimiento')] 
class CrearHospedaje extends Component
{
    use WithFileUploads;

    public int $pivotId;
    public string $nombre = '';
    public string $descripcion = '';
    public float $precio = 0.0;
    public int $stock = 0;
    public int $capacidad = 1;
    public array $imagenes = [];

    public function mount(int $pivotId): void
    {
        $this->pivotId = $pivotId;
    }

    protected function rules()
    {
        return [
            'nombre'      => 'required|string|min:3|max:100',
            'descripcion' => 'required|string|min:10|max:500',
            'precio'      => 'required|numeric|min:0.01',
            'stock'       => 'required|integer|min:1',
            'capacidad'   => 'required|integer|min:1',
            'imagenes.*'  => 'image|mimes:jpeg,png,jpg,webp|max:2048', 
        ];
    }

    protected function messages()
    {
        return [
            // ... (tus mensajes están perfectos, mantenlos igual)
            'nombre.required'      => 'El nombre de la habitación es obligatorio.',
            'nombre.min'           => 'El nombre debe tener al menos 3 caracteres.',
            'descripcion.required' => 'Por favor, añade una descripción detallada.',
            'descripcion.min'      => 'La descripción debe tener al menos 10 caracteres.',
            'precio.required'      => 'El precio por noche es obligatorio.',
            'precio.numeric'       => 'El precio debe ser un número válido.',
            'precio.min'           => 'El precio debe ser mayor a cero.',
            'stock.required'       => 'Indica la cantidad de habitaciones disponibles.',
            'stock.min'            => 'El stock debe ser de al menos 1.',
            'capacidad.required'   => 'La capacidad es obligatoria.',
            'capacidad.min'        => 'La capacidad debe ser de al menos 1 persona.',
            'imagenes.*.image'     => 'El archivo debe ser una imagen válida.',
            'imagenes.*.mimes'     => 'Formato no permitido (Solo JPG, PNG, WEBP).',
            'imagenes.*.max'       => 'Cada imagen no debe pesar más de 2MB.',
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
    public function guardar(HospedajeService $service) 
    {
        $this->validate();

        try {
            $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
            $datosDetalle = ['capacidad' => $this->capacidad];

            // 🔥 3. USAMOS EL MÉTODO ESTANDARIZADO "crear"
            $service->crear($this->pivotId, $datosBase, $datosDetalle, $this->imagenes);

            // Preparamos la alerta
            session()->flash('success', '¡Registro exitoso! La habitación ha sido creada.');
            
            // 🔥 4. APLICAMOS LA LÓGICA DE REDIRECCIÓN LIMPIA (Igual que en Alimentación)
            $tabDestino = $this->pivotId;
            $this->reset(); 
            
            return redirect()->route('emprendimiento.servicios.index', ['tab' => $tabDestino]);

        } catch (\Exception $e) {
            Log::error("Error crítico en transacción de Hospedaje: " . $e->getMessage());
            session()->flash('error', 'No se pudo completar el registro. Intente más tarde.');
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.crear-hospedaje');
    }
}