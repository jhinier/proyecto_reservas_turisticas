<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Modelo Pivote: Representa la relación activa entre un Emprendimiento y una Categoría.
 * Al heredar de 'Pivot' en lugar de 'Model', optimizamos las consultas relacionales.
 */
class EmprendimientoTipoServicio extends Pivot
{
    /**
     * @var string Nombre exacto de la tabla en la base de datos.
     */
    protected $table = 'emprendimiento_tipo_servicios';

    /**
     * @var bool Indica que el ID principal es autoincrementable (usado por la tabla servicios).
     */
    public $incrementing = true;

    /**
     * Relación: Obtiene los ítems físicos (servicios) que pertenecen a esta categoría específica.
     */
    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'emprendimiento_tipo_servicio_id');
    }
}