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
        .alerta { background-color: #fef3c7; color: #92400e; padding: 15px; border-radius: 8px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="contenedor">
        <h1>Hola {{ $reserva->turista->name }},</h1>
        <p>Tu reserva #{{ $reserva->id }} tiene el estado de <strong>Confirmada</strong> por el establecimiento.</p>
        
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

        <div class="alerta">
            Tienes un plazo máximo de 24 horas para realizar el pago y asegurar tu cupo.
        </div>
        
        <br>
        <p>Gracias por usar Explora Candelaria.</p>
    </div>
</body>
</html>