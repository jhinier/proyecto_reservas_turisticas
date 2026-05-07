<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;
use App\Services\ReservaService;
use App\Models\Servicio;
use Illuminate\Support\Facades\Log;

class FormularioReserva extends Component
{
    public bool $mostrar = false;
    public ?Servicio $servicio = null;
    public string $fecha = '';
    public string $fechaFin = '';
    public string $hora = '';
    public int $cantidad = 1;
    public int $numeroPersonasGroup = 1; 
    public int $disponibilidad = 0;
    public array $fechasAgotadas = [];

    #[Computed]
    public function unidadMedida()
    {
        if (!$this->servicio) return 'Cantidad';
        
        $tipo = strtolower($this->servicio->tipoServicio->nombre ?? '');
        
        if (str_contains($tipo, 'hospedaje')) return 'Habitaciones';
        if (str_contains($tipo, 'guianza')) return 'Guías';
        if (str_contains($tipo, 'paquete')) return 'Cupos';
        if (str_contains($tipo, 'alquiler')) return 'Unidades';
        if (str_contains($tipo, 'alimentación') || str_contains($tipo, 'alimentacion')) return 'Platos';
        
        return 'Cantidad';
    }

    #[Computed]
    public function requiereFechaFin()
    {
        if (!$this->servicio) return false;
        $tipo = strtolower($this->servicio->tipoServicio->nombre ?? '');
        return str_contains($tipo, 'hospedaje') || str_contains($tipo, 'alquiler') || str_contains($tipo, 'guianza');
    }

    #[Computed]
    public function esPaquete()
    {
        if (!$this->servicio) return false;
        $tipo = strtolower($this->servicio->tipoServicio->nombre ?? '');
        return str_contains($tipo, 'paquete');
    }

