<?php
namespace App\Services;

use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReservaService
{
    private const TIPOS_CON_STOCK_DIARIO = [
        'Alquiler de Equipos',
        'Hospedaje',
        'Guianza',
        'Paquetes Turísticos',
        'Alimentación',
    ];

    public function obtenerReservasPorEmprendimiento(int $emprendimientoId, string $filtroEstado = '')
    {
        $query = Reserva::with(['turista', 'detalles.servicio'])
            ->whereHas('detalles.servicio.categoriaPivot', function ($q) use ($emprendimientoId) {
                $q->where('emprendimiento_id', $emprendimientoId);
            });

        if (!empty($filtroEstado)) {
            $query->where('estado', $filtroEstado);
        }

        return $query->latest()->paginate(10);
    }

    public function obtenerDetalleSeguro(int $reservaId, int $emprendimientoId): ?Reserva
    {
        return Reserva::with([
            'turista', 
            'detalles.servicio.detalleHospedaje', 
            'detalles.servicio.detalleGuianza', 
            'detalles.servicio.detallePaqueteTuristico'
        ])
            ->where('id', $reservaId)
            ->whereHas('detalles.servicio.categoriaPivot', function ($q) use ($emprendimientoId) {
                $q->where('emprendimiento_id', $emprendimientoId);
            })->first();
    }

    public function cambiarEstado(int $reservaId, string $nuevoEstado, int $emprendimientoId, ?string $motivo = null): bool
    {
        $reserva = $this->obtenerDetalleSeguro($reservaId, $emprendimientoId);
        
        if (!$reserva) {
            return false;
        }

        $reserva->estado = $nuevoEstado;
        
        if (in_array($nuevoEstado, ['Cancelada', 'Rechazada'], true)) {
            $reserva->cancelada_en = now();
            $reserva->cancelada_por_rol = 'Emprendimiento';
            $reserva->motivo_cancelacion = $motivo;
        }

        return $reserva->save();
    }

    public function calcularDisponibilidadEnRango(int $servicioId, string $fechaInicio, string $fechaFin): int
    {
        $servicio = Servicio::with('tipoServicio')->findOrFail($servicioId);
        $nombreTipo = $servicio->tipoServicio->nombre ?? '';

        if (!$this->manejaStockDiario($nombreTipo)) {
            return 999;
        }

        // Determinar si es un rango (Hospedaje, Alquiler, Guianza) o solo día de inicio (Paquetes, Alimentación)
        $esRangoCompleto = in_array($nombreTipo, ['Hospedaje', 'Alquiler de Equipos', 'Guianza']);
        $esPaqueteTuristico = $nombreTipo === 'Paquetes Turísticos';
        
        // Para Paquetes Turísticos, solo considerar el día de inicio
        $fechaFinReal = $esRangoCompleto ? $fechaFin : $fechaInicio;

        $reservasAfectadas = DB::table('reserva_detalles')
            ->join('reservas', 'reserva_detalles.reserva_id', '=', 'reservas.id')
            ->where('reserva_detalles.servicio_id', $servicioId)
            ->whereIn('reservas.estado', ['Confirmada', 'Pendiente'])
            ->where(function ($query) use ($fechaInicio, $fechaFinReal, $esPaqueteTuristico) {
                if ($esPaqueteTuristico) {
                    // Paquetes: solo importa que el día de inicio esté en el rango de inicio
                    $query->whereDate('reserva_detalles.fecha_inicio', $fechaInicio);
                } else {
                    // Hospedaje/Guianza/Alquiler: rango completo debe traslaparse
                    $query->where('reserva_detalles.fecha_inicio', '<=', $fechaFinReal)
                          ->where('reserva_detalles.fecha_fin', '>=', $fechaInicio);
                }
            })
            ->get(['fecha_inicio', 'fecha_fin', 'cantidad']);

        if ($reservasAfectadas->isEmpty()) {
            return $servicio->stock;
        }

        // Para Paquetes Turísticos, solo contar ocupación del día de inicio
        if ($esPaqueteTuristico) {
            $ocupacionTotal = $reservasAfectadas->sum('cantidad');
            return max(0, $servicio->stock - $ocupacionTotal);
        }

        // Para Hospedaje/Guianza/Alquiler: calcular cuello de botella (mínimo disponible cada día)
        $ocupacionDiaria = [];
        $periodoBuscado = CarbonPeriod::create($fechaInicio, $fechaFinReal);

        foreach ($periodoBuscado as $fecha) {
            $ocupacionDiaria[$fecha->format('Y-m-d')] = 0;
        }

        foreach ($reservasAfectadas as $reserva) {
            $rangoReserva = CarbonPeriod::create($reserva->fecha_inicio, $reserva->fecha_fin);
            foreach ($rangoReserva as $fecha) {
                $fechaStr = $fecha->format('Y-m-d');
                if (isset($ocupacionDiaria[$fechaStr])) {
                    $ocupacionDiaria[$fechaStr] += $reserva->cantidad;
                }
            }
        }

        $maximaOcupacionEnElRango = empty($ocupacionDiaria) ? 0 : max($ocupacionDiaria);

        return max(0, $servicio->stock - $maximaOcupacionEnElRango);
    }
    
    public function crearReserva(array $datosTurista, array $carrito, int $emprendimientoId)
    {
        $passwordPlana = Str::random(10);

        return DB::transaction(function () use ($datosTurista, $carrito, $passwordPlana) {
            
            $user = $this->obtenerOCrearTurista($datosTurista, $passwordPlana);

            $reserva = Reserva::create([
                'user_id' => $user->id,
                'estado' => 'Confirmada',
                'precio_total' => 0,
                'reservada_por_rol' => 'Emprendimiento',
            ]);

            $totalCalculado = $this->procesarDetallesCarrito($reserva, $carrito);

            $reserva->update(['precio_total' => $totalCalculado]);

            // El envío de correo ocurre de forma segura solo si la transacción hace commit exitosamente.
            DB::afterCommit(function () use ($user, $reserva, $passwordPlana) {
                if ($user->wasRecentlyCreated) {
                    try {
                        Mail::to($user->email)->send(new \App\Mail\NuevoUsuarioCreadoMail($user, $reserva, $passwordPlana));
                    } catch (\Exception $e) {
                        Log::error('Fallo al enviar correo a turista: ' . $e->getMessage());
                    }
                }
            });

            return $reserva;
        });
    }

    public function obtenerFechasAgotadas(int $servicioId): array
    {
        $servicio = Servicio::with('tipoServicio')->findOrFail($servicioId);
        $nombreTipo = $servicio->tipoServicio->nombre ?? '';

        if (!$this->manejaStockDiario($nombreTipo)) {
            return [];
        }

        $esRangoCompleto = in_array($nombreTipo, ['Hospedaje', 'Alquiler de Equipos', 'Guianza']);
        $esPaqueteTuristico = $nombreTipo === 'Paquetes Turísticos';

        // Para Paquetes Turísticos y Alimentación: solo analizar por día de inicio
        if ($esPaqueteTuristico || $nombreTipo === 'Alimentación') {
            return DB::table('reserva_detalles')
                ->join('reservas', 'reserva_detalles.reserva_id', '=', 'reservas.id')
                ->selectRaw('DATE(fecha_inicio) as fecha_inicio, SUM(cantidad) as total_reservado')
                ->where('servicio_id', $servicioId)
                ->whereIn('reservas.estado', ['Confirmada', 'Pendiente'])
                ->where('fecha_inicio', '>=', now()->format('Y-m-d'))
                ->groupBy('fecha_inicio')
                ->havingRaw('SUM(cantidad) >= ?', [$servicio->stock])
                ->pluck('fecha_inicio')
                ->toArray();
        }

        // Para Hospedaje/Guianza/Alquiler: analizar rango completo con cuello de botella
        $reservas = DB::table('reserva_detalles')
            ->join('reservas', 'reserva_detalles.reserva_id', '=', 'reservas.id')
            ->where('servicio_id', $servicioId)
            ->whereIn('reservas.estado', ['Confirmada', 'Pendiente'])
            ->where('fecha_fin', '>=', now()->format('Y-m-d'))
            ->get(['fecha_inicio', 'fecha_fin', 'cantidad']);

        $ocupacionPorDia = [];
        
        foreach ($reservas as $res) {
            $periodo = CarbonPeriod::create($res->fecha_inicio, $res->fecha_fin);
            
            foreach ($periodo as $fecha) {
                $fechaStr = $fecha->format('Y-m-d');
                if (!isset($ocupacionPorDia[$fechaStr])) {
                    $ocupacionPorDia[$fechaStr] = 0;
                }
                $ocupacionPorDia[$fechaStr] += $res->cantidad;
            }
        }

        $fechasAgotadas = [];
        foreach ($ocupacionPorDia as $fecha => $ocupado) {
            if ($ocupado >= $servicio->stock) {
                $fechasAgotadas[] = $fecha;
            }
        }

        return $fechasAgotadas;
    }

    private function obtenerOCrearTurista(array $datosTurista, string $passwordPlana): User
    {
        $user = User::firstOrCreate(
            ['cedula' => $datosTurista['identificacion']],
            [
                'name' => $datosTurista['nombres'],
                'apellidos' => $datosTurista['apellidos'],
                'email' => $datosTurista['correo'],
                'telefono' => $datosTurista['telefono'] ?? null,
                'edad' => $datosTurista['edad'] ?? null,
                'password' => Hash::make($passwordPlana),
            ]
        );

        if (!$user->hasRole('turista')) {
            $user->assignRole('turista');
        }

        return $user;
    }

    private function procesarDetallesCarrito(Reserva $reserva, array $carrito): float
    {
        $totalCalculado = 0;

        foreach ($carrito as $item) {
            $servicioDB = Servicio::with('tipoServicio')
                ->where('id', $item['id'])
                ->lockForUpdate()
                ->firstOrFail();

            $fechaInicio = $item['fecha'] ?? $item['fecha_inicio'];
            $cantidad = (int) $item['cantidad'];
            $nombreTipo = $servicioDB->tipoServicio->nombre ?? '';

            // Para Alimentación: fecha_inicio = fecha_fin (solo día, no rango)
            // Para otros: usar fecha_fin proporcionada o fecha_inicio si no existe
            if ($nombreTipo === 'Alimentación') {
                $fechaFin = $fechaInicio;
            } else {
                $fechaFin = $item['fecha_fin'] ?? $fechaInicio;
            }

            if ($this->manejaStockDiario($nombreTipo)) {
                $disponibleEnRango = $this->calcularDisponibilidadEnRango($servicioDB->id, $fechaInicio, $fechaFin);

                if ($disponibleEnRango < $cantidad) {
                    throw new \Exception("Cupos insuficientes para el servicio: {$servicioDB->nombre}");
                }
            }

            $subtotal = $servicioDB->precio * $cantidad;

            $reserva->detalles()->create([
                'servicio_id' => $servicioDB->id,
                'fecha_inicio' => $fechaInicio,
                'fecha_fin' => $fechaFin,
                'hora' => $item['hora'] ?? null,
                'numero_personas' => $item['numero_personas'] ?? 1,
                'cantidad' => $cantidad,
                'precio_unitario' => $servicioDB->precio,
                'subtotal' => $subtotal,
            ]);

            $totalCalculado += $subtotal;
        }

        return $totalCalculado;
    }

    private function manejaStockDiario(string $nombreTipo): bool
    {
        return in_array($nombreTipo, self::TIPOS_CON_STOCK_DIARIO, true);
    }
}