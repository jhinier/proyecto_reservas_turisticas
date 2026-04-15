<?php

namespace App\Services;

use App\Models\Emprendimiento;
use App\Models\Servicio;
use App\Models\DetalleHospedaje;
use Illuminate\Support\Facades\DB;

/**
 * Servicio de Dominio para la entidad Servicio (Habitaciones, Platos, etc.).
 * Maneja consultas optimizadas y transacciones atómicas de guardado.
 */
class ServicioService
{
    /**
     * Recupera las categorías activas (Pivot) optimizadas con Eager Loading.
     */
    public function obtenerCategoriasActivas(Emprendimiento $emprendimiento)
    {
        return $emprendimiento->tiposServicios()
            ->wherePivot('estado', true)
            ->withPivot('id')
            ->get();
    }

    /**
     * Recupera los ítems físicos filtrados por la llave foránea de la categoría.
     */
    public function obtenerServiciosPorCategoria(int $pivotId)
    {
        return Servicio::where('emprendimiento_tipo_servicio_id', $pivotId)
            ->latest()
            ->get();
    }

    /**
     * Crea un servicio de tipo Hospedaje usando una Transacción Atómica.
     * Garantiza que el Padre (Servicio), Hijo (Detalle) e Imágenes se guarden juntos.
     *
     * @param int $pivotId ID de la categoría activa (emprendimiento_tipo_servicio_id)
     * @param array $datosBase Datos genéricos (nombre, precio, stock, etc.)
     * @param array $datosDetalle Datos específicos (capacidad)
     * @param array $imagenes Array de archivos subidos (UploadedFile)
     * @return \App\Models\Servicio
     * @throws \Exception Si falla la inserción SQL
     */
    public function crearHospedaje(int $pivotId, array $datosBase, array $datosDetalle, array $imagenes = [])
    {
        return DB::transaction(function () use ($pivotId, $datosBase, $datosDetalle, $imagenes) {
            
            // 1. Guardar el Registro Padre (Tabla: servicios)
            $servicio = Servicio::create([
                'emprendimiento_tipo_servicio_id' => $pivotId,
                'nombre'      => $datosBase['nombre'],
                'descripcion' => $datosBase['descripcion'],
                'precio'      => $datosBase['precio'],
                'stock'       => $datosBase['stock'],
            ]);

            // 2. Guardar el Registro Hijo (Tabla: detalle_hospedajes) usando el ID del Padre
            DetalleHospedaje::create([
                'servicio_id' => $servicio->id, // Conexión de Herencia
                'capacidad'   => $datosDetalle['capacidad'],
            ]);

            // 🔥 3. Guardar Imágenes (Física y Base de Datos)
            if (!empty($imagenes)) {
                foreach ($imagenes as $imagen) {
                    // Laravel guarda en storage/app/public/servicios y genera un hash seguro
                    $rutaImagen = $imagen->store('servicios', 'public');
                    
                    // Guarda la ruta en la tabla imagen_servicios atada al servicio actual
                    $servicio->imagenes()->create([
                        'imagen' => $rutaImagen
                    ]);
                }
            }

            return $servicio;
        });
    }
}