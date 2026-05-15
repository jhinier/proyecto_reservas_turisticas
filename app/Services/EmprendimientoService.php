<?php

namespace App\Services;

use App\Models\Emprendimiento;
use App\Models\User; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 
use Exception;

class EmprendimientoService
{
    protected UserService $userService;

    // Inyectamos el UserService para aplicar el Principio DRY (No te repitas).
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // --- MÉTODOS DE LECTURA (Nuevos para conectar con Livewire) ---

    // Obtiene los usuarios con el rol 'emprendimiento' para los selectores de la UI.
    public function obtenerUsuariosEmprendedores()
    {
        return User::role('emprendimiento')->get();
    }

    // Lista los emprendimientos paginados con su usuario para evitar consultas lentas (N+1).
    public function listarPaginados(int $porPagina = 10)
    {
        return Emprendimiento::with('user')->latest()->paginate($porPagina);
    }

    // Busca un emprendimiento específico cargando todos sus datos y los de su dueño.
    public function buscarConRelaciones(int $id)
    {
        return Emprendimiento::with('user')->findOrFail($id);
    }


    // --- MÉTODOS DE ESCRITURA (Tu lógica original protegida) ---

    // Registra un nuevo Usuario y su Emprendimiento garantizando integridad ACID.
    public function registrarNuevoEmprendimiento(array $datosUsuario, array $datosEmpresa)
    {
        try {
            return DB::transaction(function () use ($datosUsuario, $datosEmpresa) {
                
                $datosUsuario['role'] = 'emprendimiento';
                
                // Delegamos la creación al servicio de usuarios
                $user = $this->userService->crearUsuario($datosUsuario);

                $emprendimiento = Emprendimiento::create([
                    'user_id'     => $user->id,
                    'nombre'      => $datosEmpresa['nombre_emprendimiento'], 
                    'descripcion' => $datosEmpresa['descripcion'],
                    'estado'      => $datosEmpresa['estado'] ?? 1, // Aseguramos el estado al crear
                ]);

                return $emprendimiento;
            });

        } catch (Exception $e) {
            Log::error('Fallo al registrar el usuario y su emprendimiento: ' . $e->getMessage());
            throw $e; 
        }
    }

    // Actualiza Empresa y Usuario en una sola transacción atómica.
    public function actualizarTodo(int $emprendimientoId, array $datosEmpresa, array $datosUsuario)
    {
        return DB::transaction(function () use ($emprendimientoId, $datosEmpresa, $datosUsuario) {
            
            $emprendimiento = Emprendimiento::findOrFail($emprendimientoId);
            $emprendimiento->update($datosEmpresa);
    
            $usuario = User::findOrFail($emprendimiento->user_id);
            $usuario->update($datosUsuario);
    
            return $emprendimiento;
        });
    }

    // Elimina el registro, limpia roles y libera la cédula/email.
    public function eliminarRegistroCompleto(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            try {
                $emp = Emprendimiento::findOrFail($id);
                $usuario = $emp->user;

                if ($usuario) {
                    $usuario->syncRoles([]); 
                    return (bool) $usuario->delete();
                }

                return (bool) $emp->delete();
            } catch (Exception $e) {
                Log::error("Fallo crítico al eliminar registro #{$id}: " . $e->getMessage());
                return false;
            }
        });
    }

}