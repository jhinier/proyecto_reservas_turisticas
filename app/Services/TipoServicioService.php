<?php

namespace App\Services;

use App\Models\Emprendimiento;
use App\Models\TipoServicio;
use Illuminate\Support\Facades\DB;

/**
 * Servicio para la gestión de Tipos de Servicios Turísticos.
 */
class TipoServicioService
{
    /**
     * Recupera el catálogo maestro en tiempo real.
     */
    public function obtenerCatalogo()
    {
        return TipoServicio::all(['id', 'nombre']);
    }

    /**
     * Recupera SOLO las categorías activas (estado = true) del emprendimiento.
     * Ideal para el formulario de reservas.
     */
   /**
     * Recupera SOLO las categorías activas (estado = true) del emprendimiento.
     * Ideal para el formulario de reservas.
     */
    public function obtenerTiposActivosPorEmprendimiento(int $emprendimientoId)
    {
        $emprendimiento = Emprendimiento::find($emprendimientoId);

        if (!$emprendimiento) {
            return collect();
        }

        // Al usar la relación directamente, Laravel busca automáticamente el nombre correcto de tu tabla pivote
        return $emprendimiento->tiposServicios()
            ->wherePivot('estado', true)
            ->select('tipo_servicios.id', 'tipo_servicios.nombre')
            ->get();
    }

    /**
     * Sincroniza la relación N:M preservando historial.
     */
    public function sincronizarTipos(Emprendimiento $emprendimiento, array $seleccionados): void
    {
        $seleccionados = array_unique($seleccionados);

        DB::transaction(function () use ($emprendimiento, $seleccionados) {
            
            $tiposActuales = $emprendimiento->tiposServicios()->pluck('tipo_servicios.id');
            
            if ($tiposActuales->isNotEmpty()) {
                $emprendimiento->tiposServicios()->updateExistingPivot($tiposActuales, ['estado' => false]);
            }

            if (empty($seleccionados)) {
                return;
            }

            $emprendimiento->tiposServicios()->syncWithoutDetaching($seleccionados);
            $emprendimiento->tiposServicios()->updateExistingPivot($seleccionados, ['estado' => true]);
        });
    }
}