<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout; 
use App\Services\GuianzaService;
use Illuminate\Support\Facades\Log;

/**
 * Controlador de UI para la creación de Guianzas.
 * Capa de Interactividad: Recibe, valida y delega.
 */
#[Layout('layouts.app.sidebar_emprendimiento')] 
class CrearGuianza extends Component
{
    public $pivotId;
    
    // Asignamos el nombre por defecto desde el inicio
    public string $nombre = 'Servicio de Guía Turístico'; 
    public $descripcion, $precio, $stock, $numero_max_persona;

    /**
     * Método mount para capturar el pivotId desde la URL
     */
    public function mount($pivotId)
    {
        $this->pivotId = $pivotId;
    }

    /**
     * Reglas de validación (Capa de Seguridad de Entrada)
     */
    protected function rules()
    {
        return [
            'nombre'             => 'required|string|min:3|max:100',
            'descripcion'        => 'required|string|min:10|max:1000',
            'precio'             => 'required|numeric|min:0.01',
            'stock'              => 'required|integer|min:1',
            'numero_max_persona' => 'required|integer|min:1',
        ];
    }

    /**
     * TRADUCCIÓN DE ERRORES:
     * Mensajes personalizados para mejorar la Experiencia de Usuario (UX)
     */
    protected function messages()
    {
        return [
            'descripcion.required'        => 'Por favor, describe los lugares o rutas que puede guiar.',
            'descripcion.min'             => 'La descripción debe tener al menos 10 caracteres.',
            'precio.required'             => 'El precio por día es obligatorio.',
            'precio.numeric'              => 'El precio debe ser un número válido.',
            'precio.min'                  => 'El precio debe ser mayor a cero.',
            'stock.required'              => 'Indica la cantidad de guías disponibles por día.',
            'stock.min'                   => 'Debe haber al menos 1 guía disponible.',
            'numero_max_persona.required' => 'Debes indicar el límite de personas por guía.',
            'numero_max_persona.min'      => 'El límite debe ser de al menos 1 persona.',
        ];
    }

    /**
     * Ejecuta la lógica de negocio final directamente
     */
    public function guardar(GuianzaService $service)
    {
        $this->validate();

        try {
            // Preparamos los arrays de datos al igual que en Hospedaje
            $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
            $datosDetalle = ['numero_max_persona' => $this->numero_max_persona];

            // Inyección: Pasamos los datos a la capa de Servicio
            // Inyección: Pasamos los datos a la capa de Servicio
            $service->crear($this->pivotId, $datosBase, $datosDetalle);
            // Limpiamos la memoria
            $this->reset(['descripcion', 'precio', 'stock', 'numero_max_persona']);
            
            // Notificamos que el servicio fue creado
            $this->dispatch('servicio-creado'); 
            
            // Preparamos la alerta de éxito para la vista del Gestor
            session()->flash('success', '¡Registro exitoso! El servicio de guía ha sido creado.');

            // Redirección con el parámetro de la pestaña para que no parpadee ni se pierda
            return redirect()->route('emprendimiento.servicios.index', ['tab' => $this->pivotId]);

        } catch (\Exception $e) {
            Log::error("Error crítico en transacción de Guianza: " . $e->getMessage());
            session()->flash('error', 'No se pudo completar el registro. Intente más tarde.');
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.crear-guianza');
    }
}