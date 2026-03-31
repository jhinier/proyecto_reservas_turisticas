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
        if(isset($input['cedula'])) {
            Validator::make($input, [
                'cedula' => ['required', new CedulaEcuatoriana],
            ])->validate();
        }
        
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();


        return User::create([
            'name' => $input['name'],
            'apellidos' => $input['apellidos'],
            'cedula' => $input['cedula'],
            'telefono' => $input['telefono'],
            'email' => $input['email'],
            'password' => $input['password'],
            'edad' => $input['edad'],
        ]);
    }
}
