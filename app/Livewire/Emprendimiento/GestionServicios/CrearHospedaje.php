<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout; 
// 🔥 1. IMPORTAMOS EL SERVICIO CORRECTO
use App\Services\HospedajeService; 
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app.sidebar_emprendimiento')] 
class CrearHospedaje extends Component
{
    public int $pivotId;
    public string $nombre = '';
    public string $descripcion = '';
    public float $precio = 0.0;
    public int $stock = 0;
    public int $capacidad = 1;

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
        ];
    }

    // 🔥 2. INYECTAMOS EL SERVICIO CORRECTO AQUÍ
    public function guardar(HospedajeService $service) 
    {
        $this->validate();

        try {
            $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
            $datosDetalle = ['capacidad' => $this->capacidad];

            // 🔥 3. USAMOS EL MÉTODO ESTANDARIZADO "crear"
            $service->crear($this->pivotId, $datosBase, $datosDetalle);

            // Preparamos la alerta
            session()->flash('success', '¡Registro exitoso! La habitación ha sido creada.');
            $this->dispatch('servicio-actualizado');
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
