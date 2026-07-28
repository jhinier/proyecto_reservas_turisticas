<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; color: #333; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
        
        <div style="background-color: #ef4444; color: white; padding: 20px; text-align: center;">
            <h2 style="margin: 0;">¡Aviso importante!</h2>
        </div>
        
        <div style="padding: 20px;">
            <p>Tienes una reserva pendiente de verificación de pago.</p>
            
            <div style="background-color: #fef2f2; padding: 15px; border-left: 4px solid #ef4444; margin: 20px 0;">
                <p style="margin: 0 0 10px 0;"><strong>Turista:</strong> {{ $reserva->turista->name }} {{ $reserva->turista->apellidos }}</p>
                <p style="margin: 0;"><strong>Tiempo restante:</strong> 1 hora</p>
            </div>

            <p>Detalles de la solicitud:</p>
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

            <p>El comprobante de pago fue subido hace 11 horas. Ingresa al sistema para validarlo.</p>
            <p style="color: #ef4444; font-weight: bold;">Si no realizas la verificación en la próxima hora, el sistema pasará la reserva a estado Completada de forma automática.</p>
        </div>
        
    </div>
</body>
</html>