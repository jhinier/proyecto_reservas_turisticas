<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Servicio;
use App\Services\ImagenEmprendimientoService;

class AlimentacionService
{
    public function __construct(
        private ServicioBaseService $servicioBase,
        private ImagenEmprendimientoService $imagenService
    ) {}

    public function crear(int $pivotId, array $datosBase, array $datosDetalle, array $imagenes = [])
    {
        return DB::transaction(function () use ($pivotId, $datosBase, $datosDetalle, $imagenes) {
            
            $servicio = $this->servicioBase->crearServicioBase($pivotId, $datosBase);

            $servicio->detalleAlimentacion()->create([
                'tipo_alimentacion'  => $datosDetalle['tipo_alimentacion'],
                'lugar_alimentacion' => $datosDetalle['lugar_alimentacion'],
            ]);

            if (!empty($imagenes)) {
                $this->imagenService->subirImagenes($servicio->id, $imagenes);
            }

            return $servicio;
        });
    }

    public function actualizar(int $servicioId, array $datosBase, array $datosDetalle)
    {
        return DB::transaction(function () use ($servicioId, $datosBase, $datosDetalle) {
            $servicio = Servicio::with('detalleAlimentacion')->findOrFail($servicioId);
            
            $servicio->update($datosBase);
            
            if ($servicio->detalleAlimentacion) {
                $servicio->detalleAlimentacion->update($datosDetalle);
            }

            return $servicio;
        });
    }
}