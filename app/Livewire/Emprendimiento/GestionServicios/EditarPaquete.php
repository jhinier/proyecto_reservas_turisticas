<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads; // Soporte para archivos
use App\Models\Servicio;
use Illuminate\Http\UploadedFile;
use App\Services\PaqueteTuristicoService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EditarPaquete extends Component
{
    use WithFileUploads; // Importante para el PDF

    public bool $abierto = false;
    public int $servicioId;

    public string $nombre = '';
    public string $descripcion = '';
    public float|int|string|null $precio = null;
    public int|string|null $stock = null;
    public string $lugar_salida = '';
    public ?string $hora_salida = null;
    public int|string|null $duracion_dias = null;
    public string $servicios_incluidos = '';
    public string $lugares_actividades = '';
    public string $recomendaciones = '';

    // Variables para el archivo itinerario
    public ?string $documento = null;
    public ?UploadedFile $nuevo_documento = null;

    protected function rules()
    {
        return [
            'nombre' => 'required|string|min:3|max:150',
            'descripcion' => 'required|string|min:10|max:500',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:1',
            'lugar_salida' => 'required|string|max:150',
            'hora_salida' => 'required',
            'duracion_dias' => 'required|integer|min:1',
            'servicios_incluidos' => 'required|string|max:500',
            'lugares_actividades' => 'required|string|max:500',
            'recomendaciones' => 'required|string|max:500',
            'nuevo_documento' => 'nullable|mimes:pdf|max:5120', // Valida que sea PDF
        ];
    }

    #[On('abrir-editar-paquete')] 
    public function cargarDatos(int $id)
    {
        $this->servicioId = $id;
        
        $servicio = Servicio::with('detallePaqueteTuristico')->findOrFail($id);
        
        $this->nombre = $servicio->nombre;
        $this->descripcion = $servicio->descripcion;
        $this->precio = $servicio->precio;
        $this->stock = $servicio->stock;
        
        if ($servicio->detallePaqueteTuristico) {
            $detalle = $servicio->detallePaqueteTuristico;
            $this->lugar_salida = $detalle->lugar_salida;
            $this->hora_salida = $detalle->hora_salida;
            $this->duracion_dias = $detalle->duracion_dias;
            $this->servicios_incluidos = $detalle->servicios_incluidos;
            $this->lugares_actividades = $detalle->lugares_actividades;
            $this->recomendaciones = $detalle->recomendaciones;
            $this->documento = $detalle->documento; // Carga el PDF actual
        }
    
        $this->resetValidation();
        $this->abierto = true;
    }

    public function actualizar(PaqueteTuristicoService $service)
    {
        $this->validate();

        try {
            $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
            $datosDetalle = $this->only([
                'lugar_salida', 'hora_salida',
                'duracion_dias', 'servicios_incluidos', 
                'lugares_actividades', 'recomendaciones'
            ]);

            // Si subiste un PDF nuevo, lo guardamos
            if ($this->nuevo_documento) {
                $ruta = $this->nuevo_documento->store('itinerarios', 'public');
                $datosDetalle['documento'] = $ruta;
            }

            $service->actualizar($this->servicioId, $datosBase, $datosDetalle);

            $this->dispatch('servicio-actualizado');
            $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Paquete actualizado con éxito.']);
            $this->abierto = false;
            $this->reset('nuevo_documento');

        } catch (\Exception $e) {
            Log::error("Error al actualizar Paquete: " . $e->getMessage());
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Ocurrió un error al guardar.']);
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.editar-paquete');
    }
}
