<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Servicio;
use Illuminate\Http\UploadedFile;
use App\Services\ImagenEmprendimientoService;

class PaqueteTuristicoService
{
    public function __construct(
        private ServicioBaseService $servicioBase,
        private ImagenEmprendimientoService $imagenService
    ) {}

    public function crear(int $pivotId, array $datosBase, array $datosDetalle, array $imagenes = [], ?UploadedFile $documento = null)
    {
        return DB::transaction(function () use ($pivotId, $datosBase, $datosDetalle, $imagenes, $documento) {
            
            $servicio = $this->servicioBase->crearServicioBase($pivotId, $datosBase);

            // Manejo del documento adjunto
            $rutaDocumento = '';
            if ($documento && $documento->isValid()) {
                $rutaDocumento = $documento->store('paquetes_documentos', 'public');
            }

            $servicio->detallePaqueteTuristico()->create([
                'lugar_salida'        => $datosDetalle['lugar_salida'] ?? '',
                'hora_salida'         => $datosDetalle['hora_salida'] ?? '08:00',
                'servicios_incluidos' => $datosDetalle['servicios_incluidos'] ?? '',
                'lugares_actividades' => $datosDetalle['lugares_actividades'] ?? '',
                'recomendaciones'     => $datosDetalle['recomendaciones'] ?? '',
                'documento'           => $rutaDocumento, 
                'duracion_dias'       => $datosDetalle['duracion_dias'] ?? 1,
                'mensaje_pago'        => $datosDetalle['mensaje_pago'] ?? null,
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
        // Usa el nombre largo aquí también
        $servicio = Servicio::with('detallePaqueteTuristico')->findOrFail($servicioId);
        
        $servicio->update($datosBase);
        
        if ($servicio->detallePaqueteTuristico) {
            $servicio->detallePaqueteTuristico->update($datosDetalle);
        }

        return $servicio;
    });
}
}