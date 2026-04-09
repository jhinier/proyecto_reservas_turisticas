<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Entidad Hija: Detalle de Hospedaje.
 * Implementa Herencia de Tabla por Clase acoplado al modelo Servicio.
 */
class DetalleHospedaje extends Model
{
    use HasFactory;

    /** @var string Definimos explícitamente la llave primaria personalizada. */
    protected $primaryKey = 'servicio_id';

    /** @var bool Desactivamos el autoincremento porque el ID viene heredado del Servicio Padre. */
    public $incrementing = false;

    /** @var array Atributos asignables de forma masiva. */
    protected $fillable = [
        'servicio_id',
        'capacidad',
    ];

    /**
     * Relación Inversa (1:1): Conecta este detalle con su entidad padre (Servicio).
     */
    public function servicioPadre()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}