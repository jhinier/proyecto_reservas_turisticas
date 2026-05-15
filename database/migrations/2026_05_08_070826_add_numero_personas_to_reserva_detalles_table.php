<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reserva_detalles', function (Blueprint $table) {
            $table->integer('numero_personas')->default(1)->after('cantidad');
        });
    }

    public function down(): void
    {
        Schema::table('reserva_detalles', function (Blueprint $table) {
            $table->dropColumn('numero_personas');
        });
    }
};