<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\QueryException;
use Exception;

class TuristaService
{
    /**
     * Busca un usuario por su cédula optimizando la memoria.
     */
    public function buscarPorIdentificacion(string $identificacion): ?User
    {
        // Cambiamos 'nombre' por 'name' en la lista de campos
        return User::where('cedula', $identificacion)
            ->first(['id', 'cedula', 'email', 'name', 'apellidos', 'edad', 'telefono']);
    }

    public function procesarTurista(array $datos): User
    {
        // 1. Buscamos si el correo ya existe en otro usuario distinto
        $usuarioConEmail = User::where('email', $datos['correo'])
            ->where('cedula', '!=', $datos['identificacion'])
            ->first();

        if ($usuarioConEmail) {
            throw new \Exception('El correo electrónico ya está registrado con otra identificación.');
        }

        try {
            $turista = User::where('cedula', $datos['identificacion'])->first();

            if ($turista) {
                $turista->update([
                    'email' => $datos['correo'],
                    'name' => $datos['nombres'],
                    'apellidos' => $datos['apellidos'],
                    'edad' => $datos['edad'],
                    'telefono' => $datos['telefono'] ?? null,
                ]);

                return $turista;
            }

            // Si es nuevo, creamos la cuenta
            $passwordSeguro = Hash::make(Str::random(16));

            $nuevoTurista = User::create([
                'cedula' => $datos['identificacion'],
                'email' => $datos['correo'],
                'name' => $datos['nombres'],
                'apellidos' => $datos['apellidos'],
                'edad' => $datos['edad'],
                'telefono' => $datos['telefono'] ?? null,
                'password' => $passwordSeguro,
            ]);
            
            return $nuevoTurista;

        } catch (\Exception $e) {
            throw new \Exception('Error al guardar los datos del turista.');
        }
    }
}