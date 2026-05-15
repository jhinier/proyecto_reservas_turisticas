<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sitios_turisticos', function (Blueprint $table) {
            $table->string('nombre')->nullable();
            $table->text('descripcion')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sitios_turisticos', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'descripcion']);
        });
    }
};
