<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            align-items: center;
            background: #f3f6fa;
            color: #1f2937;
            display: flex;
            font-family: Arial, sans-serif;
            justify-content: center;
            margin: 0;
            min-height: 100vh;
            padding: 24px;
        }
        main {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 12px 35px rgba(15, 23, 42, .12);
            max-width: 520px;
            padding: 42px 32px;
            text-align: center;
            width: 100%;
        }
        .icon {
            align-items: center;
            background: #dcfce7;
            border-radius: 50%;
            color: #15803d;
            display: inline-flex;
            font-size: 30px;
            height: 64px;
            justify-content: center;
            width: 64px;
        }
        h1 { font-size: 26px; margin: 22px 0 12px; }
        p { color: #64748b; line-height: 1.6; margin: 0 0 28px; }
        .actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        a {
            background: #2563eb;
            border-radius: 8px;
            color: #fff;
            padding: 12px 22px;
            text-decoration: none;
        }
        a.secondary { background: #e2e8f0; color: #334155; }
    </style>
</head>
<body>
    <main>
        <div class="icon">&#10003;</div>
        <h1>{{ $titulo }}</h1>
        <p>{{ $mensaje }}</p>
        <div class="actions">
            <a href="{{ route('dashboard') }}">Ir a mi cuenta</a>
            <a class="secondary" href="{{ route('home') }}">Volver al inicio</a>
        </div>
    </main>
</body>
</html>
