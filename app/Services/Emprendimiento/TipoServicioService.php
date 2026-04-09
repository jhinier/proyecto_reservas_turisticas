<?php

namespace App\Services\Emprendimiento;

use App\Models\Emprendimiento;
use App\Models\TipoServicio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

/**
 * Servicio de Dominio para la gestión de Servicios Turísticos.
 * Centraliza la lógica de negocio, caché y mutaciones transaccionales.
 */
class TipoServicioService
{
    /**
     * Recupera el catálogo maestro de servicios implementando patrón Cache-Aside.
     * * @return \Illuminate\Database\Eloquent\Collection Colección cacheadada (TTL: 24h).
     */
    public function obtenerCatalogos()
    {
        return Cache::remember('catalogo_tipos_servicios', 86400, function () {
            return TipoServicio::all(['id', 'nombre']);
        });
    }

    /**
     * Sincroniza la relación N:M (Emprendimiento-TipoServicio) preservando el historial.
     * Implementa Soft-Delete lógico a nivel de tabla pivot mediante el flag 'estado'.
     *
     * @param Emprendimiento $emprendimiento Modelo base a mutar.
     * @param array<int> $seleccionados IDs de los servicios a activar/vincular.
     * @return void
     * @throws \Exception Si falla la transacción atómica en base de datos.
     */
    public function guardarTiposSeleccionados(Emprendimiento $emprendimiento, array $seleccionados): void
    {
        DB::transaction(function () use ($emprendimiento, $seleccionados) {
            
            // 1. Soft-Delete (Lógico): Desactiva todas las relaciones previas.
            $todosSusTipos = $emprendimiento->tiposServicios()->pluck('tipo_servicios.id')->toArray();
            
            if (!empty($todosSusTipos)) {
                $emprendimiento->tiposServicios()->updateExistingPivot($todosSusTipos, ['estado' => false]);
            }

            // 2. Vinculación Segura: Inserta nuevos registros sin eliminar relaciones preexistentes.
            $emprendimiento->tiposServicios()->syncWithoutDetaching($seleccionados);
            
            // 3. Activación: Enciende el flag (estado = true) únicamente para la selección actual.
            $emprendimiento->tiposServicios()->updateExistingPivot($seleccionados, ['estado' => true]);
            
        });
    }
}