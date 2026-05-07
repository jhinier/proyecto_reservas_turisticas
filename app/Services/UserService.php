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
            // 1. Creación con los nombres exactos que vienen del Form Object
            $usuario = User::create([
                'name'      => $datos['nombre'],    // Antes decía 'name', ahora coincide con el Form
                'apellidos' => $datos['apellidos'], // ¡No te olvides de los apellidos!
                'email'     => $datos['email'],
                'password'  => Hash::make($datos['password']),
                'cedula'    => $datos['cedula'],
                'telefono'  => $datos['telefono'],
                'edad'      => $datos['edad'],
            ]);

            // 2. Asignación del rol
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
                    'edad'      => $datos['edad'] ?? 18, // Valor por defecto si no lo envían
                    'password'  => Hash::make(\Illuminate\Support\Str::random(16)), // Contraseña automática
                ]
            );

            // Solo asignamos el rol si es un usuario nuevo en el sistema
            if ($usuario->wasRecentlyCreated) {
                $usuario->assignRole('turista');
            }

            return $usuario;
        });
    }
}