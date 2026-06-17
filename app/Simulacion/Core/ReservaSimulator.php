<?php

namespace App\Simulacion\Core;

use App\Models\Reserva;
use App\Models\ReservaDetalle;
use App\Models\Servicio;
use App\Simulacion\Config\SimulacionConfig;
use App\Simulacion\Data\TestData;
use App\Simulacion\Logging\Logger;
use App\Simulacion\Metrics\MetricsCollector;
use App\Services\InventarioService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservaSimulator
{
    private array $config;
    private Logger $logger;
    private MetricsCollector $metrics;
    private array $createdReservas = [];
    private InventarioService $inventarioService;

    public function __construct(array $config, Logger $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->metrics = new MetricsCollector();
        $this->inventarioService = app(InventarioService::class);
    }

    public function run(): void
    {
        $this->initialize();
        $this->metrics->start();

        if ($this->config['mode'] === 'create') {
            $this->runCreateTests();
        } elseif ($this->config['mode'] === 'update') {
            $this->runUpdateTests();
        } else {
            $this->runMixedTests();
        }

        $this->metrics->end();
    }

    private function initialize(): void
    {
        $this->logger->section('🚀 SIMULADOR DE RENDIMIENTO - RESERVAS TURÍSTICAS');
        $this->logger->log("Concurrencia: {$this->config['concurrency']}");
        $this->logger->log("Iteraciones: {$this->config['iterations']}");
        $this->logger->log("Modo: {$this->config['mode']}");
    }

    private function runCreateTests(): void
    {
        $this->logger->log("\n📝 CREANDO RESERVAS...\n");
        $tasks = [];
        for ($i = 0; $i < $this->config['iterations']; $i++) {
            $tasks[] = fn() => $this->createReserva($i);
        }
        $this->runConcurrent($tasks);
    }

    private function runUpdateTests(): void
    {
        $this->logger->log("\n✏️ ACTUALIZANDO RESERVAS...\n");
        // Crear reservas base
        for ($i = 0; $i < min($this->config['iterations'], SimulacionConfig::BASE_RESERVA_DELAY_MS); $i++) {
            $this->createReserva($i, true);
            usleep(SimulacionConfig::BASE_RESERVA_DELAY_MS * 1000);
        }
        if (empty($this->createdReservas)) {
            $this->logger->warn("No hay reservas para actualizar");
            return;
        }

        $tasks = [];
        for ($i = 0; $i < $this->config['iterations']; $i++) {
            $reservaInfo = $this->createdReservas[$i % count($this->createdReservas)];
            $tasks[] = fn() => $this->updateReserva($reservaInfo, $i);
        }
        $this->runConcurrent($tasks);
    }

    private function runMixedTests(): void
    {
        $this->logger->log("\n🔄 PRUEBAS MIXTAS (creación + actualización)...\n");
        $createCount = floor($this->config['iterations'] * (SimulacionConfig::PROB_MIXED_MODE['PORCENTAJE_CREACION'] / 100));
        $tasks = [];

        for ($i = 0; $i < $this->config['iterations']; $i++) {
            if ($i < $createCount) {
                $tasks[] = fn() => $this->createReserva($i);
            } else {
                if (empty($this->createdReservas) && $i === $createCount) {
                    for ($j = 0; $j < 5; $j++) {
                        $this->createReserva($j, true);
                        usleep(SimulacionConfig::BASE_RESERVA_DELAY_MS * 1000);
                    }
                }
                if (!empty($this->createdReservas)) {
                    $reservaInfo = $this->createdReservas[$i % count($this->createdReservas)];
                    $tasks[] = fn() => $this->updateReserva($reservaInfo, $i);
                } else {
                    $tasks[] = fn() => $this->createReserva($i);
                }
            }
        }
        $this->runConcurrent($tasks);
    }

    private function createReserva(int $iteration, bool $silent = false): ?array
    {
        $start = microtime(true) * 1000;
        $success = false;
        $error = null;
        $cpuBefore = getrusage();
        $result = null;

        try {
            DB::beginTransaction();

            // Obtener un turista existente (primer usuario con rol turista)
            $turista = \App\Models\User::role('turista')->first();
            if (!$turista) {
                throw new \Exception("No hay usuarios con rol turista para simular reservas.");
            }

            $items = TestData::getRandomScenario();
            $total = 0;
            $reserva = Reserva::create([
                'user_id' => $turista->id,
                'estado' => 'Pendiente',
                'precio_total' => 0,
                'reservada_por_rol' => 'Turista'
            ]);

            foreach ($items as $item) {
                $servicio = Servicio::find($item['id_servicio']);
                if (!$servicio) continue;

                $tipoNombre = $servicio->tipoServicio->nombre ?? '';
                $esHospedaje = stripos($tipoNombre, 'hospedaje') !== false;
                $esPaquete = stripos($tipoNombre, 'paquete') !== false;
                $esGuianza = stripos($tipoNombre, 'guianza') !== false;
                $esAlquiler = stripos($tipoNombre, 'alquiler') !== false;
                $esAlimentacion = stripos($tipoNombre, 'alimentacion') !== false;

                $fechaInicio = $item['fecha_inicio'];
                $fechaFin = $esAlimentacion ? $fechaInicio : ($item['fecha_fin'] ?? $fechaInicio);
                $cantidad = $item['cantidad'];
                $numeroPersonas = $esHospedaje ? ($item['numero_personas'] ?? 1) : 0;

                $dias = max(1, Carbon::parse($fechaInicio)->diffInDays(Carbon::parse($fechaFin)) + 1);

                // Validar stock diario (si aplica)
                if ($this->inventarioService->manejaStockDiario($tipoNombre) && !$esAlimentacion) {
                    $fechaCheck = $esPaquete ? $fechaInicio : $fechaFin;
                    $disponible = $this->inventarioService->calcularDisponibilidadEnRango($servicio->id, $fechaInicio, $fechaCheck);
                    if ($disponible < $cantidad) {
                        throw new \Exception("Stock insuficiente para {$servicio->nombre}");
                    }
                }

                // Calcular subtotal (misma lógica que en ReservaService)
                if ($esPaquete) {
                    $subtotal = $servicio->precio * $cantidad;
                } elseif ($esHospedaje) {
                    $subtotal = $servicio->precio * max(1, $numeroPersonas) * $cantidad * $dias;
                } elseif ($esGuianza || $esAlquiler) {
                    $subtotal = $servicio->precio * $cantidad * $dias;
                } else {
                    $subtotal = $servicio->precio * $cantidad;
                }

                ReservaDetalle::create([
                    'reserva_id' => $reserva->id,
                    'servicio_id' => $servicio->id,
                    'fecha_inicio' => $fechaInicio,
                    'fecha_fin' => $fechaFin,
                    'hora_llegada' => $item['hora_llegada'] ?? null,
                    'cantidad' => $cantidad,
                    'numero_personas' => $numeroPersonas,
                    'precio_unitario' => $servicio->precio,
                    'subtotal' => $subtotal,
                ]);
                $total += $subtotal;
            }

            $reserva->precio_total = $total;
            $reserva->save();
            DB::commit();

            $success = true;
            $result = ['id' => $reserva->id, 'items' => $items];
            $this->createdReservas[] = ['id' => $reserva->id, 'items' => $items];
            if (!$silent && $this->config['verbose']) {
                $this->logger->verboseLog("✅ Creación #{$iteration}: Reserva {$reserva->id} - " . round(microtime(true)*1000 - $start) . "ms");
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $success = false;
            $error = $e->getMessage();
            if (!$silent && $this->config['verbose']) {
                $this->logger->verboseLog("❌ Creación #{$iteration}: {$error}");
            }
        }

        $cpuAfter = getrusage();
        $cpuTimeMs = (($cpuAfter['ru_utime.tv_sec'] - $cpuBefore['ru_utime.tv_sec']) * 1e6 +
                      ($cpuAfter['ru_utime.tv_usec'] - $cpuBefore['ru_utime.tv_usec'])) / 1000;
        $realTimeMs = (microtime(true) * 1000) - $start;

        $this->metrics->recordOperation([
            'type' => 'create',
            'iteration' => (string)$iteration,
            'success' => $success,
            'duration' => $realTimeMs,
            'cpuTimeMs' => $cpuTimeMs,
            'error' => $error
        ]);

        return $success ? $result : null;
    }

    private function updateReserva(array $reservaInfo, int $iteration): bool
    {
        $start = microtime(true) * 1000;
        $success = false;
        $error = null;
        $cpuBefore = getrusage();

        try {
            $reserva = Reserva::find($reservaInfo['id']);
            if (!$reserva || in_array($reserva->estado, ['Cancelada', 'Completada'])) {
                throw new \Exception("Reserva no editable");
            }

            // Simular tipo de actualización aleatoria
            $tipos = [
                'AUMENTAR_CANTIDAD' => fn($detalle) => $this->aumentarCantidad($detalle),
                'INCREMENTAR_PERSONAS' => fn($detalle) => $this->incrementarPersonas($detalle),
                'CAMBIAR_FECHAS' => fn($detalle) => $this->cambiarFechas($detalle),
                'AGREGAR_SERVICIO' => null, // se maneja aparte
                'EDITAR_PENDIENTES' => fn($detalle) => $this->editarPendientes($detalle)
            ];
            $rand = rand(1, 100);
            $acum = 0;
            $tipoSeleccionado = 'AUMENTAR_CANTIDAD';
            foreach (SimulacionConfig::PROB_TIPO_ACTUALIZACION as $tipo => $porc) {
                $acum += $porc;
                if ($rand <= $acum) {
                    $tipoSeleccionado = $tipo;
                    break;
                }
            }

            DB::beginTransaction();

            if ($tipoSeleccionado === 'AGREGAR_SERVICIO') {
                $nuevoServicio = TestData::getServicioAleatorio();
                $nuevoItem = TestData::crearItemReserva($nuevoServicio);
                $this->agregarDetalleAReserva($reserva, $nuevoItem);
            } else {
                $detalles = $reserva->detalles;
                if ($detalles->isEmpty()) throw new \Exception("Sin detalles");
                $detalle = $detalles->random();
                $callable = $tipos[$tipoSeleccionado];
                if ($callable) {
                    $callable($detalle);
                }
            }

            // Recalcular total
            $nuevoTotal = $reserva->detalles->sum('subtotal');
            $reserva->precio_total = $nuevoTotal;
            $reserva->estado = 'Confirmada'; // después de actualizar
            $reserva->save();

            DB::commit();
            $success = true;
            if ($this->config['verbose']) {
                $this->logger->verboseLog("✅ Actualización #{$iteration}: Reserva {$reserva->id} ({$tipoSeleccionado}) - " . round(microtime(true)*1000 - $start) . "ms");
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            $success = false;
            $error = $e->getMessage();
            if ($this->config['verbose']) {
                $this->logger->verboseLog("❌ Actualización #{$iteration}: {$error}");
            }
        }

        $cpuAfter = getrusage();
        $cpuTimeMs = (($cpuAfter['ru_utime.tv_sec'] - $cpuBefore['ru_utime.tv_sec']) * 1e6 +
                      ($cpuAfter['ru_utime.tv_usec'] - $cpuBefore['ru_utime.tv_usec'])) / 1000;
        $realTimeMs = (microtime(true) * 1000) - $start;

        $this->metrics->recordOperation([
            'type' => 'update',
            'iteration' => (string)$iteration,
            'success' => $success,
            'duration' => $realTimeMs,
            'cpuTimeMs' => $cpuTimeMs,
            'error' => $error
        ]);

        return $success;
    }

    private function aumentarCantidad(ReservaDetalle $detalle): void
    {
        $detalle->cantidad += 1;
        $detalle->subtotal = $detalle->precio_unitario * $detalle->cantidad *
            ($detalle->servicio->tipoServicio->nombre === 'Hospedaje' ? max(1, $detalle->numero_personas) : 1);
        $detalle->save();
    }

    private function incrementarPersonas(ReservaDetalle $detalle): void
    {
        if (stripos($detalle->servicio->tipoServicio->nombre ?? '', 'hospedaje') !== false) {
            $detalle->numero_personas += 1;
            $detalle->subtotal = $detalle->precio_unitario * $detalle->numero_personas * $detalle->cantidad *
                (Carbon::parse($detalle->fecha_inicio)->diffInDays(Carbon::parse($detalle->fecha_fin)) + 1);
            $detalle->save();
        }
    }

    private function cambiarFechas(ReservaDetalle $detalle): void
    {
        $nuevaInicio = Carbon::parse($detalle->fecha_inicio)->addDays(rand(1, 5));
        $nuevaFin = Carbon::parse($detalle->fecha_fin)->addDays(rand(1, 5));
        $detalle->fecha_inicio = $nuevaInicio;
        $detalle->fecha_fin = $nuevaFin;
        $dias = max(1, $nuevaInicio->diffInDays($nuevaFin) + 1);
        $detalle->subtotal = $detalle->precio_unitario * ($detalle->numero_personas ?: 1) * $detalle->cantidad * $dias;
        $detalle->save();
    }

    private function editarPendientes(ReservaDetalle $detalle): void
    {
        // Simplemente cambiamos la hora de llegada
        $detalle->hora_llegada = rand(8, 20) . ':00:00';
        $detalle->save();
    }

    private function agregarDetalleAReserva(Reserva $reserva, array $item): void
    {
        $servicio = Servicio::find($item['id_servicio']);
        if (!$servicio) return;
        $esHospedaje = stripos($servicio->tipoServicio->nombre ?? '', 'hospedaje') !== false;
        $dias = max(1, Carbon::parse($item['fecha_inicio'])->diffInDays(Carbon::parse($item['fecha_fin'])) + 1);
        $subtotal = $servicio->precio * ($esHospedaje ? max(1, $item['numero_personas']) : 1) * $item['cantidad'] * ($esHospedaje ? $dias : 1);

        ReservaDetalle::create([
            'reserva_id' => $reserva->id,
            'servicio_id' => $servicio->id,
            'fecha_inicio' => $item['fecha_inicio'],
            'fecha_fin' => $item['fecha_fin'],
            'hora_llegada' => $item['hora_llegada'] ?? null,
            'cantidad' => $item['cantidad'],
            'numero_personas' => $item['numero_personas'],
            'precio_unitario' => $servicio->precio,
            'subtotal' => $subtotal,
        ]);
    }

    private function runConcurrent(array $tasks): void
    {
        $batchSize = $this->config['concurrency'];
        $total = count($tasks);
        for ($i = 0; $i < $total; $i += $batchSize) {
            $batch = array_slice($tasks, $i, $batchSize);
            $promises = [];
            foreach ($batch as $task) {
                $promises[] = $task();
            }
            // Ejecución secuencial por lote (simulando concurrencia real sería con hilos, pero en CLI podemos usar paralelismo con procesos)
            // Para simplicidad, ejecutamos en serie dentro del lote. En un entorno real se podría usar Pool de procesos.
            foreach ($promises as $promise) {
                $promise();
            }
            if ($i + $batchSize < $total) {
                usleep(SimulacionConfig::BATCH_DELAY_MS * 1000);
            }
        }
    }

    public function getMetricsSummary(): array
    {
        return $this->metrics->getSummary();
    }

    public function getCreatedReservas(): array
    {
        return $this->createdReservas;
    }
}