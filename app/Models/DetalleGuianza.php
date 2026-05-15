<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleGuianza extends Model
{
    use HasFactory;

    // Definimos la tabla explícitamente ya que Laravel buscaría "detalle_guianzas" (plural estándar)
    protected $table = 'detalle_guianzas';

    // La llave primaria según tu migración es servicio_id
    protected $primaryKey = 'servicio_id';
    
    // Como la llave primaria no es autoincremental (es una FK), desactivamos el incremento
    public $incrementing = false;

    protected $fillable = [
        'servicio_id',
        'numero_max_persona',
    ];

    /**
     * Relación inversa con el Servicio (Padre)
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}