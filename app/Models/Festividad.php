<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Festividad extends Model
{
    protected $table = 'festividades'; // 🔥 ESTA ES LA CLAVE    
    protected $primaryKey = 'publicacion_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'publicacion_id',
        'nombre',
        'fecha_inicio',
        'fecha_fin',
        'lugar',
        'descripcion',
        'imagen'
    ];

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'publicacion_id', 'publicacion_id');
    }

}