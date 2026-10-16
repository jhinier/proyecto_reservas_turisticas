<?php

use App\Models\User;
use Database\Seeders\permisos;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

test('admin seeding rejects missing or short passwords before creating records', function ($password) {
    config(['seeding.gad_admin_password' => $password]);

    expect(fn () => $this->seed(permisos::class))
        ->toThrow(RuntimeException::class, 'GAD_ADMIN_PASSWORD');

    $this->assertDatabaseCount('users', 0);
    $this->assertDatabaseCount('roles', 0);
    $this->assertDatabaseCount('permissions', 0);
})->with([
    'not configured' => [null],
    'too short' => ['short'],
]);

test('admin seeding uses the configured password and assigns the administrator role', function () {
    $password = Str::password(24);
    config(['seeding.gad_admin_password' => $password]);

    $this->seed(permisos::class);

    $user = User::where('email', 'lacandelaria_penipe@hotmail.com')->sole();

    expect(Hash::check($password, $user->password))->toBeTrue()
        ->and($user->hasRole('superAdministrador'))->toBeTrue();
});
