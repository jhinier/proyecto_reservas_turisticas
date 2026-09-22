<div class="mx-auto max-w-7xl space-y-8">

    {{-- CABECERA --}}
    <div class="rounded-3xl bg-gradient-to-r from-emerald-600 to-green-500 p-8 shadow text-white">

        <h1 class="text-3xl font-bold">
            📊 Centro de Reportes
        </h1>

        <p class="mt-2 text-emerald-100">
            Consulte la información estadística y administrativa del sistema.
        </p>

    </div>

    {{-- TARJETAS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

        {{-- GENERAL --}}
        <button
            wire:click="cambiarReporte('general')"
            class="rounded-3xl bg-white shadow p-6 text-left hover:shadow-lg transition">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="font-bold text-xl">
                        📈 Reporte General
                    </h2>

                    <p class="text-sm text-gray-500 mt-2">
                        Resumen general del sistema.
                    </p>

                </div>

            </div>

        </button>

        {{-- EMPRENDIMIENTOS --}}
        <button
            wire:click="cambiarReporte('emprendimientos')"
            class="rounded-3xl bg-white shadow p-6 text-left hover:shadow-lg transition">

            <h2 class="font-bold text-xl">

                🏪 Emprendimientos

            </h2>

            <p class="text-sm text-gray-500 mt-2">

                Información de los emprendimientos registrados.

            </p>

        </button>

        {{-- RESERVAS --}}
        <button
            wire:click="cambiarReporte('reservas')"
            class="rounded-3xl bg-white shadow p-6 text-left hover:shadow-lg transition">

            <h2 class="font-bold text-xl">

                📅 Reservas

            </h2>

            <p class="text-sm text-gray-500 mt-2">

                Reporte de reservas realizadas.

            </p>

        </button>

        {{-- SITIOS --}}
        <button
            wire:click="cambiarReporte('sitios')"
            class="rounded-3xl bg-white shadow p-6 text-left hover:shadow-lg transition">

            <h2 class="font-bold text-xl">

                🗺 Sitios Turísticos

            </h2>

            <p class="text-sm text-gray-500 mt-2">

                Sitios turísticos registrados.

            </p>

        </button>

        {{-- ACTIVIDADES --}}
        <button
            wire:click="cambiarReporte('actividades')"
            class="rounded-3xl bg-white shadow p-6 text-left hover:shadow-lg transition">

            <h2 class="font-bold text-xl">

                🎯 Actividades

            </h2>

            <p class="text-sm text-gray-500 mt-2">

                Actividades turísticas.

            </p>

        </button>

        {{-- FESTIVIDADES --}}
        <button
            wire:click="cambiarReporte('festividades')"
            class="rounded-3xl bg-white shadow p-6 text-left hover:shadow-lg transition">

            <h2 class="font-bold text-xl">

                🎉 Festividades

            </h2>

            <p class="text-sm text-gray-500 mt-2">

                Festividades registradas.

            </p>

        </button>

    </div>

    {{-- CONTENIDO DEL REPORTE --}}
    <div class="rounded-3xl bg-white shadow p-8">

        @switch($reporte)

            @case('general')

                <h2 class="text-2xl font-bold text-emerald-700">

                    📈 Reporte General

                </h2>

                <p class="mt-3 text-gray-500">

                    Aquí aparecerán las estadísticas generales del sistema.

                </p>

            @break

            @case('emprendimientos')

                @livewire('admin.reportes.emprendimientos')

            @break

            @case('reservas')

                <h2 class="text-2xl font-bold">

                    📅 Reporte de Reservas

                </h2>

                <p class="mt-3 text-gray-500">

                    Próximamente...

                </p>

            @break

            @case('sitios')

                <h2 class="text-2xl font-bold">

                    🗺 Reporte de Sitios

                </h2>

            @break

            @case('actividades')

                <h2 class="text-2xl font-bold">

                    🎯 Reporte de Actividades

                </h2>

            @break

            @case('festividades')

                <h2 class="text-2xl font-bold">

                    🎉 Reporte de Festividades

                </h2>

            @break

        @endswitch

    </div>

</div>