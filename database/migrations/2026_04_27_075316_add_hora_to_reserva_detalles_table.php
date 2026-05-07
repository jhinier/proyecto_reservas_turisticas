<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('reserva_detalles', function (Blueprint $table) {
            // Usamos el nombre que pediste para mayor claridad
            $table->time('hora_llegada')->nullable()->after('fecha_inicio');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reserva_detalles', function (Blueprint $table) {
            // Siempre es bueno poder deshacer lo que hicimos
            $table->dropColumn('hora_llegada');
        });
    }
};
