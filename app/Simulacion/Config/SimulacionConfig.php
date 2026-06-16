<?php

namespace App\Simulacion\Config;

/**
 * Configuración centralizada del simulador ISO 25010 / ISO 25023
 * Adaptada a reservas de servicios turísticos.
 */
class SimulacionConfig
{
    // ==================== PARÁMETROS ISO ====================
    public const OBJETIVO_TIEMPO_PROMEDIO_MS = 4000;   // 4.0 segundos (Muy Bueno)
    public const OBJETIVO_P95_MS = 6000;               // 6.0 segundos (Bueno)
    public const OBJETIVO_P99_MS = 8000;               // 8.0 segundos (Aceptable)
    public const OBJETIVO_CAPACIDAD_POR_MINUTO = 25;   // 25 reservas/minuto (Bueno)
    public const OBJETIVO_PICO_HEAP_MB = 350;          // 350 MB (Bueno)
    public const OBJETIVO_TASA_EXITO_PCT = 95;

    // Umbrales de hipótesis (documento)
    public const UMBRAL_HIPOTESIS_INVESTIGACION = 75;   // Hi₁: ≥75%
    public const UMBRAL_HIPOTESIS_ALTERNA_SUPERIOR = 90;
    public const UMBRAL_HIPOTESIS_ALTERNA_INFERIOR = 50;

    // Niveles de cumplimiento
    public const NIVEL_EXCELENTE = 90;
    public const NIVEL_BUENO = 75;
    public const NIVEL_REGULAR = 50;

    // Límites de prueba
    public const CONCURRENCIA_MAX = 100;
    public const ITERACIONES_MAX = 1000;

    // Configuración ejecución
    public const DEFAULT_MODE = 'mixed';
    public const DEFAULT_CONCURRENCY = 3;
    public const DEFAULT_ITERATIONS = 10;
    public const BATCH_DELAY_MS = 100;
    public const BASE_RESERVA_DELAY_MS = 200;

    // ==================== PROBABILIDADES ====================
    public const PROB_ESTADO_CREACION = [
        'pendiente' => 30,
        'en_proceso' => 40,
        'confirmada' => 30
    ];

    public const PROB_TIPO_ACTUALIZACION = [
        'AUMENTAR_CANTIDAD' => 20,
        'INCREMENTAR_PERSONAS' => 20,
        'CAMBIAR_FECHAS' => 20,
        'AGREGAR_SERVICIO' => 20,
        'EDITAR_PENDIENTES' => 20
    ];

    public const PROB_MIXED_MODE = [
        'PORCENTAJE_CREACION' => 60,
        'RESERVAS_BASE_INICIALES' => 10
    ];

    /**
     * Obtiene la ruta donde se guardarán los reportes.
     */
    public static function getOutputDir(): string
    {
        $dir = storage_path('simulacion_reportes');
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        return $dir;
    }
}