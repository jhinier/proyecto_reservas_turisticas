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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class VerServicios extends Component
{
    public Emprendimiento $emprendimiento;
    public TipoServicio $tipoServicio;

    public string $fechaInicio = '';
    public string $fechaFin = '';
    public string $horaLlegada = '';
    public ?int $tipoServicioSeleccionado = null;

    public bool $busquedaRealizada = false;
    public array $servicios = [];

    public array $cantidadesTarjetas = [];
    public array $personasTarjetas = [];

    public array $carrito = [];
    
    public array $capacidadesServicios = [];
    public array $disponibilidadServicios = [];

    public function mount(Emprendimiento $emprendimiento, $tipo = null)
    {
        $this->emprendimiento = $emprendimiento;
        $tipoId = $tipo ?: request()->query('tipo') ?: request()->query('categoria_id');
        $this->tipoServicioSeleccionado = $tipoId ? (int) $tipoId : null;

        $this->tipoServicio = $this->tipoServicioSeleccionado
            ? TipoServicio::findOrFail($this->tipoServicioSeleccionado)
            : TipoServicio::first();

        // 1. Establecemos las fechas por defecto
        $this->fechaInicio = $this->esPaquete()
            ? now()->addDays(3)->toDateString()
            : now()->toDateString();

        if ($this->requiereFechaFin()) {
            $this->fechaFin = now()->addDay()->toDateString();
        }
        if ($this->requiereHora()) {
            $this->horaLlegada = '12:00';
        }

        // 2. Si vienen fechas en la URL tras realizar una reserva, las sobreescribimos
        if (request()->has('fechaInicio') && request()->query('fechaInicio')) {
            $this->fechaInicio = request()->query('fechaInicio');
        }
        if (request()->has('fechaFin') && request()->query('fechaFin')) {
            $this->fechaFin = request()->query('fechaFin');
        }
        if (request()->has('horaLlegada') && request()->query('horaLlegada')) {
            $this->horaLlegada = request()->query('horaLlegada');
        }

        if (request()->boolean('restaurarCarrito')) {
            $datosReserva = session()->get('reserva_turista_datos', []);

            $this->carrito = session()->get('reserva_turista_carrito', []);
            $this->fechaInicio = request()->query('fechaInicio') ?: ($datosReserva['fechaInicio'] ?? $this->fechaInicio);
            $this->fechaFin = request()->query('fechaFin') ?: ($datosReserva['fechaFin'] ?? $this->fechaFin);
            $this->horaLlegada = request()->query('horaLlegada') ?: ($datosReserva['horaLlegada'] ?? $this->horaLlegada);
        }

        // 3. Ejecutamos la búsqueda con las fechas finales
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
    // 1. Definimos las reglas de validación base
    $reglas = [
        'fechaInicio' => 'required|date|after_or_equal:today'
    ];

    // 2. Ajustamos la regla de fechaInicio si es un paquete
    if ($this->esPaquete()) {
        $reglas['fechaInicio'] = 'required|date|after_or_equal:' . now()->addDays(3)->toDateString();
    }

    // 3. Regla para fecha fin (solo si el servicio lo requiere)
    if ($this->requiereFechaFin()) {
        $reglas['fechaFin'] = 'required|date|after_or_equal:fechaInicio';
    }

    // 4. Regla para hora (solo si el servicio lo requiere)
    if ($this->requiereHora()) {
        $reglas['horaLlegada'] = 'required|date_format:H:i';
    }

    // 5. Validamos los datos actuales del componente
    $this->validate($reglas);

    // 6. Ejecutamos la búsqueda con los datos que ya están en $this->fechaInicio, etc.
    $this->ejecutarBusqueda($catalogoService, $inventarioService);
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

            $subtotal = 0;
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
                $horaFinal         = $this->horaLlegada;
                $personasGuardar   = $personasElegidas;

            } elseif ($this->esGuianza()) {
                $subtotal          = $servicio->precio * $cantidadElegida * $diasCalculados;
                $horaFinal         = $this->horaLlegada;
                $personasGuardar   = 0;

            } else {
                $subtotal = $servicio->precio * $cantidadElegida;
            }

            $this->carrito[] = [
                'id'                 => $servicio->id,
                'nombre'             => $servicio->nombre,
                'categoria'          => $this->tipoServicio->nombre,
                'categoria_id'       => $this->tipoServicio->id,
                'categoria_nombre'   => $this->tipoServicio->nombre,
                'cantidad'           => $cantidadElegida,
                'numero_personas'    => $personasGuardar,
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

            $this->dispatch('notificar', ['tipo' => 'success', 'mensaje' => '¡Servicio añadido!']);
            $this->dispatch('servicio-agregado');

        } catch (\Exception $e) {
            Log::error('Error en agregarAlCarrito: ' . $e->getMessage());
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
            $this->dispatch('notificar', ['tipo' => 'info', 'mensaje' => 'Servicio eliminado.']);
        }
    }

    public function irAlCheckout(): void
{
    // 1. Guardamos el carrito primero para no perder los datos
    session()->put('reserva_turista_carrito', $this->carrito);
    session()->put('reserva_turista_datos', [
        'fechaInicio'       => $this->fechaInicio,
        'fechaFin'          => $this->fechaFin,
        'horaLlegada'       => $this->horaLlegada,
        'emprendimiento_id' => $this->emprendimiento->id,
        'categoria_id'      => $this->tipoServicio->id,
        'total'             => collect($this->carrito)->sum('subtotal'),
    ]);

    // 2. Verificamos la sesión
    if (!Auth::check()) {
        // Le decimos a Laravel que luego del login o registro venga al checkout
        session()->put('url.intended', route('turista.reservas.checkout'));
        
        $this->dispatch('mostrar-alerta-login');
        return;
    }

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
