<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emprendimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'emprendimientos';

    protected $fillable = [
        'user_id',
        'nombre',
        'descripcion',
        'imagen',
        'estado',
        'enlaces',
    ];

    protected $casts = [
        'estado' => 'boolean',
        'enlaces' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tiposServicios(): BelongsToMany
    {
        return $this->belongsToMany(TipoServicio::class, 'emprendimiento_tipo_servicios')
            ->withTimestamps();
    }

    public function cuentasBancarias(): HasMany
    {
        return $this->hasMany(CuentaBancaria::class);
    }
}
