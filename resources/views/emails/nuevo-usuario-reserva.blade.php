<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de tu Reserva</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px; color: #333333; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { background-color: #1a4031; color: #ffffff; padding: 30px 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 1px; }
        .content { padding: 30px 20px; line-height: 1.6; }
        .reserva-box { background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin: 20px 0; }
        .reserva-box h3 { margin-top: 0; color: #1a4031; font-size: 18px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; text-transform: uppercase; }
        .reserva-item { margin-bottom: 8px; font-size: 14px; }
        .reserva-item strong { color: #475569; }
        .info-cuenta { background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px; margin: 20px 0; font-size: 14px; }
        .button-container { text-align: center; margin-top: 30px; }
        .button { background-color: #1a4031; color: #ffffff !important; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block; text-transform: uppercase; font-size: 13px; }
        .footer { background-color: #f8fafc; text-align: center; padding: 20px; font-size: 11px; color: #64748b; border-top: 1px solid #e2e8f0; }
        .badge-date { color: #1a4031; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Hola, {{ $turista->name }}!</h1>
        </div>
        
        <div class="content">
            <p>Tu reserva ha sido agendada y confirmada exitosamente en el <strong>Sistema Turístico GAD La Candelaria</strong>. Aquí tienes el resumen de tu itinerario:</p>
            
            <div class="reserva-box">
                <h3>Detalles de la Reserva</h3>
                @foreach($reserva->detalles as $detalle)
                <div style="margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #edf2f7;">
                    <div class="reserva-item">
                        <strong>Servicio:</strong> <span style="color: #1a4031; font-weight: 800;">{{ $detalle->servicio->nombre }}</span>
                    </div>
                    <div class="reserva-item">
                        <strong>Fecha:</strong> 
                        <span class="badge-date">
                            {{ \Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y') }}
                            @if($detalle->fecha_fin && $detalle->fecha_fin != $detalle->fecha_inicio)
                                al {{ \Carbon\Carbon::parse($detalle->fecha_fin)->format('d/m/Y') }}
                            @endif
                        </span>
                    </div>
                    @if($detalle->hora)
                    <div class="reserva-item">
                        <strong>Hora establecida:</strong> {{ \Carbon\Carbon::parse($detalle->hora)->format('H:i') }}
                    </div>
                    @endif
                    <div class="reserva-item">
                        <strong>Cantidad/Personas:</strong> {{ $detalle->cantidad }} (Para {{ $detalle->numero_personas }} pax)
                    </div>
                    <div class="reserva-item" style="text-align: right; margin-top: 5px;">
                        <strong>Subtotal:</strong> <span style="font-weight: bold; color: #1a4031;">${{ number_format($detalle->subtotal, 2) }}</span>
                    </div>
                </div>
                @endforeach
                
                <div style="text-align: right; margin-top: 15px; font-size: 18px;">
                    <strong style="color: #1a4031; text-transform: uppercase;">Total pagado:</strong> 
                    <span style="font-weight: 900; color: #1a4031;">${{ number_format($reserva->precio_total, 2) }}</span>
                </div>
            </div>

            <div class="info-cuenta">
                <strong>🔒 Información de acceso:</strong><br>
                Hemos creado un perfil para que puedas gestionar tus reservas y descargar tus comprobantes. <br><br>
                <strong>Usuario (Correo):</strong> {{ $turista->email }} <br>
                <strong>Contraseña temporal:</strong> <span style="background-color: #fff; padding: 2px 6px; border: 1px dashed #3b82f6; font-weight: bold;">{{ $passwordTemporal }}</span><br><br>
                <em>Nota: Por seguridad, te recomendamos cambiar tu contraseña en tu primer ingreso.</em>
            </div>

            <div class="button-container">
                <a href="{{ url('/login') }}" class="button">Acceder al Sistema</a>
            </div>
        </div>

        <div class="footer">
            <p><strong>GAD Parroquial La Candelaria - Chimborazo, Ecuador</strong></p>
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
        </div>
    </div>
</body>
</html>