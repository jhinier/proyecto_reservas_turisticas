<?php

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
