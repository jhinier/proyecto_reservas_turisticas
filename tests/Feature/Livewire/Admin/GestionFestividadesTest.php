<?php

use App\Livewire\Admin\Festividades\GestionFestividades;
use App\Models\Actividad;
use App\Models\Festividad;
use App\Models\PublicacionTuristica;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->usuario = User::factory()->create();
    $tipoId = DB::table('tipo_publicaciones')->insertGetId(['nombre' => 'Evento']);

    $this->publicacion = PublicacionTuristica::create([
        'user_id' => $this->usuario->id,
        'tipo_publicacion_id' => $tipoId,
        'nombre' => 'Festival comunitario',
        'descripcion' => 'Actividades de la comunidad.',
    ]);

    Festividad::create([
        'publicacion_id' => $this->publicacion->id,
        'fecha_inicio' => '2026-11-01',
        'fecha_fin' => '2026-11-03',
    ]);
});

test('guardar una actividad actualiza la lista del evento sin errores', function () {
    Livewire::actingAs($this->usuario)
        ->test(GestionFestividades::class)
        ->call('seleccionarFestividad', $this->publicacion->id)
        ->set('actividad_nombre', 'Recorrido comunitario')
        ->set('fecha', '2026-11-02')
        ->set('hora', '10:30')
        ->set('lugar', 'Plaza central')
        ->set('descripcion_actividad', 'Recorrido por la comunidad.')
        ->call('guardarActividad')
        ->assertHasNoErrors()
        ->assertSet('actividadesEdicion.0.nombre', 'Recorrido comunitario')
        ->assertSet('actividadesEdicion.0.fecha', '2026-11-02')
        ->assertDispatched('actualizarCalendarioLateral');

    $this->assertDatabaseHas('actividades_festividades', [
        'publicacion_id' => $this->publicacion->id,
        'nombre' => 'Recorrido comunitario',
    ]);
});

test('editar una actividad carga su fecha y conserva la imagen si no se reemplaza', function () {
    $actividad = Actividad::create([
        'publicacion_id' => $this->publicacion->id,
        'nombre' => 'Recorrido original',
        'fecha' => '2026-11-02',
        'hora' => '10:30',
        'lugar' => 'Plaza central',
        'descripcion' => 'Descripcion original.',
        'imagen' => 'actividades/original.jpg',
    ]);

    Livewire::actingAs($this->usuario)
        ->test(GestionFestividades::class)
        ->call('cargarFestividad', $this->publicacion->id)
        ->assertSet('actividadesEdicion.0.fecha', '2026-11-02')
        ->call('cargarActividadParaEditar', $actividad->id)
        ->assertSet('fecha', '2026-11-02')
        ->set('actividad_nombre', 'Recorrido actualizado')
        ->call('actualizarActividad')
        ->assertHasNoErrors()
        ->assertSet('actividadesEdicion.0.nombre', 'Recorrido actualizado');

    expect($actividad->fresh()->nombre)->toBe('Recorrido actualizado')
        ->and($actividad->fresh()->imagen)->toBe('actividades/original.jpg');
});

test('eliminar una actividad quita su imagen y actualiza la lista', function () {
    Storage::fake('public');
    Storage::disk('public')->put('actividades/eliminar.jpg', 'imagen');

    $actividad = Actividad::create([
        'publicacion_id' => $this->publicacion->id,
        'nombre' => 'Actividad a eliminar',
        'fecha' => '2026-11-02',
        'hora' => '10:30',
        'lugar' => 'Plaza central',
        'descripcion' => 'Descripcion de la actividad.',
        'imagen' => 'actividades/eliminar.jpg',
    ]);

    Livewire::actingAs($this->usuario)
        ->test(GestionFestividades::class)
        ->call('cargarFestividad', $this->publicacion->id)
        ->call('eliminarActividad', $actividad->id)
        ->assertSet('actividadesEdicion', [])
        ->assertDispatched('actualizarCalendarioLateral');

    $this->assertDatabaseMissing('actividades_festividades', ['id' => $actividad->id]);
    Storage::disk('public')->assertMissing('actividades/eliminar.jpg');
});
