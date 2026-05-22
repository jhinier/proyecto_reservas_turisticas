<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('emprendimientos', function (Blueprint $table) {
            $table->string('imagen')->nullable()->after('descripcion');
            $table->softDeletes(); // Crea el campo deleted_at automáticamente
        });
    }

    public function down(): void
    {
        Schema::table('emprendimientos', function (Blueprint $table) {
            $table->dropColumn('imagen');
            $table->dropSoftDeletes();
        });
    }
};