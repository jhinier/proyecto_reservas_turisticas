<div class="max-w-5xl mx-auto p-4 md:p-6 relative">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 border-b pb-6 dark:border-gray-800">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight flex items-center gap-2">
                <svg class="size-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" /></svg>
                Nuevo Paquete Turístico
            </h1>
            <p class="text-sm text-gray-500 mt-1 uppercase tracking-wider font-semibold">Configuración de expediciones y tours comunitarios</p>
        </div>
        <a href="{{ route('emprendimiento.servicios.index', ['tab' => $pivotId]) }}" class="inline-flex justify-center items-center gap-2 whitespace-nowrap rounded-xl bg-black px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800 dark:bg-white dark:text-black dark:hover:bg-gray-200">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-5 fill-current">
                <path fill-rule="evenodd" d="M9.53 2.47a.75.75 0 010 1.06L4.81 8.25H21a.75.75 0 010 1.5H4.81l4.72 4.72a.75.75 0 11-1.06 1.06l-6-6a.75.75 0 010-1.06l6-6a.75.75 0 011.06 0z" clip-rule="evenodd" />
            </svg>
            Volver
        </a>
    </div>

    <div class="p-8 bg-white rounded-2xl border border-gray-200 shadow-xl dark:bg-gray-900 dark:border-gray-800">
        <form wire:submit.prevent="guardar" class="space-y-10">
            
            {{-- SECCIÓN 1: VENTA --}}
            <div>
                <h3 class="flex items-center gap-2 text-lg font-bold text-gray-800 dark:text-gray-100 mb-6">
                    <span class="p-1.5 bg-gray-100 dark:bg-gray-800 rounded-lg">
                        <svg class="size-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                    Información de Venta
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input-form id="nombre" label="Nombre del Paquete" model="nombre" placeholder="Ej. Cumbre al Altar" />
                    <x-input-form id="precio" label="Precio por Persona" model="precio" type="number" step="0.01" simbolo="$" />
                    <x-input-form id="stock" label="Stock por Día (Cupos disponibles)" model="stock" type="number" />
                </div>
            </div>

            {{-- SECCIÓN 2: LOGÍSTICA Y DURACIÓN --}}
            <div class="bg-gray-50 dark:bg-gray-800/40 p-6 rounded-2xl border border-gray-200 dark:border-gray-700">
                <h3 class="flex items-center gap-2 text-lg font-bold text-gray-800 dark:text-gray-100 mb-6">
                    <span class="p-1.5 bg-gray-100 dark:bg-gray-800 rounded-lg">
                        <svg class="size-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </span>
                    Duración y Salida
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <x-input-form id="duracion_dias" label="Días de duración" model="duracion_dias" type="number" placeholder="Ej. 3" />
                    <x-input-form id="lugar_salida" label="Punto de Encuentro" model="lugar_salida" placeholder="Lugar de inicio" />
                    <x-input-form id="hora_salida" label="Hora de Inicio" model="hora_salida" type="time" />
                </div>
            </div>

            {{-- SECCIÓN 3: EXPERIENCIA --}}
            <div>
                <h3 class="flex items-center gap-2 text-lg font-bold text-gray-800 dark:text-gray-100 mb-6">
                    <span class="p-1.5 bg-gray-100 dark:bg-gray-800 rounded-lg">
                        <svg class="size-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </span>
                    Experiencia e Itinerario
                </h3>
                <div class="space-y-6">
                    <x-textarea-form id="descripcion" label="Resumen General" model="descripcion" rows="3" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-textarea-form id="lugares_actividades" label="Itinerario Detallado" model="lugares_actividades" rows="4" />
                        <x-textarea-form id="servicios_incluidos" label="¿Qué incluye?" model="servicios_incluidos" rows="4" />
                    </div>
                    
                    {{-- Campo de recomendaciones agregado aquí --}}
                    <x-textarea-form id="recomendaciones" label="Recomendaciones para el turista" model="recomendaciones" rows="3" placeholder="Ej. Llevar ropa abrigada, protector solar..." />
                </div>
            </div>

            {{-- SECCIÓN 4: DOCUMENTACIÓN --}}
            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                <div class="relative flex w-full max-w-md flex-col gap-3">
                    <label class="flex items-center gap-2 text-sm font-bold text-gray-700 dark:text-gray-300" for="documento">
                        <svg class="size-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        Itinerario PDF (Opcional)
                    </label>
                    
                    <input id="documento" type="file" wire:model="documento" accept=".pdf" 
                        class="w-full overflow-clip rounded-xl border border-gray-300 bg-gray-50/50 text-sm text-gray-600 
                        file:mr-4 file:border-none file:bg-gray-200 file:px-4 file:py-2 file:font-bold file:text-gray-700 
                        focus-visible:outline-2 focus-visible:outline-emerald-500 disabled:cursor-not-allowed disabled:opacity-75 
                        dark:border-gray-700 dark:bg-gray-800/50 dark:text-gray-400 dark:file:bg-gray-700 dark:file:text-gray-200" />
                    
                    <p class="text-[11px] text-gray-500 font-medium">Máximo 5MB. Formato PDF.</p>
                    @error('documento') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Botones --}}
            <div class="flex justify-end items-center gap-4 pt-8 border-t border-gray-100 dark:border-gray-700">
                <button type="button" onclick="history.back()" class="text-sm font-bold text-gray-500 hover:text-gray-700 transition">Cancelar</button>
                <button type="submit" wire:loading.attr="disabled" class="bg-emerald-900 text-white px-10 py-3 rounded-xl font-bold shadow-lg hover:bg-emerald-950 transition active:scale-95 disabled:opacity-50 flex items-center gap-2">
                    <span wire:loading.remove wire:target="guardar">Guardar Paquete</span>
                    <span wire:loading wire:target="guardar" class="flex items-center gap-2">
                        <svg class="animate-spin size-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Guardando...
                    </span>
                </button>
            </div>
        </form>
        {{-- CAJA DE ERRORES (TEMPORAL PARA DEPURAR) --}}
            @if ($errors->any())
                <div class="p-5 bg-red-50 border-l-4 border-red-500 rounded-r-xl shadow-sm">
                    <div class="flex items-center gap-2 text-red-800 font-bold mb-2 text-lg">
                        <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        El sistema detuvo el guardado por esto:
                    </div>
                    <ul class="list-disc pl-6 text-sm text-red-700 font-medium space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="p-4 bg-red-600 text-white font-bold rounded-xl shadow-lg flex items-center gap-2">
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('error') }}
                </div>
            @endif
            {{-- FIN DE CAJA DE ERRORES --}}
    </div>
</div>
