<?php

namespace App\Presenters;

use App\Models\Servicio;
use Illuminate\Support\Facades\Storage;

class ServicioPresenter
{
    public function __construct(
        private Servicio $servicio
    ) {}

    public function precio(): string
    {
        return '$' . number_format((float) $this->servicio->precio, 2);
    }

    public function imagenUrl(): ?string
    {
        if (! $this->servicio->relationLoaded('imagenes')) {
            return null;
        }

        $img = $this->servicio->imagenes->first();

        // Si existe la imagen, la mostramos. Si no, devolvemos null.
        return $img ? Storage::url($img->imagen) : null;
    }

    /**
     * MODO SEGURO: Si no hay relación, devuelve null sin romper la UI.
     */
    public function tipoId(): ?int
    {
        if (! $this->servicio->relationLoaded('categoriaPivot')) {
            return null;
        }

        return $this->servicio->tipo_real_id;
    }

    /**
     * MAPEO LIMPIO: El Presenter decide qué componente dibujar.
     */
    public function iconoComponente(): string
    {
        return match ($this->tipoId()) {
            Servicio::TIPO_GUIANZA      => 'icon-map',
            Servicio::TIPO_ALIMENTACION => 'icon-food',
            Servicio::TIPO_HOSPEDAJE    => 'icon-bed',
            Servicio::TIPO_ALQUILER     => 'icon-tools',
            Servicio::TIPO_PAQUETE      => 'icon-package',
            default                     => 'icon-default',
        };
    }
}