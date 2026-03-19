<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emprendimiento extends Model
{
    use HasFactory;

    protected $table = 'emprendimientos'; 

    // EL ESCUDO DE SEGURIDAD
    protected $fillable = [
        'user_id',
        'nombre',
        'descripcion',
        'estado',
    ];

    // TRANSFORMACIÓN AUTOMÁTICA DE DATOS
    protected $casts = [
        'estado' => 'boolean',
    ];

    // EL ÁRBOL GENEALÓGICO (RELACIÓN)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}