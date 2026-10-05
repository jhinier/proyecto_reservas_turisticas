<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña</title>
</head>
<body style="margin:0; padding:0; font-family:Arial, sans-serif; background-color:#f6f8fa;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f8fa; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 20px 60px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background-color:#0b8a0f; padding: 36px 32px; text-align:center; color:#ffffff;">
                            <img src="{{ asset('img/logo1.png') }}" alt="Explora Candelaria" width="68" height="68" style="display:block; margin:0 auto 16px; object-fit:contain;">
                            <h1 style="margin:0; font-size:28px; font-weight:800; letter-spacing:0.02em;">Explora Candelaria</h1>
                            <p style="margin:8px auto 0; max-width:420px; font-size:14px; color:#d9f6c9; line-height:1.7;">Recupera tu cuenta y continua explorando viajes, tours y experiencias en La Candelaria.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:36px 32px;">
                            <p style="margin:0 0 16px; font-size:16px; color:#111827;">Hola {{ $name }},</p>
                            <p style="margin:0 0 24px; font-size:15px; color:#4b5563; line-height:1.75;">Hemos recibido una solicitud para restablecer la contraseña de tu cuenta. Haz clic en el botón de abajo para continuar.</p>
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $url }}" target="_blank" style="display:inline-block; text-decoration:none; background-color:#0b8a0f; color:#ffffff; font-weight:700; padding:16px 28px; border-radius:999px; font-size:15px;">Restablecer mi contraseña</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:24px 0 12px; font-size:13px; color:#6b7280;">Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
                            <div style="word-break:break-all; background-color:#f3f4f6; border:1px solid #e5e7eb; border-radius:16px; padding:16px; font-size:13px; color:#111827; line-height:1.5;">{{ $url }}</div>
                            <p style="margin:24px 0 0; font-size:13px; color:#6b7280;">Si no solicitaste restablecer tu contraseña, puedes ignorar este correo con seguridad.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f3f4f6; padding:24px 32px; text-align:center; color:#6b7280; font-size:13px;">
                            Explora Candelaria · Turismo & Experiencias<br>
                            Avenida Principal, La Candelaria
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
