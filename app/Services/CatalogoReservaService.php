<?php

namespace App\Services;

use App\Services\ServicioService;
use App\Services\InventarioService;
use App\Models\TipoServicio;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class CatalogoReservaService
{
    protected InventarioService $inventarioService;
    protected ServicioService $servicioService;

    public function __construct(InventarioService $inventarioService, ServicioService $servicioService)
    {
        $this->inventarioService = $inventarioService;
        $this->servicioService = $servicioService;
    }

    public function buscarDisponibilidad(int $emprendimientoId, int $tipoServicioId, array $parametros): Collection
    {
        if (empty($parametros['fecha_inicio'])) {
            return collect();
        }

        $serviciosBrutos = $this->servicioService->obtenerServiciosParaReserva($emprendimientoId, $tipoServicioId);

        $serviciosDisponibles = collect();
        $tipoModelo = TipoServicio::find($tipoServicioId);
        $nombreTipo = $tipoModelo ? strtolower($tipoModelo->nombre) : '';
        $esPaquete = str_contains($nombreTipo, 'paquete');

        $fechaInicioCheck = $parametros['fecha_inicio'];
        $fechaFinCheck = $esPaquete ? $fechaInicioCheck : ($parametros['fecha_fin'] ?? $fechaInicioCheck);

        foreach ($serviciosBrutos as $servicio) {
            
            $disponiblesBD = $this->inventarioService->calcularDisponibilidadEnRango(
                $servicio->id,
                $fechaInicioCheck,
                $fechaFinCheck
            );

            if ($disponiblesBD <= 0) {
                continue;
            }

            $capacidad = 1;
            if ($servicio->detalleHospedaje) {
                $capacidad = (int) $servicio->detalleHospedaje->capacidad;
            } elseif ($servicio->detalleGuianza) {
                $capacidad = (int) $servicio->detalleGuianza->numero_max_persona;
            }

            $servicio->cupos_libres = $disponiblesBD;
            $servicio->capacidad_unitaria = max(1, $capacidad);
            $servicio->dias_calculados = max(1, Carbon::parse($fechaInicioCheck)->diffInDays(Carbon::parse($fechaFinCheck)) + 1);

            $serviciosDisponibles->push($servicio);
        }

        return $serviciosDisponibles;
    }
}