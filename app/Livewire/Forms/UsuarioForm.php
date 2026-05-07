<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Rules\CedulaEcuatoriana;
use Illuminate\Validation\Rules\Password;

class UsuarioForm extends Form
{
    public string $nombre = '';
    public string $apellidos = '';
    public string $cedula = '';
    public string $edad = '';
    public string $telefono = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function rules(): array
    {
        return [
            'nombre'    => 'required|string|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            'apellidos' => 'required|string|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            // Mantenemos 'unique' aquí para que Laravel use su motor interno de BD, es más rápido
            'cedula'    => ['required', 'numeric', 'digits:10', 'unique:users,cedula', new CedulaEcuatoriana()],
            'edad'      => 'required|numeric|min:18|max:99',
            'telefono'  => 'required|numeric|digits:10',
            'email'     => 'required|email|max:255|unique:users,email',
            'password'  => ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ];
    }

    public function messages(): array
    {
        return [
            // MENSAJES PARA CÉDULA
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.digits'   => 'La cédula debe tener exactamente 10 dígitos.',
            'cedula.unique'   => 'Esta cédula ya se encuentra registrada en el sistema.', // <--- ESTO ES LO QUE TE FALTABA
            
            // MENSAJES PARA TELÉFONO
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.digits'   => 'El teléfono debe tener 10 dígitos.',
            
            // MENSAJES PARA EMAIL
            'email.required' => 'El correo es obligatorio.',
            'email.unique'   => 'Este correo ya está en uso por otro usuario.',
            
            // MENSAJES PARA PASSWORD
            'password.required'  => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            
            // OTROS MENSAJES
            'edad.required'   => 'La edad es obligatoria.',
            'edad.min'        => 'Debes ser mayor de edad (18+).',
            'nombre.regex'    => 'El nombre solo puede contener letras.',
            'nombre.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'apellidos.regex' => 'Los apellidos solo pueden contener letras.',
        ];
    }
}
