<?php

use App\Models\User;
use Laravel\Fortify\Features;
use Spatie\Permission\Models\Role;

test('two factor challenge redirects to login when not authenticated', function () {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two-factor authentication is not enabled.');
    }

    $response = $this->get(route('two-factor.login'));

    $response->assertRedirect(route('login'));
});

test('two factor challenge can be rendered', function () {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two-factor authentication is not enabled.');
    }

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    Role::create(['name' => 'turista']);

    $user = User::factory()->withTwoFactor()->create();
    $user->assignRole('turista');

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ])->assertRedirect(route('two-factor.login'));

    $this->get(route('two-factor.login'))
        ->assertOk()
        ->assertSee('Abre la app Authenticator donde vinculaste esta cuenta')
        ->assertSee('No llega por correo ni por SMS')
        ->assertSee('Usa uno de los códigos de recuperación que guardaste')
        ->assertSee('Pega aquí un código de recuperación guardado')
        ->assertSee('Inicio')
        ->assertSee('Volver');
});
