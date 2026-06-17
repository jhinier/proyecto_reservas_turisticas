<?php

namespace App\Console\Commands;

use App\Simulacion\SimulacionManager;
use App\Simulacion\Config\SimulacionConfig;
use Illuminate\Console\Command;

class SimulacionRendimientoCommand extends Command
{
    protected $signature = 'simulacion:rendimiento
                            {--concurrency=3 : Nivel de concurrencia (máx 100)}
                            {--iterations=10 : Número de iteraciones (máx 1000)}
                            {--mode=mixed : Modo de prueba (create, update, mixed)}';

    protected $description = 'Ejecuta el simulador de rendimiento ISO 25023 para reservas turísticas';

    public function handle(): int
    {
        $concurrency = min((int) $this->option('concurrency'), SimulacionConfig::CONCURRENCIA_MAX);
        $iterations = min((int) $this->option('iterations'), SimulacionConfig::ITERACIONES_MAX);
        $mode = $this->option('mode');
        $verbose = $this->option('verbose'); // ✅ Laravel ya provee esta opción

        if (!in_array($mode, ['create', 'update', 'mixed'])) {
            $this->error('Modo no válido. Use create, update o mixed.');
            return 1;
        }

        $this->info("Iniciando simulación de rendimiento...");
        $this->line("Concurrencia: {$concurrency}");
        $this->line("Iteraciones: {$iterations}");
        $this->line("Modo: {$mode}");
        if ($verbose) {
            $this->line("Modo verbose: activado");
        }

        $config = [
            'concurrency' => $concurrency,
            'iterations' => $iterations,
            'mode' => $mode,
            'verbose' => $verbose,
        ];

        try {
            SimulacionManager::ejecutar($config);
            $this->info("\n✅ Simulación completada. Reporte generado en storage/simulacion_reportes/");
            return 0;
        } catch (\Throwable $e) {
            $this->error("Error durante la simulación: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }
}