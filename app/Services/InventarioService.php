<?php

namespace App\Services;

use App\Models\Servicio;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

class InventarioService
{
    private const TIPOS_CON_STOCK_DIARIO = [
        'Alquiler de Equipos',
        'Hospedaje',
        'Guianza',
        'Paquetes Turísticos',
        'Alimentación',
    ];

    public function calcularDisponibilidadEnRango(int $servicioId, string $fechaInicio, string $fechaFin): int
    {
        $servicio = Servicio::with('tipoServicio')->findOrFail($servicioId);
        $nombreTipo = $servicio->tipoServicio->nombre ?? '';

        if (!$this->manejaStockDiario($nombreTipo)) {
            return 999;
        }

        $esRangoCompleto = in_array($nombreTipo, ['Hospedaje', 'Alquiler de Equipos', 'Guianza']);
        $esPaqueteTuristico = $nombreTipo === 'Paquetes Turísticos';

        $fechaFinReal = $esRangoCompleto ? $fechaFin : $fechaInicio;

        $reservasAfectadas = DB::table('reserva_detalles')
            ->join('reservas', 'reserva_detalles.reserva_id', '=', 'reservas.id')
            ->where('reserva_detalles.servicio_id', $servicioId)
            ->whereIn('reservas.estado', ['Confirmada', 'Pendiente'])
            ->where(function ($query) use ($fechaInicio, $fechaFinReal, $esPaqueteTuristico) {
                if ($esPaqueteTuristico) {
                    $query->whereDate('reserva_detalles.fecha_inicio', $fechaInicio);
                } else {
                    $query->where('reserva_detalles.fecha_inicio', '<=', $fechaFinReal)
                          ->where('reserva_detalles.fecha_fin', '>=', $fechaInicio);
                }
            })
            ->get(['fecha_inicio', 'fecha_fin', 'cantidad']);

        if ($reservasAfectadas->isEmpty()) {
            return $servicio->stock;
        }

        if ($esPaqueteTuristico) {
            $ocupacionTotal = $reservasAfectadas->sum('cantidad');
            return max(0, $servicio->stock - $ocupacionTotal);
        }

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

    public function obtenerFechasAgotadas(int $servicioId): array
    {
        $servicio = Servicio::with('tipoServicio')->findOrFail($servicioId);
        $nombreTipo = $servicio->tipoServicio->nombre ?? '';

        if (!$this->manejaStockDiario($nombreTipo)) {
            return [];
        }

        $esRangoCompleto = in_array($nombreTipo, ['Hospedaje', 'Alquiler de Equipos', 'Guianza']);
        $esPaqueteTuristico = $nombreTipo === 'Paquetes Turísticos';

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

    public function manejaStockDiario(string $nombreTipo): bool
    {
        return in_array($nombreTipo, self::TIPOS_CON_STOCK_DIARIO, true);
    }
}