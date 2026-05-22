<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades_festividades';

    protected $fillable = [
        'publicacion_id',
        'nombre',
        'fecha',
        'hora',
        'lugar',
        'descripcion',
        'imagen'
    ];

    protected $casts = [
    'fecha' => 'date',
    ];

    public function publicacion()
    {
        return $this->belongsTo(PublicacionTuristica::class, 'publicacion_id');
    }
}