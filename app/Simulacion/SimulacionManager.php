<?php

namespace App\Simulacion;

use App\Simulacion\Config\SimulacionConfig;
use App\Simulacion\Core\ReservaSimulator;
use App\Simulacion\Evaluation\ISOEvaluator;
use App\Simulacion\Logging\Logger;
use App\Simulacion\Reports\ReportGenerator;

class SimulacionManager
{
    public static function ejecutar(array $config): void
    {
        $logger = new Logger($config['verbose'] ?? false);

        $logger->section('🚀 SIMULADOR DE RENDIMIENTO - ISO 25010 / ISO 25023');
        $logger->log('Basado en documento de operacionalización - Reservas Turísticas');

        $simulator = new ReservaSimulator($config, $logger);
        $simulator->run();

        $summary = $simulator->getMetricsSummary();
        $evaluacion = ISOEvaluator::evaluar($summary);

        $reportGen = new ReportGenerator();
        $reportGen->generateReport($summary, $evaluacion, $config, $logger);

        // Mostrar resultados en consola
        self::imprimirResultados($summary, $evaluacion, $logger);
    }

    private static function imprimirResultados(array $summary, array $evaluacion, Logger $logger): void
    {
        $logger->section('📊 RESULTADOS DE RENDIMIENTO');
        $logger->log("Tiempo promedio: " . round($summary['cpu']['avgOpDurationMs'] / 1000, 2) . " s");
        $logger->log("Capacidad: " . round($summary['cpu']['operationsPerSecond'] * 60, 1) . " reservas/minuto");
        $logger->log("Tasa de éxito: " . round($summary['cpu']['successRate'], 1) . "%");
        $logger->log("Puntaje ponderado ISO: " . $evaluacion['puntajeGeneral'] . "/100");
        $logger->log("Nivel: " . strtoupper($evaluacion['nivel']));
        $logger->log("Hipótesis aceptada: " . $evaluacion['hipotesis']['hipotesis_aceptada']);
        $logger->log("Conclusión: " . $evaluacion['hipotesis']['texto']);
    }
}