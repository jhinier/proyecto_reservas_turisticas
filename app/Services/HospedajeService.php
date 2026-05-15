<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Servicio;
use App\Services\ImagenEmprendimientoService;

class HospedajeService
{
    public function __construct(
        private ServicioBaseService $servicioBase,
        private ImagenEmprendimientoService $imagenService
    ) {}

    public function crear(int $pivotId, array $datosBase, array $datosDetalle, array $imagenes = [])
    {
        return DB::transaction(function () use ($pivotId, $datosBase, $datosDetalle, $imagenes) {
            
            // 1. Creamos la base
            $servicio = $this->servicioBase->crearServicioBase($pivotId, $datosBase);

            // 2. Creamos el detalle específico
            $servicio->detalleHospedaje()->create([
                'capacidad' => $datosDetalle['capacidad'],
            ]);

            // 3. Subimos imágenes si existen
            if (!empty($imagenes)) {
                $this->imagenService->subirImagenes($servicio->id, $imagenes);
            }

            return $servicio;
        });
    }

    public function actualizar(int $servicioId, array $datosBase, array $datosDetalle)
    {
        return DB::transaction(function () use ($servicioId, $datosBase, $datosDetalle) {
            // Cargamos la relación para que el modelo sepa quién es
            $servicio = Servicio::with('detalleHospedaje')->findOrFail($servicioId);
            
            $servicio->update($datosBase);
            $servicio->detalleHospedaje->update($datosDetalle);
    
            return $servicio;
        });
    }
}