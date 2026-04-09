<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            // Agrega la columna 'deleted_at' de tipo timestamp
            $table->softDeletes(); 
        });
    }

    public function down(): void
    {
        Schema::table('servicios', function (Blueprint $table) {
            // Revierte el cambio si hacemos un rollback
            $table->dropSoftDeletes(); 
        });
    }
};