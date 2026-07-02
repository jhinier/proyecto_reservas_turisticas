<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserService
{
    public function crearUsuario(array $datos)
    {
        
        return DB::transaction(function () use ($datos) {
            $usuario = User::create([
<<<<<<< HEAD
                'name' => strip_tags($datos['nombre'] ?? $datos['name'] ?? ''),
                'apellidos' => strip_tags($datos['apellidos'] ?? ''),
                'email' => filter_var($datos['email'] ?? '', FILTER_SANITIZE_EMAIL),
                'password' => Hash::make($datos['password'] ?? ''),
                'cedula' => strip_tags($datos['cedula'] ?? ''),
                'telefono' => strip_tags($datos['telefono'] ?? ''),
                'edad' => (int) ($datos['edad'] ?? 0),
=======
                'name'      => strip_tags($datos['nombre']),
                'apellidos' => strip_tags($datos['apellidos']),
                'email'     => filter_var($datos['email'], FILTER_SANITIZE_EMAIL),
                'password'  => Hash::make($datos['password']),
                'cedula'    => strip_tags($datos['cedula']),
                'telefono'  => strip_tags($datos['telefono']),
                'edad'      => (int) $datos['edad'],
>>>>>>> origin/Rama-Daniela
            ]);

            $usuario->assignRole($datos['role'] ?? 'turista');

            return $usuario;
        });
    }

    public function buscarOCrearTurista(array $datos)
    {
        return DB::transaction(function () use ($datos) {
            $usuario = User::firstOrCreate(
                ['cedula' => strip_tags($datos['cedula'] ?? '')],
                [
<<<<<<< HEAD
                    'name' => strip_tags($datos['nombre'] ?? $datos['name'] ?? ''),
                    'apellidos' => strip_tags($datos['apellidos'] ?? ''),
                    'email' => filter_var($datos['email'] ?? '', FILTER_SANITIZE_EMAIL),
                    'telefono' => strip_tags($datos['telefono'] ?? ''),
                    'edad' => (int) ($datos['edad'] ?? 18),
                    'password' => Hash::make(Str::random(16)),
=======
                    'name'      => strip_tags($datos['name']),
                    'apellidos' => strip_tags($datos['apellidos']),
                    'email'     => filter_var($datos['email'], FILTER_SANITIZE_EMAIL),
                    'telefono'  => strip_tags($datos['telefono']),
                    'edad'      => (int) ($datos['edad'] ?? 18),
                    'password'  => Hash::make(Str::random(16)),
>>>>>>> origin/Rama-Daniela
                ]
            );

            if ($usuario->wasRecentlyCreated) {
                // Si se creó por este método, asignamos rol turista por defecto
                $usuario->assignRole($datos['role'] ?? 'turista');
            }

            return $usuario;
        });
    }

    public function buscarPorIdentificacion(string $identificacion): ?User
    {
        return User::role('turista')
            ->where('cedula', strip_tags($identificacion))
            ->first(['id', 'cedula', 'email', 'name', 'apellidos', 'edad', 'telefono']);
    }
}