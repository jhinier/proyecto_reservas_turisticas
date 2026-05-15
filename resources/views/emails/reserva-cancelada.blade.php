<div style="font-family: sans-serif; max-width: 600px; margin: 0 auto; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
    <div style="background-color: #ef4444; color: white; padding: 20px; text-align: center;">
        <h2 style="margin: 0;">Reserva Cancelada</h2>
    </div>
    <div style="padding: 20px; color: #374151;">
        <p>Hola <strong>{{ $reserva->turista->name }}</strong>,</p>
        <p>Lamentamos informarte que tu reserva <strong>#{{ $reserva->id }}</strong> ha sido cancelada por el establecimiento.</p>
        <div style="background-color: #fef2f2; padding: 15px; border-left: 4px solid #ef4444; margin: 20px 0;">
            <strong>Motivo de la cancelación:</strong><br>
            {{ $motivo ?: 'No se especificó un motivo.' }}
        </div>
        <p>Si tienes dudas, por favor contacta al emprendimiento.</p>
    </div>
</div>