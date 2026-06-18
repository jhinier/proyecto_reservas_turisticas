<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Rules\CedulaEcuatoriana;
use Illuminate\Validation\Rules\Password;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        // Unificamos todas las validaciones en un solo bloque
        Validator::make($input, [
            ...$this->profileRules(),
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'cedula' => ['required', 'string', 'unique:users', new CedulaEcuatoriana()],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->symbols(), 'confirmed'],
            'edad' => ['required', 'integer', 'min:18'],
        ], [
            // ... tus mensajes de error ...
            'cedula.unique' => 'Esta cédula ya se encuentra registrada.',
            'email.unique' => 'Este correo electrónico ya se encuentra registrado.'
        ])->validate();

        // 1. Guardamos el usuario
        $user = User::create([
            'name' => $input['name'],
            'apellidos' => $input['apellidos'],
            'cedula' => $input['cedula'],
            'telefono' => $input['telefono'],
            'email' => $input['email'],
            'password' => $input['password'],
            'edad' => $input['edad'],
        ]);

        // 2. Le asignamos el rol
        $user->assignRole('turista');

        // 3. Retornamos el usuario
        return $user;
    }
}