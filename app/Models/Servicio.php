<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\{HasOne, HasMany, BelongsTo};

class Servicio extends Model
{
    use SoftDeletes;

    const TIPO_GUIANZA      = 1;
    const TIPO_PAQUETE      = 2;
    const TIPO_ALIMENTACION = 3;
    const TIPO_HOSPEDAJE    = 4;
    const TIPO_ALQUILER     = 5;

    protected $fillable = [
        'emprendimiento_tipo_servicio_id',
        'nombre',
        'descripcion',
        'precio',
        'stock'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'stock'  => 'integer',
    ];

    // =========================
    // DOMINIO (ESTADO)
    // =========================

    protected function tipoRealId(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->relationLoaded('categoriaPivot')) {
                return null;
            }

            return $this->categoriaPivot?->tipo_servicio_id;
        });
    }

    protected function tieneImagen(): Attribute
    {
        return Attribute::get(fn () => 
            $this->relationLoaded('imagenes') && $this->imagenes->isNotEmpty()
        );
    }

    protected function permiteGaleria(): Attribute
    {
        return Attribute::get(function () {
            // Si no sabemos qué es (porque olvidamos el ->with()), por seguridad NO permitimos galería
            if (! $this->tipo_real_id) return false; 
            
            return $this->tipo_real_id !== self::TIPO_GUIANZA;
        });
    }

    // =========================
    // RELACIONES
    // =========================

    public function categoriaPivot(): BelongsTo
    {
        return $this->belongsTo(
            EmprendimientoTipoServicio::class,
            'emprendimiento_tipo_servicio_id'
        );
    }

    public function tipoServicio(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(
            TipoServicio::class,
            EmprendimientoTipoServicio::class,
            'id', // Llave foránea en EmprendimientoTipoServicio (id de la fila intermedia)
            'id', // Llave foránea en TipoServicio (id de la categoría)
            'emprendimiento_tipo_servicio_id', // Llave local en Servicios
            'tipo_servicio_id' // Llave local en EmprendimientoTipoServicio
        );
    }

    public function imagenes(): HasMany
    {
        return $this->hasMany(
            ImagenServicio::class,
            'servicio_id'
        );
    }

    public function detalleHospedaje(): HasOne
    {
        return $this->hasOne(DetalleHospedaje::class, 'servicio_id');
    }

    public function detalleGuianza(): HasOne
    {
        return $this->hasOne(DetalleGuianza::class, 'servicio_id');
    }

    public function detalleAlimentacion(): HasOne
    {
        return $this->hasOne(DetalleAlimentacion::class, 'servicio_id');
    }

    public function detallePaqueteTuristico(): HasOne
    {
        return $this->hasOne(DetallePaqueteTuristico::class, 'servicio_id');
    }

    public function presenter(): \App\Presenters\ServicioPresenter
    {
        return new \App\Presenters\ServicioPresenter($this);
    }

    public function emprendimientoTipoServicio()
    {
        return $this->belongsTo(EmprendimientoTipoServicio::class, 'emprendimiento_tipo_servicio_id');
    }
}