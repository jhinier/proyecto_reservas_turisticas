<?php

/**
 * Modelo Eloquent para el detalle especifico de un servicio de alimentacion.
 * Complementa el registro base de servicio usando servicio_id como llave primaria compartida.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleAlimentacion extends Model
{
    use HasFactory;

    // 1. Especificamos la tabla exacta
    protected $table = 'detalle_alimentaciones';

    // 2. 🔥 CLAVE: Le decimos a Laravel que la llave primaria es 'servicio_id' y NO es autoincrementable
    protected $primaryKey = 'servicio_id';
    public $incrementing = false;

    // 3. Campos que se pueden llenar masivamente
    protected $fillable = [
        'servicio_id',
        'tipo_alimentacion',
        'lugar_alimentacion',
    ];

    // 4. Relación Inversa (Un detalle pertenece a un servicio general)
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
