<?php

namespace App\Simulacion\Config;

class MetricThresholds
{
    public static function get(string $metric): array
    {
        return match ($metric) {
            'RESPONSE_TIME' => [
                'Excelente' => ['min' => 0, 'max' => 2.0, 'puntaje' => 100, 'emoji' => '✅', 'descripcion' => 'Excelente', 'unit' => 's'],
                'Muy Bueno' => ['min' => 2.1, 'max' => 4.0, 'puntaje' => 90, 'emoji' => '✅', 'descripcion' => 'Muy Bueno', 'unit' => 's'],
                'Bueno'     => ['min' => 4.1, 'max' => 6.0, 'puntaje' => 75, 'emoji' => '✅', 'descripcion' => 'Bueno', 'unit' => 's'],
                'Aceptable' => ['min' => 6.1, 'max' => 8.0, 'puntaje' => 50, 'emoji' => '⚠️', 'descripcion' => 'Aceptable', 'unit' => 's'],
                'Regular'   => ['min' => 8.1, 'max' => 10.0, 'puntaje' => 20, 'emoji' => '⚠️', 'descripcion' => 'Regular', 'unit' => 's'],
                'Malo'      => ['min' => 10.1, 'max' => INF, 'puntaje' => 0, 'emoji' => '❌', 'descripcion' => 'Malo', 'unit' => 's'],
            ],
            'CPU_USAGE' => [
                'Excelente' => ['min' => 0, 'max' => 0.5, 'puntaje' => 100, 'emoji' => '✅', 'descripcion' => 'Excelente', 'unit' => '%'],
                'Muy Bueno' => ['min' => 0.6, 'max' => 1.5, 'puntaje' => 90, 'emoji' => '✅', 'descripcion' => 'Muy Bueno', 'unit' => '%'],
                'Bueno'     => ['min' => 1.6, 'max' => 2.5, 'puntaje' => 75, 'emoji' => '✅', 'descripcion' => 'Bueno', 'unit' => '%'],
                'Aceptable' => ['min' => 2.6, 'max' => 3.5, 'puntaje' => 50, 'emoji' => '⚠️', 'descripcion' => 'Aceptable', 'unit' => '%'],
                'Regular'   => ['min' => 3.6, 'max' => 4.5, 'puntaje' => 20, 'emoji' => '⚠️', 'descripcion' => 'Regular', 'unit' => '%'],
                'Malo'      => ['min' => 4.6, 'max' => INF, 'puntaje' => 0, 'emoji' => '❌', 'descripcion' => 'Malo', 'unit' => '%'],
            ],
            'MEMORY_USAGE' => [
                'Excelente' => ['min' => 0, 'max' => 150, 'puntaje' => 100, 'emoji' => '✅', 'descripcion' => 'Excelente', 'unit' => 'MB'],
                'Muy Bueno' => ['min' => 151, 'max' => 250, 'puntaje' => 90, 'emoji' => '✅', 'descripcion' => 'Muy Bueno', 'unit' => 'MB'],
                'Bueno'     => ['min' => 251, 'max' => 350, 'puntaje' => 75, 'emoji' => '✅', 'descripcion' => 'Bueno', 'unit' => 'MB'],
                'Aceptable' => ['min' => 351, 'max' => 450, 'puntaje' => 50, 'emoji' => '⚠️', 'descripcion' => 'Aceptable', 'unit' => 'MB'],
                'Regular'   => ['min' => 451, 'max' => 550, 'puntaje' => 20, 'emoji' => '⚠️', 'descripcion' => 'Regular', 'unit' => 'MB'],
                'Malo'      => ['min' => 551, 'max' => INF, 'puntaje' => 0, 'emoji' => '❌', 'descripcion' => 'Malo', 'unit' => 'MB'],
            ],
            'CAPACITY' => [
                'Excelente' => ['min' => 35, 'max' => INF, 'puntaje' => 100, 'emoji' => '✅', 'descripcion' => 'Excelente', 'unit' => 'res/min'],
                'Muy Bueno' => ['min' => 30, 'max' => 34, 'puntaje' => 90, 'emoji' => '✅', 'descripcion' => 'Muy Bueno', 'unit' => 'res/min'],
                'Bueno'     => ['min' => 25, 'max' => 29, 'puntaje' => 75, 'emoji' => '✅', 'descripcion' => 'Bueno', 'unit' => 'res/min'],
                'Aceptable' => ['min' => 20, 'max' => 24, 'puntaje' => 50, 'emoji' => '⚠️', 'descripcion' => 'Aceptable', 'unit' => 'res/min'],
                'Regular'   => ['min' => 15, 'max' => 19, 'puntaje' => 20, 'emoji' => '⚠️', 'descripcion' => 'Regular', 'unit' => 'res/min'],
                'Malo'      => ['min' => 0, 'max' => 14, 'puntaje' => 0, 'emoji' => '❌', 'descripcion' => 'Malo', 'unit' => 'res/min'],
            ],
            default => [],
        };
    }
}