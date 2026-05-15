<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ImagenPublicacion;
use App\Models\SitioTuristico;
use App\Models\Festividad;
use App\Models\ActividadTuristica;

class PublicacionTuristica extends Model
{
    protected $table = 'publicaciones_turisticas'; // 🔥 CORREGIDO

    protected $fillable = [
        'user_id',
        'tipo_publicacion_id',
        'nombre',
        'descripcion'
    ];

    // 🔹 RELACIONES
    public function imagenes()
    {
        return $this->hasMany(ImagenPublicacion::class, 'publicacion_id');
    }

    public function sitio()
    {
        return $this->hasOne(SitioTuristico::class, 'publicacion_id');
    }

    public function festividad()
    {
        return $this->hasOne(Festividad::class, 'publicacion_id');
    }

    public function actividad()
    {
        return $this->hasOne(ActividadTuristica ::class, 'publicacion_id');
    }
}