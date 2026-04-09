<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout; 
use App\Services\Emprendimiento\ServicioService;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app.sidebar_emprendimiento')] 
class CrearHospedaje extends Component
{
    public $pivotId;
    public $nombre, $descripcion, $precio, $stock, $capacidad;

    /**
     * Método mount para capturar el pivotId desde la URL
     */
    public function mount($pivotId)
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

    /**
     * TRADUCCIÓN DE ERRORES:
     * Mensajes personalizados para mejorar la Experiencia de Usuario (UX)
     */
    protected function messages()
    {
        return [
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

    /**
     * Ejecuta la lógica de negocio final directamente (Sin modal)
     */
    public function guardar(ServicioService $service)
    {
        $this->validate();

        try {
            $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
            $datosDetalle = ['capacidad' => $this->capacidad];

            // Transacción atómica en capa de Servicio
            $service->crearHospedaje($this->pivotId, $datosBase, $datosDetalle);

            // Limpiamos solo los campos de datos
            $this->reset(['nombre', 'descripcion', 'precio', 'stock', 'capacidad']);
            
            // Notificamos que el servicio fue creado
            $this->dispatch('servicio-creado'); 
            
            // Preparamos la alerta de éxito para la vista del Gestor
            session()->flash('success', '¡Registro exitoso! La habitación ha sido creada.');

            session()->flash('tab_activa', $this->pivotId);

            // Redirección clásica y sólida para evitar parpadeos
            return redirect()->route('emprendimiento.servicios.index');

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