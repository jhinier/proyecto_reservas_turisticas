<div style="font-family: sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
    <div style="background-color: #ef4444; color: white; padding: 20px; text-align: center;">
        <h2 style="margin: 0;">Reserva Cancelada</h2>
    </div>
    <div style="padding: 20px; color: #374151;">
        <p>Hola <strong>{{ $reserva->turista->name }}</strong>,</p>
        <p>Lamentamos informarte que la reserva para los siguientes servicios en <strong>{{ $nombreEmprendimiento }}</strong> fue cancelada:</p>
        
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

        <div style="background-color: #fef2f2; padding: 15px; border-left: 4px solid #ef4444; margin: 20px 0;">
            <strong>Motivo de la cancelación:</strong><br>
            {{ $motivo ?: 'No se especificó un motivo.' }}
        </div>
        <p>Si tienes dudas, por favor contacta a {{ $nombreEmprendimiento }}.</p>
    </div>
</div>