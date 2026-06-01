<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { width: 100%; border-bottom: 2px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #000; color: #fff; padding: 8px; text-align: left; }
        td { border-bottom: 1px solid #ccc; padding: 8px; }
        .total { text-align: right; font-weight: bold; font-size: 14px; margin-top: 20px; color: #00A344; }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin:0;">Reporte de Agenda Turística</h2>
        <p>Rango: {{ $desde }} al {{ $hasta }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Cantidad</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicios as $item)
            <tr>
                <td>{{ $item->servicio->nombre }}</td>
                <td>{{ \Carbon\Carbon::parse($item->fecha_inicio)->format('Y-m-d') }}</td>
                <td>{{ $item->hora_llegada ?? '--:--' }}</td>
                <td>{{ $item->cantidad }}</td>
                <td>{{ $item->reserva->estado ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>