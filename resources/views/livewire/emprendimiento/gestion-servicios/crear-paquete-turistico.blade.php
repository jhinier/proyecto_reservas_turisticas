<div class="max-w-4xl mx-auto p-4 md:p-8 font-sans text-[#06281E] dark:text-gray-200">
    
    {{-- Cabecera --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-[#06281E] dark:text-white">Nuevo paquete turístico</h1>
            <p class="text-sm text-gray-500 mt-1">Configuración de expediciones y tours comunitarios.</p>
        </div>
        <a href="{{ route('emprendimiento.servicios.index', ['tab' => $pivotId]) }}" class="inline-flex items-center gap-2 rounded-lg bg-white dark:bg-zinc-800 px-4 py-2 text-sm font-semibold text-gray-500 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-zinc-700 transition shadow-sm outline-none shrink-0">
            <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Volver a la lista
        </a>
    </div>

    {{-- Contenedor Principal del Formulario --}}
    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-sm border border-gray-200 dark:border-white/10 overflow-hidden">
        <form wire:submit.prevent="guardar">
            
            <div class="p-6 md:p-10 space-y-10">
                
                {{-- SECCIÓN 1: VENTA --}}
                <div>
                    <div class="border-b border-gray-200 dark:border-white/10 pb-2 mb-6">
                        <h2 class="text-base font-bold text-[#06281E] dark:text-white">1. Información de venta</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-input-form id="nombre" label="Nombre del paquete" model="nombre" placeholder="Ej. Cumbre al Altar" />
                        <x-input-form id="precio" label="Precio por persona" model="precio" type="number" step="0.01" simbolo="$" />
                        <x-input-form id="stock" label="Stock por día (Cupos disponibles)" model="stock" type="number" />
                    </div>
                </div>

                {{-- SECCIÓN 2: LOGÍSTICA --}}
                <div>
                    <div class="border-b border-gray-200 dark:border-white/10 pb-2 mb-6">
                        <h2 class="text-base font-bold text-[#06281E] dark:text-white">2. Duración y salida</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <x-input-form id="duracion_dias" label="Días de duración" model="duracion_dias" type="number" placeholder="Ej. 3" />
                        <x-input-form id="lugar_salida" label="Punto de encuentro" model="lugar_salida" placeholder="Lugar de inicio" />
                        <x-input-form id="hora_salida" label="Hora de inicio" model="hora_salida" type="time" />
                    </div>
                </div>

                {{-- SECCIÓN 3: EXPERIENCIA --}}
                <div>
                    <div class="border-b border-gray-200 dark:border-white/10 pb-2 mb-6">
                        <h2 class="text-base font-bold text-[#06281E] dark:text-white">3. Experiencia e itinerario</h2>
                    </div>
                    <div class="space-y-6">
                        <x-textarea-form id="descripcion" label="Resumen general" model="descripcion" rows="3" />
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-textarea-form id="lugares_actividades" label="Itinerario detallado" model="lugares_actividades" rows="4" />
                            <x-textarea-form id="servicios_incluidos" label="¿Qué incluye?" model="servicios_incluidos" rows="4" />
                        </div>
                        <x-textarea-form id="recomendaciones" label="Recomendaciones para el turista" model="recomendaciones" rows="3" placeholder="Ej. Llevar ropa abrigada, protector solar..." />
                    </div>
                </div>

                {{-- SECCIÓN 4: DOCUMENTACIÓN --}}
                <div>
                    <div class="border-b border-gray-200 dark:border-white/10 pb-2 mb-6">
                        <h2 class="text-base font-bold text-[#06281E] dark:text-white">4. Documentación adicional</h2>
                    </div>
                    <div class="max-w-md">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2" for="documento">
                            Itinerario PDF (Opcional)
                        </label>
                        <input id="documento" type="file" wire:model="documento" accept=".pdf" 
                            class="block w-full text-sm text-gray-500 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer bg-gray-50 dark:bg-zinc-800 dark:text-gray-400 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                        <p class="mt-2 text-xs text-gray-500">Formato PDF. Tamaño máximo 5MB.</p>
                        @error('documento') <span class="text-sm text-red-600 mt-1 font-medium">{{ $message }}</span> @enderror
                    </div>
                </div>
                
            </div>

            {{-- Pie de Formulario y Botones --}}
            <div class="bg-gray-50 dark:bg-zinc-800/50 px-6 py-4 flex flex-col-reverse sm:flex-row items-center justify-end gap-3 border-t border-gray-200 dark:border-white/10">
                <button type="button" onclick="history.back()" class="w-full sm:w-auto px-5 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-gray-900 transition outline-none">
                    Cancelar
                </button>
                <button type="submit" wire:loading.attr="disabled" class="w-full sm:w-auto px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-[#00A344] hover:bg-green-700 transition shadow-sm outline-none disabled:opacity-70 flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="guardar">Guardar paquete</span>
                    <span wire:loading wire:target="guardar" class="flex items-center gap-2">
                        <svg class="animate-spin size-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Procesando...
                    </span>
                </button>
            </div>
        </form>
    </div>

    {{-- Notificaciones de Error --}}
    @if ($errors->any() || session()->has('error'))
        <div class="mt-6 p-4 bg-red-50 border border-red-200 rounded-xl shadow-sm">
            @if(session()->has('error'))
                <div class="flex items-center gap-2 text-red-700 font-medium text-sm">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="flex items-center gap-2 text-red-700 font-semibold text-sm mb-2 {{ session()->has('error') ? 'mt-4' : '' }}">
                    Revisa los siguientes campos:
                </div>
                <ul class="list-disc pl-5 text-sm text-red-600 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

</div>