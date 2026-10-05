<div style="font-family: sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
    <div style="background-color: #eab308; color: white; padding: 20px; text-align: center;">
        <h2 style="margin: 0;">Reserva Reagendada</h2>
    </div>
    <div style="padding: 20px; color: #374151;">
        <p>Hola <strong>{{ $reserva->turista->name }}</strong>,</p>
        <p>Tu reserva en <strong>{{ $nombreEmprendimiento }}</strong> ha sido modificada y reagendada para nuevas fechas. Aquí tienes el detalle actualizado:</p>

        <ul style="background-color: #f9fafb; padding: 15px 15px 15px 35px; border-radius: 6px; border: 1px solid #e5e7eb;">
            @foreach($reserva->detalles as $detalle)
                <li style="margin-bottom: 10px;">
                    <strong>{{ $detalle->servicio->nombre ?? 'Servicio' }}</strong><br>
                    <span style="font-size: 0.9em; color: #4b5563;">
                        Fecha de inicio: {{ \Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y') }}
                        @if($detalle->fecha_fin && $detalle->fecha_fin != $detalle->fecha_inicio)
                            <br>Fecha de fin: {{ \Carbon\Carbon::parse($detalle->fecha_fin)->format('d/m/Y') }}
                        @endif
                        @if($detalle->hora_llegada)
                            <br>Hora: {{ \Carbon\Carbon::parse($detalle->hora_llegada)->format('H:i') }}
                        @endif
                    </span>
                </li>
            @endforeach
        </ul>

        <div style="background-color: #fefce8; padding: 15px; border-left: 4px solid #eab308; margin: 20px 0;">
            <strong>Mensaje del establecimiento:</strong><br>
            {{ $motivo ?: 'Tus fechas han sido actualizadas.' }}
        </div>
        <p>Por favor, revisa los nuevos detalles con {{ $nombreEmprendimiento }}. Te esperamos.</p>
    </div>
</div>