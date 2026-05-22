<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('festividades', function (Blueprint $table) {

            $table->dropColumn([
                'nombre',
                'lugar',
                'descripcion',
                'imagen'
            ]);

        });
    }

    public function down(): void
    {
        Schema::table('festividades', function (Blueprint $table) {

            $table->string('nombre')->nullable();
            $table->string('lugar')->nullable();
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();

        });
    }
};
