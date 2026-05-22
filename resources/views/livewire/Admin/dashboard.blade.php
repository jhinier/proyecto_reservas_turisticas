   <div class="mx-auto max-w-6xl">
    <div>

    {{-- ALERTA --}}
    @if (session('status'))

        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 shadow-sm">

            <div class="flex items-center gap-3">

                <flux:icon.check-circle class="h-5 w-5" />

                <span class="font-medium">
                    {{ session('status') }}
                </span>

            </div>

        </div>

    @endif

    {{-- HERO --}}
    <div class="relative overflow-hidden rounded-3xl
                border border-emerald-100
                bg-gradient-to-r from-emerald-50 via-green-50 to-emerald-100
                px-8 py-10 shadow-sm">

        <div class="relative z-10">

            <h1 class="text-3xl font-bold text-emerald-800">
                Bienvenido, {{ auth()->user()->nombres }} 👋
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-emerald-700">

                Administra la información turística, emprendimientos,
                festividades y actividades del sistema turístico de Riobamba.

            </p>

        </div>

    </div>

    {{-- CARDS --}}
    <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">

        {{-- CARD --}}
        <div class="rounded-3xl border border-emerald-100 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-semibold text-zinc-500">
                        Total Emprendimientos
                    </p>

                    <h2 class="mt-3 text-4xl font-extrabold text-emerald-600">
                        0
                    </h2>

                </div>

                <div class="rounded-2xl bg-emerald-100 p-4">

                    <flux:icon.building-storefront class="h-7 w-7 text-emerald-600" />

                </div>

            </div>

        </div>

        {{-- CARD --}}
        <div class="rounded-3xl border border-blue-100 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-semibold text-zinc-500">
                        Usuarios Registrados
                    </p>

                    <h2 class="mt-3 text-4xl font-extrabold text-blue-600">
                        0
                    </h2>

                </div>

                <div class="rounded-2xl bg-blue-100 p-4">

                    <flux:icon.users class="h-7 w-7 text-blue-600" />

                </div>

            </div>

        </div>

        {{-- CARD --}}
        <div class="rounded-3xl border border-purple-100 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-semibold text-zinc-500">
                        Servicios Publicados
                    </p>

                    <h2 class="mt-3 text-4xl font-extrabold text-purple-600">
                        0
                    </h2>

                </div>

                <div class="rounded-2xl bg-purple-100 p-4">

                    <flux:icon.sparkles class="h-7 w-7 text-purple-600" />

                </div>

            </div>

        </div>

    </div>

</div>