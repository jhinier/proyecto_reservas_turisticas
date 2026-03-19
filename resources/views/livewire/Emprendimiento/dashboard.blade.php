<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl p-4">
    
    <div class="mb-2">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            Bienvenido, {{ auth()->user()->name }}
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Resumen de tu actividad turística.
        </p>
    </div>

    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-gray-800">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Mis Servicios</h3>
            <p class="mt-2 text-3xl font-bold text-blue-600 dark:text-blue-400">0</p>
        </div>
        
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-gray-800">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Reservas Pendientes</h3>
            <p class="mt-2 text-3xl font-bold text-orange-500 dark:text-orange-400">0</p>
        </div>
        
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-gray-800">
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Calificación Promedio</h3>
            <div class="mt-2 flex items-center gap-2">
                <p class="text-3xl font-bold text-gray-900 dark:text-white">0.0</p>
                <span class="text-yellow-400 text-2xl">★</span>
            </div>
        </div>

    </div>

    <div class="relative flex-1 overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-neutral-700 dark:bg-gray-800">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Últimos Movimientos</h3>
        
        <div class="flex h-40 items-center justify-center rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
            <p class="text-gray-500 dark:text-gray-400">
                Aún no tienes reservas recientes. ¡Añade tus primeros servicios turísticos!
            </p>
        </div>
    </div>

</div>