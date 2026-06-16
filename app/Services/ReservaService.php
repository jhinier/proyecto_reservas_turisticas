<?php

namespace App\Services;

use App\Models\Reserva;
use App\Models\ReservaDetalle;
use App\Models\Servicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaCanceladaMail;
use App\Mail\ReservaReagendadaMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReservaService
{
    protected InventarioService $inventarioService;
    protected UserService       $userService; // Cambiado para usar el servicio correcto

    public function __construct(InventarioService $inventarioService, UserService $userService)
    {
        $this->inventarioService = $inventarioService;
        $this->userService       = $userService;
    }

    public function obtenerReservasPorEmprendimiento(int $emprendimientoId, string $filtroEstado = '', string $filtroCategoria = '', string $buscarCedula = '')
    {
        $query = Reserva::with(['turista', 'detalles.servicio.tipoServicio'])
            ->whereHas('detalles.servicio.categoriaPivot', function ($q) use ($emprendimientoId) {
                $q->where('emprendimiento_id', $emprendimientoId);
            });

        if (!empty($filtroEstado)) {
            $query->where('estado', $filtroEstado);
        }

        // Limpieza de espacios en la cédula
        if (!empty($buscarCedula)) {
            $cedulaLimpia = trim($buscarCedula);
            $query->whereHas('turista', function ($q) use ($cedulaLimpia) {
                $q->where('cedula', 'like', '%' . $cedulaLimpia . '%');
            });
        }

        if (!empty($filtroCategoria)) {
            $query->whereHas('detalles.servicio.categoriaPivot', function ($q) use ($filtroCategoria) {
                $q->where('tipo_servicio_id', $filtroCategoria);
            });
        }

        // Ordenamos por la última modificación (updated_at) de forma descendente
        return $query->latest('updated_at')->paginate(10);
    }

    public function obtenerReservasPorTurista(int $turistaId, string $filtroEstado = '')
    {
        // Navegamos por las relaciones para extraer el emprendimiento sin sobrecargar la BD
        $query = Reserva::with(['detalles.servicio.categoriaPivot.emprendimiento'])
            ->where('user_id', $turistaId);

        if (!empty($filtroEstado)) {
            $query->where('estado', $filtroEstado);
        }

        return $query->latest('updated_at')->paginate(10);
    }

    public function obtenerDetalleSeguro(int $reservaId, int $emprendimientoId): ?Reserva
    {
        return Reserva::with([
            'turista',
            'detalles.servicio.detalleHospedaje',
            'detalles.servicio.detalleGuianza',
            'detalles.servicio.detallePaqueteTuristico',
        ])
            ->where('id', $reservaId)
            ->whereHas('detalles.servicio.categoriaPivot', function ($q) use ($emprendimientoId) {
                $q->where('emprendimiento_id', $emprendimientoId);
            })->first();
    }

    public function obtenerDetalleSeguroTurista(int $reservaId, int $turistaId): ?Reserva
    {
        return Reserva::with([
            'emprendimiento',
            'detalles.servicio.tipoServicio',
            'detalles.servicio.detalleHospedaje',
            'detalles.servicio.detalleGuianza',
            'detalles.servicio.detallePaqueteTuristico',
        ])
        ->where('id', $reservaId)
        ->where('user_id', $turistaId)
        ->first();
    }

    public function cancelarReservaTurista(int $reservaId, int $turistaId, string $motivo): bool
    {
        return DB::transaction(function () use ($reservaId, $turistaId, $motivo) {
            $reserva = $this->obtenerDetalleSeguroTurista($reservaId, $turistaId);

            // Bloquea si no existe o si no pasa la regla de las 24 horas
            if (!$reserva || !$this->esCancelablePorTurista($reserva)) {
                return false;
            }

            $reserva->estado = 'Cancelada';
            $reserva->cancelada_en = now();
            $reserva->cancelada_por_rol = 'Turista';
            $reserva->motivo_cancelacion = $motivo;
            $reserva->save();

            return true;
        });
    }

    public function cambiarEstado(int $reservaId, string $nuevoEstado, int $emprendimientoId, ?string $motivo = null): bool
    {
        return DB::transaction(function () use ($reservaId, $nuevoEstado, $emprendimientoId, $motivo) {
            $reserva = $this->obtenerDetalleSeguro($reservaId, $emprendimientoId);
            
            if (!$reserva) {
                return false;
            }

            $reserva->estado = $nuevoEstado;

            if (in_array($nuevoEstado, ['Cancelada', 'Rechazada'], true)) {
                $reserva->cancelada_en        = now();
                $reserva->cancelada_por_rol   = 'Emprendimiento';
                $reserva->motivo_cancelacion  = $motivo;
            }

            $reserva->save();

            // Enviar correo solo después de que la base de datos guarda los cambios
            // Enviar correo solo después de que la base de datos guarda los cambios
            DB::afterCommit(function () use ($reserva, $nuevoEstado, $motivo) {
                if (in_array($nuevoEstado, ['Cancelada', 'Rechazada'], true)) {
                    Mail::to($reserva->turista->email)->send(new ReservaCanceladaMail($reserva, $motivo));
                } elseif ($nuevoEstado === 'Confirmada') {
                    Mail::to($reserva->turista->email)->send(new \App\Mail\ReservaAceptadaMail($reserva));
                }
            });

            return true;
        });
    }

   public function reagendarReserva(int $reservaId, array $nuevasFechas, int $emprendimientoId): bool
    {
        return DB::transaction(function () use ($reservaId, $nuevasFechas, $emprendimientoId) {
            $reserva = $this->obtenerDetalleSeguro($reservaId, $emprendimientoId);
            if (!$reserva) return false;

            $estadoOriginal = $reserva->estado;
            $reserva->estado = 'Reagendando';
            $reserva->save();

            try {
                $nuevoTotalReserva = 0;

                foreach ($reserva->detalles as $detalle) {
                    if (isset($nuevasFechas[$detalle->id])) {
                        
                        $fechaInicio = $nuevasFechas[$detalle->id]['inicio'];
                        $horaLlegada = $nuevasFechas[$detalle->id]['hora_llegada'] ?? null;
                        
                        $servicioDB = Servicio::with('tipoServicio')
                            ->where('id', $detalle->servicio_id)
                            ->lockForUpdate()
                            ->firstOrFail();

                        $nombreTipo      = $servicioDB->tipoServicio->nombre ?? '';
                        $tipoNormalizado = Str::slug($nombreTipo, ' ');
                        
                        $esAlimentacion = str_contains($tipoNormalizado, 'alimentacion');
                        $esPaquete      = str_contains($tipoNormalizado, 'paquete');
                        $esAlquiler     = str_contains($tipoNormalizado, 'alquiler');
                        $esGuianza      = str_contains($tipoNormalizado, 'guianza');
                        $esHospedaje    = str_contains($tipoNormalizado, 'hospedaje');

                        $fechaFin = $esAlimentacion ? $fechaInicio : ($nuevasFechas[$detalle->id]['fin'] ?? $fechaInicio);
                        
                        $fechaParaCalculo = $fechaFin ?: $fechaInicio;
                        $diasCalculados = max(1, Carbon::parse($fechaInicio)->diffInDays(Carbon::parse($fechaParaCalculo)) + 1);
                        $cantidad = $detalle->cantidad;
                        $numeroPersonasCalculo = max(1, $detalle->numero_personas);

                        if ($this->inventarioService->manejaStockDiario($nombreTipo) && !$esAlimentacion) {
                            $fechaFinCheck = $esPaquete ? $fechaInicio : $fechaFin;
                            
                            $disponibleEnRango = $this->inventarioService->calcularDisponibilidadEnRango(
                                $servicioDB->id,
                                $fechaInicio,
                                $fechaFinCheck
                            );

                            if ($disponibleEnRango < $cantidad) {
                                throw new \Exception("Fechas sin disponibilidad. No hay cupos para: {$servicioDB->nombre}");
                            }
                        }

                        if ($esPaquete) {
                            $subtotal = $servicioDB->precio * $cantidad;
                        } elseif ($esHospedaje) {
                            $subtotal = $servicioDB->precio * $numeroPersonasCalculo * $cantidad * $diasCalculados;
                        } elseif ($esGuianza || $esAlquiler) {
                            $subtotal = $servicioDB->precio * $cantidad * $diasCalculados;
                        } else {
                            $subtotal = $servicioDB->precio * $cantidad;
                        }

                        $detalle->update([
                            'fecha_inicio' => $fechaInicio,
                            'fecha_fin'    => $fechaFin,
                            'hora_llegada' => $horaLlegada,
                            'subtotal'     => $subtotal,
                        ]);

                        $nuevoTotalReserva += $subtotal;
                    } else {
                        $nuevoTotalReserva += $detalle->subtotal;
                    }
                }

                $reserva->precio_total = $nuevoTotalReserva;
                $reserva->estado = 'Confirmada';
                $reserva->save();

                DB::afterCommit(function () use ($reserva) {
                    try {
                        $mensajeAutomatico = 'Tus fechas de reserva han sido actualizadas y confirmadas por el establecimiento. Te esperamos.';
                        Mail::to($reserva->turista->email)->send(new ReservaReagendadaMail($reserva, $mensajeAutomatico));
                    } catch (\Exception $e) {
                        Log::error('Error enviando correo al reagendar: ' . $e->getMessage());
                    }
                });

                return true;

            } catch (\Exception $e) {
                $reserva->estado = $estadoOriginal;
                $reserva->save();
                throw $e;
            }
        });
    }

    public function crearReserva(array $datosTurista, array $carrito, int $emprendimientoId)
    {
        return DB::transaction(function () use ($datosTurista, $carrito, $emprendimientoId) {

            // Buscamos al usuario existente en lugar de crearlo
            $user = $this->userService->buscarPorIdentificacion($datosTurista['identificacion']);

            if (!$user) {
                throw new \Exception("El turista no existe en el sistema.");
            }

            $reserva = Reserva::create([
                'user_id'           => $user->id,
                'emprendimiento_id' => $emprendimientoId,
                'estado'            => 'Confirmada',
                'precio_total'      => 0,
                'reservada_por_rol' => 'Emprendimiento',
            ]);

            $totalCalculado = $this->procesarDetallesCarrito($reserva, $carrito);

            $reserva->update(['precio_total' => $totalCalculado]);

            // Enviar el correo de confirmación
            DB::afterCommit(function () use ($user, $reserva, $carrito) {
                try {
                    Mail::to($user->email)->send(
                        new \App\Mail\ReservaConfirmadaMail($reserva, $user, $carrito)
                    );
                } catch (\Exception $e) {
                    Log::error('Fallo al enviar correo de reserva al turista: ' . $e->getMessage());
                }
            });

            return $reserva;
        });
    }

    private function procesarDetallesCarrito(Reserva $reserva, array $carrito): float
    {
        $totalCalculado = 0;

        foreach ($carrito as $item) {
            $servicioDB = Servicio::with('tipoServicio')
                ->where('id', $item['id'])
                ->lockForUpdate()
                ->firstOrFail();

            $nombreTipo      = $servicioDB->tipoServicio->nombre ?? '';
            $tipoNormalizado = Str::slug($nombreTipo, ' ');
            
            $esAlimentacion = str_contains($tipoNormalizado, 'alimentacion');
            $esPaquete      = str_contains($tipoNormalizado, 'paquete');
            $esAlquiler     = str_contains($tipoNormalizado, 'alquiler');
            $esGuianza      = str_contains($tipoNormalizado, 'guianza');
            $esHospedaje    = str_contains($tipoNormalizado, 'hospedaje');
                
            $fechaInicio    = $item['fecha_inicio'];
            $cantidad       = (int) $item['cantidad'];
            
            // Para la BD, hospedaje usa número de personas, los demás mandan 0
            $numeroPersonas = $esHospedaje ? (int) ($item['numero_personas'] ?? 1) : 0;
            $numeroPersonasCalculo = max(1, $numeroPersonas);

            if ($esAlimentacion) {
                $fechaFin = $fechaInicio;
            } else {
                $fechaFin = $item['fecha_fin'] ?? $fechaInicio;
            }

            $fechaParaCalculo = $fechaFin ?: $fechaInicio;
            // Corrección: añadimos + 1 para que el backend cobre los días inclusivos igual que la vista
            $diasCalculados = max(1, Carbon::parse($fechaInicio)->diffInDays(Carbon::parse($fechaParaCalculo)) + 1);

            if ($this->inventarioService->manejaStockDiario($nombreTipo) && !$esAlimentacion) {
                $fechaFinCheck   = $esPaquete ? $fechaInicio : $fechaFin;
                $disponibleEnRango = $this->inventarioService->calcularDisponibilidadEnRango(
                    $servicioDB->id,
                    $fechaInicio,
                    $fechaFinCheck
                );

                if ($disponibleEnRango < $cantidad) {
                    throw new \Exception("Cupos insuficientes para el servicio: {$servicioDB->nombre}");
                }
            }

            // Matemática exacta y alineada con la vista
            if ($esPaquete) {
                $subtotal = $servicioDB->precio * $cantidad;
            } elseif ($esHospedaje) {
                $subtotal = $servicioDB->precio * $numeroPersonasCalculo * $cantidad * $diasCalculados;
            } elseif ($esGuianza || $esAlquiler) {
                // Guianza y Alquiler NO multiplican por el número de personas
                $subtotal = $servicioDB->precio * $cantidad * $diasCalculados;
            } else {
                $subtotal = $servicioDB->precio * $cantidad;
            }

            $reserva->detalles()->create([
                'servicio_id'     => $servicioDB->id,
                'fecha_inicio'    => $fechaInicio,
                'fecha_fin'       => $fechaFin,
                'hora_llegada'    => $item['hora'] ?? null, // Nombre correcto de la base de datos
                'numero_personas' => $numeroPersonas,
                'cantidad'        => $cantidad,
                'precio_unitario' => $servicioDB->precio,
                'subtotal'        => $subtotal,
            ]);

            $totalCalculado += $subtotal;
        }

        return $totalCalculado;
    }
    
    public function obtenerAgendaPorRangoYFiltros(
        int $emprendimientoId, 
        string $inicio, 
        string $fin, 
        ?string $categoria = null, 
        ?string $estado = null, 
        ?string $cedula = null
    ) {
        $query = ReservaDetalle::with(['reserva.turista', 'servicio.tipoServicio'])
            ->whereHas('servicio.categoriaPivot', function ($q) use ($emprendimientoId) {
                $q->where('emprendimiento_id', $emprendimientoId);
            })
            ->whereDate('fecha_inicio', '<=', $fin)
            ->whereDate('fecha_fin', '>=', $inicio);

        if (!empty($estado)) {
            $query->whereHas('reserva', function ($q) use ($estado) {
                $q->where('estado', $estado);
            });
        } else {
            // AHORA MOSTRARÁ TODOS LOS ESTADOS POR DEFECTO
            $query->whereHas('reserva', function ($q) {
                $q->whereIn('estado', ['Confirmada', 'Reagendada', 'Pendiente', 'Completada', 'Cancelada', 'Rechazada']);
            });
        }

        if (!empty($cedula)) {
            $cedulaLimpia = trim($cedula);
            $query->whereHas('reserva.turista', function ($q) use ($cedulaLimpia) {
                $q->where('cedula', 'like', '%' . $cedulaLimpia . '%');
            });
        }

        if (!empty($categoria)) {
    $query->whereHas('servicio.tipoServicio', function ($q) use ($categoria) {
        // Cambiamos 'id' por 'tipo_servicios.id'
        $q->where('tipo_servicios.id', $categoria);
    });
}

        return $query->orderBy('hora_llegada', 'asc')->get();
    }

    /**
     * Nuevo flujo: Registro para Turistas (Estado Pendiente)
     */
    public function registrarReservaTurista(array $carrito, int $userId): Reserva
    {
        return DB::transaction(function () use ($carrito, $userId) {
            
            // 1. Crear Reserva como Pendiente
            $reserva = Reserva::create([
                'user_id'           => $userId,
                'estado'            => Reserva::ESTADO_PENDIENTE,
                'precio_total'      => 0, // Se actualizará al procesar detalles
                'reservada_por_rol' => 'Turista'
            ]);

            // 2. Procesar detalles (reutilizamos tu método privado existente)
            $totalCalculado = $this->procesarDetallesCarrito($reserva, $carrito);

            $reserva->update(['precio_total' => $totalCalculado]);

            // 3. Disparar correo de confirmación de recepción
            DB::afterCommit(function () use ($reserva) {
                try {
                    Mail::to($reserva->turista->email)->send(new \App\Mail\ReservaPendienteTuristaMail($reserva));
                } catch (\Exception $e) {
                    Log::error("Fallo al enviar correo de reserva pendiente: " . $e->getMessage());
                }
            });

            return $reserva;
        });
    }

    /**
     * Regla de negocio: Cancelación (24h antes)
     * Se puede usar en el Controller o Service
     */
    public function esCancelablePorTurista(Reserva $reserva): bool
    {
        if (in_array($reserva->estado, ['Completada', 'Cancelada', 'Rechazada'])) {
            return false;
        }

        // Ordenamos para encontrar el servicio que inicia primero
        $primerDetalle = $reserva->detalles->sortBy('fecha_inicio')->first();
        
        if (!$primerDetalle) {
            return false;
        }

        $fechaString = \Carbon\Carbon::parse($primerDetalle->fecha_inicio)->format('Y-m-d');
        $horaString = $primerDetalle->hora_llegada ?? '00:00:00';
        
        $fechaInicioServicio = \Carbon\Carbon::parse($fechaString . ' ' . $horaString);
        
        // Valida si faltan más de 24 horas desde este momento
        return now()->addHours(24)->isBefore($fechaInicioServicio);
    }
}