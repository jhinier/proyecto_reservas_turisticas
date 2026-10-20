<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publicaciones_turisticas', function (Blueprint $table) {
            $table->longText('descripcion')->change();
        });

        Schema::table('actividades_festividades', function (Blueprint $table) {
            $table->longText('descripcion')->change();
        });

        Schema::table('actividades_turisticas', function (Blueprint $table) {
            $table->longText('recomendaciones')->change();
        });

        Schema::table('emprendimientos', function (Blueprint $table) {
            $table->longText('descripcion')->change();
        });
    }

    public function down(): void
    {
        Schema::table('publicaciones_turisticas', function (Blueprint $table) {
            $table->string('descripcion', 300)->change();
        });

        Schema::table('actividades_festividades', function (Blueprint $table) {
            $table->string('descripcion', 300)->change();
        });

        Schema::table('actividades_turisticas', function (Blueprint $table) {
            $table->string('recomendaciones', 300)->change();
        });

        Schema::table('emprendimientos', function (Blueprint $table) {
            $table->string('descripcion', 300)->change();
        });
    }
};
