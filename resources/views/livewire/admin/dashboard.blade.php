<div class="mx-auto max-w-6xl space-y-8">

    {{-- ALERTA --}}
    @if (session('status'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 shadow-sm">
            <div class="flex items-center gap-3">
                <flux:icon.check-circle class="h-5 w-5" />
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        </div>
    @endif

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-3xl border border-emerald-100 bg-gradient-to-r from-emerald-50 via-green-50 to-emerald-100 px-8 py-10 shadow-sm">

        <h1 class="text-3xl font-bold text-emerald-800">
            Panel Turístico 📊
        </h1>

        <p class="mt-3 max-w-2xl text-sm text-emerald-700">
            Gestión centralizada de emprendimientos, lugares turísticos, actividades y eventos del sistema.
        </p>

        <div class="absolute right-0 top-0 h-full w-1/3 opacity-10 bg-emerald-500 blur-3xl"></div>
    </div>

  {{-- CARDS --}}
<div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">

    {{-- EMPRENDIMIENTOS --}}
    <div class="rounded-3xl border bg-white p-6 shadow-sm hover:shadow-md hover:scale-[1.02] transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-500 font-semibold">Emprendimientos</p>
                <h2 class="mt-2 text-4xl font-extrabold text-emerald-600">
                    {{ $emprendimientosCount ?? 0 }}
                </h2>
            </div>
            <div class="rounded-2xl bg-emerald-100 p-4">
                <flux:icon.building-storefront class="h-7 w-7 text-emerald-600" />
            </div>
        </div>
    </div>

    {{-- LUGARES TURÍSTICOS --}}
    <div class="rounded-3xl border bg-white p-6 shadow-sm hover:shadow-md hover:scale-[1.02] transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-500 font-semibold">Lugares turísticos</p>
                <h2 class="mt-2 text-4xl font-extrabold text-blue-600">
                    {{ $lugaresCount ?? 0 }}
                </h2>
            </div>
            <div class="rounded-2xl bg-blue-100 p-4">
                <flux:icon.map-pin class="h-7 w-7 text-blue-600" />
            </div>
        </div>
    </div>

    {{-- ACTIVIDADES --}}
    <div class="rounded-3xl border bg-white p-6 shadow-sm hover:shadow-md hover:scale-[1.02] transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-500 font-semibold">Actividades</p>
                <h2 class="mt-2 text-4xl font-extrabold text-purple-600">
                    {{ $actividadesCount ?? 0 }}
                </h2>
            </div>
            <div class="rounded-2xl bg-purple-100 p-4">
                <flux:icon.sparkles class="h-7 w-7 text-purple-600" />
            </div>
        </div>
    </div>

    {{-- FESTIVIDADES --}}
    <div class="rounded-3xl border bg-white p-6 shadow-sm hover:shadow-md hover:scale-[1.02] transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-500 font-semibold">Festividades</p>
                <h2 class="mt-2 text-4xl font-extrabold text-orange-500">
                    {{ $festividadesCount ?? 0 }}
                </h2>
            </div>
            <div class="rounded-2xl bg-orange-100 p-4">
                <flux:icon.calendar-days class="h-7 w-7 text-orange-500" />
            </div>
        </div>
    </div>

</div>

{{-- EVENTOS DEL SISTEMA --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- EVENTOS EN CURSO --}}
    <div class="rounded-3xl border bg-white p-6 shadow-sm">
        <h3 class="text-lg font-bold text-green-700 mb-4">
            🔴 Eventos en curso
        </h3>

        <div class="space-y-3">
            @forelse ($eventosHoy as $evento)
                <div class="border-b pb-2">
                    <p class="font-semibold text-zinc-800">
                        {{ $evento->nombre }}
                    </p>

                    <p class="text-sm text-zinc-500">
                        {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M Y') }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-zinc-500">
                    No hay eventos activos hoy
                </p>
            @endforelse
        </div>
    </div>

    {{-- PRÓXIMOS EVENTOS --}}
    <div class="rounded-3xl border bg-white p-6 shadow-sm">
        <h3 class="text-lg font-bold text-blue-700 mb-4">
            📅 Próximos eventos
        </h3>

        <div class="space-y-3">
            @forelse ($eventosProximos as $evento)
                <div class="border-b pb-2">
                    <p class="font-semibold text-zinc-800">
                        {{ $evento->nombre }}
                    </p>

                    <p class="text-sm text-zinc-500">
                        {{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d M Y') }}
                        -
                        {{ \Carbon\Carbon::parse($evento->fecha_fin)->format('d M Y') }}
                    </p>
                </div>
            @empty
                <p class="text-sm text-zinc-500">
                    No hay eventos próximos
                </p>
            @endforelse
        </div>
    </div>

    {{-- EVENTOS FINALIZADOS --}}
    <div class="rounded-3xl border bg-white p-6 shadow-sm">
        <h3 class="text-lg font-bold text-gray-700 mb-4">
            📜 Eventos finalizados
        </h3>

        <div class="space-y-3">
            @forelse ($eventosPasados as $evento)
                <div class="border-b pb-2 opacity-75">
                    <p class="font-semibold text-zinc-700">
                        {{ $evento->nombre }}
                    </p>

                    <p class="text-sm text-zinc-500">
                        Finalizado
                    </p>
                </div>
            @empty
                <p class="text-sm text-zinc-500">
                    No hay eventos finalizados
                </p>
            @endforelse
        </div>
    </div>

</div>  