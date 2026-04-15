<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Modelo Entidad Padre: Servicio (Habitaciones, Platos, Tours, etc.)
 *
 * Centraliza los atributos comunes para optimizar consultas polimórficas y
 * protege el historial de transacciones (reservas) mediante borrado lógico.
 */
class Servicio extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var array Atributos permitidos para asignación masiva (Seguridad contra inyección).
     */
    protected $fillable = [
        'emprendimiento_tipo_servicio_id',
        'nombre',
        'descripcion',
        'precio',
        'stock'
    ];

    /**
     * @var array Casteo de tipos para asegurar integridad matemática y de datos.
     */
    protected $casts = [
        'precio' => 'decimal:2',
        'stock'  => 'integer',
    ];

    /**
     * Relación Inversa (N:1): Identifica a qué emprendimiento y categoría pertenece este ítem.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaPivot()
    {
        // Se conecta directamente con la tabla pivot que creamos antes
        return $this->belongsTo(EmprendimientoTipoServicio::class, 'emprendimiento_tipo_servicio_id');
    }

    /**
     * Relación de Herencia (1:1): Obtiene los detalles específicos si este servicio es una habitación.
     * * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function detalleHospedaje()
    {
        return $this->hasOne(DetalleHospedaje::class, 'servicio_id');
    }

    /**
     * 🔥 NUEVA RELACIÓN (1:N): Un servicio puede tener múltiples imágenes para el catálogo.
     * * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imagenes()
    {
        return $this->hasMany(ImagenServicio::class, 'servicio_id');
    }
}