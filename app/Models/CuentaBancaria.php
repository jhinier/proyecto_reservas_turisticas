<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CuentaBancaria extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cuentas_bancarias';

    protected $fillable = [
        'emprendimiento_id',
        'nombre_banco',
        'numero_cuenta',
        'titular',
    ];

    public function emprendimiento(): BelongsTo
    {
        return $this->belongsTo(Emprendimiento::class);
    }
}
