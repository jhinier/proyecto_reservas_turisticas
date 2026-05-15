<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';

    protected $fillable = [
        'publicacion_id',
        'nombre',
        'fecha',
        'hora',
        'lugar',
        'descripcion'
    ];
}