<?php

namespace App\Livewire\Emprendimiento\Reserva;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\{Computed, Reactive};
use App\Services\ServicioService;
use App\Services\InventarioService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ListaServiciosReservas extends Component
{
    #[Reactive] public ?string $filtroCategoria  = '';
    #[Reactive] public ?string $nombreCategoria  = ''; 
    #[Reactive] public ?bool   $busquedaActiva   = false;
    #[Reactive] public ?bool   $metaAlcanzada    = false;
    #[Reactive] public ?string $fechaBusqueda    = '';
    #[Reactive] public ?string $fechaFinBusqueda = '';
    #[Reactive] public ?int    $personasBusqueda = 1;
    
    #[Reactive] public array   $carrito          = [];

    public array $cantidades = [];
    public array $horas      = [];

    private function limpiarNombre(): string { return Str::slug($this->nombreCategoria ?? '', ' '); }
    
    private function esHospedaje(): bool { return str_contains($this->limpiarNombre(), 'hospedaje'); }
    private function esGuianza(): bool { return str_contains($this->limpiarNombre(), 'guianza'); }
    private function esPaquete(): bool { return str_contains($this->limpiarNombre(), 'paquete'); }
    private function esAlquiler(): bool { return str_contains($this->limpiarNombre(), 'alquiler'); }
    private function esAlimentacion(): bool { return str_contains($this->limpiarNombre(), 'aliment'); }

    #[Computed]
    public function servicios()
    {
        if (!($this->busquedaActiva ?? false) || empty($this->filtroCategoria)) {
            return collect();
        }

        $emprendimientoId = Auth::user()->emprendimiento->id ?? null;
        if (!$emprendimientoId) return collect();

        $serviciosBrutos = app(ServicioService::class)->obtenerServiciosParaReserva(
            (int) $emprendimientoId,
            $this->filtroCategoria
        );

        $inventario = app(InventarioService::class);
        $serviciosDisponibles = collect();

        $fechaInicioCheck = $this->fechaBusqueda;
        $fechaFinCheck    = $this->esPaquete() ? $this->fechaBusqueda : $this->fechaFinBusqueda;

        if(empty($fechaInicioCheck)) return collect();

        foreach ($serviciosBrutos as $servicio) {
            
            $disponiblesBD = $inventario->calcularDisponibilidadEnRango(
                $servicio->id,
                $fechaInicioCheck,
                $fechaFinCheck ?: $fechaInicioCheck
            );

            $cantidadEnCarrito = 0;
            if (!empty($this->carrito)) {
                foreach ($this->carrito as $item) {
                    if ($item['id'] === $servicio->id) {
                        $cantidadEnCarrito += $item['cantidad'];
                    }
                }
            }

            $cuposReales = $disponiblesBD - $cantidadEnCarrito;

            if ($cuposReales <= 0) continue;

            $servicio->cupos_libres = $cuposReales;

            $capacidad = 1;
            if ($servicio->detalleHospedaje) {
                $capacidad = (int) $servicio->detalleHospedaje->capacidad;
            } elseif ($servicio->detalleGuianza) {
                $capacidad = (int) $servicio->detalleGuianza->numero_max_persona;
            }
            $servicio->capacidad_unitaria = max(1, $capacidad);

            if (!isset($this->cantidades[$servicio->id])) {
                $this->cantidades[$servicio->id] = 1;
            }

            $serviciosDisponibles->push($servicio);
        }

        return $serviciosDisponibles;
    }

    public function agregarServicio(int $servicioId): void
    {
        $servicio = $this->servicios->firstWhere('id', $servicioId);
        if (!$servicio) return;

        $cantidadElegida = (int) ($this->cantidades[$servicioId] ?? 1);
        $horaElegida     = $this->horas[$servicioId] ?? '';

        if ($cantidadElegida < 1 || $cantidadElegida > $servicio->cupos_libres) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => "Cantidad inválida. Máximo {$servicio->cupos_libres}."]);
            return;
        }

        $requiereHora = !$this->esPaquete();
        if ($requiereHora && empty($horaElegida)) {
            $this->dispatch('notificar', ['tipo' => 'warning', 'mensaje' => 'Debe especificar una hora.']);
            return;
        }

        $fechaInicio = $this->fechaBusqueda;
        $fechaFin    = $this->fechaFinBusqueda ?: $fechaInicio;
        $horaFinal   = $horaElegida ?: null;
        
        $diasCalculados = max(1, Carbon::parse($fechaInicio)->diffInDays(Carbon::parse($fechaFin)) + 1);

        if ($this->esPaquete()) {
            // Control de 3 días de anticipación para paquetes
            $fechaInicioCarbon = Carbon::parse($fechaInicio)->startOfDay();
            $fechaMinimaPermitida = now()->startOfDay()->addDays(3);

            if ($fechaInicioCarbon->lt($fechaMinimaPermitida)) {
                $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Los paquetes turísticos deben reservarse con al menos 3 días de anticipación.']);
                return;
            }

            $duracion = (int) ($servicio->detallePaqueteTuristico->duracion_dias ?? 1);
            $fechaFin = Carbon::parse($fechaInicio)->addDays(max(0, $duracion - 1))->format('Y-m-d');
            if (!empty($servicio->detallePaqueteTuristico->hora_salida)) {
                $horaFinal = Carbon::parse($servicio->detallePaqueteTuristico->hora_salida)->format('H:i');
            }
            $subtotal = $servicio->precio * $cantidadElegida;
        } elseif ($this->esAlquiler()) {
            $subtotal = $servicio->precio * $cantidadElegida * $diasCalculados;
        } else {
            $fechaFin = $fechaInicio;
            $subtotal = $servicio->precio * $cantidadElegida;
        }

        $this->dispatch('agregar-al-carrito', item: [
            'id'                 => $servicio->id,
            'nombre'             => $servicio->nombre,
            'categoria'          => $this->filtroCategoria,
            'categoria_nombre'   => $this->nombreCategoria,
            'cantidad'           => $cantidadElegida,
            'numero_personas'    => 1,
            'capacidad_aportada' => 0,
            'fecha'              => $fechaInicio, 
            'fecha_inicio'       => $fechaInicio,
            'fecha_fin'          => $fechaFin,
            'hora'               => $horaFinal,
            'precio'             => $servicio->precio,
            'subtotal'           => $subtotal,
        ]);

        $this->cantidades[$servicioId] = 1;
        $this->horas[$servicioId]      = '';
    }

    public function agregarHospedaje(int $servicioId, int $personasAsignadas, int $cantidadElegida): void
    {
        $servicio = $this->servicios->firstWhere('id', $servicioId);
        if (!$servicio) return;

        $horaElegida = $this->horas[$servicioId] ?? '';
        $esGuianza = $this->esGuianza();

        if ($cantidadElegida < 1 || $cantidadElegida > $servicio->cupos_libres) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => "Cantidad inválida. Máximo {$servicio->cupos_libres}."]);
            return;
        }

        if (empty($horaElegida)) {
            $this->dispatch('notificar', ['tipo' => 'warning', 'mensaje' => 'Debe especificar una hora.']);
            return;
        }

        $fechaInicio = $this->fechaBusqueda;
        $fechaFin    = $this->fechaFinBusqueda ?: $fechaInicio;
        
        $dias = max(1, Carbon::parse($fechaInicio)->diffInDays(Carbon::parse($fechaFin)) + 1);
        
        if ($esGuianza) {
            $subtotal = $servicio->precio * $cantidadElegida * $dias;
            $capacidadAportada = $servicio->capacidad_unitaria * $cantidadElegida;
        } else {
            $subtotal = $servicio->precio * $personasAsignadas * $cantidadElegida * $dias;
            $capacidadAportada = $personasAsignadas * $cantidadElegida;
        }

        $this->dispatch('agregar-al-carrito', item: [
            'id'                 => $servicio->id,
            'nombre'             => $servicio->nombre,
            'categoria'          => $this->filtroCategoria,
            'categoria_nombre'   => $this->nombreCategoria,
            'cantidad'           => $cantidadElegida,
            'numero_personas'    => $esGuianza ? 0 : $personasAsignadas,
            'capacidad_aportada' => $capacidadAportada,
            'fecha'              => $fechaInicio, 
            'fecha_inicio'       => $fechaInicio,
            'fecha_fin'          => $fechaFin,
            'hora'               => $horaElegida ?: null,
            'precio'             => $servicio->precio,
            'subtotal'           => $subtotal,
        ]);

        $this->horas[$servicioId] = '';
    }

    public function render()
    {
        return view('livewire.emprendimiento.reserva.lista-servicios-reservas');
    }
}