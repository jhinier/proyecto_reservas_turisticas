<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitioTuristico extends Model
{
    protected $table = 'sitios_turisticos';

    protected $primaryKey = 'publicacion_id';

    public $incrementing = false;

    protected $fillable = [
        'publicacion_id'
    ];

    public function publicacion()
    {
        return $this->belongsTo(PublicacionTuristica::class);
    }
}
