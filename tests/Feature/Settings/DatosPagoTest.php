<?php

use App\Livewire\Settings\DatosPago;
use App\Models\CuentaBancaria;
use App\Models\Emprendimiento;
use App\Models\User;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

function crearEmprendimientoParaDatosPago(): array
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
        'descripcion' => 'Descripcion original del emprendimiento.',
        'estado' => true,
    ]);

    return [$user, $emprendimiento];
}

test('solo un usuario de emprendimiento puede abrir los datos de pago', function () {
    [$emprendedor] = crearEmprendimientoParaDatosPago();

    $this->actingAs($emprendedor)
        ->get(route('emprendimiento-payment.edit'))
        ->assertOk();

    $otroUsuario = User::factory()->create([
        'apellidos' => 'Turista',
        'cedula' => '0923456789',
        'edad' => 28,
        'telefono' => '0987654321',
    ]);

    $this->actingAs($otroUsuario)
        ->get(route('emprendimiento-payment.edit'))
        ->assertForbidden();
});

test('el emprendimiento puede registrar varias cuentas bancarias', function () {
    [$user, $emprendimiento] = crearEmprendimientoParaDatosPago();

    Livewire::actingAs($user)
        ->test(DatosPago::class)
        ->set('cuentasBancarias.0.nombre_banco', 'Banco Pichincha')
        ->set('cuentasBancarias.0.numero_cuenta', '2200112233')
        ->set('cuentasBancarias.0.titular', 'Turismo Comunitario')
        ->call('agregarCuentaBancaria')
        ->set('cuentasBancarias.1.nombre_banco', 'Banco Guayaquil')
        ->set('cuentasBancarias.1.numero_cuenta', '9988776655')
        ->set('cuentasBancarias.1.titular', 'Asociacion Turismo')
        ->call('guardar')
        ->assertHasNoErrors()
        ->assertSessionHas('datos_pago_success', 'Datos bancarios guardados exitosamente.')
        ->assertRedirect(route('emprendimiento-payment.edit'));

    $cuentas = $emprendimiento->cuentasBancarias()
        ->orderBy('id')
        ->get(['nombre_banco', 'numero_cuenta', 'titular'])
        ->map(fn (CuentaBancaria $cuenta) => $cuenta->only(['nombre_banco', 'numero_cuenta', 'titular']))
        ->all();

    expect($cuentas)->toBe([
        [
            'nombre_banco' => 'Banco Pichincha',
            'numero_cuenta' => '2200112233',
            'titular' => 'Turismo Comunitario',
        ],
        [
            'nombre_banco' => 'Banco Guayaquil',
            'numero_cuenta' => '9988776655',
            'titular' => 'Asociacion Turismo',
        ],
    ]);
});

test('una cuenta bancaria incompleta no se guarda', function () {
    [$user, $emprendimiento] = crearEmprendimientoParaDatosPago();

    Livewire::actingAs($user)
        ->test(DatosPago::class)
        ->set('cuentasBancarias.0.nombre_banco', 'Banco Pichincha')
        ->call('guardar')
        ->assertHasErrors([
            'cuentasBancarias.0.numero_cuenta',
            'cuentasBancarias.0.titular',
        ]);

    expect($emprendimiento->cuentasBancarias()->count())->toBe(0);
});

test('el emprendimiento elimina una cuenta bancaria con soft delete', function () {
    [$user, $emprendimiento] = crearEmprendimientoParaDatosPago();

    $cuentaAEliminar = CuentaBancaria::create([
        'emprendimiento_id' => $emprendimiento->id,
        'nombre_banco' => 'Banco Pichincha',
        'numero_cuenta' => '2200112233',
        'titular' => 'Turismo Comunitario',
    ]);

    $cuentaActiva = CuentaBancaria::create([
        'emprendimiento_id' => $emprendimiento->id,
        'nombre_banco' => 'Banco Guayaquil',
        'numero_cuenta' => '9988776655',
        'titular' => 'Asociacion Turismo',
    ]);

    $component = Livewire::actingAs($user)->test(DatosPago::class);
    $filaAEliminar = collect($component->get('cuentasBancarias'))
        ->firstWhere('cuenta_id', $cuentaAEliminar->id);

    $component
        ->call('eliminarCuentaBancaria', $filaAEliminar['id'])
        ->call('guardar')
        ->assertHasNoErrors()
        ->assertSessionHas('datos_pago_success', 'Datos bancarios guardados exitosamente.')
        ->assertRedirect(route('emprendimiento-payment.edit'));

    $idsVisibles = collect($component->get('cuentasBancarias'))->pluck('cuenta_id')->all();

    expect(CuentaBancaria::withTrashed()->find($cuentaAEliminar->id)->trashed())->toBeTrue();
    expect($cuentaActiva->fresh()->deleted_at)->toBeNull();
    expect($idsVisibles)->not->toContain($cuentaAEliminar->id);
    expect($idsVisibles)->toContain($cuentaActiva->id);
});
