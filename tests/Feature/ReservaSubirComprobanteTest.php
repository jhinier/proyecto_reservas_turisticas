<?php

use App\Mail\ComprobanteSubidoEmprendedorMail;
use App\Models\Emprendimiento;
use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\TipoServicio;
use App\Models\User;
use App\Services\ReservaService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

it('notifica al emprendedor cuando el turista sube el comprobante', function () {
    Mail::fake();
    Storage::fake('public');

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

    $archivo = UploadedFile::fake()->image('comprobante.jpg');

    app(ReservaService::class)->subirComprobante($reserva->id, $turista->id, $archivo);

    $reserva->refresh();

    expect($reserva->estado)->toBe('Pago en revisión')
        ->and($reserva->comprobante_pago)->not->toBeNull()
        ->and($reserva->fecha_subida_comprobante)->not->toBeNull();

    Mail::assertSent(ComprobanteSubidoEmprendedorMail::class, function ($mail) use ($responsable, $reserva) {
        return $mail->hasTo($responsable->email)
            && $mail->reserva->id === $reserva->id
            && $mail->nombreTurista === 'Juan Perez';
    });
});
