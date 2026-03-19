<div>
    @if (session('status'))
        <flux:card class="bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-800 mb-6">
            <div class="flex items-center gap-3 text-green-700 dark:text-green-400">
                <flux:icon.check-circle variant="micro" />
                <span class="text-sm font-medium">{{ session('status') }}</span>
            </div>
        </flux:card>
    @endif

    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4">
        
        <div class="mb-2">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Panel de Control GAD - {{ auth()->user()->nombres }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Resumen general del sistema turístico de Riobamba.
            </p>
        </div>

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-gray-800">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Emprendimientos</h3>
                <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">0</p>
            </div>
            
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-gray-800">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usuarios Registrados</h3>
                <p class="mt-2 text-3xl font-bold text-green-500 dark:text-green-400">0</p>
            </div>
            
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-gray-800">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Servicios Publicados</h3>
                <p class="mt-2 text-3xl font-bold text-purple-500 dark:text-purple-400">0</p>
            </div>
        </div>

    </div>
</div>