<?php

/**
 * Modelo Eloquent para cada linea o item de una reserva.
 * Relaciona un servicio con fechas, hora, cantidad, numero de personas y subtotal.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservaDetalle extends Model
{
    protected $fillable = [
        'reserva_id',
        'servicio_id',
        'fecha_inicio',
        'fecha_fin',
        'hora_llegada',
        'cantidad',
        'numero_personas',
        'precio_unitario',
        'subtotal'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'hora_llegada' => 'string',
    ];

    public function reserva(): BelongsTo
    {
        return $this->belongsTo(Reserva::class);
    }

    public function servicio(): BelongsTo
    {
        return $this->belongsTo(Servicio::class);
    }
}
