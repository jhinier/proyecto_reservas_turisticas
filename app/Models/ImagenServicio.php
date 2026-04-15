<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImagenServicio extends Model
{
    // Vinculamos exactamente con la tabla que tienes en tu migración
    protected $table = 'imagen_servicios'; 

    // Permitimos la asignación masiva de estos campos
    protected $fillable = ['servicio_id', 'imagen'];

    /**
     * Relación Inversa (N:1): A qué servicio pertenece esta imagen.
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}