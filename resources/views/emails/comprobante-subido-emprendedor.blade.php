<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            color: #374151;
            margin: 0;
            padding: 20px;
            line-height: 1.5;
        }
        .contenedor {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .cabecera {
            background-color: #1a4031;
            color: #ffffff;
            padding: 22px;
            text-align: center;
        }
        .cabecera h1 {
            margin: 0;
            font-size: 23px;
        }
        .cuerpo {
            padding: 24px;
        }
        .aviso {
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
            color: #064e3b;
            padding: 14px;
            margin: 20px 0;
            border-radius: 6px;
            font-size: 14px;
        }
        .resumen {
            background-color: #f8fafc;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 14px;
            margin: 20px 0;
            font-size: 14px;
        }
        .resumen p {
            margin: 0 0 8px 0;
        }
        .resumen p:last-child {
            margin-bottom: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
            font-size: 14px;
            vertical-align: top;
        }
        th {
            background-color: #f3f4f6;
            color: #374151;
        }
        .total {
            text-align: right;
            font-size: 18px;
            color: #06281E;
            margin: 20px 0;
        }
        .pie {
            text-align: center;
            padding: 18px 24px;
            font-size: 12px;
            color: #9ca3af;
            background-color: #f9fafb;
            border-top: 1px solid #f3f4f6;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="cabecera">
            <h1>Comprobante de pago recibido</h1>
        </div>

        <div class="cuerpo">
            <p>Hola <strong>{{ $nombreEmprendimiento }}</strong>,</p>
            <p>El turista <strong>{{ $nombreTurista }}</strong> ya subio el comprobante/factura de pago de la reserva #{{ $reserva->id }}.</p>

            <div class="aviso">
                Debes revisar el comprobante/factura antes de que pasen las {{ $horasRevision }} horas desde su subida. Si no se realiza la revision, el sistema completara la reserva de forma automatica.
            </div>

            <div class="resumen">
                <p><strong>Turista:</strong> {{ $nombreTurista }}</p>
                <p><strong>Total pagado:</strong> ${{ number_format($reserva->precio_total, 2) }}</p>
                @if($reserva->fecha_subida_comprobante)
                    <p><strong>Fecha de subida:</strong> {{ $reserva->fecha_subida_comprobante->format('d/m/Y H:i') }}</p>
                    <p><strong>Limite de revision:</strong> {{ $reserva->fecha_subida_comprobante->copy()->addHours($horasRevision)->format('d/m/Y H:i') }}</p>
                @endif
            </div>

            <p>Servicios reservados:</p>
            <table>
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Fechas</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reserva->detalles as $detalle)
                        <tr>
                            <td>
                                <strong>{{ $detalle->servicio->nombre ?? 'Servicio' }}</strong><br>
                                Cantidad: {{ $detalle->cantidad }}
                            </td>
                            <td>
                                Inicio: {{ \Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y') }}
                                @if($detalle->fecha_fin && $detalle->fecha_fin != $detalle->fecha_inicio)
                                    <br>Fin: {{ \Carbon\Carbon::parse($detalle->fecha_fin)->format('d/m/Y') }}
                                @endif
                                @if($detalle->hora_llegada)
                                    <br>Hora: {{ \Carbon\Carbon::parse($detalle->hora_llegada)->format('H:i') }}
                                @endif
                            </td>
                            <td style="text-align: right;">${{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                <strong>Precio total: ${{ number_format($reserva->precio_total, 2) }}</strong>
            </div>

            <p>Ingresa al sistema para revisar el comprobante/factura cargado por el turista.</p>
        </div>

        <div class="pie">
            <p>Este es un correo automatico, por favor no respondas a esta direccion.</p>
        </div>
    </div>
</body>
</html>
