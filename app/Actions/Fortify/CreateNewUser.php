<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Rules\CedulaEcuatoriana;
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
    'cedula' => ['required', 'numeric'], // Aquí quitamos la validación ecuatoriana
    'password' => $this->passwordRules(),
    'edad' => ['required', 'integer', 'min:18'],
], [
            'edad.min' => 'Debes tener al menos 18 años para registrarte en la plataforma.',
            'edad.required' => 'La edad es obligatoria.',
            'edad.integer' => 'La edad debe ser un número válido.'
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
