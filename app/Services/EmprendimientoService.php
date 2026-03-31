<?php

namespace App\Services;

use App\Models\Emprendimiento;
use App\Models\User; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 
use Exception;

class EmprendimientoService
{
    protected $userService;

    /**
     * Inyectamos el UserService para aplicar el Principio DRY (No te repitas)
     * y la Composición de Servicios.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Registra un nuevo Usuario y su Emprendimiento al mismo tiempo.
     * Usa una transacción para garantizar la Integridad de los Datos (ACID).
     */
    public function registrarNuevoEmprendimiento(array $datosUsuario, array $datosEmpresa)
    {
        try {
            return DB::transaction(function () use ($datosUsuario, $datosEmpresa) {
                
                // 1. Le decimos al UserService qué rol debe asignarle a esta persona
                $datosUsuario['role'] = 'emprendimiento';
                
                // 2. Delegamos la creación del usuario a su servicio especializado
                // (Él se encarga de crear, encriptar la clave y asignar el rol)
                $user = $this->userService->crearUsuario($datosUsuario);

                // 3. Creamos el negocio amarrado al ID de ese nuevo dueño
                $emprendimiento = Emprendimiento::create([
                    'user_id'     => $user->id,
                    'nombre'      => $datosEmpresa['nombre_emprendimiento'], 
                    'descripcion' => $datosEmpresa['descripcion'],
                ]);

                return $emprendimiento;
            });

        } catch (Exception $e) {
            // Si la base de datos falla, lo registramos para poder investigarlo luego
            Log::error('Fallo al registrar el usuario y su emprendimiento: ' . $e->getMessage());
            throw $e; 
        }
    }

    /**
     * Actualiza Empresa y Usuario en una sola transacción atómica.
     * Si falla uno, no se guarda ninguno (Integridad de datos).
     */
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

     public function eliminarRegistroCompleto(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            try {
                $emp = Emprendimiento::findOrFail($id);
                $usuario = $emp->user;

                if ($usuario) {
                    // 1. Limpiamos la tabla de roles (Spatie)
                    $usuario->syncRoles([]); 
                    // 2. Borramos al usuario (dispara el onDelete cascade hacia emprendimientos)
                    return (bool) $usuario->delete();
                }

                return (bool) $emp->delete();
            } catch (Exception $e) {
                Log::error("Fallo crítico al eliminar registro #{$id}: " . $e->getMessage());
                return false;
            }
        });
    }

    /**
     * Registra un servicio turístico asociado a un emprendimiento.
     */
    public function registrarServicioTuristico(array $datos)
    {
        // Lógica futura para servicios
    }
}