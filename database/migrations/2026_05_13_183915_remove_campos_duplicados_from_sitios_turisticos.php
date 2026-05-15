<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sitios_turisticos', function (Blueprint $table) {

            $table->dropColumn([
                'nombre',
                'descripcion'
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('sitios_turisticos', function (Blueprint $table) {

            $table->string('nombre');
            $table->text('descripcion');

        });
    }
};