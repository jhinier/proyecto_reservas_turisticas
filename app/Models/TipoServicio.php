<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent para el catálogo maestro de tipos de servicios (ej. Hospedaje, Alimentación).
 */
class TipoServicio extends Model
{
    use HasFactory;

    /**
     * @var array<string> Atributos permitidos para asignación masiva (Mass Assignment).
     */
    protected $fillable = ['nombre'];

    /**
     * Relación N:M (BelongsToMany) inversa hacia Emprendimiento, exponiendo el flag pivot 'estado'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function emprendimientos()
    {
        return $this->belongsToMany(Emprendimiento::class, 'emprendimiento_tipo_servicios')
                    ->withPivot('estado');
    }
}