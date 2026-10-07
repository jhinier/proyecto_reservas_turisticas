<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            color: #374151;
            margin: 0;
            padding: 20px;
            line-height: 1.5;
        }
        .contenedor {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .cabecera {
            background-color: #1a4031;
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }
        .cabecera h1 {
            margin: 0;
            font-size: 22px;
        }
        .cuerpo {
            padding: 24px;
        }
        .credenciales {
            background-color: #ecfdf5;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #10b981;
            border-radius: 6px;
            padding: 16px;
            margin: 20px 0;
            font-size: 14px;
        }
        .credenciales p {
            margin: 0 0 10px 0;
        }
        .credenciales p:last-child {
            margin-bottom: 0;
        }
        .valor {
            display: inline-block;
            margin-top: 4px;
            padding: 4px 8px;
            background-color: #ffffff;
            border: 1px dashed #10b981;
            border-radius: 4px;
            color: #064e3b;
            font-weight: 700;
            word-break: break-all;
        }
        .boton {
            display: inline-block;
            background-color: #1a4031;
            color: #ffffff !important;
            padding: 12px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
        }
        .centro {
            text-align: center;
            margin: 26px 0 12px 0;
        }
        .nota {
            color: #6b7280;
            font-size: 13px;
        }
        .pie {
            text-align: center;
            padding: 18px 24px;
            font-size: 12px;
            color: #9ca3af;
            background-color: #f9fafb;
            border-top: 1px solid #f3f4f6;
        }
    </style>
</head>
<body>
    <div class="contenedor">
        <div class="cabecera">
            <h1>Cuenta de emprendimiento creada</h1>
        </div>

        <div class="cuerpo">
            <p>Hola <strong>{{ $nombreCompleto }}</strong>,</p>
            <p>El GAD La Candelaria ha creado tu cuenta para administrar el emprendimiento <strong>{{ $emprendimiento->nombre }}</strong>.</p>

            <div class="credenciales">
                <p>
                    <strong>Usuario / correo:</strong><br>
                    <span class="valor">{{ $usuario->email }}</span>
                </p>
                <p>
                    <strong>Contrasena:</strong><br>
                    <span class="valor">{{ $passwordPlano }}</span>
                </p>
            </div>

            <p class="nota">Por seguridad, te recomendamos cambiar tu contrasena despues de ingresar por primera vez.</p>

            <div class="centro">
                <a href="{{ url('/login') }}" class="boton">Ingresar al sistema</a>
            </div>
        </div>

        <div class="pie">
            <p>Este es un correo automatico, por favor no respondas a esta direccion.</p>
        </div>
    </div>
</body>
</html>