    #[On('prepararAgendamiento')]
    public function abrir(int $id, ReservaService $service)
    {
        try {
            $this->servicio = Servicio::with([
                'tipoServicio',
                'detalleAlimentacion',
                'detalleHospedaje',
                'detalleGuianza',
                'detallePaqueteTuristico',
            ])->findOrFail($id);
            
            $this->fechasAgotadas = $service->obtenerFechasAgotadas($id);
            
            $this->fecha = '';
            $this->fechaFin = '';
            $this->hora = '';
            $this->cantidad = 1;
            $this->numeroPersonasGroup = 1; 
            $this->disponibilidad = 0;
            $this->mostrar = true;
            
        } catch (\Exception $e) {
            Log::error("Error al abrir agendador: " . $e->getMessage());
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'No se pudo cargar el servicio.']);
        }
    }

    // 1. Hook cuando cambia la FECHA DE INICIO
    public function updatedFecha()
    {
        $this->revisarStock();
    }

    // 2. Hook cuando cambia la FECHA DE FIN
    public function updatedFechaFin()
    {
        $this->revisarStock();
    }

    // 3. Centralizamos la lógica de revisión del Cuello de Botella
    private function revisarStock()
    {
        // Reseteamos fecha fin si es menor a inicio
        if ($this->fecha && $this->fechaFin && $this->fechaFin < $this->fecha) {
            $this->fechaFin = $this->fecha;
        }

        if ($this->servicio && $this->fecha) {
            $fechaFinConsulta = ($this->requiereFechaFin && $this->fechaFin) 
                ? $this->fechaFin 
                : $this->fecha;
    
            $this->disponibilidad = app(ReservaService::class)->calcularDisponibilidadEnRango(
                $this->servicio->id, 
                $this->fecha, 
                $fechaFinConsulta
            );

            // CONTROL ESTRICTO: Si el turista pidió 9 pero el cuello de botella dice 3, bajamos a 3.
            if ($this->disponibilidad > 0 && $this->cantidad > $this->disponibilidad) {
                $this->cantidad = $this->disponibilidad;
                $this->dispatch('notificar', [
                    'tipo' => 'warning', 
                    'mensaje' => 'Disponibilidad ajustada debido a las reservas en las fechas intermedias.'
                ]);
            }
            return;
        }
    
        $this->disponibilidad = 0;
    }

    public function updatedCantidad(int|string|null $value): void
    {
        $value = (int) $value;
        $esAlimentacion = str_contains(strtolower($this->servicio->tipoServicio->nombre ?? ''), 'alimentaci');

        if (!$esAlimentacion && $this->disponibilidad > 0 && $value > $this->disponibilidad) {
            $this->dispatch('notificar', [
                'tipo' => 'warning', 
                'mensaje' => 'Solo hay ' . $this->disponibilidad . ' ' . strtolower($this->unidadMedida) . ' disponibles.'
            ]);
        }
    }

    // Ya no necesitamos 'actualizarDisponibilidad' público porque 'revisarStock' hace el trabajo

    public function agregarAlResumen()
    {
        $rules = [
            'fecha' => 'required|date|after_or_equal:today',
            'cantidad' => 'required|integer|min:1',
        ];

        if (!$this->esPaquete) {
            $rules['hora'] = 'required';
        }

        if ($this->requiereFechaFin) {
            $rules['fechaFin'] = 'required|date|after_or_equal:fecha';
        }

        $esAlimentacion = str_contains(strtolower($this->servicio->tipoServicio->nombre ?? ''), 'alimentaci');

        if ($this->disponibilidad !== 999 && !$esAlimentacion) {
            $rules['cantidad'] .= "|max:{$this->disponibilidad}";
        }

        if ($this->servicio->detalleHospedaje || $this->servicio->detalleGuianza) {
            $rules['numeroPersonasGroup'] = 'required|integer|min:1';
        }

        $this->validate($rules, [
            'cantidad.max' => 'La cantidad supera los cupos disponibles para el rango de fechas.',
            'fechaFin.after_or_equal' => 'La fecha de fin no puede ser menor a la fecha de inicio.'
        ]);

        $capacidadUnidad = 0;
        if ($this->servicio->detalleHospedaje) {
            $capacidadUnidad = $this->servicio->detalleHospedaje->capacidad;
        } elseif ($this->servicio->detalleGuianza) {
            $capacidadUnidad = $this->servicio->detalleGuianza->numero_max_persona;
        }

        if ($capacidadUnidad > 0) {
            $totalCapacidadContratada = $this->cantidad * $capacidadUnidad;
            
            if ($this->numeroPersonasGroup > $totalCapacidadContratada) {
                $nombreUnidad = strtolower($this->unidadMedida);
                $this->addError('capacidad', "Lo contratado ({$this->cantidad} {$nombreUnidad}) no abastece a tu grupo ({$this->numeroPersonasGroup} personas). Cada {$nombreUnidad} soporta máximo {$capacidadUnidad} personas.");
                return;
            }
        }

        $fechaFinCalculada = null;
        if ($this->esPaquete && $this->servicio->detallePaqueteTuristico) {
            $dias = $this->servicio->detallePaqueteTuristico->duracion_dias;
            $fechaFinCalculada = \Carbon\Carbon::parse($this->fecha)->addDays(max(0, $dias - 1))->toDateString();
        }

        $this->dispatch('agregar-al-carrito', item: [
            'id' => $this->servicio->id,
            'nombre' => $this->servicio->nombre,
            'cantidad' => $this->cantidad,
            'numero_personas' => $this->numeroPersonasGroup, 
            'fecha' => $this->fecha, 
            'fecha_fin' => $this->requiereFechaFin ? $this->fechaFin : ($this->esPaquete ? $fechaFinCalculada : $this->fecha),
            'hora' => $this->esPaquete ? \Carbon\Carbon::parse($this->servicio->detallePaqueteTuristico->hora_salida)->format('H:i') : $this->hora,
            'precio' => $this->servicio->precio,
            'subtotal' => $this->servicio->precio * $this->cantidad
        ]);
    
        $this->mostrar = false;
    }

    public function render()
    {
        return view('livewire.emprendimiento.reserva.formulario-reserva');
    }
}