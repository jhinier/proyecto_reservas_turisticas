<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Festividad extends Model
{
    protected $table = 'festividades';

    protected $primaryKey = 'publicacion_id';

    public $incrementing = false;

    protected $keyType = 'int';

    protected $fillable = [
        'publicacion_id',
        'fecha_inicio',
        'fecha_fin',
    ];

    // 🔹 PUBLICACIÓN
    public function publicacion()
    {
        return $this->belongsTo(
            PublicacionTuristica::class,
            'publicacion_id'
        );
    }

    // 🔹 ACTIVIDADES
    public function actividades()
    {
        return $this->hasMany(
            Actividad::class,
            'publicacion_id',
            'publicacion_id'
        );
    }
}