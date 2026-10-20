<?php

/**
 * Controlador de reportes PDF y Excel para emprendimientos.
 * Usa filtros de fecha, categoria, estado y cedula para resumir reservas, agenda e inventario.
 */

namespace App\Http\Controllers\Emprendimiento;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use App\Models\TipoServicio;
use App\Services\ReservaService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteEmprendedorController extends Controller
{
    public function descargarReporte(Request $request)
    {
        $desde = $request->query('desde') ?: now()->startOfMonth()->format('Y-m-d');
        $hasta = $request->query('hasta') ?: now()->format('Y-m-d');
        $categoria = $request->query('categoria');
        $estado = $request->query('estado');
        $cedula = $request->query('cedula');
        $tipoReporte = $request->query('tipo_reporte', 'todo');

        $user = Auth::user();
        $emprendimiento = $user->emprendimiento;

        // Consulta de agenda
        $servicios = app(ReservaService::class)->obtenerAgendaPorRangoYFiltros(
            $emprendimiento->id,
            $desde,
            $hasta,
            $categoria,
            $estado,
            $cedula
        );

        $reservas = $servicios->map(function ($item) {
            return $item->reserva;
        })->unique('id');

        $totalRecaudado = $reservas->whereIn('estado', ['Confirmada', 'Completada'])->sum('precio_total');
        $totalCanceladas = $reservas->whereIn('estado', ['Cancelada', 'Rechazada'])->count();
        $totalPendientes = $reservas->where('estado', 'Pendiente')->count();
        $totalConfirmadas = $reservas->whereIn('estado', ['Confirmada', 'Completada'])->count();
        $totalReservas = $reservas->count();

        $nombreCatFiltro = 'Todas';
        if (! empty($categoria)) {
            $cat = TipoServicio::find($categoria);
            $nombreCatFiltro = $cat ? $cat->nombre : 'Todas';
        }

        // Consulta de inventario agrupada por categoría
        $serviciosInventario = Servicio::with('tipoServicio')
            ->whereHas('categoriaPivot', function ($q) use ($emprendimiento) {
                $q->where('emprendimiento_id', $emprendimiento->id);
            })->get()->groupBy(function ($s) {
                return $s->tipoServicio->nombre ?? 'Otros';
            });

        $fechaDesdeFormato = Carbon::parse($desde)->format('Ymd');
        $fechaHastaFormato = Carbon::parse($hasta)->format('Ymd');
        $nombreArchivo = "Reporte_{$tipoReporte}_{$fechaDesdeFormato}_{$fechaHastaFormato}.pdf";

        $pdf = Pdf::loadView('pdf.reporte-reservas', [
            'servicios' => $servicios,
            'reservas' => $reservas,
            'serviciosInventario' => $serviciosInventario,
            'tipoReporte' => $tipoReporte,
            'desde' => $desde,
            'hasta' => $hasta,
            'emprendimientoNombre' => $emprendimiento->nombre ?? 'Mi Emprendimiento',
            'usuarioGenerador' => $user->name,
            'emailGenerador' => $user->email,
            'filtroCategoria' => $nombreCatFiltro,
            'filtroEstado' => $estado ?: 'Todos',
            'filtroCedula' => $cedula ?: 'Todos',
            'analisis' => [
                'recaudado' => $totalRecaudado,
                'canceladas' => $totalCanceladas,
                'pendientes' => $totalPendientes,
                'confirmadas' => $totalConfirmadas,
                'total' => $totalReservas,
            ],
        ]);

        return $pdf->stream($nombreArchivo);
    }

    public function descargarExcel(Request $request)
    {
        $datos = $this->prepararDatosExcel($request);
        $fechaDesdeFormato = Carbon::parse($datos['desde'])->format('Ymd');
        $fechaHastaFormato = Carbon::parse($datos['hasta'])->format('Ymd');
        $nombreArchivo = "Reporte_{$datos['tipoReporte']}_{$fechaDesdeFormato}_{$fechaHastaFormato}.xlsx";
        $spreadsheet = $this->construirExcel($datos);

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, $nombreArchivo, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    private function prepararDatosExcel(Request $request): array
    {
        $desde = $request->query('desde') ?: now()->startOfMonth()->format('Y-m-d');
        $hasta = $request->query('hasta') ?: now()->format('Y-m-d');
        $categoria = $request->query('categoria');
        $estado = $request->query('estado');
        $cedula = $request->query('cedula');
        $tipoReporte = $request->query('tipo_reporte', 'todo');
        $nombreServicio = $request->query('nombre');

        $user = Auth::user();
        $emprendimiento = $user->emprendimiento;

        $servicios = app(ReservaService::class)->obtenerAgendaPorRangoYFiltros(
            $emprendimiento->id,
            $desde,
            $hasta,
            $categoria,
            $estado,
            $cedula
        );

        if (! empty($nombreServicio)) {
            $nombreBuscado = trim($nombreServicio);
            $servicios = $servicios->filter(function ($item) use ($nombreBuscado) {
                return stripos($item->servicio->nombre ?? '', $nombreBuscado) !== false;
            })->values();
        }

        $reservas = $servicios->map(function ($item) {
            return $item->reserva;
        })->filter()->unique('id')->values();

        $nombreCatFiltro = 'Todas';
        if (! empty($categoria)) {
            $cat = TipoServicio::find($categoria);
            $nombreCatFiltro = $cat ? $cat->nombre : 'Todas';
        }

        $serviciosInventario = Servicio::with('tipoServicio')
            ->whereHas('categoriaPivot', function ($q) use ($emprendimiento) {
                $q->where('emprendimiento_id', $emprendimiento->id);
            })->get()->groupBy(function ($s) {
                return $s->tipoServicio->nombre ?? 'Otros';
            });

        return [
            'servicios' => $servicios,
            'reservas' => $reservas,
            'serviciosInventario' => $serviciosInventario,
            'tipoReporte' => $tipoReporte,
            'desde' => $desde,
            'hasta' => $hasta,
            'emprendimientoNombre' => $emprendimiento->nombre ?? 'Mi Emprendimiento',
            'usuarioGenerador' => $user->name,
            'emailGenerador' => $user->email,
            'filtroCategoria' => $nombreCatFiltro,
            'filtroEstado' => $estado ?: 'Todos',
            'filtroCedula' => $cedula ?: 'Todos',
            'filtroNombre' => $nombreServicio ?: 'Todos',
            'analisis' => [
                'recaudado' => $reservas->whereIn('estado', ['Confirmada', 'Completada'])->sum('precio_total'),
                'canceladas' => $reservas->whereIn('estado', ['Cancelada', 'Rechazada'])->count(),
                'pendientes' => $reservas->where('estado', 'Pendiente')->count(),
                'confirmadas' => $reservas->where('estado', 'Confirmada')->count(),
                'completadas' => $reservas->where('estado', 'Completada')->count(),
                'total' => $reservas->count(),
            ],
        ];
    }

    private function construirExcel(array $datos): Spreadsheet
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
            ->setCreator($datos['usuarioGenerador'])
            ->setTitle('Reporte de reservas y operaciones');
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

        $resumen = $spreadsheet->getActiveSheet();
        $resumen->setTitle('Resumen');
        $this->llenarHojaResumen($resumen, $datos);

        if ($datos['tipoReporte'] === 'todo' || $datos['tipoReporte'] === 'servicios') {
            $hojaServicios = $spreadsheet->createSheet();
            $hojaServicios->setTitle('Servicios');
            $this->llenarHojaServicios($hojaServicios, $datos['servicios']);
        }

        if ($datos['tipoReporte'] === 'todo' || $datos['tipoReporte'] === 'turistas') {
            $hojaTuristas = $spreadsheet->createSheet();
            $hojaTuristas->setTitle('Turistas');
            $this->llenarHojaTuristas($hojaTuristas, $datos['servicios']);
        }

        if ($datos['tipoReporte'] === 'todo' || $datos['tipoReporte'] === 'inventario') {
            $hojaInventario = $spreadsheet->createSheet();
            $hojaInventario->setTitle('Inventario');
            $this->llenarHojaInventario($hojaInventario, $datos['serviciosInventario']);
        }

        $spreadsheet->setActiveSheetIndex(0);

        return $spreadsheet;
    }

    private function llenarHojaResumen(Worksheet $sheet, array $datos): void
    {
        $sheet->setCellValue('A1', 'Reporte de reservas y operaciones');
        $sheet->mergeCells('A1:E1');
        $this->aplicarTitulo($sheet, 'A1:E1');

        $sheet->fromArray([
            ['Emprendimiento', $datos['emprendimientoNombre']],
            ['Generado por', $datos['usuarioGenerador']],
            ['Correo', $datos['emailGenerador']],
            ['Rango', Carbon::parse($datos['desde'])->format('d/m/Y').' a '.Carbon::parse($datos['hasta'])->format('d/m/Y')],
            ['Fecha de generacion', now()->format('d/m/Y H:i:s')],
        ], null, 'A3');

        $sheet->fromArray(['Filtro', 'Valor'], null, 'A10');
        $this->aplicarEncabezado($sheet, 'A10:B10');
        $sheet->fromArray([
            ['Categoria', $datos['filtroCategoria']],
            ['Estado', $datos['filtroEstado']],
            ['Cedula turista', $datos['filtroCedula']],
            ['Nombre servicio', $datos['filtroNombre']],
            ['Tipo de reporte', $datos['tipoReporte']],
        ], null, 'A11');

        $sheet->fromArray(['Indicador', 'Valor'], null, 'D10');
        $this->aplicarEncabezado($sheet, 'D10:E10');
        $sheet->fromArray([
            ['Total reservas', $datos['analisis']['total']],
            ['Confirmadas', $datos['analisis']['confirmadas']],
            ['Completadas', $datos['analisis']['completadas']],
            ['Pendientes', $datos['analisis']['pendientes']],
            ['Canceladas', $datos['analisis']['canceladas']],
            ['Total recaudado', (float) $datos['analisis']['recaudado']],
        ], null, 'D11');

        $sheet->getStyle('A3:A7')->getFont()->setBold(true);
        $sheet->getStyle('E16')->getNumberFormat()->setFormatCode('$#,##0.00');
        $this->aplicarBordes($sheet, 'A10:B15');
        $this->aplicarBordes($sheet, 'D10:E16');
        $this->autosizeColumns($sheet, 'A', 'E');
    }

    private function llenarHojaServicios(Worksheet $sheet, $servicios): void
    {
        $headers = ['N°', 'C.I. Turista', 'Turista', 'F. Inicio', 'F. Fin', 'Hora', 'Categoria', 'Servicio', 'Cant.', 'Subtotal', 'Estado'];
        $sheet->fromArray($headers, null, 'A1');
        $this->aplicarEncabezado($sheet, 'A1:K1');

        $row = 2;
        $contador = 1;
        $total = 0;

        foreach ($servicios as $item) {
            $turista = $item->reserva?->turista;
            $total += (float) $item->subtotal;

            $sheet->setCellValue("A{$row}", $contador++);
            $sheet->setCellValueExplicit("B{$row}", $turista->cedula ?? 'N/A', DataType::TYPE_STRING);
            $sheet->setCellValue("C{$row}", trim(($turista->name ?? 'Usuario').' '.($turista->apellidos ?? '')));
            $sheet->setCellValue("D{$row}", $this->formatearFecha($item->fecha_inicio));
            $sheet->setCellValue("E{$row}", $this->formatearFecha($item->fecha_fin ?: $item->fecha_inicio));
            $sheet->setCellValue("F{$row}", $this->formatearHora($item->hora_llegada));
            $sheet->setCellValue("G{$row}", $item->servicio->tipoServicio->nombre ?? '');
            $sheet->setCellValue("H{$row}", $item->servicio->nombre ?? 'N/A');
            $sheet->setCellValue("I{$row}", $item->cantidad);
            $sheet->setCellValue("J{$row}", (float) $item->subtotal);
            $sheet->setCellValue("K{$row}", $item->reserva->estado ?? 'Indefinido');
            $row++;
        }

        if ($row === 2) {
            $sheet->setCellValue('A2', 'No hay servicios en este rango.');
            $sheet->mergeCells('A2:K2');
        } else {
            $sheet->setCellValue("I{$row}", 'TOTAL');
            $sheet->setCellValue("J{$row}", $total);
            $sheet->getStyle("I{$row}:J{$row}")->getFont()->setBold(true);
            $sheet->getStyle("J2:J{$row}")->getNumberFormat()->setFormatCode('$#,##0.00');
        }

        $lastRow = max(2, $row);
        $this->aplicarBordes($sheet, "A1:K{$lastRow}");
        $this->configurarTabla($sheet, "A1:K{$lastRow}");
        $this->autosizeColumns($sheet, 'A', 'K');
    }

    private function llenarHojaTuristas(Worksheet $sheet, $servicios): void
    {
        $headers = ['N°', 'C.I.', 'Turista', 'Edad', 'Email', 'Telefono', 'Servicio solicitado', 'F. Inicio', 'F. Fin'];
        $sheet->fromArray($headers, null, 'A1');
        $this->aplicarEncabezado($sheet, 'A1:I1');

        $row = 2;
        $contador = 1;

        foreach ($servicios as $item) {
            $turista = $item->reserva?->turista;

            $sheet->setCellValue("A{$row}", $contador++);
            $sheet->setCellValueExplicit("B{$row}", $turista->cedula ?? 'N/A', DataType::TYPE_STRING);
            $sheet->setCellValue("C{$row}", trim(($turista->name ?? 'Usuario').' '.($turista->apellidos ?? '')));
            $sheet->setCellValue("D{$row}", $this->obtenerEdadTurista($turista));
            $sheet->setCellValue("E{$row}", $turista->email ?? 'Sin correo');
            $sheet->setCellValueExplicit("F{$row}", $turista->telefono ?? 'N/A', DataType::TYPE_STRING);
            $sheet->setCellValue("G{$row}", $item->servicio->nombre ?? 'N/A');
            $sheet->setCellValue("H{$row}", $this->formatearFecha($item->fecha_inicio));
            $sheet->setCellValue("I{$row}", $this->formatearFecha($item->fecha_fin ?: $item->fecha_inicio));
            $row++;
        }

        if ($row === 2) {
            $sheet->setCellValue('A2', 'No hay clientes en este rango.');
            $sheet->mergeCells('A2:I2');
        }

        $lastRow = max(2, $row - 1);
        $this->aplicarBordes($sheet, "A1:I{$lastRow}");
        $this->configurarTabla($sheet, "A1:I{$lastRow}");
        $this->autosizeColumns($sheet, 'A', 'I');
    }

    private function llenarHojaInventario(Worksheet $sheet, $serviciosInventario): void
    {
        $headers = ['Categoria', 'Servicio disponible', 'Precio base'];
        $sheet->fromArray($headers, null, 'A1');
        $this->aplicarEncabezado($sheet, 'A1:C1');

        $row = 2;

        foreach ($serviciosInventario as $categoria => $listaServicios) {
            foreach ($listaServicios as $servicio) {
                $sheet->setCellValue("A{$row}", $categoria);
                $sheet->setCellValue("B{$row}", $servicio->nombre);
                $sheet->setCellValue("C{$row}", (float) $servicio->precio);
                $row++;
            }
        }

        if ($row === 2) {
            $sheet->setCellValue('A2', 'No hay servicios registrados en el inventario.');
            $sheet->mergeCells('A2:C2');
        } else {
            $sheet->getStyle("C2:C".($row - 1))->getNumberFormat()->setFormatCode('$#,##0.00');
        }

        $lastRow = max(2, $row - 1);
        $this->aplicarBordes($sheet, "A1:C{$lastRow}");
        $this->configurarTabla($sheet, "A1:C{$lastRow}");
        $this->autosizeColumns($sheet, 'A', 'C');
    }

    private function aplicarTitulo(Worksheet $sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '06281E']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
    }

    private function aplicarEncabezado(Worksheet $sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '00A344']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);
    }

    private function aplicarBordes(Worksheet $sheet, string $range): void
    {
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D9E8DF'],
                ],
            ],
        ]);
    }

    private function configurarTabla(Worksheet $sheet, string $range): void
    {
        $sheet->freezePane('A2');
        $sheet->setAutoFilter($range);
        $sheet->getStyle($range)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }

    private function autosizeColumns(Worksheet $sheet, string $firstColumn, string $lastColumn): void
    {
        foreach (range($firstColumn, $lastColumn) as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }

    private function formatearFecha($fecha): string
    {
        return $fecha ? Carbon::parse($fecha)->format('d/m/Y') : '';
    }

    private function formatearHora($hora): string
    {
        return $hora ? Carbon::parse($hora)->format('H:i') : '--:--';
    }

    private function obtenerEdadTurista($turista): string|int
    {
        if (! $turista) {
            return 'N/A';
        }

        if ($turista->edad !== null) {
            return $turista->edad;
        }

        if (! empty($turista->fecha_nacimiento)) {
            return Carbon::parse($turista->fecha_nacimiento)->age;
        }

        return 'N/A';
    }
}
