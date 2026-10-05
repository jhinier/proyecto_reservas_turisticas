<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Reporte General</title>

    <style>

        @page {
            margin: 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
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
            font-size: 9px;
        }

        .resumen {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .resumen th {
            background-color: #276a25;
            color: white;
            border: 1px solid #1f5720;
            padding: 7px;
            font-size: 9px;
        }

        .resumen td {
            border: 1px solid #ccc;
            padding: 7px;
            text-align: center;
            font-size: 10px;
        }

        .seccion {
            margin-top: 25px;
            margin-bottom: 10px;
            padding: 7px;
            background-color: #276a25;
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .datos {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .datos thead {
            display: table-header-group;
        }

        .datos th {
            background-color: #e8eee8;
            color: #333;
            border: 1px solid #aaa;
            padding: 6px 4px;
            text-align: center;
            font-size: 8px;
        }

        .datos td {
            border: 1px solid #ccc;
            padding: 6px 4px;
            vertical-align: top;
            font-size: 8px;
        }

        .datos tr {
            page-break-inside: avoid;
        }

        .numero {
            width: 25px;
            text-align: center;
        }

        .centrado {
            text-align: center;
        }

        .sin-datos {
            border: 1px solid #ccc;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        .pie {
            margin-top: 25px;
            text-align: center;
            font-size: 7px;
            color: #777;
        }

    </style>

</head>


<body>

@php

    /*
    |--------------------------------------------------------------------------
    | Función para limpiar emojis solamente en el PDF
    |--------------------------------------------------------------------------
    */

    $limpiarTexto = function ($texto) {

        if ($texto === null) {
            return '';
        }

        $texto = (string) $texto;

        $texto = preg_replace(
            '/[\x{1F000}-\x{1FAFF}\x{2600}-\x{27BF}\x{2300}-\x{23FF}\x{2B00}-\x{2BFF}\x{FE0F}\x{200D}]/u',
            '',
            $texto
        );

        return trim($texto);
    };

@endphp


{{-- ========================================================= --}}
{{-- ENCABEZADO --}}
{{-- ========================================================= --}}

<div class="encabezado">

    <h1>
        GAD PARROQUIAL RURAL LA CANDELARIA
    </h1>

    <h2>
        REPORTE GENERAL
    </h2>

    <p>
        Fecha de generación:
        {{ $fecha->format('d/m/Y H:i') }}
    </p>

</div>


{{-- ========================================================= --}}
{{-- RESUMEN GENERAL --}}
{{-- ========================================================= --}}

<table class="resumen">

    <thead>

        <tr>

            <th>Usuarios</th>

            <th>Festividades</th>

            <th>Sitios turísticos</th>

            <th>Actividades turísticas</th>

            <th>Emprendimientos</th>

        </tr>

    </thead>

    <tbody>

        <tr>

            <td>
                {{ $usuarios }}
            </td>

            <td>
                {{ $totalFestividades }}
            </td>

            <td>
                {{ $totalSitios }}
            </td>

            <td>
                {{ $totalActividades }}
            </td>

            <td>
                {{ $totalEmprendimientos }}
            </td>

        </tr>

    </tbody>

</table>


{{-- ========================================================= --}}
{{-- FESTIVIDADES --}}
{{-- ========================================================= --}}

<div class="seccion">
    1. FESTIVIDADES
</div>

@if($festividades->count() > 0)

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

            @foreach($festividades as $indice => $registro)

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
                        {{ $registro->fecha_inicio ?? 'No registrada' }}
                    </td>

                    <td>
                        {{ $registro->fecha_fin ?? 'No registrada' }}
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


{{-- ========================================================= --}}
{{-- SITIOS TURÍSTICOS --}}
{{-- ========================================================= --}}

<div class="seccion">
    2. SITIOS TURÍSTICOS
</div>

@if($sitios->count() > 0)

    <table class="datos">

        <thead>

            <tr>

                <th class="numero">#</th>

                <th>Nombre</th>

                <th>Descripción</th>

            </tr>

        </thead>

        <tbody>

            @foreach($sitios as $indice => $registro)

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

                </tr>

            @endforeach

        </tbody>

    </table>

@else

    <div class="sin-datos">
        No existen sitios turísticos registrados.
    </div>

@endif


{{-- ========================================================= --}}
{{-- ACTIVIDADES TURÍSTICAS --}}
{{-- ========================================================= --}}

<div class="seccion">
    3. ACTIVIDADES TURÍSTICAS
</div>

@if($actividades->count() > 0)

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

            @foreach($actividades as $indice => $registro)

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
                        {{ $limpiarTexto($registro->duracion_estimada ?? 'No registrada') }}
                    </td>

                    <td>
                        {{ $limpiarTexto($registro->dificultad ?? 'No registrada') }}
                    </td>

                    <td>
                        {{ $limpiarTexto($registro->recomendaciones ?? 'No registradas') }}
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


{{-- ========================================================= --}}
{{-- EMPRENDIMIENTOS --}}
{{-- ========================================================= --}}

<div class="seccion">
    4. EMPRENDIMIENTOS
</div>

@if($emprendimientos->count() > 0)

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

            @foreach($emprendimientos as $indice => $registro)

                <tr>

                    <td class="numero">
                        {{ $indice + 1 }}
                    </td>

                    <td>
                        {{ $limpiarTexto($registro->nombre ?? 'Sin nombre') }}
                    </td>

                    <td>
                        {{ $limpiarTexto($registro->descripcion ?? 'Sin descripción') }}
                    </td>

                    <td class="centrado">

                        @if($registro->estado)
                            Activo
                        @else
                            Inactivo
                        @endif

                    </td>

                    <td>

                        @if($registro->tiposServicios && $registro->tiposServicios->count() > 0)

                            {{ $limpiarTexto(
                                $registro->tiposServicios
                                    ->pluck('nombre')
                                    ->implode(', ')
                            ) }}

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


{{-- ========================================================= --}}
{{-- PIE --}}
{{-- ========================================================= --}}

<div class="pie">

    Reporte generado automáticamente por el sistema
    de gestión turística del GAD Parroquial Rural La Candelaria.

</div>


</body>

</html>