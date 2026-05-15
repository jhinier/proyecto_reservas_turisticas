<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('festividades', function (Blueprint $table) {

            $table->string('nombre')->after('publicacion_id');
            $table->string('lugar')->nullable()->after('fecha_fin');
            $table->text('descripcion')->nullable()->after('lugar');
            $table->string('imagen')->nullable()->after('descripcion');

        });
    }

    public function down(): void
    {
        Schema::table('festividades', function (Blueprint $table) {

            $table->dropColumn(['nombre','lugar','descripcion','imagen']);

        });
    }
};