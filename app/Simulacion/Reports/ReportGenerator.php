<?php

namespace App\Simulacion\Reports;

use App\Simulacion\Config\SimulacionConfig;
use App\Simulacion\Logging\Logger;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ReportGenerator
{
    private string $outputDir;

    public function __construct(?string $outputDir = null)
    {
        $this->outputDir = $outputDir ?? SimulacionConfig::getOutputDir();
    }

    public function generateReport(array $summary, array $evaluacion, array $config, Logger $logger): string
    {
        if (!is_dir($this->outputDir)) {
            mkdir($this->outputDir, 0755, true);
        }

        $filename = 'reporte_rendimiento_' . date('Y-m-d_H-i-s') . "_concurrency_{$config['concurrency']}_iter_{$config['iterations']}.xlsx";
        $filepath = $this->outputDir . DIRECTORY_SEPARATOR . $filename;

        $spreadsheet = new Spreadsheet();
        $spreadsheet->removeSheetByIndex(0);

        // Hoja Resumen
        $sheetResumen = $spreadsheet->createSheet();
        $sheetResumen->setTitle('Resumen General');
        $this->buildSummarySheet($sheetResumen, $summary, $evaluacion, $config);

        // Hoja Métricas
        $sheetMetrics = $spreadsheet->createSheet();
        $sheetMetrics->setTitle('Métricas');
        $this->buildMetricsSheet($sheetMetrics, $summary, $evaluacion);

        // Hoja Evaluación ISO
        $sheetISO = $spreadsheet->createSheet();
        $sheetISO->setTitle('Evaluación ISO');
        $this->buildEvaluationSheet($sheetISO, $evaluacion);

        // Hoja Configuración
        $sheetConfig = $spreadsheet->createSheet();
        $sheetConfig->setTitle('Configuración');
        $this->buildConfigSheet($sheetConfig, $config);

        $writer = new Xlsx($spreadsheet);
        $writer->save($filepath);

        $logger->success("Reporte Excel generado: {$filepath}");
        return $filepath;
    }

    private function buildSummarySheet($sheet, array $summary, array $evaluacion, array $config): void
    {
        $sheet->setCellValue('A1', 'INFORMACIÓN GENERAL');
        $sheet->setCellValue('A2', 'Fecha/Hora');
        $sheet->setCellValue('B2', now()->format('Y-m-d H:i:s'));
        $sheet->setCellValue('A3', 'Modo de prueba');
        $sheet->setCellValue('B3', $config['mode']);
        $sheet->setCellValue('A4', 'Concurrencia');
        $sheet->setCellValue('B4', $config['concurrency']);
        $sheet->setCellValue('A5', 'Iteraciones');
        $sheet->setCellValue('B5', $config['iterations']);

        $row = 7;
        $cpu = $summary['cpu'];
        $sheet->setCellValue("A{$row}", 'MÉTRICAS DE RENDIMIENTO');
        $row++;
        $sheet->setCellValue("A{$row}", 'Duración total (ms)');
        $sheet->setCellValue("B{$row}", round($cpu['totalDurationMs'], 0));
        $row++;
        $sheet->setCellValue("A{$row}", 'Duración total (s)');
        $sheet->setCellValue("B{$row}", round($cpu['totalDurationMs'] / 1000, 1));
        $row++;
        $sheet->setCellValue("A{$row}", 'Operaciones/segundo');
        $sheet->setCellValue("B{$row}", round($cpu['operationsPerSecond'], 2));
        $row++;
        $sheet->setCellValue("A{$row}", 'Capacidad (reservas/minuto)');
        $sheet->setCellValue("B{$row}", round($cpu['operationsPerSecond'] * 60, 1));
        $row++;
        $sheet->setCellValue("A{$row}", 'Tiempo promedio (ms)');
        $sheet->setCellValue("B{$row}", round($cpu['avgOpDurationMs'], 0));
        $row++;
        $sheet->setCellValue("A{$row}", 'Percentil 95 (ms)');
        $sheet->setCellValue("B{$row}", round($cpu['p95OpDurationMs'], 0));
        $row++;
        $sheet->setCellValue("A{$row}", 'Tasa de éxito (%)');
        $sheet->setCellValue("B{$row}", round($cpu['successRate'], 1));
        $row+=2;
        $sheet->setCellValue("A{$row}", 'EVALUACIÓN FINAL');
        $row++;
        $sheet->setCellValue("A{$row}", 'Puntaje obtenido');
        $sheet->setCellValue("B{$row}", $evaluacion['puntajeGeneral'] . '/100');
        $row++;
        $sheet->setCellValue("A{$row}", 'Nivel de cumplimiento');
        $sheet->setCellValue("B{$row}", strtoupper($evaluacion['nivel']));
        $row++;
        $sheet->setCellValue("A{$row}", 'Hipótesis aceptada');
        $sheet->setCellValue("B{$row}", $evaluacion['hipotesis']['hipotesis_aceptada']);
        $row++;
        $sheet->setCellValue("A{$row}", 'Conclusión');
        $sheet->setCellValue("B{$row}", $evaluacion['hipotesis']['texto']);

        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(40);
        $sheet->getStyle('A1:A' . $row)->getFont()->setBold(true);
    }

    private function buildMetricsSheet($sheet, array $summary, array $evaluacion): void
    {
        $sheet->setCellValue('A1', 'Subcaracterística');
        $sheet->setCellValue('B1', 'Métrica');
        $sheet->setCellValue('C1', 'Valor');
        $sheet->setCellValue('D1', 'Puntaje');
        $sheet->setCellValue('E1', 'Nivel');

        $data = [
            ['Comportamiento Temporal', 'Tiempo de respuesta promedio', round($summary['cpu']['avgOpDurationMs'] / 1000, 2) . ' s', $evaluacion['responseTime']['puntaje'], $evaluacion['responseTime']['nivel']],
            ['Utilización de Recursos', 'CPU (estimado)', round($summary['cpu']['avgCpuPercent'], 2) . '%', $evaluacion['cpu']['puntaje'], $evaluacion['cpu']['nivel']],
            ['Utilización de Recursos', 'Memoria (pico)', round(($summary['memory']['peakHeapUsedMB'] ?? 0), 1) . ' MB', $evaluacion['memory']['puntaje'], $evaluacion['memory']['nivel']],
            ['Capacidad', 'Reservas por minuto', round($summary['cpu']['operationsPerSecond'] * 60, 1) . ' res/min', $evaluacion['capacity']['puntaje'], $evaluacion['capacity']['nivel']],
        ];

        $row = 2;
        foreach ($data as $rowData) {
            $sheet->setCellValue("A{$row}", $rowData[0]);
            $sheet->setCellValue("B{$row}", $rowData[1]);
            $sheet->setCellValue("C{$row}", $rowData[2]);
            $sheet->setCellValue("D{$row}", $rowData[3]);
            $sheet->setCellValue("E{$row}", $rowData[4]);
            $row++;
        }
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);
        foreach (range('A', 'E') as $col) $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    private function buildEvaluationSheet($sheet, array $evaluacion): void
    {
        $sheet->setCellValue('A1', 'Concepto');
        $sheet->setCellValue('B1', 'Valor');
        $sheet->setCellValue('C1', 'Contribución');

        $weighted = $evaluacion['puntajePonderado'];
        $row = 2;
        $sheet->setCellValue("A{$row}", 'Comportamiento temporal (35%)');
        $sheet->setCellValue("B{$row}", $weighted['details']['responseTime']['score']);
        $sheet->setCellValue("C{$row}", round($weighted['details']['responseTime']['contribution'], 1));
        $row++;
        $sheet->setCellValue("A{$row}", 'Utilización CPU (20%)');
        $sheet->setCellValue("B{$row}", $weighted['details']['cpu']['score']);
        $sheet->setCellValue("C{$row}", round($weighted['details']['cpu']['contribution'], 1));
        $row++;
        $sheet->setCellValue("A{$row}", 'Utilización Memoria (20%)');
        $sheet->setCellValue("B{$row}", $weighted['details']['memory']['score']);
        $sheet->setCellValue("C{$row}", round($weighted['details']['memory']['contribution'], 1));
        $row++;
        $sheet->setCellValue("A{$row}", 'Capacidad (25%)');
        $sheet->setCellValue("B{$row}", $weighted['details']['capacity']['score']);
        $sheet->setCellValue("C{$row}", round($weighted['details']['capacity']['contribution'], 1));
        $row+=2;
        $sheet->setCellValue("A{$row}", 'PUNTAJE TOTAL');
        $sheet->setCellValue("B{$row}", $evaluacion['puntajeGeneral'] . '/100');
        $row++;
        $sheet->setCellValue("A{$row}", 'NIVEL DE CUMPLIMIENTO');
        $sheet->setCellValue("B{$row}", strtoupper($evaluacion['nivel']));
        $row+=2;
        $sheet->setCellValue("A{$row}", 'HIPÓTESIS ACEPTADA');
        $sheet->setCellValue("B{$row}", $evaluacion['hipotesis']['hipotesis_aceptada']);
        $row++;
        $sheet->setCellValue("A{$row}", 'Texto');
        $sheet->setCellValue("B{$row}", $evaluacion['hipotesis']['texto']);

        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(35);
        $sheet->getColumnDimension('B')->setWidth(20);
    }

    private function buildConfigSheet($sheet, array $config): void
    {
        $sheet->setCellValue('A1', 'Parámetro');
        $sheet->setCellValue('B1', 'Valor');
        $row = 2;
        $sheet->setCellValue("A{$row}", 'Modo');
        $sheet->setCellValue("B{$row}", $config['mode']);
        $row++;
        $sheet->setCellValue("A{$row}", 'Concurrencia');
        $sheet->setCellValue("B{$row}", $config['concurrency']);
        $row++;
        $sheet->setCellValue("A{$row}", 'Iteraciones');
        $sheet->setCellValue("B{$row}", $config['iterations']);
        $row++;
        $sheet->setCellValue("A{$row}", 'Verbose');
        $sheet->setCellValue("B{$row}", $config['verbose'] ? 'Sí' : 'No');
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getColumnDimension('A')->setWidth(30);
    }
}