<?php

namespace App\Livewire\Turista\Servicios;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use App\Models\Emprendimiento;
use App\Models\TipoServicio;
use App\Services\CatalogoReservaService;
use App\Services\InventarioService;
use Illuminate\Support\Str;

class VerServicios extends Component
{
    public Emprendimiento $emprendimiento;
    public TipoServicio $tipoServicio;

    public string $fechaInicio = '';
    public string $fechaFin = '';
    public string $horaLlegada = '';
    public int $huespedesGlobales = 1;
    public ?int $tipoServicioSeleccionado = null;

    public bool $busquedaRealizada = false;
    public array $servicios = [];

    public array $cantidadesTarjetas = [];
    public array $personasTarjetas = [];

    public array $carrito = [];
    public bool $metaAlcanzada = false;
    public int $capacidadActual = 0;
    
    public array $capacidadesServicios = []; // Para la capacidad máxima
public array $disponibilidadServicios = []; // Para el stock restante

    public function mount(Emprendimiento $emprendimiento, $tipo = null)
    {
        $this->emprendimiento = $emprendimiento;
        $this->tipoServicioSeleccionado = $tipo ? (int) $tipo : null;

        $this->tipoServicio = $tipo
            ? TipoServicio::findOrFail($tipo)
            : TipoServicio::first();

        $this->fechaInicio = $this->esPaquete()
            ? now()->addDays(3)->toDateString()
            : now()->toDateString();

        if ($this->requiereFechaFin()) {
            $this->fechaFin = now()->addDay()->toDateString();
        }
        if ($this->requiereHora()) {
            $this->horaLlegada = '12:00';
        }

        $this->ejecutarBusqueda(app(CatalogoReservaService::class), app(InventarioService::class));
    }

    public function getNombreTipoProperty(): string
    {
        return Str::slug($this->tipoServicio->nombre, ' ');
    }

    public function esHospedaje(): bool { return str_contains($this->nombreTipo, 'hospedaje'); }
    public function esPaquete(): bool   { return str_contains($this->nombreTipo, 'paquete'); }
    public function esAlquiler(): bool  { return str_contains($this->nombreTipo, 'alquiler'); }
    public function esGuianza(): bool   { return str_contains($this->nombreTipo, 'guianza'); }
    public function requiereFechaFin(): bool { return $this->esHospedaje() || $this->esAlquiler() || $this->esGuianza(); }
    public function requiereHora(): bool     { return $this->esHospedaje() || $this->esGuianza() || $this->esAlquiler(); }

    public function buscar(CatalogoReservaService $catalogoService, InventarioService $inventarioService): void
    {
        $reglas = ['fechaInicio' => 'required|date|after_or_equal:today'];

        if ($this->esPaquete()) {
            $reglas['fechaInicio'] = 'required|date|after_or_equal:' . now()->addDays(3)->toDateString();
        }
        if ($this->requiereFechaFin()) {
            $reglas['fechaFin'] = 'required|date|after_or_equal:fechaInicio';
        }
        if ($this->requiereHora()) {
            $reglas['horaLlegada'] = 'required|date_format:H:i';
        }

        $this->validate($reglas);
        $this->ejecutarBusqueda($catalogoService, $inventarioService);
        $this->evaluarMetaCapacidad();
    }

