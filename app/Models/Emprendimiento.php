<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    ];

    protected $casts = [
        'estado' => 'boolean',
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
}