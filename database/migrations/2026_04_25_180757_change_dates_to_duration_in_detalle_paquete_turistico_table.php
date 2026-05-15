<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('detalle_paquete_turistico', function (Blueprint $table) {
            // Eliminamos los campos de fecha que ya no necesitamos
            $table->dropColumn(['fecha_inicio', 'fecha_fin']);
            
            // Agregamos solo el campo de días
            $table->integer('duracion_dias')->after('documento')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detalle_paquete_turistico', function (Blueprint $table) {
            // Devolvemos las columnas originales
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
            
            // Eliminamos solo el campo de días
            $table->dropColumn('duracion_dias');
        });
    }
};