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


        {{-- ========================================================
            MENSAJE PARA REPORTES DETALLADOS
        ========================================================= --}}
        @if($reporte !== 'general')

            <div class="p-5 border-t border-slate-100 sm:p-8">

                <div class="text-center">

                    <div class="text-5xl mb-4">

                        @if($reporte === 'festividades')
                            🎉
                        @elseif($reporte === 'sitios')
                            🏔️
                        @elseif($reporte === 'actividades')
                            🧗
                        @else
                            🏪
                        @endif

                    </div>


                    <h3 class="text-xl font-bold text-slate-800">

                        @if($reporte === 'festividades')
                            Reporte de Festividades
                        @elseif($reporte === 'sitios')
                            Reporte de Sitios Turísticos
                        @elseif($reporte === 'actividades')
                            Reporte de Actividades Turísticas
                        @else
                            Reporte de Emprendimientos
                        @endif

                    </h3>


                    <p class="text-sm text-slate-500 mt-2 max-w-xl mx-auto">
                        Presiona <strong>Generar PDF</strong> para obtener
                        el reporte completo correspondiente al módulo seleccionado.
                    </p>

                </div>

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
