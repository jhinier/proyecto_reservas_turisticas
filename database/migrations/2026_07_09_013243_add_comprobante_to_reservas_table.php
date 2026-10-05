<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->string('comprobante_pago')->nullable()->after('reservada_por_rol');
            $table->timestamp('fecha_subida_comprobante')->nullable()->after('comprobante_pago');
        });
    }

    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropColumn(['comprobante_pago', 'fecha_subida_comprobante']);
        });
    }
};