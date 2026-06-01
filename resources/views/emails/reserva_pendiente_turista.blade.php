<!DOCTYPE html>
<html>
<head>
    <title>Reserva Pendiente</title>
</head>
<body>
    <h1>Hola {{ $reserva->turista->name }},</h1>
    <p>Hemos recibido tu reserva #{{ $reserva->id }} y actualmente se encuentra <strong>Pendiente</strong>.</p>
    <p>El establecimiento revisará la disponibilidad. Una vez confirmada, tendrás 24 horas para realizar el pago.</p>
    <br>
    <p>Gracias por usar Explora Candelaria.</p>
</body>
</html>