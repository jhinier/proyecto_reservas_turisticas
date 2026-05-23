<?php

namespace App\Services;

use App\Models\Servicio;
use Illuminate\Pagination\LengthAwarePaginator;

class BuscadorTuristicoService
{
    public function buscarServicios(string $termino, ?int $tipoServicioId): LengthAwarePaginator
    {
        $query = Servicio::with([
            'emprendimientoTipoServicio.emprendimiento',
            'emprendimientoTipoServicio.tipoServicio',
            'imagenes'
        ])->whereNull('deleted_at');

        if ($tipoServicioId) {
            $query->whereHas('emprendimientoTipoServicio', function ($q) use ($tipoServicioId) {
                $q->where('tipo_servicio_id', $tipoServicioId)
                  ->where('estado', 1);
            });
        }

        if ($termino) {
            $tipoMapeado = $this->mapearTermino($termino);

            $query->where(function ($q) use ($termino, $tipoMapeado) {
                $q->where('nombre', 'like', "%{$termino}%")
                  ->orWhere('descripcion', 'like', "%{$termino}%")
                  ->orWhereHas('emprendimientoTipoServicio.emprendimiento', function ($qEmp) use ($termino) {
                      $qEmp->where('nombre', 'like', "%{$termino}%")
                           ->where('estado', 1);
                  });

                if ($tipoMapeado) {
                    $q->orWhereHas('emprendimientoTipoServicio.tipoServicio', function ($qTipo) use ($tipoMapeado) {
                        $qTipo->where('nombre', $tipoMapeado);
                    });
                }
            });
        }

        return $query->paginate(10);
    }

    private function mapearTermino(string $termino): ?string
    {
        $diccionario = [
            'comer' => 'Alimentación',
            'comida' => 'Alimentación',
            'dormir' => 'Hospedaje',
            'cama' => 'Hospedaje',
            'guia' => 'Guianza',
            'paseo' => 'Guianza',
            'carro' => 'Alquiler de Equipos',
            'bici' => 'Alquiler de Equipos',
            'equipo' => 'Alquiler de Equipos',
            'tour' => 'Paquetes Turísticos',
            'paquete' => 'Paquetes Turísticos',
        ];

        $terminoMinuscula = strtolower(trim($termino));

        return $diccionario[$terminoMinuscula] ?? null;
    }
}