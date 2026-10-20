<?php

/**
 * Modelo Eloquent para imagenes asociadas a publicaciones turisticas del GAD.
 * Se usa en sitios, actividades y festividades para manejar galerias publicas.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PublicacionTuristica;

class ImagenPublicacion extends Model
{
    protected $table = 'imagen_publicaciones'; // AJUSTA SEGÚN TU BD

    protected $fillable = [
        'publicacion_id',
        'imagen',
    ];

    public function publicacion()
    {
        return $this->belongsTo(PublicacionTuristica::class, 'publicacion_id');
    }
}
