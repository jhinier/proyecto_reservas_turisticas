<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificacionRegistroMail;
use App\Models\User;
use App\Rules\CedulaEcuatoriana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegistroController extends Controller
{
    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'],
            'apellidos' => ['required', 'string', 'min:2', 'max:50', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'],
            'cedula' => [
                'required',
                'string',
                Rule::unique('users', 'cedula')->whereNull('deleted_at'),
                new CedulaEcuatoriana(),
            ],
            'edad' => ['required', 'integer', 'min:18', 'max:99'],
            'telefono' => ['required', 'numeric', 'digits:10'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)->mixedCase()->symbols(),
            ],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'apellidos.required' => 'Los apellidos son obligatorios.',
            'cedula.required' => 'La cédula es obligatoria.',
            'cedula.unique' => 'Esta cédula ya se encuentra registrada.',
            'edad.required' => 'La edad es obligatoria.',
            'edad.min' => 'Debes ser mayor de edad (18+).',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.digits' => 'El teléfono debe tener exactamente 10 dígitos.',
            'email.required' => 'El correo es obligatorio.',
            'email.unique' => 'Este correo ya está registrado en el sistema.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ])->validate();

        $token = Str::random(64);
        $cacheKey = 'registro.pending.' . $token;

        Cache::put($cacheKey, [
            'name' => $data['name'],
            'apellidos' => $data['apellidos'],
            'cedula' => $data['cedula'],
            'edad' => $data['edad'],
            'telefono' => $data['telefono'],
            'email' => $data['email'],
            'password' => $data['password'],
            'created_at' => now(),
        ], now()->addMinutes(30));

        Mail::to($data['email'])->send(
            new VerificacionRegistroMail(
                $data['name'],
                $data['email'],
                $token
            )
        );

        return redirect()->back()->with(
            'status',
            'Tu cuenta está en espera de confirmación. Revisa tu correo electrónico y confirma tu registro para terminar.'
        );
    }

    public function confirmar(string $token)
    {
        $cacheKey = 'registro.pending.' . $token;
        $datos = Cache::get($cacheKey);

        if (!$datos) {
            abort(404, 'El enlace de verificación ya expiró o no es válido.');
        }

        if (User::where('email', $datos['email'])->exists()) {
            Cache::forget($cacheKey);

            abort(409, 'Este correo ya se encuentra registrado.');
        }

        $user = User::create([
            'name' => $datos['name'],
            'apellidos' => $datos['apellidos'],
            'cedula' => $datos['cedula'],
            'edad' => $datos['edad'],
            'telefono' => $datos['telefono'],
            'email' => $datos['email'],
            'password' => $datos['password'],
        ]);

        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();

        $user->assignRole('turista');

        Auth::login($user);

        Cache::forget($cacheKey);

        return view('registro.confirmacion', [
            'titulo' => 'Cuenta creada correctamente',
            'mensaje' => 'Tu correo fue confirmado. Ya puedes empezar a usar tu cuenta.',
        ]);
    }
}
