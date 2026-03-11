<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('tipo_servicio', function (Blueprint $table) {
        $table->bigIncrements('id_tipo_servicio');
        $table->string('nombre_tipo_servicio',100);
        $table->timestamps();
    });

    Schema::create('tipo_publicacion', function (Blueprint $table) {
        $table->bigIncrements('id_tipo_publicacion');
        $table->string('nombre_tipo_publicacion',100);
        $table->timestamps();
    });

    Schema::create('empresa', function (Blueprint $table) {
        $table->bigIncrements('id_empresa');
        $table->unsignedBigInteger('id_usuario');
        $table->string('nombre_empresa',150);
        $table->string('descripcion',300);
        $table->timestamps();

        $table->foreign('id_usuario')->references('id')->on('users');
    });

    Schema::create('servicios', function (Blueprint $table) {
        $table->bigIncrements('id_servicio');
        $table->unsignedBigInteger('id_tipo_servicio');
        $table->unsignedBigInteger('id_empresa');
        $table->string('nombre_servicio',150);
        $table->string('descripcion',300);
        $table->decimal('precio',8,2);
        $table->integer('stock');
        $table->timestamps();

        $table->foreign('id_tipo_servicio')->references('id_tipo_servicio')->on('tipo_servicio');
        $table->foreign('id_empresa')->references('id_empresa')->on('empresa');
    });

    Schema::create('reserva', function (Blueprint $table) {
        $table->bigIncrements('id_reserva');
        $table->unsignedBigInteger('id_servicio');
        $table->unsignedBigInteger('id_usuario');
        $table->date('fecha');
        $table->string('estado',20);
        $table->decimal('precio_total',8,2);
        $table->integer('numero_personas');
        $table->timestamps();

        $table->foreign('id_servicio')->references('id_servicio')->on('servicios');
        $table->foreign('id_usuario')->references('id')->on('users');
    });

    Schema::create('imagenes_servicio', function (Blueprint $table) {
        $table->bigIncrements('id_img_servicio');
        $table->unsignedBigInteger('id_servicio');
        $table->string('imagen',255);
        $table->timestamps();

        $table->foreign('id_servicio')->references('id_servicio')->on('servicios');
    });

    Schema::create('detalle_hospedaje', function (Blueprint $table) {
        $table->unsignedBigInteger('id_servicio')->primary();
        $table->integer('capacidad');

        $table->foreign('id_servicio')->references('id_servicio')->on('servicios');
    });

    Schema::create('detalle_guianza', function (Blueprint $table) {
        $table->unsignedBigInteger('id_servicio')->primary();
        $table->string('lugar_salida',150);
        $table->time('hora_salida');
        $table->integer('capacidad');
        $table->string('servicios_incluidos',300);
        $table->string('lugares_actividades',300);
        $table->string('recomendaciones',300);
        $table->string('documento',255);
        $table->date('fecha_inicio');
        $table->date('fecha_fin');

        $table->foreign('id_servicio')->references('id_servicio')->on('servicios');
    });

    Schema::create('detalle_alimentacion', function (Blueprint $table) {
        $table->unsignedBigInteger('id_servicio')->primary();
        $table->string('horario',100);
        $table->string('tipo_alimentacion',100);

        $table->foreign('id_servicio')->references('id_servicio')->on('servicios');
    });

    Schema::create('publicacion_turistica', function (Blueprint $table) {
        $table->bigIncrements('id_publicacion');
        $table->unsignedBigInteger('id_usuario');
        $table->unsignedBigInteger('id_tipo_publicacion');
        $table->string('nombre_publicacion',150);
        $table->string('descripcion',300);
        $table->timestamps();

        $table->foreign('id_usuario')->references('id')->on('users');
        $table->foreign('id_tipo_publicacion')->references('id_tipo_publicacion')->on('tipo_publicacion');
    });

    Schema::create('imagenes_publicacion', function (Blueprint $table) {
        $table->bigIncrements('id_img_publicacion');
        $table->unsignedBigInteger('id_publicacion');
        $table->string('imagen',255);
        $table->timestamps();

        $table->foreign('id_publicacion')->references('id_publicacion')->on('publicacion_turistica');
    });

    Schema::create('sitios_turisticos', function (Blueprint $table) {
        $table->unsignedBigInteger('id_publicacion')->primary();
        $table->string('ubicacion_sitio_turistico',200);

        $table->foreign('id_publicacion')->references('id_publicacion')->on('publicacion_turistica');
    });

    Schema::create('actividades_turisticas', function (Blueprint $table) {
        $table->unsignedBigInteger('id_publicacion')->primary();
        $table->string('duracion_estimada',50);
        $table->string('dificultad',50);
        $table->string('recomendaciones',300);

        $table->foreign('id_publicacion')->references('id_publicacion')->on('publicacion_turistica');
    });

    Schema::create('festividades', function (Blueprint $table) {
        $table->unsignedBigInteger('id_publicacion')->primary();
        $table->date('fecha_inicio');
        $table->date('fecha_fin');

        $table->foreign('id_publicacion')->references('id_publicacion')->on('publicacion_turistica');
    });

    Schema::create('actividades_festividad', function (Blueprint $table) {
        $table->bigIncrements('id_act_festividad');
        $table->unsignedBigInteger('id_publicacion');
        $table->string('nombre_act_festividad',150);
        $table->date('fecha');
        $table->time('hora');
        $table->string('lugar',150);
        $table->string('descripcion',300);
        $table->string('imagen_act_festividad',255);

        $table->foreign('id_publicacion')->references('id_publicacion')->on('publicacion_turistica');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades_festividad');
        Schema::dropIfExists('festividades');
        Schema::dropIfExists('actividades_turisticas');
        Schema::dropIfExists('sitios_turisticos');
        Schema::dropIfExists('imagenes_publicacion');
        Schema::dropIfExists('publicacion_turistica');
        Schema::dropIfExists('detalle_alimentacion');
        Schema::dropIfExists('detalle_guianza');
        Schema::dropIfExists('detalle_hospedaje');
        Schema::dropIfExists('imagenes_servicio');
        Schema::dropIfExists('reserva');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('empresa');
        Schema::dropIfExists('tipo_publicacion');
        Schema::dropIfExists('tipo_servicio');
    }
};
