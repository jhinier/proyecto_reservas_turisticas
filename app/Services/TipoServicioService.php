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
     * Recupera el catálogo maestro en tiempo real (Caché removida para desarrollo).
     * * MEJORA 3: Renombrado a singular (obtenerCatalogo)
     */
    public function obtenerCatalogo()
    {
        // Consulta directa para evitar los "fantasmas" de datos vacíos
        return TipoServicio::all(['id', 'nombre']);
    }

    /**
     * Sincroniza la relación N:M preservando historial.
     */
    public function sincronizarTipos(Emprendimiento $emprendimiento, array $seleccionados): void
    {
        // MEJORA 4: Protección extra contra IDs duplicados enviados desde el HTML
        $seleccionados = array_unique($seleccionados);

        DB::transaction(function () use ($emprendimiento, $seleccionados) {
            
            // MEJORA 1: Eliminado el toArray() innecesario. Dejamos la Colección pura.
            $tiposActuales = $emprendimiento->tiposServicios()->pluck('tipo_servicios.id');
            
            // Como ahora es una Colección de Laravel, usamos isNotEmpty() en lugar de !empty()
            if ($tiposActuales->isNotEmpty()) {
                $emprendimiento->tiposServicios()->updateExistingPivot($tiposActuales, ['estado' => false]);
            }

            // Salida temprana (Early Return)
            if (empty($seleccionados)) {
                return;
            }

            // Vincular sin eliminar
            $emprendimiento->tiposServicios()->syncWithoutDetaching($seleccionados);
            
            // Activar selección actual
            $emprendimiento->tiposServicios()->updateExistingPivot($seleccionados, ['estado' => true]);
        });
    }
}