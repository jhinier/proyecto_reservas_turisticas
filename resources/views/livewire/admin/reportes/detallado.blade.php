<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <title>{{ $titulo }}</title>

    <style>

        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #333;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #276a25;
        }

        .encabezado h1 {
            margin: 0;
            color: #276a25;
            font-size: 18px;
        }

        .encabezado h2 {
            margin: 8px 0 5px 0;
            font-size: 13px;
            font-weight: normal;
        }

        .encabezado p {
            margin: 4px 0;
            font-size: 10px;
        }

        .resumen {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .resumen td {
            border: 1px solid #d5d5d5;
            padding: 8px;
        }

        .resumen .etiqueta {
            background-color: #f1f1f1;
            font-weight: bold;
            width: 20%;
        }

        .datos {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .datos thead {
            display: table-header-group;
        }

        .datos th {
            background-color: #276a25;
            color: white;
            border: 1px solid #1f5720;
            padding: 7px 5px;
            text-align: center;
            font-size: 8.5px;
        }

        .datos td {
            border: 1px solid #cccccc;
            padding: 7px 5px;
            vertical-align: top;
            font-size: 8.5px;
        }

        .datos tr {
            page-break-inside: avoid;
        }

        .numero {
            width: 30px;
            text-align: center;
        }

        .estado {
            text-align: center;
        }

        .sin-datos {
            text-align: center;
            border: 1px solid #ccc;
            padding: 20px;
            margin-top: 15px;
        }

        .pie {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #777;
        }

    </style>

</head>


<body>
        @php
             $limpiarTexto = function ($texto) {

                 if ($texto === null) {
                     return '';
                 }

                 $texto = (string) $texto;

                 // Eliminar emojis y símbolos que DomPDF suele mostrar como cuadros
                 $texto = preg_replace(
                     '/[\x{1F000}-\x{1FAFF}\x{2600}-\x{27BF}\x{2300}-\x{23FF}\x{2B00}-\x{2BFF}\x{FE0F}\x{200D}]/u',
                     '',
                     $texto
                 );

                 return trim($texto);
             };
        @endphp

    {{-- ENCABEZADO --}}

    <div class="encabezado">

        <h1>
            GAD PARROQUIAL RURAL LA CANDELARIA
        </h1>

        <h2>
            {{ $titulo }}
        </h2>

        <p>
            Fecha de generación:
            {{ $fecha->format('d/m/Y H:i') }}
        </p>

    </div>


    {{-- RESUMEN --}}

    <table class="resumen">

        <tr>

            <td class="etiqueta">
                Módulo
            </td>

            <td>
                {{ $modulo }}
            </td>

            <td class="etiqueta">
                Total de registros
            </td>

            <td>
                {{ $total }}
            </td>

        </tr>

    </table>


    {{-- ===================================================== --}}
    {{-- FESTIVIDADES --}}
    {{-- ===================================================== --}}

    @if($tipo == 'festividades')

        @if($registros->count() > 0)

            <table class="datos">

                <thead>

                    <tr>
                        <th class="numero">#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha de inicio</th>
                        <th>Fecha de fin</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($registros as $indice => $registro)

                        <tr>

                            <td class="numero">
                                {{ $indice + 1 }}
                            </td>

                            <td>
                                {{ $limpiarTexto(optional($registro->publicacion)->nombre ?? 'Sin nombre') }}
                            </td>

                            <td>
                                {{ $limpiarTexto(optional($registro->publicacion)->descripcion ?? 'Sin descripción') }}
                            </td>

                            <td>
                               {{ $limpiarTexto($registro->recomendaciones ?? 'No registradas') }}
                            </td>

                            <td>
                                {{ $limpiarTexto($registro->fecha_fin ?? 'No registrada') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="sin-datos">
                No existen festividades registradas.
            </div>

        @endif

    @endif


    {{-- ===================================================== --}}
    {{-- SITIOS TURÍSTICOS --}}
    {{-- ===================================================== --}}

    @if($tipo == 'sitios')

        @if($registros->count() > 0)

            <table class="datos">

                <thead>

                    <tr>
                        <th class="numero">#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($registros as $indice => $registro)

                        <tr>

                            <td class="numero">
                                {{ $indice + 1 }}
                            </td>

                            <td>
                                {{ optional($registro->publicacion)->nombre ?? 'Sin nombre' }}
                            </td>

                            <td>
                                {{ optional($registro->publicacion)->descripcion ?? 'Sin descripción' }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="sin-datos">
                No existen sitios turísticos registrados.
            </div>

        @endif

    @endif


    {{-- ===================================================== --}}
    {{-- ACTIVIDADES TURÍSTICAS --}}
    {{-- ===================================================== --}}

    @if($tipo == 'actividades')

        @if($registros->count() > 0)

            <table class="datos">

                <thead>

                    <tr>
                        <th class="numero">#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Duración estimada</th>
                        <th>Dificultad</th>
                        <th>Recomendaciones</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($registros as $indice => $registro)

                        <tr>

                            <td class="numero">
                                {{ $indice + 1 }}
                            </td>

                            <td>
                                {{ optional($registro->publicacion)->nombre ?? 'Sin nombre' }}
                            </td>

                            <td>
                                {{ optional($registro->publicacion)->descripcion ?? 'Sin descripción' }}
                            </td>

                            <td>
                                {{ $registro->duracion_estimada ?? 'No registrada' }}
                            </td>

                            <td>
                                {{ $registro->dificultad ?? 'No registrada' }}
                            </td>

                            <td>
                                {{ $registro->recomendaciones ?? 'No registradas' }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="sin-datos">
                No existen actividades turísticas registradas.
            </div>

        @endif

    @endif


    {{-- ===================================================== --}}
    {{-- EMPRENDIMIENTOS --}}
    {{-- ===================================================== --}}

    @if($tipo == 'emprendimientos')

        @if($registros->count() > 0)

            <table class="datos">

                <thead>

                    <tr>
                        <th class="numero">#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Servicios</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach($registros as $indice => $registro)

                        <tr>

                            <td class="numero">
                                {{ $indice + 1 }}
                            </td>

                            <td>
                                {{ $registro->nombre ?? 'Sin nombre' }}
                            </td>

                            <td>
                                {{ $registro->descripcion ?? 'Sin descripción' }}
                            </td>

                            <td class="estado">

                                @if($registro->estado)
                                    Activo
                                @else
                                    Inactivo
                                @endif

                            </td>

                            <td>

                                @if($registro->tiposServicios && $registro->tiposServicios->count() > 0)

                                    {{ $registro->tiposServicios->pluck('nombre')->implode(', ') }}

                                @else

                                    No registrados

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="sin-datos">
                No existen emprendimientos registrados.
            </div>

        @endif

    @endif


    {{-- PIE --}}

    <div class="pie">

        Reporte generado automáticamente por el sistema
        de gestión turística del GAD Parroquial Rural La Candelaria.

    </div>

</body>

</html>