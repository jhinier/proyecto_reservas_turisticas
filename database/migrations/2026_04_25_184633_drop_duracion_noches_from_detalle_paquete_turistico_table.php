<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalle_paquete_turistico', function (Blueprint $table) {
            $table->dropColumn('duracion_noches');
        });
    }

    public function down(): void
    {
        Schema::table('detalle_paquete_turistico', function (Blueprint $table) {
            $table->integer('duracion_noches')->after('duracion_dias')->default(0);
        });
    }
};