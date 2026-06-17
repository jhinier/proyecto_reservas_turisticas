<!DOCTYPE html>
<?php
/** @var \Illuminate\Support\Collection $servicios */
/** @var \Illuminate\Support\Collection $serviciosInventario */
/** @var array $analisis */
/** @var string $emprendimientoNombre */
/** @var string $usuarioGenerador */
/** @var string $emailGenerador */
/** @var string $filtroCategoria */
/** @var string $filtroEstado */
/** @var string $filtroCedula */
/** @var string $tipoReporte */
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Actividad</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 11px; color: #333; margin: 40px; padding: 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        td, th { padding: 6px 8px; border: 1px solid #ddd; text-align: left; }
        h2 { font-size: 18px; margin: 0 0 5px 0; color: #06281E; }
        h3 { font-size: 14px; text-transform: uppercase; margin: 25px 0 10px 0; color: #000; font-weight: bold; display: inline-block; border-bottom: 2px solid #000; padding-bottom: 3px; }
        p { margin: 0 0 5px 0; }

        .table-filtros th { background-color: #3b82f6; color: #fff; border-color: #2563eb; } 
        
        .table-datos th { background-color: #00A344; color: #fff; border-color: #00A344; text-transform: uppercase; font-size: 10px;}
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        .footer { position: fixed; bottom: -10px; width: 100%; text-align: center; font-size: 9px; color: #666; border-top: 1px solid #ddd; padding-top: 5px; }
        .pagenum:before { content: counter(page); }
    </style>
</head>
<body>
    <div class="footer">
        Página <span class="pagenum"></span>
    </div>

    <table style="border: none; border-bottom: 2px solid #06281E; padding-bottom: 10px; margin-bottom: 20px;">
        <tr>
            <td style="border: none; padding: 0; width: 50%; vertical-align: bottom;">
                <h2>{{ $emprendimientoNombre }}</h2>
                <p style="font-size: 14px; font-weight: bold;">Reporte de Reservas y Operaciones</p>
                <p>Rango: {{ \Carbon\Carbon::parse($desde)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}</p>
            </td>
            <td style="border: none; padding: 0; width: 50%; text-align: right; vertical-align: bottom;">
                <p>Generado por: {{ $usuarioGenerador }}</p>
                <p>Correo: {{ $emailGenerador }}</p>
                <p>Fecha: {{ now()->format('d/m/Y, H:i:s') }}</p>
            </td>
        </tr>
    </table>

    {{-- Lógica para mostrar tabla de filtros según el tipo de reporte --}}
    <?php if($tipoReporte !== 'inventario'): ?>
    <table class="table-filtros">
        <thead>
            <tr>
                <th style="width: 70%;">Filtro</th>
                <th style="width: 30%;">Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php if($tipoReporte === 'todo' || $tipoReporte === 'servicios'): ?>
                <tr><td>Categoría</td><td>{{ $filtroCategoria }}</td></tr>
                <tr><td>Estado</td><td>{{ $filtroEstado }}</td></tr>
            <?php endif; ?>
            
            <?php if($tipoReporte === 'todo' || $tipoReporte === 'turistas'): ?>
                <tr><td>Cédula Turista</td><td>{{ $filtroCedula }}</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php endif; ?>

    {{-- GRÁFICOS: Solo se muestran cuando se imprimen todas las tablas --}}
    <?php if($tipoReporte === 'todo'): ?>
    <?php
        $conf = $analisis['confirmadas'] ?? 0;
        $pend = $analisis['pendientes'] ?? 0;
        $canc = $analisis['canceladas'] ?? 0;
        $comp = $analisis['completadas'] ?? 0;

        $nombresStr = '';
        $cantidadesStr = '';
        
        if(isset($servicios) && $servicios->isNotEmpty()){
            $agrupado = $servicios->groupBy(function($item) { return $item->servicio->nombre ?? 'Otros'; });
            $nombres = [];
            $cantidades = [];
            foreach($agrupado as $nom => $grp) {
                // Limpieza para que la URL sea válida
                $nombres[] = "'" . str_replace(['\'', '"'], '', $nom) . "'";
                $cantidades[] = $grp->sum('cantidad');
            }
            $nombresStr = implode(',', $nombres);
            $cantidadesStr = implode(',', $cantidades);
        }
        
        // Conversión y codificación nativa en PHP para saltar la restricción del PDF
        $chartConfigDona = "{type:'doughnut',data:{labels:['Confirmadas','Completadas','Pendientes','Canceladas'],datasets:[{data:[$conf,$comp,$pend,$canc],backgroundColor:['#00A344','#3b82f6','#f59e0b','#ef4444']}]},options:{plugins:{datalabels:{display:false}},legend:{position:'right',labels:{fontSize:10}}}}";
        $urlDona = "https://quickchart.io/chart?w=350&h=180&bkg=white&c=" . urlencode($chartConfigDona);
        
        $srcDona = $urlDona;
        try { 
            $donaData = @file_get_contents($urlDona);
            if ($donaData) { $srcDona = 'data:image/png;base64,' . base64_encode($donaData); }
        } catch(\Exception $e) {}

        $srcBarras = '';
        if($nombresStr !== '') {
            $chartConfigBarras = "{type:'bar',data:{labels:[$nombresStr],datasets:[{label:'Cantidad',data:[$cantidadesStr],backgroundColor:'#8DBEA2'}]},options:{plugins:{legend:{display:false}},scales:{y:{ticks:{stepSize:1}}}}}";
            $urlBarras = "https://quickchart.io/chart?w=350&h=180&bkg=white&c=" . urlencode($chartConfigBarras);
            
            $srcBarras = $urlBarras;
            try { 
                $barrasData = @file_get_contents($urlBarras);
                if ($barrasData) { $srcBarras = 'data:image/png;base64,' . base64_encode($barrasData); }
            } catch(\Exception $e) {}
        }
    ?>
    <table style="width: 100%; margin-bottom: 20px; text-align: center; border: none;">
        <tr>
            <td style="width: 48%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; vertical-align: top;">
                <h3 style="margin-top: 0; color: #999; font-size: 10px;">ESTADO DE RESERVAS</h3>
                <img src="<?php echo $srcDona; ?>" style="max-width: 100%; height: auto;" />
            </td>
            <td style="width: 4%; border: none;"></td>
            <td style="width: 48%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; vertical-align: top;">
                <h3 style="margin-top: 0; color: #999; font-size: 10px;">SERVICIOS SOLICITADOS</h3>
                <?php if($srcBarras !== ''): ?>
                    <img src="<?php echo $srcBarras; ?>" style="max-width: 100%; height: auto;" />
                <?php else: ?>
                    <p style="color: #999; margin-top: 40px;">No hay datos en este rango</p>
                <?php endif; ?>
            </td>
        </tr>
    </table>
    <?php endif; ?>

    <?php if($tipoReporte === 'todo' || $tipoReporte === 'servicios'): ?>
    <h3>Desglose de servicios agendados</h3>
    <table class="table-datos">
        <thead>
            <tr>
                <th style="width: 20px; text-align: center;">N°</th>
                <th>C.I. Turista</th>
                <th>F. Inicio</th>
                <th>F. Fin</th>
                <th>Hora</th>
                <th>Servicio</th>
                <th class="text-center">Cant.</th>
                <th class="text-right">Subtotal</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php $sumaPDF = 0; $contadorServicios = 1; ?>
            <?php if($servicios->isNotEmpty()): foreach($servicios as $item): ?>
                <?php $sumaPDF += $item->subtotal; ?>
                <tr>
                    <td class="text-center font-bold" style="vertical-align: middle;"><?php echo $contadorServicios++; ?></td>
                    <td style="font-family: monospace; vertical-align: middle;"><?php echo $item->reserva->turista->cedula ?? 'N/A'; ?></td>
                    <td style="vertical-align: middle;"><?php echo \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y'); ?></td>
                    <td style="vertical-align: middle;"><?php echo $item->fecha_fin ? \Carbon\Carbon::parse($item->fecha_fin)->format('d/m/Y') : \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y'); ?></td>
                    <td style="vertical-align: middle;"><?php echo $item->hora_llegada ? \Carbon\Carbon::parse($item->hora_llegada)->format('H:i') : '--:--'; ?></td>
                    <td style="vertical-align: middle;">
                        <strong><?php echo $item->servicio->nombre ?? 'N/A'; ?></strong><br>
                        <span style="font-size: 9px; color: #666;"><?php echo $item->servicio->tipoServicio->nombre ?? ''; ?></span>
                    </td>
                    <td class="text-center" style="vertical-align: middle;"><?php echo $item->cantidad; ?></td>
                    <td class="text-right" style="vertical-align: middle;">$<?php echo number_format($item->subtotal, 2); ?></td>
                    <td style="vertical-align: middle;">
                        <?php
                            $est = $item->reserva->estado ?? 'Indefinido';
                            if ($est === 'Confirmada' || $est === 'Completada') $colorBadge = '#059669';
                            elseif ($est === 'Pendiente') $colorBadge = '#d97706';
                            elseif ($est === 'Cancelada' || $est === 'Rechazada') $colorBadge = '#dc2626';
                            else $colorBadge = '#333';
                            $estiloSpan = 'color: ' . $colorBadge . '; font-weight: bold; text-transform: uppercase; font-size: 10px;';
                        ?>
                        <span style="<?php echo $estiloSpan; ?>"><?php echo $est; ?></span>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="9" class="text-center">No hay servicios en este rango.</td></tr>
            <?php endif; ?>
        </tbody>
        <?php if($servicios->isNotEmpty()): ?>
        <tfoot style="background-color: #f9fafb;">
            <tr>
                <td colspan="7" class="text-right font-bold" style="font-size: 10px;">TOTAL CALCULADO:</td>
                <td class="text-right font-bold" style="color: #00A344;">$<?php echo number_format($sumaPDF, 2); ?></td>
                <td></td>
            </tr>
        </tfoot>
        <?php endif; ?>
    </table>
    <?php endif; ?>

    <?php if($tipoReporte === 'todo' || $tipoReporte === 'turistas'): ?>
    <h3>Listado de Turistas</h3>
    <table class="table-datos">
        <thead>
            <tr>
                <th style="width: 20px; text-align: center;">N°</th>
                <th>Turista</th>
                <th>Contacto</th>
                <th>Servicio Solicitado</th>
                <th>Rango de Fechas</th>
            </tr>
        </thead>
        <tbody>
            <?php $contadorTuristas = 1; ?>
            <?php if($servicios->isNotEmpty()): foreach($servicios as $item): 
                $turista = $item->reserva->turista;
                $edad = $turista->edad ?? (\Carbon\Carbon::parse($turista->fecha_nacimiento)->age ?? 'N/A');
            ?>
                <tr>
                    <td class="text-center font-bold" style="vertical-align: middle;"><?php echo $contadorTuristas++; ?></td>
                    <td style="vertical-align: middle;">
                        <strong><?php echo $turista->name . ' ' . $turista->apellidos; ?></strong><br>
                        <span style="font-size: 9px; color: #666;">C.I: <?php echo $turista->cedula ?? 'N/A'; ?> | Edad: <?php echo $edad; ?></span>
                    </td>
                    <td style="vertical-align: middle;">
                        <?php echo $turista->email ?? 'Sin correo'; ?><br>
                        <span style="font-size: 9px; color: #666;">Tel: <?php echo $turista->telefono ?? 'N/A'; ?></span>
                    </td>
                    <td style="vertical-align: middle;"><strong><?php echo $item->servicio->nombre ?? 'N/A'; ?></strong></td>
                    <td style="vertical-align: middle;">
                        Del: <?php echo \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y'); ?><br>
                        Al: <?php echo $item->fecha_fin ? \Carbon\Carbon::parse($item->fecha_fin)->format('d/m/Y') : \Carbon\Carbon::parse($item->fecha_inicio)->format('d/m/Y'); ?>
                    </td>
                </tr>
            <?php endforeach; else: ?>
                <tr><td colspan="5" class="text-center">No hay clientes en este rango.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <?php if($tipoReporte === 'todo' || $tipoReporte === 'inventario'): ?>
    <h3>Inventario de Servicios</h3>
    <table class="table-datos">
        <thead>
            <tr>
                <th>Categoría</th>
                <th>Servicio Disponible</th>
                <th class="text-right">Precio Base</th>
            </tr>
        </thead>
        <tbody>
            <?php if($serviciosInventario->isNotEmpty()): foreach($serviciosInventario as $categoria => $listaServicios): ?>
                <?php foreach($listaServicios as $index => $servicio): ?>
                <tr>
                    <?php if($index === 0): ?>
                    <td rowspan="<?php echo count($listaServicios); ?>" style="vertical-align: top; background-color: #f9fafb; font-weight: bold; text-transform: uppercase; font-size: 9px;">
                        <?php echo $categoria; ?>
                    </td>
                    <?php endif; ?>
                    <td><?php echo $servicio->nombre; ?></td>
                    <td class="text-right font-bold">$<?php echo number_format($servicio->precio, 2); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endforeach; else: ?>
                <tr><td colspan="3" class="text-center">No hay servicios registrados en el inventario.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php endif; ?>

</body>
</html>