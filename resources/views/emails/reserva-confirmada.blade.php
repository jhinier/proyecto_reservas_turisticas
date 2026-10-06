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
        .datos-pago {
            background-color: #ecfdf5;
            color: #064e3b;
            padding: 15px;
            border-left: 4px solid #10b981;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .cuenta-pago {
            border-bottom: 1px solid #bbf7d0;
            padding: 10px 0;
        }
        .cuenta-pago:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }
        .cuenta-pago p {
            margin: 3px 0;
        }
        .instrucciones {
            background-color: #f8fafc;
            color: #1f2937;
            padding: 15px;
            border-left: 4px solid #3b82f6;
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

            <div class="datos-pago">
                <p style="margin: 0 0 10px 0;"><strong>Datos para el pago:</strong></p>
                <p style="margin: 0 0 10px 0;">Telefono de contacto: <strong>{{ $telefono }}</strong></p>

                @foreach($cuentasBancarias as $cuenta)
                    <div class="cuenta-pago">
                        <p><strong>Banco:</strong> {{ $cuenta->nombre_banco }}</p>
                        <p><strong>Cuenta:</strong> {{ $cuenta->numero_cuenta }}</p>
                        <p><strong>Titular:</strong> {{ $cuenta->titular }}</p>
                    </div>
                @endforeach
            </div>

            <div class="instrucciones">
                <p style="margin: 0 0 10px 0;"><strong>Instrucciones para el pago:</strong></p>
                <p style="margin: 0 0 10px 0;"><strong>Realiza el pago</strong> usando una de las cuentas indicadas en este correo.</p>
                <p style="margin: 0;">Luego ingresa al sistema y <strong>sube tu comprobante de pago</strong> para que el establecimiento pueda validarlo.</p>
            </div>

            <div class="alerta">
                <strong>Importante:</strong> Tienes un plazo maximo de 24 horas para realizar el pago. Caso contrario, tu reserva sera cancelada automaticamente. Si tienes dudas, comunicate al siguiente numero: <strong>{{ $telefono }}</strong>.
            </div>

            <p>Por favor, conserva este correo como comprobante de tu reserva. Si tienes alguna duda, ponte en contacto con {{ $nombreEmprendimiento }}.</p>
        </div>

        <div class="pie-pagina">
            <p>Este es un correo automático, por favor no respondas a esta dirección.</p>
        </div>
    </div>
</body>
</html>