    private function ejecutarBusqueda(CatalogoReservaService $catalogoService, InventarioService $inventarioService): void
    {
        $resultados = $catalogoService->buscarDisponibilidad(
            $this->emprendimiento->id,
            $this->tipoServicio->id,
            ['fecha_inicio' => $this->fechaInicio, 'fecha_fin' => $this->fechaFin]
        );

        $fechaFinCheck = $this->esPaquete() ? $this->fechaInicio : $this->fechaFin;
        $serviciosDisponibles = collect();

        foreach ($resultados as $servicio) {
        $disponiblesBD = $inventarioService->calcularDisponibilidadEnRango(
            $servicio->id, $this->fechaInicio, $fechaFinCheck ?: $this->fechaInicio
        );

        $cantidadEnCarrito = collect($this->carrito)->where('id', $servicio->id)->sum('cantidad');
        $cuposReales = $disponiblesBD - (int) $cantidadEnCarrito;
        
        // Guardamos en los arrays persistentes
        $this->disponibilidadServicios[$servicio->id] = $cuposReales;

        $capacidad = 1;
        if ($servicio->detalleHospedaje) {
            $capacidad = (int) $servicio->detalleHospedaje->capacidad;
        } elseif ($servicio->detalleGuianza) {
            $capacidad = (int) $servicio->detalleGuianza->numero_max_persona;
        }
        
        $this->capacidadesServicios[$servicio->id] = max(1, $capacidad);

        if ($cuposReales <= 0) continue;

        $this->cantidadesTarjetas[$servicio->id] ??= 1;
        if ($this->esHospedaje()) {
            $this->personasTarjetas[$servicio->id] ??= 1;
        }

        $serviciosDisponibles->push($servicio);
    }

        $this->servicios = $serviciosDisponibles->values()->all();
        $this->busquedaRealizada = true;
    }

    // ─── Métodos llamados directamente con $wire.call() desde Alpine ──────────

    public function aumentarCantidad(int $id): void
    {
        $servicio = collect($this->servicios)->firstWhere('id', $id);
        $max = $servicio ? (int) ($servicio->cupos_libres ?? 99) : 99;
        $this->cantidadesTarjetas[$id] = min($max, ($this->cantidadesTarjetas[$id] ?? 1) + 1);
    }

    public function disminuirCantidad(int $id): void
    {
        $this->cantidadesTarjetas[$id] = max(1, ($this->cantidadesTarjetas[$id] ?? 1) - 1);
    }

    public function aumentarPersonas(int $id): void
    {
        $max = $this->capacidadesServicios[$id] ?? 1;
        $this->personasTarjetas[$id] = min($max, ($this->personasTarjetas[$id] ?? 1) + 1);
    }

    public function disminuirPersonas(int $id): void
    {
        $this->personasTarjetas[$id] = max(1, ($this->personasTarjetas[$id] ?? 1) - 1);
    }

    public function setHuespedes(int $valor): void
    {
        $this->huespedesGlobales = max(1, $valor);
        $this->evaluarMetaCapacidad();
    }

    public function agregarAlCarrito(int $id): void
{
    try {
        $servicio = collect($this->servicios)->firstWhere('id', $id);

        if (!$servicio) {
            $this->ejecutarBusqueda(app(CatalogoReservaService::class), app(InventarioService::class));
            $servicio = collect($this->servicios)->firstWhere('id', $id);
        }

        if (!$servicio) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Servicio no encontrado.']);
            return;
        }

        $cantidadElegida  = (int) ($this->cantidadesTarjetas[$id] ?? 1);
        $personasElegidas = (int) ($this->personasTarjetas[$id]   ?? 1);
        
        // Aquí está la corrección: leemos el stock del array público
        $cuposLibres      = (int) ($this->disponibilidadServicios[$id] ?? 0);

        if ($cuposLibres <= 0) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Sin disponibilidad.']);
            return;
        }

