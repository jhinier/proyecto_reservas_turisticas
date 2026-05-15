<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detalle_hospedajes', function (Blueprint $table) {
            $table->dropColumn('stock');
        });

        Schema::table('detalle_guianzas', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }

    public function down(): void
    {
        Schema::table('detalle_hospedajes', function (Blueprint $table) {
            // Ajusta el tipo de dato si antes usabas string u otro tipo
            $table->integer('stock')->nullable(); 
        });

        Schema::table('detalle_guianzas', function (Blueprint $table) {
            $table->integer('stock')->nullable();
        });
    }
};