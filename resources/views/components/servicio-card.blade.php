{{-- Tarjeta reutilizable para presentar un servicio o paquete con imagen, precio, stock y acciones. --}}
@props([
    'servicio',
    'deleteAction' => 'eliminarServicio',
])

@php
    $p = $servicio->presenter();
@endphp

<div {{ $attributes->merge(['class' => 'group flex h-full flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:shadow-md dark:border-white/10 dark:bg-zinc-900']) }}>
    
    {{-- Header: Imagen o Icono --}}
    <div class="relative flex h-36 w-full shrink-0 items-center justify-center overflow-hidden bg-gray-100 dark:bg-zinc-800">
        
        @if($p->imagenUrl())
            {{-- Imagen con efecto de zoom suave al pasar el cursor --}}
            <img src="{{ $p->imagenUrl() }}" alt="{{ $servicio->nombre }}" class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105">
            
            {{-- Indicador flotante sutil (Opcional, estilo galería) --}}
            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center pointer-events-none">
            </div>
        @else
            {{-- Si NO hay imagen, mostramos el icono centrado sobre el fondo gris suave --}}
            <div class="flex items-center justify-center h-full w-full transition-colors group-hover:bg-gray-100/50 dark:group-hover:bg-zinc-800/50">
                {{-- Caja contenedora del icono (mantiene su diseño original) --}}
                <div class="rounded-xl border border-green-100 bg-green-50 p-4 text-[#00A344] shadow-sm transition-transform duration-300 group-hover:scale-105 dark:border-[#07b25f]/20 dark:bg-[#07b25f]/10 dark:text-[#00D65B]">
                    <x-icon-servicio-card :tipo="$p->tipoId()" class="size-8" />
                </div>
            </div>
        @endif

    </div>

    {{-- Body --}}
    <div class="flex flex-1 flex-col p-4">
        
        {{-- Datos desde el Modelo --}}
        <h3 class="line-clamp-1 text-base font-bold leading-tight text-[#06281E] dark:text-white" title="{{ $servicio->nombre }}">
            {{ $servicio->nombre }}
        </h3>
        
        <p class="mt-1.5 line-clamp-2 text-xs font-medium leading-relaxed text-gray-600 dark:text-gray-400">
            {{ $servicio->descripcion ?? 'Sin descripción detallada.' }}
        </p>

        {{-- Footer --}}
        <div class="mt-auto flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 pt-4 dark:border-white/5">
            
            {{-- Contenedor del precio estructurado --}}
            <div class="flex flex-col">
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Precio base</span>
                <span class="truncate text-base font-black leading-none text-[#00A344] dark:text-[#00D65B]">
                    {{ $p->precio() }}
                </span>
            </div>
            
            {{-- Contenedor de Botones (Renderiza los tuyos) --}}
            <div class="flex shrink-0 flex-wrap items-center justify-end gap-2">
                <button type="button"
                        @click="$dispatch('abrir-detalle-servicio', { servicioId: @js($servicio->id) })"
                        title="Ver detalle"
                        aria-label="Ver detalle de {{ $servicio->nombre }}"
                        class="inline-flex items-center justify-center gap-1.5 rounded-xl border border-gray-300 bg-white px-3 py-1.5 text-[#31552b] transition-all duration-300 hover:-translate-y-0.5 hover:border-[#06281E] hover:bg-[#06281E] hover:text-white hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#00A344] dark:border-zinc-600 dark:bg-zinc-800 dark:text-green-300 dark:hover:bg-white dark:hover:text-[#06281E]">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Detalle</span>
                </button>
                <x-botones-servicio-card :servicio="$servicio" :solo-iconos="true" :delete-action="$deleteAction" />
            </div>
        </div>
    </div>
</div>
