<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalle_paquete_turistico', function (Blueprint $table) {
            // Cambiamos a TEXT para que soporte itinerarios largos
            $table->text('servicios_incluidos')->change();
            $table->text('lugares_actividades')->change();
            $table->text('recomendaciones')->change();
        });

        Schema::table('servicios', function (Blueprint $table) {
            $table->text('descripcion')->change();
        });
    }

    public function down(): void
    {
        Schema::table('detalle_paquete_turistico', function (Blueprint $table) {
            $table->string('servicios_incluidos', 300)->change();
            $table->string('lugares_actividades', 300)->change();
            $table->string('recomendaciones', 300)->change();
        });

        Schema::table('servicios', function (Blueprint $table) {
            $table->string('descripcion', 300)->change();
        });
    }
};