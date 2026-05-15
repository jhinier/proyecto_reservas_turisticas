<div style="font-family: sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
    <div style="background-color: #eab308; color: white; padding: 20px; text-align: center;">
        <h2 style="margin: 0;">Reserva Reagendada</h2>
    </div>
    <div style="padding: 20px; color: #374151;">
        <p>Hola <strong>{{ $reserva->turista->name }}</strong>,</p>
        <p>Tu reserva <strong>#{{ $reserva->id }}</strong> ha sido modificada y reagendada para nuevas fechas.</p>
        <div style="background-color: #fefce8; padding: 15px; border-left: 4px solid #eab308; margin: 20px 0;">
            <strong>Mensaje del establecimiento:</strong><br>
            {{ $motivo ?: 'Tus fechas han sido actualizadas.' }}
        </div>
        <p>Por favor, revisa los nuevos detalles con el establecimiento. Te esperamos.</p>
    </div>
</div>