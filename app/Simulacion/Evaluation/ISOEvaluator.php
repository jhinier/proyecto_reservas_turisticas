<?php

namespace App\Simulacion\Evaluation;

use App\Simulacion\Config\SimulacionConfig;
use App\Simulacion\Config\MetricThresholds;

class ISOEvaluator
{
    public static function evaluar(array $summary): array
    {
        $cpu = $summary['cpu'];
        $memory = $summary['memory'];
        $responseTimeMs = $cpu['avgOpDurationMs'];
        $opsPerMinute = $cpu['operationsPerSecond'] * 60;

        // Evaluaciones individuales
        $responseTimeEval = self::evaluateMetric('RESPONSE_TIME', $responseTimeMs / 1000);
        $cpuEval = self::evaluateMetric('CPU_USAGE', $cpu['avgCpuPercent']);
        $memoryEval = self::evaluateMetric('MEMORY_USAGE', $memory ? $memory['peakHeapUsedMB'] : 0);
        $capacityEval = self::evaluateMetric('CAPACITY', $opsPerMinute);

        // Puntaje ponderado
        $weighted = self::calculateWeightedScore($responseTimeEval['puntaje'], $cpuEval['puntaje'], $memoryEval['puntaje'], $capacityEval['puntaje']);
        $puntajeGeneral = $weighted['total'];

        // Hipótesis
        $hipotesis = self::evaluarHipotesis($puntajeGeneral);

        // Nivel cualitativo
        if ($puntajeGeneral >= SimulacionConfig::NIVEL_EXCELENTE) $nivel = 'Excelente';
        elseif ($puntajeGeneral >= SimulacionConfig::NIVEL_BUENO) $nivel = 'Bueno';
        elseif ($puntajeGeneral >= SimulacionConfig::NIVEL_REGULAR) $nivel = 'Regular';
        else $nivel = 'Malo';

        return [
            'nivel' => $nivel,
            'puntajeGeneral' => round($puntajeGeneral, 1),
            'puntajePonderado' => $weighted,
            'hipotesis' => $hipotesis,
            'responseTime' => $responseTimeEval,
            'cpu' => $cpuEval,
            'memory' => $memoryEval,
            'capacity' => $capacityEval,
        ];
    }

    private static function evaluateMetric(string $type, float $value): array
    {
        $thresholds = MetricThresholds::get($type);
        foreach ($thresholds as $level => $range) {
            if ($value >= $range['min'] && $value <= $range['max']) {
                return [
                    'puntaje' => $range['puntaje'],
                    'nivel' => $level,
                    'observacion' => "{$range['emoji']} {$range['descripcion']}: {$value} {$range['unit']}",
                    'metricas' => ['value' => $value]
                ];
            }
        }
        return ['puntaje' => 0, 'nivel' => 'Malo', 'observacion' => 'No evaluado', 'metricas' => []];
    }

    private static function calculateWeightedScore(float $respScore, float $cpuScore, float $memScore, float $capScore): array
    {
        $wTemporal = 0.35;
        $wCpu = 0.20;
        $wMem = 0.20;
        $wCap = 0.25;

        $total = ($respScore * $wTemporal) + ($cpuScore * $wCpu) + ($memScore * $wMem) + ($capScore * $wCap);

        return [
            'total' => $total,
            'details' => [
                'responseTime' => ['score' => $respScore, 'weight' => $wTemporal, 'contribution' => $respScore * $wTemporal],
                'cpu' => ['score' => $cpuScore, 'weight' => $wCpu, 'contribution' => $cpuScore * $wCpu],
                'memory' => ['score' => $memScore, 'weight' => $wMem, 'contribution' => $memScore * $wMem],
                'capacity' => ['score' => $capScore, 'weight' => $wCap, 'contribution' => $capScore * $wCap],
            ]
        ];
    }

    private static function evaluarHipotesis(float $puntaje): array
    {
        if ($puntaje >= SimulacionConfig::UMBRAL_HIPOTESIS_ALTERNA_SUPERIOR) {
            return [
                'hipotesis_aceptada' => 'Ha₁',
                'texto' => "Cumplimiento EXCELENTE ({$puntaje}%) ≥ " . SimulacionConfig::UMBRAL_HIPOTESIS_ALTERNA_SUPERIOR . "%",
                'cumple_hi' => true, 'cumple_ha_superior' => true, 'cumple_ha_inferior' => false
            ];
        }
        if ($puntaje <= SimulacionConfig::UMBRAL_HIPOTESIS_ALTERNA_INFERIOR) {
            return [
                'hipotesis_aceptada' => 'Ha₁',
                'texto' => "Cumplimiento DEFICIENTE ({$puntaje}%) ≤ " . SimulacionConfig::UMBRAL_HIPOTESIS_ALTERNA_INFERIOR . "%",
                'cumple_hi' => false, 'cumple_ha_superior' => false, 'cumple_ha_inferior' => true
            ];
        }
        if ($puntaje >= SimulacionConfig::UMBRAL_HIPOTESIS_INVESTIGACION) {
            return [
                'hipotesis_aceptada' => 'Hi₁',
                'texto' => "Cumplimiento BUENO ({$puntaje}%) ≥ " . SimulacionConfig::UMBRAL_HIPOTESIS_INVESTIGACION . "%",
                'cumple_hi' => true, 'cumple_ha_superior' => false, 'cumple_ha_inferior' => false
            ];
        }
        return [
            'hipotesis_aceptada' => 'H0₁',
            'texto' => "Cumplimiento INSUFICIENTE ({$puntaje}%) < " . SimulacionConfig::UMBRAL_HIPOTESIS_INVESTIGACION . "%",
            'cumple_hi' => false, 'cumple_ha_superior' => false, 'cumple_ha_inferior' => false
        ];
    }
}