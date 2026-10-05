<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9fafb;
            color: #374151;
            margin: 0;
            padding: 20px;
        }
        .contenedor {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }
        .cabecera {
            background-color: #1a4031;
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }
        .cabecera h1 {
            margin: 0;
            font-size: 24px;
            letter-spacing: 1px;
        }
        .cuerpo {
            padding: 32px 24px;
        }
        .saludo {
            font-size: 16px;
            margin-bottom: 24px;
        }
        .tabla-resumen {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
            margin-bottom: 32px;
        }
        .tabla-resumen th {
            background-color: #f3f4f6;
            color: #4b5563;
            font-size: 12px;
            text-transform: uppercase;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #e5e7eb;
        }
        .tabla-resumen td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        .servicio-info {
            display: block;
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }
        .totales {
            text-align: right;
            padding: 16px 12px;
            background-color: #f8fafc;
            font-weight: bold;
            font-size: 18px;
            color: #1a4031;
        }
        .alerta {
            background-color: #fef3c7;
            color: #92400e;
            padding: 15px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .pie-pagina {
            text-align: center;
            padding: 24px;
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
            <h1>Confirmación de Reserva</h1>
        </div>
        
        <div class="cuerpo">
            <p class="saludo">Hola <strong>{{ $turista->name }} {{ $turista->apellidos }}</strong>,</p>
            <p>Tu reserva en <strong>{{ $nombreEmprendimiento }}</strong> ha sido registrada con éxito. Aquí tienes el detalle de los servicios agendados:</p>

            <table class="tabla-resumen">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th style="text-align: center;">Cant.</th>
                        <th style="text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reserva->detalles as $detalle)
                    <tr>
                        <td>
                            <strong>{{ $detalle->servicio->nombre ?? 'Servicio' }}</strong>
                            <span class="servicio-info">Inicio: {{ \Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y') }}</span>
                            @if($detalle->fecha_fin && $detalle->fecha_fin != $detalle->fecha_inicio)
                                <span class="servicio-info">Fin: {{ \Carbon\Carbon::parse($detalle->fecha_fin)->format('d/m/Y') }}</span>
                            @endif
                            @if($detalle->hora_llegada)
                                <span class="servicio-info">Hora: {{ \Carbon\Carbon::parse($detalle->hora_llegada)->format('H:i') }}</span>
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $detalle->cantidad }}</td>
                        <td style="text-align: right;">${{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="totales">
                            Total a pagar: ${{ number_format($reserva->precio_total, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>

            <div class="alerta">
                <strong>Atención:</strong> Tienes un plazo máximo de 24 horas para comunicarte al número <strong>{{ $telefono }}</strong>, realizar el pago y subir tu comprobante al sistema. Si el tiempo expira, la reserva se cancela de forma automática.
            </div>

            <p>Por favor, conserva este correo como comprobante de tu reserva. Si tienes alguna duda, ponte en contacto con {{ $nombreEmprendimiento }}.</p>
        </div>

        <div class="pie-pagina">
            <p>Este es un correo automático, por favor no respondas a esta dirección.</p>
        </div>
    </div>
</body>
</html>