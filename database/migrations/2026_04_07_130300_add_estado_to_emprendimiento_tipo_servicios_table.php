<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('emprendimiento_tipo_servicios', function (Blueprint $table) {
            // Se llama 'estado', pero es booleano (1 o 0 / true o false)
            $table->boolean('estado')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('emprendimiento_tipo_servicios', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};