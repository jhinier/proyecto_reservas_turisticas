<?php

namespace App\Services;

use App\Models\ImagenServicio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImagenEmprendimientoService
{
    /**
     * Sube múltiples imágenes. (Ya lo tienes, está perfecto)
     */
    public function subirImagenes(int $servicioId, array $imagenes): void
    {
        foreach ($imagenes as $imagen) {
            if ($imagen instanceof UploadedFile && $imagen->isValid()) {
                $ruta = $imagen->store('servicios', 'public');
                ImagenServicio::create([
                    'servicio_id' => $servicioId,
                    'imagen' => $ruta,
                ]);
            }
        }
    }

    /**
     * 🔥 NUEVO MÉTODO: Para eliminar usando solo el ID.
     */
    public function eliminarPorId(int $id): void
    {
        $imagen = ImagenServicio::findOrFail($id);
        $this->eliminarImagen($imagen);
    }

    /**
     * Elimina el archivo y el registro. (Ya lo tienes)
     */
    public function eliminarImagen(ImagenServicio $imagen): void
    {
        if (Storage::disk('public')->exists($imagen->imagen)) {
            Storage::disk('public')->delete($imagen->imagen);
        }
        $imagen->delete();
    }
}