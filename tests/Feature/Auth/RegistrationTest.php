<?php

use App\Mail\VerificacionRegistroMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response
        ->assertOk()
        ->assertSee('Inicio');
});

test('new users can register', function () {
    Mail::fake();

    $response = $this->from(route('register'))->post(route('registro.store'), [
        'name' => 'John',
        'apellidos' => 'Doe',
        'cedula' => '1710034065',
        'edad' => 25,
        'telefono' => '0999999999',
        'email' => 'test@example.com',
        'password' => 'Password#123',
        'password_confirmation' => 'Password#123',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertSessionHas('status')
        ->assertRedirect(route('register'));

    Mail::assertSent(VerificacionRegistroMail::class);

    $this->assertGuest();
    expect(User::where('email', 'test@example.com')->exists())->toBeFalse();
});
