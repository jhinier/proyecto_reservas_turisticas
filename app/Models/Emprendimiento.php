<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // <-- NUEVO: Importamos la relación Muchos a Muchos

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

    // --- NUEVO: RELACIÓN CON LOS TIPOS DE SERVICIOS (Tabla Pivote) ---
    // Esto permite que el emprendimiento active sus servicios (Hospedaje, Guianza, etc.)
    public function tiposServicios(): BelongsToMany
    {
        return $this->belongsToMany(TipoServicio::class, 'emprendimiento_tipo_servicios')
                    ->withTimestamps(); // Guarda la fecha en la que activaron el servicio
    }
}