<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Servicio;
use App\Services\ImagenEmprendimientoService;
use Livewire\Attributes\On;

class GestorGaleria extends Component
{
    use WithFileUploads;

    public bool $abierto = false;
    public ?Servicio $servicio = null;
    public $nuevasImagenes = [];

    /**
     * Escucha el evento para abrir el modal y cargar los datos del servicio.
     */
    #[On('abrir-gestor-galeria')]
    public function cargarGaleria(int $servicioId)
    {
        $this->servicio = Servicio::with('imagenes')->findOrFail($servicioId);
        $this->abierto = true;
        $this->nuevasImagenes = [];
        $this->resetErrorBag();
    }

    /**
     * Elimina una imagen existente usando el Service especializado.
     */
    public function eliminarImagen(int $imagenId, ImagenEmprendimientoService $service)
    {
        // Usamos el método que creamos en el Service de imágenes
        $service->eliminarPorId($imagenId);
        
        // Refrescamos la relación para que desaparezca de la vista
        $this->servicio->load('imagenes'); 
        
        $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Imagen eliminada.']);
        
        // 🔥 EL GRITO: Avisamos a la lista que la galería cambió al borrar
        $this->dispatch('galeria-actualizada');
    }

    /**
     * Remueve una imagen de la lista de previsualización antes de subirla.
     */
    public function removerTemporal($index)
    {
        if (isset($this->nuevasImagenes[$index])) {
            unset($this->nuevasImagenes[$index]);
            $this->nuevasImagenes = array_values($this->nuevasImagenes);
        }
    }

    /**
     * Valida y sube las nuevas fotos al servidor y base de datos.
     */
    public function subirFotos(ImagenEmprendimientoService $service)
    {
        // 1. Validación con mensajes en español y límite de 5MB
        $this->validate([
            'nuevasImagenes.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120'
        ], [
            'nuevasImagenes.*.image' => 'El archivo debe ser una imagen válida.',
            'nuevasImagenes.*.mimes' => 'Formato no permitido (Solo JPG, PNG, WEBP).',
            'nuevasImagenes.*.max'   => 'Una de las imágenes pesa más de 5MB.',
        ]);

        // 2. Llamada al servicio para procesar la subida
        $service->subirImagenes($this->servicio->id, $this->nuevasImagenes);
        
        // 3. Limpieza y refresco
        $this->reset('nuevasImagenes');
        $this->servicio->load('imagenes'); 
        
        $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Galería actualizada con éxito.']);
        
        // 🔥 EL GRITO: Avisamos a la lista que la galería cambió al subir nuevas fotos
        $this->dispatch('galeria-actualizada');
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestor-galeria');
    }
}