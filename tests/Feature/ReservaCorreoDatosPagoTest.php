<?php

use App\Mail\ReservaAceptadaMail;
use App\Mail\ReservaConfirmadaMail;
use App\Models\CuentaBancaria;
use App\Models\Emprendimiento;
use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\TipoServicio;
use App\Models\User;
use Illuminate\Support\Facades\DB;

function crearReservaConDatosDePago(bool $crearCuentas = true): array
{
    $turista = User::create([
        'name' => 'Juan',
        'apellidos' => 'Perez',
        'email' => 'juan@example.com',
        'password' => 'password',
        'cedula' => '0102030405',
        'telefono' => '0999999999',
        'edad' => 30,
    ]);

    $responsable = User::create([
        'name' => 'Maria',
        'apellidos' => 'Lopez',
        'email' => 'emprendedor@example.com',
        'password' => 'password',
        'cedula' => '1102030405',
        'telefono' => '0988888888',
        'edad' => 35,
    ]);

    $emprendimiento = Emprendimiento::create([
        'user_id' => $responsable->id,
        'nombre' => 'Aventura Andina',
        'descripcion' => 'Experiencias turisticas',
        'estado' => true,
    ]);

    if ($crearCuentas) {
        CuentaBancaria::create([
            'emprendimiento_id' => $emprendimiento->id,
            'nombre_banco' => 'Banco Pichincha',
            'numero_cuenta' => '2200112233',
            'titular' => 'Aventura Andina',
        ]);

        CuentaBancaria::create([
            'emprendimiento_id' => $emprendimiento->id,
            'nombre_banco' => 'Banco Guayaquil',
            'numero_cuenta' => '9988776655',
            'titular' => 'Maria Lopez',
        ]);
    }

    $tipoServicio = TipoServicio::create(['nombre' => 'Guianza']);

    $pivotId = DB::table('emprendimiento_tipo_servicios')->insertGetId([
        'tipo_servicio_id' => $tipoServicio->id,
        'emprendimiento_id' => $emprendimiento->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    $servicio = Servicio::create([
        'emprendimiento_tipo_servicio_id' => $pivotId,
        'nombre' => 'Ruta al mirador',
        'descripcion' => 'Caminata guiada',
        'precio' => 40,
        'stock' => 10,
    ]);

    $reserva = Reserva::create([
        'user_id' => $turista->id,
        'estado' => 'Confirmada',
        'precio_total' => 80,
        'reservada_por_rol' => 'Turista',
    ]);

    $reserva->detalles()->create([
        'servicio_id' => $servicio->id,
        'fecha_inicio' => now()->addDays(3)->toDateString(),
        'fecha_fin' => now()->addDays(3)->toDateString(),
        'hora_llegada' => '09:00',
        'cantidad' => 2,
        'numero_personas' => 2,
        'precio_unitario' => 40,
        'subtotal' => 80,
    ]);

    return [$reserva->fresh(), $turista, $responsable];
}

test('el correo de reserva aceptada incluye telefono y cuentas bancarias del emprendimiento', function () {
    [$reserva, , $responsable] = crearReservaConDatosDePago();

    $html = (new ReservaAceptadaMail($reserva, $responsable->telefono))->render();

    expect($html)->toContain('Telefono de contacto')
        ->and($html)->toContain('0988888888')
        ->and($html)->toContain('Banco Pichincha')
        ->and($html)->toContain('2200112233')
        ->and($html)->toContain('Aventura Andina')
        ->and($html)->toContain('Banco Guayaquil')
        ->and($html)->toContain('9988776655')
        ->and($html)->toContain('Maria Lopez')
        ->and($html)->toContain('Realiza el pago')
        ->and($html)->toContain('sube tu comprobante de pago')
        ->and($html)->toContain('Tienes un plazo maximo de 24 horas para realizar el pago')
        ->and($html)->toContain('tu reserva sera cancelada automaticamente')
        ->and($html)->toContain('Si tienes dudas')
        ->and($html)->not->toContain('24 horas para comunicarte');
});

test('el correo de reserva confirmada incluye telefono y cuentas bancarias del emprendimiento', function () {
    [$reserva, $turista, $responsable] = crearReservaConDatosDePago();

    $html = (new ReservaConfirmadaMail($reserva, $turista, [], $responsable->telefono))->render();

    expect($html)->toContain('Telefono de contacto')
        ->and($html)->toContain('0988888888')
        ->and($html)->toContain('Banco Pichincha')
        ->and($html)->toContain('2200112233')
        ->and($html)->toContain('Aventura Andina')
        ->and($html)->toContain('Banco Guayaquil')
        ->and($html)->toContain('9988776655')
        ->and($html)->toContain('Maria Lopez')
        ->and($html)->toContain('Realiza el pago')
        ->and($html)->toContain('sube tu comprobante de pago')
        ->and($html)->toContain('Tienes un plazo maximo de 24 horas para realizar el pago')
        ->and($html)->toContain('tu reserva sera cancelada automaticamente')
        ->and($html)->toContain('Si tienes dudas')
        ->and($html)->not->toContain('24 horas para comunicarte');
});

test('el correo no muestra texto alternativo de datos bancarios cuando no hay cuentas', function () {
    [$reserva, , $responsable] = crearReservaConDatosDePago(crearCuentas: false);

    $html = (new ReservaAceptadaMail($reserva, $responsable->telefono))->render();

    expect($html)->toContain('Telefono de contacto')
        ->and($html)->toContain('0988888888')
        ->and($html)->not->toContain('recibir los datos bancarios')
        ->and($html)->not->toContain('Comunicate con Aventura Andina');
});