        if ($cantidadElegida < 1 || $cantidadElegida > $cuposLibres) {
            $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => "Máximo disponible: {$cuposLibres}."]);
            return;
        }

        if ($this->requiereHora() && empty($this->horaLlegada)) {
            $this->dispatch('notificar', ['tipo' => 'warning', 'mensaje' => 'Especifica una hora de llegada.']);
            return;
        }

        $fechaFin       = $this->requiereFechaFin() ? $this->fechaFin : $this->fechaInicio;
        $diasCalculados = max(1, Carbon::parse($this->fechaInicio)->diffInDays(Carbon::parse($fechaFin)) + 1);

        $subtotal = $capacidadAportada = 0;
        $horaFinal = null;
        $personasGuardar = 1;

        if ($this->esPaquete()) {
            $duracion    = (int) ($servicio->detallePaqueteTuristico->duracion_dias ?? 1);
            $fechaFin    = Carbon::parse($this->fechaInicio)->addDays(max(0, $duracion - 1))->format('Y-m-d');
            $horaFinal   = $servicio->detallePaqueteTuristico->hora_salida
                ? Carbon::parse($servicio->detallePaqueteTuristico->hora_salida)->format('H:i')
                : null;
            $subtotal    = $servicio->precio * $cantidadElegida;

        } elseif ($this->esAlquiler()) {
            $subtotal  = $servicio->precio * $cantidadElegida * $diasCalculados;
            $horaFinal = $this->horaLlegada;

        } elseif ($this->esHospedaje()) {
            $subtotal          = $servicio->precio * $personasElegidas * $cantidadElegida * $diasCalculados;
            $capacidadAportada = $personasElegidas * $cantidadElegida;
            $horaFinal         = $this->horaLlegada;
            $personasGuardar   = $personasElegidas;

        } elseif ($this->esGuianza()) {
            $subtotal          = $servicio->precio * $cantidadElegida * $diasCalculados;
            $capacidadAportada = ($servicio->detalleGuianza->numero_max_persona ?? 1) * $cantidadElegida;
            $horaFinal         = $this->horaLlegada;
            $personasGuardar   = 0;

        } else {
            $subtotal = $servicio->precio * $cantidadElegida;
        }

        $this->carrito[] = [
            'id'                 => $servicio->id,
            'nombre'             => $servicio->nombre,
            'categoria'          => $this->tipoServicio->nombre,
            'categoria_nombre'   => $this->tipoServicio->nombre,
            'cantidad'           => $cantidadElegida,
            'numero_personas'    => $personasGuardar,
            'capacidad_aportada' => $capacidadAportada,
            'fecha_inicio'       => $this->fechaInicio,
            'fecha_fin'          => $fechaFin,
            'hora'               => $horaFinal,
            'subtotal'           => $subtotal,
        ];

        $this->cantidadesTarjetas[$id] = 1;
        if ($this->esHospedaje()) {
            $this->personasTarjetas[$id] = 1;
        }

        $this->ejecutarBusqueda(app(CatalogoReservaService::class), app(InventarioService::class));
        $this->evaluarMetaCapacidad();

        $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => '¡Servicio añadido!']);
        $this->dispatch('servicio-agregado');

    } catch (\Exception $e) {
        \Log::error('Error en agregarAlCarrito: ' . $e->getMessage());
        $this->dispatch('notificar', ['tipo' => 'error', 'mensaje' => 'Error al procesar.']);
    }
}

    #[On('quitar-del-carrito')]
    public function quitarDelCarrito(int $index): void
    {
        if (isset($this->carrito[$index])) {
            unset($this->carrito[$index]);
            $this->carrito = array_values($this->carrito);
            $this->ejecutarBusqueda(app(CatalogoReservaService::class), app(InventarioService::class));
            $this->evaluarMetaCapacidad();
            $this->dispatch('notificar', ['tipo' => 'info', 'mensaje' => 'Servicio eliminado.']);
        }
    }

    public function evaluarMetaCapacidad(): void
    {
        if (!$this->esHospedaje() && !$this->esGuianza()) {
            $this->metaAlcanzada = true;
            return;
        }
        $this->capacidadActual = (int) collect($this->carrito)->sum('capacidad_aportada');
        $this->metaAlcanzada   = $this->capacidadActual >= $this->huespedesGlobales;
    }

    public function irAlCheckout(): void
    {
        $this->evaluarMetaCapacidad();

        if (!$this->metaAlcanzada && ($this->esHospedaje() || $this->esGuianza())) {
            $this->dispatch('notificar', ['tipo' => 'warning', 'mensaje' => 'Debes cubrir la capacidad para ' . $this->huespedesGlobales . ' personas.']);
            return;
        }

        session()->put('reserva_turista_carrito', $this->carrito);
        session()->put('reserva_turista_datos', [
            'fechaInicio'       => $this->fechaInicio,
            'fechaFin'          => $this->fechaFin,
            'horaLlegada'       => $this->horaLlegada,
            'emprendimiento_id' => $this->emprendimiento->id,
            'total'             => collect($this->carrito)->sum('subtotal'),
        ]);

        $this->redirect(route('turista.reservas.checkout'), navigate: true);
    }

    #[Layout('layouts.turista')]
    public function render()
    {
        return view('livewire.turista.servicios.ver-servicios', [
            'servicios' => $this->servicios,
        ]);
    }
}