<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->timestamps();
        });

        Schema::create('emprendimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nombre', 150);
            $table->string('descripcion', 300);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });

        Schema::create('emprendimiento_tipo_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_servicio_id')->constrained('tipo_servicios')->onDelete('cascade');
            $table->foreignId('emprendimiento_id')->constrained('emprendimientos')->onDelete('cascade');
            $table->timestamps();
        });

        // SERVICIOS CON SU LLAVE FORÁNEA ORIGINAL
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emprendimiento_tipo_servicio_id')->constrained('emprendimiento_tipo_servicios')->onDelete('cascade');
            $table->string('nombre', 150);
            $table->string('descripcion', 300);
            $table->decimal('precio', 8, 2);
            $table->integer('stock');
            $table->timestamps();
        });

        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('fecha');
            $table->string('estado', 20);
            $table->decimal('precio_total', 8, 2);
            $table->integer('numero_personas');
            $table->timestamps();
        });

        Schema::create('imagen_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            $table->string('imagen', 255);
            $table->timestamps();
        });


        Schema::create('detalle_hospedajes', function (Blueprint $table) {
            $table->foreignId('servicio_id')->primary()->constrained('servicios')->onDelete('cascade');
            $table->integer('capacidad');
            $table->timestamps();
        });

        Schema::create('detalle_paquete_turistico', function (Blueprint $table) {
            $table->foreignId('servicio_id')->primary()->constrained('servicios')->onDelete('cascade');
            $table->string('lugar_salida', 150);
            $table->time('hora_salida');
            $table->integer('capacidad');
            $table->string('servicios_incluidos', 300);
            $table->string('lugares_actividades', 300);
            $table->string('recomendaciones', 300);
            $table->string('documento', 255);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('mensaje_pago', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('detalle_guianzas', function (Blueprint $table) {
            $table->foreignId('servicio_id')->primary()->constrained('servicios')->onDelete('cascade');
            $table->integer('numero_max_persona');
            $table->timestamps();
        });

        Schema::create('detalle_alimentaciones', function (Blueprint $table) {
            $table->foreignId('servicio_id')->primary()->constrained('servicios')->onDelete('cascade');
            $table->string('tipo_alimentacion', 100);
            $table->string('lugar_alimentacion', 150);
            $table->timestamps();
        });


        Schema::create('tipo_publicaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->timestamps();
        });

        Schema::create('publicaciones_turisticas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('tipo_publicacion_id')->constrained('tipo_publicaciones')->onDelete('cascade');
            $table->string('nombre', 150);
            $table->string('descripcion', 300);
            $table->timestamps();
        });

        Schema::create('imagen_publicaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publicacion_id')->constrained('publicaciones_turisticas')->onDelete('cascade');
            $table->string('imagen', 255);
            $table->timestamps();
        });

        Schema::create('sitios_turisticos', function (Blueprint $table) {
            $table->foreignId('publicacion_id')->primary()->constrained('publicaciones_turisticas')->onDelete('cascade');
            $table->string('ubicacion', 200);
            $table->timestamps();
        });

        Schema::create('actividades_turisticas', function (Blueprint $table) {
            $table->foreignId('publicacion_id')->primary()->constrained('publicaciones_turisticas')->onDelete('cascade');
            $table->string('duracion_estimada', 50);
            $table->string('dificultad', 50);
            $table->string('recomendaciones', 300);
            $table->timestamps();
        });

        Schema::create('festividades', function (Blueprint $table) {
            $table->foreignId('publicacion_id')->primary()->constrained('publicaciones_turisticas')->onDelete('cascade');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
        });

        Schema::create('actividades_festividades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('publicacion_id')->constrained('publicaciones_turisticas')->onDelete('cascade');
            $table->string('nombre', 150);
            $table->date('fecha');
            $table->time('hora');
            $table->string('lugar', 150);
            $table->string('descripcion', 300);
            $table->string('imagen', 255);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades_festividades');
        Schema::dropIfExists('festividades');
        Schema::dropIfExists('actividades_turisticas');
        Schema::dropIfExists('sitios_turisticos');
        Schema::dropIfExists('imagen_publicaciones');
        Schema::dropIfExists('publicaciones_turisticas');
        Schema::dropIfExists('tipo_publicaciones');
        Schema::dropIfExists('detalle_alimentaciones');
        Schema::dropIfExists('detalle_guianzas');
        Schema::dropIfExists('detalle_paquete_turistico');
        Schema::dropIfExists('detalle_hospedajes');
        Schema::dropIfExists('imagen_servicios');
        Schema::dropIfExists('reservas');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('emprendimiento_tipo_servicios'); // <-- Nombre correcto en el down()
        Schema::dropIfExists('emprendimientos');
        Schema::dropIfExists('tipo_servicios');
    }
};