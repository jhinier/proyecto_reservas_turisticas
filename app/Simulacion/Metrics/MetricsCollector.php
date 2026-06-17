<?php

namespace App\Simulacion\Metrics;

/**
 * Colector de métricas ISO 25023 para reservas turísticas.
 * PTb-1-G, PRu-1-G, PRu-2-G, PCa-1-G.
 */
class MetricsCollector
{
    private array $operations = [];
    private ?float $startTime = null;
    private ?float $endTime = null;
    private array $memorySnapshots = [];
    private array $cpuSnapshots = [];

    public function start(): void
    {
        $this->startTime = microtime(true) * 1000; // ms
        $this->takeMemorySnapshot('start');
        $this->takeCpuSnapshot('start');
    }

    public function end(): void
    {
        $this->endTime = microtime(true) * 1000;
        $this->takeMemorySnapshot('end');
        $this->takeCpuSnapshot('end');
    }

    public function recordOperation(array $operation): void
    {
        $cpuRatio = null;
        if (isset($operation['cpuTimeMs']) && isset($operation['duration']) && $operation['duration'] > 0) {
            $cpuRatio = $operation['cpuTimeMs'] / $operation['duration'];
        }
        $this->operations[] = array_merge($operation, ['cpuRatio' => $cpuRatio]);
    }

    private function takeMemorySnapshot(string $label): void
    {
        $mem = memory_get_usage(true);
        $peak = memory_get_peak_usage(true);
        $this->memorySnapshots[] = [
            'label' => $label,
            'timestamp' => microtime(true) * 1000,
            'memory_usage' => $mem,
            'peak_usage' => $peak,
        ];
    }

    private function takeCpuSnapshot(string $label): void
    {
        $cpu = getrusage();
        $this->cpuSnapshots[] = [
            'label' => $label,
            'timestamp' => microtime(true) * 1000,
            'user_time' => $cpu['ru_utime.tv_sec'] * 1e6 + $cpu['ru_utime.tv_usec'],
            'system_time' => $cpu['ru_stime.tv_sec'] * 1e6 + $cpu['ru_stime.tv_usec'],
            'total' => ($cpu['ru_utime.tv_sec'] + $cpu['ru_stime.tv_sec']) * 1e6 +
                       ($cpu['ru_utime.tv_usec'] + $cpu['ru_stime.tv_usec']),
        ];
    }

    public function getCPUStats(): array
    {
        $totalDuration = ($this->endTime ?? microtime(true)*1000) - ($this->startTime ?? microtime(true)*1000);
        $opDurations = array_filter(array_column($this->operations, 'duration'), fn($d) => $d > 0);
        $sumDurations = array_sum($opDurations);
        $avgDuration = count($opDurations) ? $sumDurations / count($opDurations) : 0;

        $totalOps = count($this->operations);
        $opsPerSecond = $totalDuration > 0 ? ($totalOps / $totalDuration) * 1000 : 0;

        $cpuRatios = array_filter(array_column($this->operations, 'cpuRatio'), fn($r) => $r !== null);
        $avgCpuRatio = count($cpuRatios) ? array_sum($cpuRatios) / count($cpuRatios) : 0;

        $successful = count(array_filter($this->operations, fn($op) => $op['success'] ?? false));

        return [
            'avgOpDurationMs' => $avgDuration,
            'p95OpDurationMs' => $this->calculatePercentile($opDurations, 95),
            'p99OpDurationMs' => $this->calculatePercentile($opDurations, 99),
            'totalDurationMs' => $totalDuration,
            'totalOperations' => $totalOps,
            'operationsPerSecond' => $opsPerSecond,
            'avgCpuRatio' => $avgCpuRatio,
            'avgCpuPercent' => $avgCpuRatio * 100,
            'minOpDurationMs' => $opDurations ? min($opDurations) : 0,
            'maxOpDurationMs' => $opDurations ? max($opDurations) : 0,
            'successfulOperations' => $successful,
            'failedOperations' => $totalOps - $successful,
            'successRate' => $totalOps ? ($successful / $totalOps) * 100 : 0,
        ];
    }

    private function calculatePercentile(array $values, float $percentile): float
    {
        if (empty($values)) return 0;
        sort($values);
        $index = ceil(($percentile / 100) * count($values)) - 1;
        return $values[max(0, min($index, count($values)-1))];
    }

    public function getMemoryStats(): ?array
    {
        $start = collect($this->memorySnapshots)->firstWhere('label', 'start');
        $end = collect($this->memorySnapshots)->firstWhere('label', 'end');
        if (!$start || !$end) return null;

        $initial = $start['memory_usage'];
        $final = $end['memory_usage'];
        $peak = max(array_column($this->memorySnapshots, 'memory_usage'));
        $growth = $final - $initial;
        $growthPercent = $initial ? ($growth / $initial) * 100 : 0;

        return [
            'initialHeapUsed' => $initial,
            'finalHeapUsed' => $final,
            'peakHeapUsed' => $peak,
            'peakHeapUsedMB' => $peak / 1024 / 1024,
            'heapGrowth' => $growth,
            'heapGrowthPercent' => $growthPercent,
        ];
    }

    public function getSummary(): array
    {
        $cpu = $this->getCPUStats();
        $memory = $this->getMemoryStats();
        $opsPerMinute = $cpu['operationsPerSecond'] * 60;

        return [
            'cpu' => $cpu,
            'memory' => $memory,
            'capacity' => [
                'opsPerSecond' => $cpu['operationsPerSecond'],
                'opsPerMinute' => $opsPerMinute,
            ]
        ];
    }
}