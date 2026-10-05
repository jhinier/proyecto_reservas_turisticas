<!DOCTYPE html>
<html>
<head>
    <title>Reserva Pendiente</title>
</head>
<body style="font-family: sans-serif; color: #374151; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
        
        <div style="background-color: #f59e0b; color: white; padding: 20px; text-align: center;">
            <h2 style="margin: 0;">Reserva Pendiente</h2>
        </div>
        
        <div style="padding: 20px;">
            <p>Hola <strong>{{ $reserva->turista->name }}</strong>,</p>
            <p>Hemos recibido tu solicitud de reserva en <strong>{{ $nombreEmprendimiento }}</strong> para los siguientes servicios y actualmente se encuentra <strong>Pendiente</strong>:</p>

            <ul style="background-color: #f9fafb; padding: 15px 15px 15px 35px; border-radius: 6px; border: 1px solid #e5e7eb;">
                @foreach($reserva->detalles as $detalle)
                    <li style="margin-bottom: 10px;">
                        <strong>{{ $detalle->servicio->nombre ?? 'Servicio' }}</strong><br>
                        <span style="font-size: 0.9em; color: #4b5563;">
                            Fecha de inicio: {{ \Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y') }}
                            @if($detalle->fecha_fin && $detalle->fecha_fin != $detalle->fecha_inicio)
                                <br>Fecha de fin: {{ \Carbon\Carbon::parse($detalle->fecha_fin)->format('d/m/Y') }}
                            @endif
                        </span>
                    </li>
                @endforeach
            </ul>

            <p>El establecimiento revisará la disponibilidad. Una vez confirmada, tendrás 24 horas para realizar el pago.</p>
            <br>
            <p>Gracias por usar Explora Candelaria.</p>
        </div>
        
    </div>
</body>
</html>