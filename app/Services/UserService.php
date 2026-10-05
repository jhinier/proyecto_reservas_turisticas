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
            $cedula = trim((string) ($datos['cedula'] ?? ''));
            $email = filter_var($datos['email'] ?? '', FILTER_SANITIZE_EMAIL);

            $usuarioExistente = User::withTrashed()
                ->where('cedula', $cedula)
                ->orWhere('email', $email)
                ->first();

            if ($usuarioExistente) {
                if ($usuarioExistente->trashed()) {
                    $usuarioExistente->restore();
                    $usuarioExistente->update([
                        'name'      => strip_tags($datos['nombre'] ?? $datos['name'] ?? ''),
                        'apellidos' => strip_tags($datos['apellidos'] ?? ''),
                        'email'     => $email,
                        'password'  => Hash::make($datos['password'] ?? ''),
                        'cedula'    => $cedula,
                        'telefono'  => strip_tags($datos['telefono'] ?? ''),
                        'edad'      => (int) ($datos['edad'] ?? 0),
                    ]);

                    $usuarioExistente->syncRoles(['turista']);

                    return $usuarioExistente;
                }

                throw new \RuntimeException('Ya existe un usuario activo con esta cédula o correo.');
            }

            $usuario = User::create([
                'name'      => strip_tags($datos['nombre'] ?? $datos['name'] ?? ''),
                'apellidos' => strip_tags($datos['apellidos'] ?? ''),
                'email'     => $email,
                'password'  => Hash::make($datos['password'] ?? ''),
                'cedula'    => $cedula,
                'telefono'  => strip_tags($datos['telefono'] ?? ''),
                'edad'      => (int) ($datos['edad'] ?? 0),
            ]);

            $usuario->assignRole('turista');

            return $usuario;
        });
    }

    public function buscarOCrearTurista(array $datos)
    {
        return DB::transaction(function () use ($datos) {
            $cedula = trim((string) ($datos['cedula'] ?? ''));
            $email = filter_var($datos['email'] ?? '', FILTER_SANITIZE_EMAIL);

            $usuario = User::withTrashed()->where('cedula', $cedula)->first();

            if ($usuario) {
                if ($usuario->trashed()) {
                    $usuario->restore();
                    $usuario->update([
                        'name'      => strip_tags($datos['nombre'] ?? $datos['name'] ?? ''),
                        'apellidos' => strip_tags($datos['apellidos'] ?? ''),
                        'email'     => $email,
                        'telefono'  => strip_tags($datos['telefono'] ?? ''),
                        'edad'      => (int) ($datos['edad'] ?? 18),
                        'password'  => Hash::make(Str::random(16)),
                    ]);
                }

                if (! $usuario->hasRole('turista')) {
                    $usuario->assignRole('turista');
                }

                return $usuario;
            }

            $usuario = User::create([
                'name'      => strip_tags($datos['nombre'] ?? $datos['name'] ?? ''),
                'apellidos' => strip_tags($datos['apellidos'] ?? ''),
                'email'     => $email,
                'telefono'  => strip_tags($datos['telefono'] ?? ''),
                'edad'      => (int) ($datos['edad'] ?? 18),
                'password'  => Hash::make(Str::random(16)),
                'cedula'    => $cedula,
            ]);

            $usuario->assignRole('turista');

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