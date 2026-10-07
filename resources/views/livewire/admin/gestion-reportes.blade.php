<div class="space-y-6">

    {{-- ============================================================
        ENCABEZADO
    ============================================================ --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5 mb-8">

        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight sm:text-3xl">
                Reportes
            </h1>

            <p class="text-slate-500 mt-1 text-sm">
                Consulta y genera información consolidada del sistema turístico.
            </p>
        </div>

            <a
                href="{{ route('admin.reportes.pdf', ['tipo' => $reporte]) }}"
                target="_blank"
                class="bg-emerald-700 hover:bg-emerald-800
                       text-white px-5 py-3 rounded-2xl
                       shadow-md hover:shadow-lg
                       transition-all duration-300
                       flex w-full items-center justify-center gap-2 sm:w-auto
                       font-semibold text-sm"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z"
                    />
                </svg>

                Generar PDF
            </a>

    </div>


    {{-- ============================================================
        RESUMEN GENERAL
    ============================================================ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 mb-8">

        {{-- USUARIOS --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Usuarios
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ $usuarios }}
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-slate-100 flex items-center justify-center text-xl">
                    👥
                </div>

            </div>
        </div>


        {{-- EMPRENDIMIENTOS --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Emprendimientos
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ $emprendimientos }}
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-amber-50 flex items-center justify-center text-xl">
                    🏪
                </div>

            </div>
        </div>


        {{-- SITIOS --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Sitios turísticos
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ $sitios }}
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center text-xl">
                    🏔️
                </div>

            </div>
        </div>


        {{-- ACTIVIDADES --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Actividades
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ $actividades }}
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-blue-50 flex items-center justify-center text-xl">
                    🧗
                </div>

            </div>
        </div>


        {{-- FESTIVIDADES --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Festividades
                    </p>

                    <p class="text-3xl font-bold text-slate-800 mt-2">
                        {{ $festividades }}
                    </p>
                </div>

                <div class="w-11 h-11 rounded-xl bg-purple-50 flex items-center justify-center text-xl">
                    🎉
                </div>

            </div>
        </div>

    </div>


    {{-- ============================================================
        SELECTOR DE REPORTES
    ============================================================ --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="p-5 border-b border-slate-200 bg-slate-50/70">

            <h2 class="text-sm font-bold text-slate-800">
                Tipo de reporte
            </h2>

            <p class="text-xs text-slate-500 mt-1">
                Selecciona la información que deseas consultar.
            </p>

        </div>


        {{-- BOTONES --}}
        <div class="p-5">

            <div class="flex flex-wrap gap-2">

                {{-- GENERAL --}}
                <button
                    wire:click="cambiarReporte('general')"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold border transition
                    {{ $reporte === 'general'
                        ? 'bg-slate-800 text-white border-slate-800'
                        : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-50'
                    }}"
                >
                    📊 General
                </button>


                {{-- FESTIVIDADES --}}
                <button
                    wire:click="cambiarReporte('festividades')"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold border transition
                    {{ $reporte === 'festividades'
                        ? 'bg-purple-600 text-white border-purple-600'
                        : 'bg-white text-purple-700 border-purple-200 hover:bg-purple-50'
                    }}"
                >
                    🎉 Festividades
                </button>


                {{-- SITIOS --}}
                <button
                    wire:click="cambiarReporte('sitios')"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold border transition
                    {{ $reporte === 'sitios'
                        ? 'bg-emerald-600 text-white border-emerald-600'
                        : 'bg-white text-emerald-700 border-emerald-200 hover:bg-emerald-50'
                    }}"
                >
                    🏔️ Sitios turísticos
                </button>


                {{-- ACTIVIDADES --}}
                <button
                    wire:click="cambiarReporte('actividades')"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold border transition
                    {{ $reporte === 'actividades'
                        ? 'bg-blue-600 text-white border-blue-600'
                        : 'bg-white text-blue-700 border-blue-200 hover:bg-blue-50'
                    }}"
                >
                    🧗 Actividades
                </button>


                {{-- EMPRENDIMIENTOS --}}
                <button
                    wire:click="cambiarReporte('emprendimientos')"
                    class="px-4 py-2.5 rounded-xl text-xs font-bold border transition
                    {{ $reporte === 'emprendimientos'
                        ? 'bg-amber-600 text-white border-amber-600'
                        : 'bg-white text-amber-700 border-amber-200 hover:bg-amber-50'
                    }}"
                >
                    🏪 Emprendimientos
                </button>

            </div>

        </div>


        {{-- ========================================================
            REPORTE GENERAL
        ========================================================= --}}
        @if($reporte === 'general')

            <div class="p-5 border-t border-slate-100">

                <div class="mb-5">

                    <h3 class="text-lg font-bold text-slate-800">
                        Reporte general del sistema
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Resumen de los principales módulos de gestión turística.
                    </p>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full min-w-[520px] text-sm">

                        <thead class="bg-slate-50 border-b border-slate-200">

                            <tr>

                                <th class="px-5 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Módulo
                                </th>

                                <th class="px-5 py-4 text-center text-xs font-bold uppercase tracking-wider text-slate-500">
                                    Registros
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr class="border-b border-slate-100">

                                <td class="px-5 py-4 font-semibold text-slate-700">
                                    👥 Usuarios
                                </td>

                                <td class="px-5 py-4 text-center font-bold text-slate-800">
                                    {{ $usuarios }}
                                </td>

                            </tr>


                            <tr class="border-b border-slate-100">

                                <td class="px-5 py-4 font-semibold text-slate-700">
                                    🏪 Emprendimientos
                                </td>

                                <td class="px-5 py-4 text-center font-bold text-slate-800">
                                    {{ $emprendimientos }}
                                </td>

                            </tr>


                            <tr class="border-b border-slate-100">

                                <td class="px-5 py-4 font-semibold text-slate-700">
                                    🏔️ Sitios turísticos
                                </td>

                                <td class="px-5 py-4 text-center font-bold text-slate-800">
                                    {{ $sitios }}
                                </td>

                            </tr>


                            <tr class="border-b border-slate-100">

                                <td class="px-5 py-4 font-semibold text-slate-700">
                                    🧗 Actividades turísticas
                                </td>

                                <td class="px-5 py-4 text-center font-bold text-slate-800">
                                    {{ $actividades }}
                                </td>

                            </tr>


                            <tr>

                                <td class="px-5 py-4 font-semibold text-slate-700">
                                    🎉 Festividades
                                </td>

                                <td class="px-5 py-4 text-center font-bold text-slate-800">
                                    {{ $festividades }}
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        @endif

        {{-- ============================================================
        VISTA PREVIA DEL REPORTE
        ============================================================ --}}

        <div class="border-t border-slate-100">

        {{-- ========================================================
            VISTA PREVIA GENERAL
        ========================================================= --}}
                <div class="p-5 border-t border-slate-100 sm:p-8">

    @if($reporte === 'general')

        <div class="p-5">

            <div class="mb-6">

                <h3 class="text-lg font-bold text-slate-800">
                    Vista previa del reporte general
                </h3>

                <p class="text-sm text-slate-500 mt-1">
                    Consulta toda la información registrada antes de generar el PDF.
                </p>

            </div>


            {{-- RESUMEN --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 mb-8">

                <div class="bg-slate-50 border border-slate-200 rounded-xl p-4">
                    <p class="text-xs text-slate-500 font-semibold">
                        Usuarios
                    </p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">
                        {{ $usuarios }}
                    </p>
                </div>

                <div class="bg-purple-50 border border-purple-100 rounded-xl p-4">
                    <p class="text-xs text-purple-600 font-semibold">
                        Festividades
                    </p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">
                        {{ $festividades }}
                    </p>
                </div>

                <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4">
                    <p class="text-xs text-emerald-600 font-semibold">
                        Sitios turísticos
                    </p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">
                        {{ $sitios }}
                    </p>
                </div>

                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                    <p class="text-xs text-blue-600 font-semibold">
                        Actividades
                    </p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">
                        {{ $actividades }}
                    </p>
                </div>

                <div class="bg-amber-50 border border-amber-100 rounded-xl p-4">
                    <p class="text-xs text-amber-600 font-semibold">
                        Emprendimientos
                    </p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">
                        {{ $emprendimientos }}
                    </p>
                </div>

            </div>


            {{-- ==================================================
                FESTIVIDADES
            =================================================== --}}

            <div class="mb-10">

                <div class="flex items-center justify-between mb-4">

                    <div>

                        <h4 class="text-base font-bold text-slate-800">
                            🎉 Festividades
                        </h4>

                        <p class="text-xs text-slate-500">
                            {{ $listaFestividades->count() }} registros encontrados
                        </p>

                    </div>

                </div>


                @if($listaFestividades->count() > 0)

                    <div class="overflow-x-auto border border-slate-200 rounded-xl">

                        <table class="w-full text-sm">

                            <thead class="bg-slate-50">

                                <tr>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        #
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Nombre
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Descripción
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Fecha inicio
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Fecha fin
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                @foreach($listaFestividades as $indice => $registro)

                                    <tr class="hover:bg-slate-50">

                                        <td class="px-4 py-3 text-slate-500">
                                            {{ $indice + 1 }}
                                        </td>

                                        <td class="px-4 py-3 font-semibold text-slate-700">
                                            {{ optional($registro->publicacion)->nombre ?? 'Sin nombre' }}
                                        </td>

                                        <td class="px-4 py-3 text-slate-600">
                                            {{ optional($registro->publicacion)->descripcion ?? 'Sin descripción' }}
                                        </td>

                                        <td class="px-4 py-3 text-slate-600">
                                            {{ $registro->fecha_inicio ?? 'No registrada' }}
                                        </td>

                                        <td class="px-4 py-3 text-slate-600">
                                            {{ $registro->fecha_fin ?? 'No registrada' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="p-6 text-center border border-slate-200 rounded-xl text-sm text-slate-500">
                        No existen festividades registradas.
                    </div>

                @endif

            </div>


            {{-- ==================================================
                SITIOS TURÍSTICOS
            =================================================== --}}

            <div class="mb-10">

                <div class="mb-4">

                    <h4 class="text-base font-bold text-slate-800">
                        🏔️ Sitios turísticos
                    </h4>

                    <p class="text-xs text-slate-500">
                        {{ $listaSitios->count() }} registros encontrados
                    </p>

                </div>


                @if($listaSitios->count() > 0)

                    <div class="overflow-x-auto border border-slate-200 rounded-xl">

                        <table class="w-full text-sm">

                            <thead class="bg-slate-50">

                                <tr>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        #
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Nombre
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Descripción
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                @foreach($listaSitios as $indice => $registro)

                                    <tr class="hover:bg-slate-50">

                                        <td class="px-4 py-3 text-slate-500">
                                            {{ $indice + 1 }}
                                        </td>

                                        <td class="px-4 py-3 font-semibold text-slate-700">
                                            {{ optional($registro->publicacion)->nombre ?? 'Sin nombre' }}
                                        </td>

                                        <td class="px-4 py-3 text-slate-600">
                                            {{ optional($registro->publicacion)->descripcion ?? 'Sin descripción' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="p-6 text-center border border-slate-200 rounded-xl text-sm text-slate-500">
                        No existen sitios turísticos registrados.
                    </div>

                @endif

            </div>


            {{-- ==================================================
                ACTIVIDADES
            =================================================== --}}

            <div class="mb-10">

                <div class="mb-4">

                    <h4 class="text-base font-bold text-slate-800">
                        🧗 Actividades turísticas
                    </h4>

                    <p class="text-xs text-slate-500">
                        {{ $listaActividades->count() }} registros encontrados
                    </p>

                </div>


                @if($listaActividades->count() > 0)

                    <div class="overflow-x-auto border border-slate-200 rounded-xl">

                        <table class="w-full text-sm">

                            <thead class="bg-slate-50">

                                <tr>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        #
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Nombre
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Descripción
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Duración
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Dificultad
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Recomendaciones
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                @foreach($listaActividades as $indice => $registro)

                                    <tr class="hover:bg-slate-50">

                                        <td class="px-4 py-3 text-slate-500">
                                            {{ $indice + 1 }}
                                        </td>

                                        <td class="px-4 py-3 font-semibold text-slate-700">
                                            {{ optional($registro->publicacion)->nombre ?? 'Sin nombre' }}
                                        </td>

                                        <td class="px-4 py-3 text-slate-600">
                                            {{ optional($registro->publicacion)->descripcion ?? 'Sin descripción' }}
                                        </td>

                                        <td class="px-4 py-3 text-slate-600">
                                            {{ $registro->duracion_estimada ?? 'No registrada' }}
                                        </td>

                                        <td class="px-4 py-3 text-slate-600">
                                            {{ $registro->dificultad ?? 'No registrada' }}
                                        </td>

                                        <td class="px-4 py-3 text-slate-600">
                                            {{ $registro->recomendaciones ?? 'No registradas' }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="p-6 text-center border border-slate-200 rounded-xl text-sm text-slate-500">
                        No existen actividades turísticas registradas.
                    </div>

                @endif

            </div>


            {{-- ==================================================
                EMPRENDIMIENTOS
            =================================================== --}}

            <div class="mb-5">

                <div class="mb-4">

                    <h4 class="text-base font-bold text-slate-800">
                        🏪 Emprendimientos
                    </h4>

                    <p class="text-xs text-slate-500">
                        {{ $listaEmprendimientos->count() }} registros encontrados
                    </p>

                </div>


                @if($listaEmprendimientos->count() > 0)

                    <div class="overflow-x-auto border border-slate-200 rounded-xl">

                        <table class="w-full text-sm">

                            <thead class="bg-slate-50">

                                <tr>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        #
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Nombre
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Descripción
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Estado
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-bold text-slate-500">
                                        Servicios
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-slate-100">

                                @foreach($listaEmprendimientos as $indice => $registro)

                                    <tr class="hover:bg-slate-50">

                                        <td class="px-4 py-3 text-slate-500">
                                            {{ $indice + 1 }}
                                        </td>

                                        <td class="px-4 py-3 font-semibold text-slate-700">
                                            {{ $registro->nombre ?? 'Sin nombre' }}
                                        </td>

                                        <td class="px-4 py-3 text-slate-600">
                                            {{ $registro->descripcion ?? 'Sin descripción' }}
                                        </td>

                                        <td class="px-4 py-3">

                                            @if($registro->estado)

                                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                                    Activo
                                                </span>

                                            @else

                                                <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                                    Inactivo
                                                </span>

                                            @endif

                                        </td>

                                        <td class="px-4 py-3 text-slate-600">

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

                    </div>

                @else

                    <div class="p-6 text-center border border-slate-200 rounded-xl text-sm text-slate-500">
                        No existen emprendimientos registrados.
                    </div>

                @endif

            </div>

        </div>


    {{-- ========================================================
        VISTA PREVIA INDIVIDUAL
    ========================================================= --}}

    @else

        <div class="p-5">

            {{-- ENCABEZADO DE LA VISTA PREVIA --}}

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-5">

                <div>

                    <h3 class="text-lg font-bold text-slate-800">

                        @if($reporte === 'festividades')
                            Vista previa de Festividades
                        @elseif($reporte === 'sitios')
                            Vista previa de Sitios Turísticos
                        @elseif($reporte === 'actividades')
                            Vista previa de Actividades Turísticas
                        @else
                            Vista previa de Emprendimientos
                        @endif

                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        Consulta los registros antes de generar el PDF.
                    </p>

                </div>


                {{-- TOTAL --}}

                <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">

                    <span class="text-xs text-slate-500">
                        Total de registros
                    </span>

                    <span class="ml-2 text-lg font-bold text-slate-800">

                        @if($reporte === 'festividades')
                            {{ $listaFestividades->count() }}
                        @elseif($reporte === 'sitios')
                            {{ $listaSitios->count() }}
                        @elseif($reporte === 'actividades')
                            {{ $listaActividades->count() }}
                        @else
                            {{ $listaEmprendimientos->count() }}
                        @endif

                    </span>

                </div>

            </div>


            {{-- ==================================================
                FESTIVIDADES
            =================================================== --}}

                @if($reporte === 'festividades')

                    @if($listaFestividades->count() > 0)

                        <div class="overflow-x-auto border border-slate-200 rounded-xl">

                            <table class="w-full text-sm">

                                <thead class="bg-purple-50">

                                    <tr>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-purple-700">
                                            #
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-purple-700">
                                            Nombre
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-purple-700">
                                            Descripción
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-purple-700">
                                            Fecha de inicio
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-purple-700">
                                            Fecha de fin
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach($listaFestividades as $indice => $registro)

                                        <tr class="hover:bg-purple-50/40">

                                            <td class="px-4 py-3 text-slate-500">
                                                {{ $indice + 1 }}
                                            </td>

                                            <td class="px-4 py-3 font-semibold text-slate-700">
                                                {{ optional($registro->publicacion)->nombre ?? 'Sin nombre' }}
                                            </td>

                                            <td class="px-4 py-3 text-slate-600">
                                                {{ optional($registro->publicacion)->descripcion ?? 'Sin descripción' }}
                                            </td>

                                            <td class="px-4 py-3 text-slate-600">
                                                {{ $registro->fecha_inicio ?? 'No registrada' }}
                                            </td>

                                            <td class="px-4 py-3 text-slate-600">
                                                {{ $registro->fecha_fin ?? 'No registrada' }}
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="p-8 text-center border border-slate-200 rounded-xl text-sm text-slate-500">
                            No existen festividades registradas.
                        </div>

                    @endif

                @endif


                {{-- ==================================================
                    SITIOS
                =================================================== --}}

                @if($reporte === 'sitios')

                    @if($listaSitios->count() > 0)

                        <div class="overflow-x-auto border border-slate-200 rounded-xl">

                            <table class="w-full text-sm">

                                <thead class="bg-emerald-50">

                                    <tr>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-emerald-700">
                                            #
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-emerald-700">
                                            Nombre
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-emerald-700">
                                            Descripción
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach($listaSitios as $indice => $registro)

                                        <tr class="hover:bg-emerald-50/40">

                                            <td class="px-4 py-3 text-slate-500">
                                                {{ $indice + 1 }}
                                            </td>

                                            <td class="px-4 py-3 font-semibold text-slate-700">
                                                {{ optional($registro->publicacion)->nombre ?? 'Sin nombre' }}
                                            </td>

                                            <td class="px-4 py-3 text-slate-600">
                                                {{ optional($registro->publicacion)->descripcion ?? 'Sin descripción' }}
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="p-8 text-center border border-slate-200 rounded-xl text-sm text-slate-500">
                            No existen sitios turísticos registrados.
                        </div>

                    @endif

                @endif


                {{-- ==================================================
                    ACTIVIDADES
                =================================================== --}}

                @if($reporte === 'actividades')

                    @if($listaActividades->count() > 0)

                        <div class="overflow-x-auto border border-slate-200 rounded-xl">

                            <table class="w-full text-sm">

                                <thead class="bg-blue-50">

                                    <tr>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-700">
                                            #
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-700">
                                            Nombre
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-700">
                                            Descripción
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-700">
                                            Duración
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-700">
                                            Dificultad
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-blue-700">
                                            Recomendaciones
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach($listaActividades as $indice => $registro)

                                        <tr class="hover:bg-blue-50/40">

                                            <td class="px-4 py-3 text-slate-500">
                                                {{ $indice + 1 }}
                                            </td>

                                            <td class="px-4 py-3 font-semibold text-slate-700">
                                                {{ optional($registro->publicacion)->nombre ?? 'Sin nombre' }}
                                            </td>

                                            <td class="px-4 py-3 text-slate-600">
                                                {{ optional($registro->publicacion)->descripcion ?? 'Sin descripción' }}
                                            </td>

                                            <td class="px-4 py-3 text-slate-600">
                                                {{ $registro->duracion_estimada ?? 'No registrada' }}
                                            </td>

                                            <td class="px-4 py-3 text-slate-600">
                                                {{ $registro->dificultad ?? 'No registrada' }}
                                            </td>

                                            <td class="px-4 py-3 text-slate-600">
                                                {{ $registro->recomendaciones ?? 'No registradas' }}
                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="p-8 text-center border border-slate-200 rounded-xl text-sm text-slate-500">
                            No existen actividades turísticas registradas.
                        </div>

                    @endif

                @endif


                {{-- ==================================================
                    EMPRENDIMIENTOS
                =================================================== --}}

                @if($reporte === 'emprendimientos')

                    @if($listaEmprendimientos->count() > 0)

                        <div class="overflow-x-auto border border-slate-200 rounded-xl">

                            <table class="w-full text-sm">

                                <thead class="bg-amber-50">

                                    <tr>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-amber-700">
                                            #
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-amber-700">
                                            Nombre
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-amber-700">
                                            Descripción
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-amber-700">
                                            Estado
                                        </th>

                                        <th class="px-4 py-3 text-left text-xs font-bold text-amber-700">
                                            Servicios
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="divide-y divide-slate-100">

                                    @foreach($listaEmprendimientos as $indice => $registro)

                                        <tr class="hover:bg-amber-50/40">

                                            <td class="px-4 py-3 text-slate-500">
                                                {{ $indice + 1 }}
                                            </td>

                                            <td class="px-4 py-3 font-semibold text-slate-700">
                                                {{ $registro->nombre ?? 'Sin nombre' }}
                                            </td>

                                            <td class="px-4 py-3 text-slate-600">
                                                {{ $registro->descripcion ?? 'Sin descripción' }}
                                            </td>

                                            <td class="px-4 py-3">

                                                @if($registro->estado)

                                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                                        Activo
                                                    </span>

                                                @else

                                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700">
                                                        Inactivo
                                                    </span>

                                                @endif

                                            </td>

                                            <td class="px-4 py-3 text-slate-600">

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

                        </div>

                    @else

                        <div class="p-8 text-center border border-slate-200 rounded-xl text-sm text-slate-500">
                            No existen emprendimientos registrados.
                        </div>

                    @endif

                @endif

            </div>

        @endif

    </div>


    {{-- FECHA --}}
    <div class="mt-5 text-right">

        <p class="text-xs text-slate-400">
            Última consulta:
            <span class="font-semibold">
                {{ $fecha->format('d/m/Y H:i') }}
            </span>
        </p>

    </div>

</div>
