<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePaqueteTuristico extends Model
{
    use HasFactory;

    // 1. Especificamos la tabla exacta
    protected $table = 'detalle_paquete_turistico';

    // 2. 🔥 CLAVE: Configuración de la llave primaria
    protected $primaryKey = 'servicio_id';
    public $incrementing = false;

    // 3. Campos permitidos
    protected $fillable = [
        'servicio_id',
        'lugar_salida',
        'hora_salida',
        'servicios_incluidos',
        'lugares_actividades',
        'recomendaciones',
        'documento',
        'duracion_dias',
        'mensaje_pago',
    ];

    // 4. Casteo de fechas para que Laravel las trate automáticamente como objetos Carbon
    protected $casts = [
        'duracion_dias' => 'integer',
    ];

    // 5. Relación Inversa
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}