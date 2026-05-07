<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            // 1. Manejo de Fechas (Inicio y Fin)
            $table->renameColumn('fecha', 'fecha_inicio');
            $table->date('fecha_fin')->after('numero_personas')->nullable(); 

            // 2. Control de Origen de la Reserva
            $table->string('reservada_por_rol', 50)->after('fecha_fin')->default('Turista'); 

            // 3. Auditoría de Cancelación
            $table->timestamp('cancelada_en')->after('estado')->nullable();
            $table->string('cancelada_por_rol', 50)->after('cancelada_en')->nullable(); 
            $table->text('motivo_cancelacion')->after('cancelada_por_rol')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->renameColumn('fecha_inicio', 'fecha');
            $table->dropColumn([
                'fecha_fin',
                'reservada_por_rol',
                'cancelada_en',
                'cancelada_por_rol',
                'motivo_cancelacion'
            ]);
        });
    }
};