<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    // Constantes de estado (Se mantienen, afectan a toda la reserva)
    public const ESTADO_PENDIENTE = 'Pendiente';
    public const ESTADO_CONFIRMADA = 'Confirmada';
    public const ESTADO_RECHAZADA = 'Rechazada';
    public const ESTADO_CANCELADA = 'Cancelada';

    protected $fillable = [
        'user_id',            // Quién compra
        'estado',             // Estado global de la compra
        'precio_total',       // Suma de todos los detalles
        'reservada_por_rol',  // Auditoría: ¿quién la creó?
        'cancelada_en',
        'cancelada_por_rol',
        'motivo_cancelacion'
    ];

    protected $casts = [
        'cancelada_en' => 'datetime',
        'precio_total' => 'decimal:2',
    ];

    // --- RELACIONES ---

    /**
     * Relación fundamental: Una reserva tiene muchos detalles (el carrito).
     */
    public function detalles()
    {
        return $this->hasMany(ReservaDetalle::class, 'reserva_id');
    }

    /**
     * El turista que es dueño de esta reserva.
     */
    public function turista()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // --- MÉTODOS DE APOYO (Opcional pero recomendado) ---

    /**
     * Calcula si la reserva tiene más de un servicio.
     */
    public function esPaquete(): bool
    {
        return $this->detalles()->count() > 1;
    }

    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class, 'emprendimiento_id');
    }
}