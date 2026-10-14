<?php

use App\Models\User;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Livewire;
use PragmaRX\Google2FA\Google2FA;

beforeEach(function () {
    if (! Features::canManageTwoFactorAuthentication()) {
        $this->markTestSkipped('Two-factor authentication is not enabled.');
    }

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);
});

test('two factor settings page can be rendered', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->withSession(['auth.password_confirmed_at' => time()])
        ->get(route('two-factor.show'))
        ->assertOk()
        ->assertSee('Autenticación de dos factores')
        ->assertSee('Desactivado');
});

test('two factor settings page requires password confirmation when enabled', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get(route('two-factor.show'));

    $response->assertRedirect(route('password.confirm'));
});

test('two factor settings page returns forbidden response when two factor is disabled', function () {
    config(['fortify.features' => []]);

    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->withSession(['auth.password_confirmed_at' => time()])
        ->get(route('two-factor.show'));

    $response->assertForbidden();
});

test('two factor authentication disabled when confirmation abandoned between requests', function () {
    $user = User::factory()->create();

    $user->forceFill([
        'two_factor_secret' => encrypt('test-secret'),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        'two_factor_confirmed_at' => null,
    ])->save();

    $this->actingAs($user);

    $component = Livewire::test('settings.two-factor');

    $component->assertSet('twoFactorEnabled', false);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
    ]);
});

test('two factor authentication can be disabled from fortify route', function () {
    $user = User::factory()->withTwoFactor()->create();

    $this->actingAs($user)
        ->withSession(['auth.password_confirmed_at' => time()])
        ->from(route('two-factor.show'))
        ->delete(route('two-factor.disable'))
        ->assertRedirect(route('two-factor.show'));

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
        'two_factor_confirmed_at' => null,
    ]);
});

test('two factor authentication can be confirmed with generated authenticator code', function () {
    $user = User::factory()->create();

    $component = Livewire::actingAs($user)
        ->test('settings.two-factor')
        ->call('enable')
        ->assertSet('showModal', true);

    $user->refresh();

    $secret = Fortify::currentEncrypter()->decrypt($user->two_factor_secret);
    $code = app(Google2FA::class)->getCurrentOtp($secret);

    $component
        ->set('code', $code)
        ->call('confirmTwoFactor')
        ->assertSet('twoFactorEnabled', true)
        ->assertSet('showModal', false);

    expect($user->fresh()->two_factor_confirmed_at)->not->toBeNull();
});

test('invalid two factor confirmation shows spanish guidance', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('settings.two-factor')
        ->call('enable')
        ->call('showVerificationIfNecessary')
        ->set('code', '000000')
        ->call('confirmTwoFactor')
        ->assertHasErrors(['code'])
        ->assertSee('El código no es válido');
});
