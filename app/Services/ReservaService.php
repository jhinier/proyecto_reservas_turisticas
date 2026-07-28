<?php

namespace App\Services;

use App\Models\Reserva;
use App\Models\ReservaDetalle;
use App\Models\Servicio;
use App\Models\Emprendimiento;
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
    protected UserService       $userService; 

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

        return $query->latest('updated_at')->paginate(10);
    }

    public function obtenerReservasPorTurista(int $turistaId, string $filtroEstado = '')
    {
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

            // REGLA DE SEGURIDAD: Bloquear cancelación si la fecha ya pasó
            if ($nuevoEstado === 'Cancelada') {
                $primerDetalle = $reserva->detalles->sortBy('fecha_inicio')->first();
                if ($primerDetalle) {
                    $fechaString = \Carbon\Carbon::parse($primerDetalle->fecha_inicio)->format('Y-m-d');
                    $horaString = $primerDetalle->hora_llegada ?? '00:00:00';
                    $fechaHoraInicio = \Carbon\Carbon::parse($fechaString . ' ' . $horaString);
                    
                    if (now()->greaterThanOrEqualTo($fechaHoraInicio)) {
                        throw new \Exception("La fecha del servicio ya pasó. El sistema no permite cancelar esta reserva.");
                    }
                }
            }

            $reserva->estado = $nuevoEstado;

            if (in_array($nuevoEstado, ['Cancelada', 'Rechazada'], true)) {
                $reserva->cancelada_en        = now();
                $reserva->cancelada_por_rol   = 'Emprendimiento';
                $reserva->motivo_cancelacion  = $motivo;
            }

            $reserva->save();

            DB::afterCommit(function () use ($reserva, $nuevoEstado, $motivo, $emprendimientoId) {
                if (in_array($nuevoEstado, ['Cancelada', 'Rechazada'], true)) {
                    Mail::to($reserva->turista->email)->send(new ReservaCanceladaMail($reserva, $motivo));
                } elseif ($nuevoEstado === 'Confirmada') {
                    // Obtenemos el teléfono del emprendimiento para el pago
                    $emprendimiento = Emprendimiento::with('user')->find($emprendimientoId);
                    $telefono = $emprendimiento->user->telefono ?? 'No disponible';
                    
                    // Enviamos el correo de Aceptada (pasos para el pago)
                    Mail::to($reserva->turista->email)->send(new \App\Mail\ReservaAceptadaMail($reserva, $telefono));
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

            $user = $this->userService->buscarPorIdentificacion($datosTurista['identificacion']);

            if (!$user) {
                throw new \Exception("El turista no existe en el sistema.");
            }

            $reserva = Reserva::create([
                'user_id'           => $user->id,
                'estado'            => 'Confirmada',
                'precio_total'      => 0,
                'reservada_por_rol' => 'Emprendimiento',
            ]);

            $totalCalculado = $this->procesarDetallesCarrito($reserva, $carrito);

            $reserva->update(['precio_total' => $totalCalculado]);

            $emprendimiento = \App\Models\Emprendimiento::with('user')->find($emprendimientoId);
            $telefono = $emprendimiento->user->telefono ?? 'No disponible';

            DB::afterCommit(function () use ($user, $reserva, $carrito, $telefono) {
                try {
                    Mail::to($user->email)->send(
                        new \App\Mail\ReservaConfirmadaMail($reserva, $user, $carrito, $telefono)
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
            
            $numeroPersonas = $esHospedaje ? (int) ($item['numero_personas'] ?? 1) : 0;
            $numeroPersonasCalculo = max(1, $numeroPersonas);

            if ($esAlimentacion) {
                $fechaFin = $fechaInicio;
            } else {
                $fechaFin = $item['fecha_fin'] ?? $fechaInicio;
            }

            $fechaParaCalculo = $fechaFin ?: $fechaInicio;
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

            if ($esPaquete) {
                $subtotal = $servicioDB->precio * $cantidad;
            } elseif ($esHospedaje) {
                $subtotal = $servicioDB->precio * $numeroPersonasCalculo * $cantidad * $diasCalculados;
            } elseif ($esGuianza || $esAlquiler) {
                $subtotal = $servicioDB->precio * $cantidad * $diasCalculados;
            } else {
                $subtotal = $servicioDB->precio * $cantidad;
            }

            $reserva->detalles()->create([
                'servicio_id'     => $servicioDB->id,
                'fecha_inicio'    => $fechaInicio,
                'fecha_fin'       => $fechaFin,
                'hora_llegada'    => $item['hora'] ?? null,
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
            $query->whereHas('reserva', function ($q) {
                $q->whereIn('estado', ['Confirmada', 'Reagendada', 'Pendiente', 'Completada', 'Cancelada', 'Rechazada', 'Pago en revisión']);
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
                $q->where('tipo_servicios.id', $categoria);
            });
        }

        return $query->orderBy('hora_llegada', 'asc')->get();
    }

    public function registrarReservaTurista(array $carrito, int $userId): Reserva
    {
        return DB::transaction(function () use ($carrito, $userId) {
            
            $reserva = Reserva::create([
                'user_id'           => $userId,
                'estado'            => Reserva::ESTADO_PENDIENTE,
                'precio_total'      => 0, 
                'reservada_por_rol' => 'Turista'
            ]);

            $totalCalculado = $this->procesarDetallesCarrito($reserva, $carrito);

            $reserva->update(['precio_total' => $totalCalculado]);

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

    public function subirComprobante(int $reservaId, int $userId, $archivo): bool
    {
        return DB::transaction(function () use ($reservaId, $userId, $archivo) {
            $reserva = Reserva::where('id', $reservaId)->where('user_id', $userId)->firstOrFail();
            
            if ($reserva->estado !== 'Confirmada') {
                throw new \Exception("La reserva no está habilitada para recibir comprobantes.");
            }

            $ruta = $archivo->store('comprobantes', 'public');
            
            $reserva->comprobante_pago = $ruta;
            $reserva->fecha_subida_comprobante = now();
            $reserva->estado = 'Pago en revisión';
            $reserva->save();

            return true;
        });
    }

    public function procesarCancelacionesAutomaticas(): void
    {
        $ahora = Carbon::now();

        // 1. Cancelar Pendientes > 24 horas
        $pendientes = Reserva::with('turista') // <-- Traemos al turista
            ->where('estado', 'Pendiente')
            ->where('created_at', '<=', $ahora->copy()->subHours(24))
            ->get();

        foreach ($pendientes as $reserva) {
            $motivo = 'La reserva no fue confirmada a tiempo.';
            
            $reserva->update([
                'estado' => 'Cancelada',
                'motivo_cancelacion' => $motivo,
                'cancelada_en' => $ahora,
                'cancelada_por_rol' => 'Sistema'
            ]);

            // Enviar correo de cancelación
            if ($reserva->turista && $reserva->turista->email) {
                try {
                    Mail::to($reserva->turista->email)->send(new \App\Mail\ReservaCanceladaMail($reserva, $motivo));
                } catch (\Exception $e) {
                    Log::error("Error enviando cancelación por timeout: " . $e->getMessage());
                }
            }
        }

        // 2. Cancelar Confirmadas sin pago > 24 horas
        $confirmadas = Reserva::with('turista') // <-- Traemos al turista
            ->where('estado', 'Confirmada')
            ->whereNull('comprobante_pago')
            ->where('updated_at', '<=', $ahora->copy()->subHours(24))
            ->get();

        foreach ($confirmadas as $reserva) {
            $motivo = 'Tiempo límite agotado. No se recibió el comprobante de pago.';
            
            $reserva->update([
                'estado' => 'Cancelada',
                'motivo_cancelacion' => $motivo,
                'cancelada_en' => $ahora,
                'cancelada_por_rol' => 'Sistema'
            ]);

            // Enviar correo de cancelación
            if ($reserva->turista && $reserva->turista->email) {
                try {
                    Mail::to($reserva->turista->email)->send(new \App\Mail\ReservaCanceladaMail($reserva, $motivo));
                } catch (\Exception $e) {
                    Log::error("Error enviando cancelación por falta de pago: " . $e->getMessage());
                }
            }
        }

        // 3. Alerta a las 23 horas (1 hora antes de que se cumplan las 24)
        $reservasPorAvisar = Reserva::with(['detalles.servicio.categoriaPivot.emprendimiento.user', 'turista'])
            ->where('estado', 'Pago en revisión')
            ->whereNotNull('fecha_subida_comprobante')
            ->where('fecha_subida_comprobante', '<=', $ahora->copy()->subHours(23))
            ->where('fecha_subida_comprobante', '>', $ahora->copy()->subHours(24))
            ->get();

        foreach ($reservasPorAvisar as $reserva) {
            $detalle = $reserva->detalles->first();
            $emprendedor = null;

            // Navegamos por las relaciones reales de tu sistema para llegar al dueño
            if ($detalle && $detalle->servicio && $detalle->servicio->categoriaPivot && $detalle->servicio->categoriaPivot->emprendimiento) {
                $emprendedor = $detalle->servicio->categoriaPivot->emprendimiento->user;
            }
            
            if ($emprendedor && $emprendedor->email) {
                try {
                    Mail::to($emprendedor->email)->send(new \App\Mail\AlertaRevisionComprobanteMail($reserva));
                } catch (\Exception $e) {
                    Log::error("Error enviando alerta en reserva #{$reserva->id}: " . $e->getMessage());
                }
            } else {
                Log::error("Fallo al enviar correo: No se encontró el emprendedor vinculado a los detalles de la reserva #{$reserva->id}");
            }
        }

        // 4. Aprobación automática a las 24 horas exactas
        $reservasPorCompletar = Reserva::where('estado', 'Pago en revisión')
            ->whereNotNull('fecha_subida_comprobante')
            ->where('fecha_subida_comprobante', '<=', $ahora->copy()->subHours(24))
            ->get();

        foreach ($reservasPorCompletar as $reserva) {
            $reserva->update([
                'estado' => 'Completada'
            ]);
        }
    }

    public function esCancelablePorTurista(Reserva $reserva): bool
    {
        $primerDetalle = $reserva->detalles->sortBy('fecha_inicio')->first();
        if ($primerDetalle) {
            $fechaString = \Carbon\Carbon::parse($primerDetalle->fecha_inicio)->format('Y-m-d');
            $horaString = $primerDetalle->hora_llegada ?? '00:00:00';
            $fechaHoraInicio = \Carbon\Carbon::parse($fechaString . ' ' . $horaString);
            
            if (now()->addHours(24)->greaterThanOrEqualTo($fechaHoraInicio)) {
                return false;
            }
        }

        if ($reserva->estado === 'Pendiente') {
            return true;
        }

        if ($reserva->estado === 'Confirmada' && empty($reserva->comprobante_pago)) {
            $horasDesdeConfirmacion = Carbon::parse($reserva->updated_at)->diffInHours(now());
            return $horasDesdeConfirmacion <= 24;
        }

        return false;
    }
}