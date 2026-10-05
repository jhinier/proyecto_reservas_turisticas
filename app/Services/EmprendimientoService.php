<?php

namespace App\Services;

use App\Models\Emprendimiento;
use App\Models\User; 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;
use Exception;

class EmprendimientoService
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function obtenerUsuariosEmprendedores()
    {
        return User::role('emprendimiento')->get();
    }

    public function listarPaginados(int $porPagina = 10, ?string $busqueda = null, ?string $tipoServicio = null)
    {
        $query = Emprendimiento::with('user');

        // Filtro por nombre de emprendimiento o cédula del responsable
        if ($busqueda && trim($busqueda) !== '') {
            $searchTerm = trim($busqueda);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nombre', 'like', "%{$searchTerm}%")
                  ->orWhereHas('user', function ($u) use ($searchTerm) {
                      $u->where('cedula', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Filtro por tipo de servicio
        if ($tipoServicio && trim($tipoServicio) !== '' && $tipoServicio !== 'Todos') {
            $query->whereHas('tiposServicios', function ($q) use ($tipoServicio) {
                $q->where('nombre', $tipoServicio);
            });
        }

        return $query->latest()->paginate($porPagina);
    }

    public function buscarConRelaciones(int $id)
    {
        return Emprendimiento::with('user')->findOrFail($id);
    }

    // ACTUALIZADO: Recibe la imagen, enlaces y los procesa
    public function registrarNuevoEmprendimiento(array $datosUsuario, array $datosEmpresa, $imagen = null)
    {
        try {
            return DB::transaction(function () use ($datosUsuario, $datosEmpresa, $imagen) {
                
                $datosUsuario['role'] = 'emprendimiento';
                $user = $this->userService->crearUsuario($datosUsuario);

                $rutaImagen = null;
                if ($imagen) {
                    // Guarda en storage/app/public/emprendimientos
                    $rutaImagen = $imagen->store('emprendimientos', 'public');
                }

                return Emprendimiento::create([
                    'user_id'     => $user->id,
                    'nombre'      => $datosEmpresa['nombre_emprendimiento'], 
                    'descripcion' => $datosEmpresa['descripcion'],
                    'imagen'      => $rutaImagen,
                    'estado'      => $datosEmpresa['estado'] ?? 1,
                    'enlaces'     => $datosEmpresa['enlaces'] ?? null, // Nuevo campo agregado
                ]);
            });
        } catch (Exception $e) {
            Log::error('Fallo al registrar emprendimiento: ' . $e->getMessage());
            throw $e; 
        }
    }

    public function actualizarTodo(int $emprendimientoId, array $datosEmpresa, array $datosUsuario, $nuevaImagen = null)
    {
        return DB::transaction(function () use ($emprendimientoId, $datosEmpresa, $datosUsuario, $nuevaImagen) {
            
            $emprendimiento = Emprendimiento::findOrFail($emprendimientoId);
            
            if ($nuevaImagen) {
                if ($emprendimiento->imagen) {
                    Storage::disk('public')->delete($emprendimiento->imagen);
                }
                $datosEmpresa['imagen'] = $nuevaImagen->store('emprendimientos', 'public');
            }

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

                $emp->delete(); 

                if ($usuario) {
                    $usuario->delete(); 
                }

                return true;
            } catch (Exception $e) {
                Log::error("Error al eliminar registro #{$id}: " . $e->getMessage());
                return false;
            }
        });
    }
}