<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Servicio;
use App\Services\ImagenEmprendimientoService;

class GuianzaService
{
    public function __construct(
        private ServicioBaseService $servicioBase,
        private ImagenEmprendimientoService $imagenService
    ) {}

    public function crear(int $pivotId, array $datosBase, array $datosDetalle, array $imagenes = [])
    {
        return DB::transaction(function () use ($pivotId, $datosBase, $datosDetalle, $imagenes) {
            
            $servicio = $this->servicioBase->crearServicioBase($pivotId, $datosBase);

            $servicio->detalleGuianza()->create([
                'numero_max_persona' => $datosDetalle['numero_max_persona'],
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
            $servicio = Servicio::with('detalleGuianza')->findOrFail($servicioId);
            $servicio->update($datosBase);
            $servicio->detalleGuianza()->update($datosDetalle);
            return $servicio;
        });
    }
}