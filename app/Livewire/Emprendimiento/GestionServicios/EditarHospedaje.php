<?php

namespace App\Livewire\Emprendimiento\GestionServicios;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Servicio;
use App\Services\HospedajeService;
use Illuminate\Support\Facades\Log;

class EditarHospedaje extends Component
{
    // 🔥 Variable para controlar la visibilidad del modal
    public bool $abierto = false;

    public int $servicioId;
    public int $pivotId;
    
    // Datos del formulario
    public string $nombre = '';
    public string $descripcion = '';
    public float|int|null $precio = null;
    public int|null $stock = null;
    public int|null $capacidad = null;

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
     * 🔥 Escucha el evento y carga los datos cuando se hace clic en "Editar"
     */
    #[On('abrir-editar-hospedaje')]
    public function cargarDatos(int $id)
    {
        $this->servicioId = $id;
        
        $servicio = Servicio::with('detalleHospedaje')->findOrFail($id);
        
        $this->pivotId = $servicio->emprendimiento_tipo_servicio_id;
        
        // Llenar el formulario
        $this->nombre = $servicio->nombre;
        $this->descripcion = $servicio->descripcion;
        $this->precio = $servicio->precio;
        $this->stock = $servicio->stock;
        
        if ($servicio->detalleHospedaje) {
            $this->capacidad = $servicio->detalleHospedaje->capacidad;
        }

        $this->resetValidation();
        $this->abierto = true; // 🔥 Muestra el modal
    }

    /**
     * Actualiza la información en la base de datos
     */
    public function actualizar(HospedajeService $service)
    {
        $this->validate();

        try {
            $datosBase = $this->only(['nombre', 'descripcion', 'precio', 'stock']);
            $datosDetalle = ['capacidad' => $this->capacidad];

            $service->actualizar($this->servicioId, $datosBase, $datosDetalle);

            // Disparamos un evento para avisar a ListaServicios que recargue la cuadrícula
            $this->dispatch('servicio-actualizado');
            
            // Notificamos éxito y cerramos el modal
            $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => 'Hospedaje actualizado con éxito.']);
            $this->abierto = false;

        } catch (\Exception $e) {
            Log::error("Error al actualizar Hospedaje ID {$this->servicioId}: " . $e->getMessage());
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Ocurrió un error al guardar.']);
        }
    }

    public function render()
    {
        return view('livewire.emprendimiento.gestion-servicios.editar-hospedaje');
    }
}