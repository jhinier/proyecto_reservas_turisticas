<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\Layout; 
use Livewire\WithFileUploads; 
use App\Services\ServicioService;
use Illuminate\Support\Facades\Log;

/**
 * Controlador de UI para la creación de Hospedajes.
 * Capa de Interactividad: Recibe, valida y delega.
 */
#[Layout('layouts.app.sidebar_emprendimiento')] 
class CrearHospedaje extends Component
{
    use WithFileUploads; // 🔥 2. Activamos la carga de archivos en el componente

    public $pivotId;
    public $nombre, $descripcion, $precio, $stock, $capacidad;
    
    public $imagenes = []; // 🔥 3. Array para almacenar las fotos temporalmente

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
            'nombre'      => 'required|string|min:3|max:100',
            'descripcion' => 'required|string|min:10|max:500',
            'precio'      => 'required|numeric|min:0.01',
            'stock'       => 'required|integer|min:1',
            'capacidad'   => 'required|integer|min:1',
            // 🔥 Seguridad: Previene subida de scripts maliciosos y limita peso a 2MB para cuidar el servidor
            'imagenes.*'  => 'image|mimes:jpeg,png,jpg,webp|max:2048', 
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
            
            // 🔥 Mensajes de error para las imágenes
            'imagenes.*.image'     => 'El archivo debe ser una imagen válida.',
            'imagenes.*.mimes'     => 'Formato no permitido (Solo JPG, PNG, WEBP).',
            'imagenes.*.max'       => 'Cada imagen no debe pesar más de 2MB.',
        ];
    }

    /**
     * Elimina una imagen del array temporal antes de ser guardada.
     * * @param int $index Índice de la imagen en el array.
     */
    public function eliminarImagen($index)
    {
        // Verificamos si el índice existe por seguridad
        if (isset($this->imagenes[$index])) {
            // Eliminamos el archivo del array temporal
            unset($this->imagenes[$index]);
            
            // REINDEXAR: Vital para que Livewire no confunda los índices al renderizar
            $this->imagenes = array_values($this->imagenes);
            
            // Log para auditoría técnica (Opcional en desarrollo)
            Log::info("Imagen descartada en el índice: {$index}");
        }
    }

    /**
     * Ejecuta la lógica de negocio final directamente
     */
    public function guardar(ServicioService $service)
    {
        $this->validate();

        try {
            $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
            $datosDetalle = ['capacidad' => $this->capacidad];

            // 🔥 4. Inyección: Pasamos los datos y las imágenes a la capa de Servicio
            $service->crearHospedaje($this->pivotId, $datosBase, $datosDetalle, $this->imagenes);

            // 🔥 Limpiamos la memoria, incluyendo el array de imágenes
            $this->reset(['nombre', 'descripcion', 'precio', 'stock', 'capacidad', 'imagenes']);
            
            // Notificamos que el servicio fue creado
            $this->dispatch('servicio-creado'); 
            
            // Preparamos la alerta de éxito para la vista del Gestor
            session()->flash('success', '¡Registro exitoso! La habitación ha sido creada.');
            session()->flash('tab_activa', $this->pivotId);

            // Redirección clásica y sólida
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