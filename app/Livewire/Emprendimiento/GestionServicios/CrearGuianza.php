<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout; 
use App\Services\GuianzaService;
use App\Rules\NoHtmlTags;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador de UI para la creación de Guianzas.
 * Capa de Interactividad: Recibe, valida y delega.
 */
#[Layout('layouts.app.sidebar_emprendimiento')] 
class CrearGuianza extends Component
{
    public int $pivotId;
    
    // Asignamos el nombre por defecto desde el inicio
    public string $nombre = 'Servicio de Guía Turístico'; 
    public string $descripcion = '';
    public float|int|null $precio = null;
    public int $stock = 0;
    public int $numero_max_persona = 1;

    /**
     * Método mount para capturar el pivotId desde la URL
     */
    public function mount(int $pivotId): void
    {
        $this->pivotId = $pivotId;
    }

    /**
     * Reglas de validación (Capa de Seguridad de Entrada)
     */
    protected function rules()
    {
        return [
            'nombre'             => ['required', 'string', 'min:3', 'max:100', new NoHtmlTags()],
            'descripcion'        => ['required', 'string', 'min:10', 'max:1000', new NoHtmlTags()],
            'precio'             => 'required|numeric|min:0.01|max:1000|regex:/^\d+(\.\d{1,2})?$/',
            'stock'              => 'required|integer|min:1|max:1000',
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
            'nombre.required'             => 'El nombre del servicio es obligatorio.',
            'nombre.min'                  => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max'                  => 'El nombre no puede exceder 100 caracteres.',
            'descripcion.required'        => 'Por favor, describe los lugares o rutas que puede guiar.',
            'descripcion.min'             => 'La descripción debe tener al menos 10 caracteres.',
            'descripcion.max'             => 'La descripción no puede exceder 1000 caracteres.',
            'precio.required'             => 'El precio por día es obligatorio.',
            'precio.numeric'              => 'El precio debe ser un número válido.',
            'precio.min'                  => 'El precio debe ser mayor a cero.',
            'precio.max'                  => 'El precio no puede exceder $1000.',
            'precio.regex'                => 'El precio debe tener máximo 2 decimales.',
            'stock.required'              => 'Indica la cantidad de guías disponibles por día.',
            'stock.min'                   => 'Debe haber al menos 1 guía disponible.',
            'stock.max'                   => 'El stock no puede exceder 1000 unidades.',
            'numero_max_persona.required' => 'Debes indicar el límite de personas por guía.',
            'numero_max_persona.min'      => 'El límite debe ser de al menos 1 persona.',
        ];
    }

    /**
     * Ejecuta la lógica de negocio final directamente
     */
    public function guardar(GuianzaService $service)
    {
        // Verificar rol de seguridad
        $user = Auth::user();
        if (!$user instanceof User || !$user->hasRole('emprendimiento')) {
            session()->flash('error', 'No tienes permiso para realizar esta acción.');
            return;
        }

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