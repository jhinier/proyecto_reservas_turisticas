<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function crearUsuario(array $datos)
    {
        return DB::transaction(function () use ($datos) {
            $usuario = User::create([
                'name'      => $datos['nombre'],
                'apellidos' => $datos['apellidos'],
                'email'     => $datos['email'],
                'password'  => Hash::make($datos['password']),
                'cedula'    => $datos['cedula'],
                'telefono'  => $datos['telefono'],
                'edad'      => $datos['edad'],
            ]);

            $usuario->assignRole($datos['role']);

            return $usuario;
        });
    }

    public function buscarOCrearTurista(array $datos)
    {
        return DB::transaction(function () use ($datos) {
            $usuario = User::firstOrCreate(
                ['cedula' => $datos['cedula']],
                [
                    'name'      => $datos['name'],
                    'apellidos' => $datos['apellidos'],
                    'email'     => $datos['email'],
                    'telefono'  => $datos['telefono'],
                    'edad'      => $datos['edad'] ?? 18,
                    'password'  => Hash::make(\Illuminate\Support\Str::random(16)),
                ]
            );

            if ($usuario->wasRecentlyCreated) {
                $usuario->assignRole('turista');
            }

            return $usuario;
        });
    }

    // Función movida desde TuristaService
    public function buscarPorIdentificacion(string $identificacion): ?User
{
    // El scope role('turista') obliga a que el usuario tenga ese rol específico
    return User::role('turista')
        ->where('cedula', $identificacion)
        ->first(['id', 'cedula', 'email', 'name', 'apellidos', 'edad', 'telefono']);
}
}