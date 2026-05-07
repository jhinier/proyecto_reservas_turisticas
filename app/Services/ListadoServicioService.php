<?php
namespace App\Services;

use App\Models\Emprendimiento;
use App\Models\Servicio;
use Illuminate\Pagination\LengthAwarePaginator;

class ListadoServicioService
{
    public function obtenerCategoriasActivas(Emprendimiento $emprendimiento)
    {
        return $emprendimiento->tiposServicios()
            ->wherePivot('estado', true)
            ->withPivot('id')
            ->select('tipo_servicios.id', 'tipo_servicios.nombre')
            ->get();
    }

    public function obtenerPaginadosPorCategoria(?int $pivotId, int $perPage = 10)
    {
        if (! $pivotId) {
            return new LengthAwarePaginator([], 0, $perPage);
        }

        return Servicio::query()
            ->select([
                'id',
                'nombre',
                'descripcion',
                'precio',
                'stock',
                'emprendimiento_tipo_servicio_id'
            ])
            ->where('emprendimiento_tipo_servicio_id', $pivotId)
            ->with([
                'imagenes:id,servicio_id,imagen',
                'categoriaPivot:id,tipo_servicio_id'
            ])
            ->latest()
            ->paginate($perPage);
    }
}