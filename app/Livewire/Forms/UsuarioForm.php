<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Rules\CedulaEcuatoriana; // Importamos tu regla matemática
use Illuminate\Validation\Rules\Password;

class UsuarioForm extends Form
{
    public $nombre = '';
    public $apellidos = '';
    public $cedula = '';
    public $telefono = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    public function rules()
    {
        return [
            // Validación de nombres: Solo letras y tildes
            'nombre'    => 'required|string|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            'apellidos' => 'required|string|min:3|max:50|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u',
            
            // CÉDULA: Aquí combinamos las reglas de Laravel con TU regla personalizada
            'cedula'    => [
                'required',
                'numeric',
                'digits:10',
                'unique:users,cedula', // Verifica que no se repita en la base de datos
                new CedulaEcuatoriana(), // Ejecuta tu algoritmo matemático
            ],
            
            // Teléfono: Restringido a formato ecuatoriano (7 a 10 dígitos)
            'telefono'  => 'required|numeric|digits_between:7,10',
            
            // Email: Único y con formato válido
            'email'     => 'required|email|max:255|unique:users,email',
            
            // Contraseña: Nivel de seguridad alto
            'password'  => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()     // Al menos una letra
                    ->mixedCase()   // Mayúsculas y minúsculas
                    ->numbers()     // Al menos un número
                    ->symbols(),    // Al menos un símbolo (!@#$%...)
            ],
        ];
    }

    /**
     * Mensajes personalizados para que el usuario entienda qué hizo mal
     */
    public function messages() 
    {
        return [
            'cedula.unique'   => 'Esta cédula ya pertenece a un usuario registrado.',
            'cedula.digits'   => 'La cédula debe tener 10 dígitos obligatoriamente.',
            'email.unique'    => 'Este correo ya está en uso por otro emprendedor.',
            'nombre.regex'    => 'El nombre no puede contener números ni símbolos.',
            'apellidos.regex' => 'El apellido no puede contener números ni símbolos.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ];
    }
}