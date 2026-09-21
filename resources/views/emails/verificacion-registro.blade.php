<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirma tu cuenta</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:20px;">
    <div style="max-width:600px; margin:0 auto; background:#ffffff; padding:30px; border-radius:10px;">
        <h2 style="margin-top:0;">Hola {{ $nombre }},</h2>

        <p>Gracias por registrarte en nuestro sistema.</p>

        <p>Para activar tu cuenta y comenzar a usarla, haz clic en el botón de abajo:</p>

        <p style="text-align:center; margin:30px 0;">
            <a href="{{ $url }}"
               style="background:#2563eb; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:8px; display:inline-block;">
                Confirmar mi cuenta
            </a>
        </p>

        <p>Si el botón no funciona, copia y pega esta URL en tu navegador:</p>
        <p style="word-break:break-all;">{{ $url }}</p>

        <p>Este enlace expirará en 30 minutos.</p>
    </div>
</body>
</html>
