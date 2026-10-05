<?php

use App\Livewire\Settings\DatosEmprendimiento;
use App\Livewire\Settings\Profile;
use App\Models\Emprendimiento;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

function crearEmprendimientoParaConfiguracion(array $enlaces = []): array
{
    $user = User::factory()->create([
        'apellidos' => 'Emprendedor',
        'cedula' => '0912345678',
        'edad' => 35,
        'telefono' => '0991234567',
    ]);

    Role::findOrCreate('emprendimiento', 'web');
    $user->assignRole('emprendimiento');

    $emprendimiento = Emprendimiento::create([
        'user_id' => $user->id,
        'nombre' => 'Turismo Comunitario',
        'descripcion' => 'Descripción original del emprendimiento.',
        'estado' => true,
        'enlaces' => $enlaces === [] ? null : $enlaces,
    ]);

    return [$user, $emprendimiento];
}

test('solo un usuario de emprendimiento puede abrir los datos del emprendimiento', function () {
    [$emprendedor] = crearEmprendimientoParaConfiguracion();

    $this->actingAs($emprendedor)
        ->get(route('emprendimiento-profile.edit'))
        ->assertOk();

    $otroUsuario = User::factory()->create([
        'apellidos' => 'Turista',
        'cedula' => '0923456789',
        'edad' => 28,
        'telefono' => '0987654321',
    ]);

    $this->actingAs($otroUsuario)
        ->get(route('emprendimiento-profile.edit'))
        ->assertForbidden();
});

test('el emprendimiento actualiza su descripcion y redes sin cambiar su nombre', function () {
    [$user, $emprendimiento] = crearEmprendimientoParaConfiguracion([
        'https://www.facebook.com/turismo-comunitario',
    ]);

    Livewire::actingAs($user)
        ->test(DatosEmprendimiento::class)
        ->set('nombre', 'Nombre manipulado')
        ->set('descripcion', 'Nueva descripción pública para los visitantes.')
        ->set('redes.0.url', 'https://www.instagram.com/turismo-comunitario')
        ->call('agregarRedSocial')
        ->set('redes.1.url', 'https://wa.me/593991234567')
        ->call('guardar')
        ->assertHasNoErrors()
        ->assertDispatched('emprendimiento-updated');

    $emprendimiento->refresh();

    expect($emprendimiento->nombre)->toBe('Turismo Comunitario')
        ->and($emprendimiento->descripcion)->toBe('Nueva descripción pública para los visitantes.')
        ->and($emprendimiento->enlaces)->toBe([
            'https://www.instagram.com/turismo-comunitario',
            'https://wa.me/593991234567',
        ]);
});

test('el emprendimiento puede eliminar una red social', function () {
    [$user, $emprendimiento] = crearEmprendimientoParaConfiguracion([
        'https://www.facebook.com/turismo-comunitario',
        'https://www.instagram.com/turismo-comunitario',
    ]);

    $component = Livewire::actingAs($user)->test(DatosEmprendimiento::class);
    $redes = $component->get('redes');

    $component
        ->call('eliminarRedSocial', $redes[0]['id'])
        ->call('guardar')
        ->assertHasNoErrors();

    expect($emprendimiento->refresh()->enlaces)->toBe([
        'https://www.instagram.com/turismo-comunitario',
    ]);
});

test('el emprendimiento puede reemplazar su imagen', function () {
    Storage::fake('public');
    Storage::disk('public')->put('emprendimientos/anterior.jpg', 'imagen-anterior');

    [$user, $emprendimiento] = crearEmprendimientoParaConfiguracion();
    $emprendimiento->update(['imagen' => 'emprendimientos/anterior.jpg']);

    Livewire::actingAs($user)
        ->test(DatosEmprendimiento::class)
        ->set('imagen', UploadedFile::fake()->image('nueva-imagen.jpg', 400, 400))
        ->call('guardar')
        ->assertHasNoErrors();

    $rutaNueva = $emprendimiento->refresh()->imagen;

    expect($rutaNueva)->not->toBe('emprendimientos/anterior.jpg');
    Storage::disk('public')->assertExists($rutaNueva);
    Storage::disk('public')->assertMissing('emprendimientos/anterior.jpg');
});

test('el emprendedor puede actualizar su telefono desde el perfil', function () {
    [$user] = crearEmprendimientoParaConfiguracion();

    Livewire::actingAs($user)
        ->test(Profile::class)
        ->set('telefono', '0981122334')
        ->call('updateProfileInformation')
        ->assertHasNoErrors();

    expect($user->refresh()->telefono)->toBe('0981122334');
});
