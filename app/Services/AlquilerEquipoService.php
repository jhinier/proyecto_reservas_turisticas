<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Servicio;
use App\Services\ImagenEmprendimientoService;

class AlquilerEquipoService
{
    public function __construct(
        private ServicioBaseService $servicioBase,
        private ImagenEmprendimientoService $imagenService
    ) {}

    /**
     * Crea un servicio de Alquiler de Equipo.
     * Nota: No recibe $datosDetalle porque este dominio solo ocupa la tabla padre.
     */
    public function crear(int $pivotId, array $datosBase, array $imagenes = [])
    {
        return DB::transaction(function () use ($pivotId, $datosBase, $imagenes) {
            
            // 1. Creamos la base (que en este caso es toda la información que necesitamos)
            $servicio = $this->servicioBase->crearServicioBase($pivotId, $datosBase);

            // 2. Subimos imágenes si existen
            if (!empty($imagenes)) {
                $this->imagenService->subirImagenes($servicio->id, $imagenes);
            }

            return $servicio;
        });
    }

    public function actualizar(int $id, array $datos)
    {
        return DB::transaction(function () use ($id, $datos) {
            $servicio = Servicio::findOrFail($id);
            $servicio->update($datos);
            return $servicio;
        });
    }
}