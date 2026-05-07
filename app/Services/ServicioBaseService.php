<?php
namespace App\Services;

use App\Models\Servicio;

class ServicioBaseService
{
    /**
     * Crea el registro principal en la tabla 'servicios'.
     */
    public function crearServicioBase(int $pivotId, array $datosBase): Servicio
    {
        return Servicio::create([
            'emprendimiento_tipo_servicio_id' => $pivotId,
            'nombre'      => $datosBase['nombre'],
            'descripcion' => $datosBase['descripcion'],
            'precio'      => $datosBase['precio'],
            'stock'       => $datosBase['stock'],
        ]);
    }

    // app/Services/ServicioBaseService.php

    public function eliminar(int $id): bool
    {
        $servicio = \App\Models\Servicio::findOrFail($id);
        
        // Aquí podrías agregar lógica para borrar imágenes del Storage si quisieras
        return $servicio->delete(); // SoftDelete
    }
}