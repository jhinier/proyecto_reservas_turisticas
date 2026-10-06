<!DOCTYPE html>
<html>
<head>
    <title>Reserva confirmada</title>
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.5; }
        .contenedor { max-width: 600px; margin: 0 auto; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; margin-bottom: 20px; }
        th, td { border: 1px solid #e5e7eb; padding: 10px; text-align: left; font-size: 14px; }
        th { background-color: #f9fafb; color: #374151; }
        .total-box { text-align: right; font-size: 18px; color: #06281E; margin-bottom: 20px; }
        .alerta { background-color: #fef3c7; color: #92400e; padding: 15px; border-radius: 8px; font-size: 14px; margin-bottom: 20px; }
        .instrucciones { background-color: #f8fafc; border-left: 4px solid #3b82f6; padding: 15px; border-radius: 8px; font-size: 14px; margin-bottom: 20px; }
        .datos-pago { background-color: #ecfdf5; border-left: 4px solid #10b981; padding: 15px; border-radius: 8px; font-size: 14px; margin-bottom: 20px; }
        .cuenta-pago { border-bottom: 1px solid #bbf7d0; padding: 10px 0; }
        .cuenta-pago:last-child { border-bottom: 0; padding-bottom: 0; }
        .cuenta-pago p { margin: 3px 0; }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Hola {{ $reserva->turista->name }},</h1>
        <p>Tu reserva en <strong>{{ $nombreEmprendimiento }}</strong> tiene el estado de <strong>Confirmada</strong>.</p>
        
        <h3>Detalle de tu reserva</h3>
        <table>
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Cant.</th>
                    <th>Fechas</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reserva->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->servicio->nombre ?? 'Servicio' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>
                        Inicio: {{ \Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y') }}
                        @if($detalle->fecha_fin && $detalle->fecha_fin != $detalle->fecha_inicio)
                            <br>Fin: {{ \Carbon\Carbon::parse($detalle->fecha_fin)->format('d/m/Y') }}
                        @endif
                    </td>
                    <td>${{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="total-box">
            <strong>Total a pagar: ${{ number_format($reserva->precio_total, 2) }}</strong>
        </div>

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
        
        <br>
        <p>Gracias por usar Explora Candelaria.</p>
    </div>
</body>
</html>
