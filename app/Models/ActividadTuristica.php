<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PublicacionTuristica;
use App\Models\Actividad;

class ActividadTuristica extends Model
{
    protected $table = 'actividades_turisticas';

    protected $primaryKey = 'publicacion_id';

    public $incrementing = false;

    protected $fillable = [
        'publicacion_id',
        'duracion_estimada',
        'dificultad',
        'recomendaciones'
    ];

    public function publicacion()
    {
        return $this->belongsTo(PublicacionTuristica::class, 'publicacion_id');
    }
}
