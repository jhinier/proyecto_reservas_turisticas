@props(['servicio'])

@php
    $p = $servicio->presenter();
@endphp

<div class="group flex flex-col h-full overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-md dark:border-white/10 dark:bg-zinc-900">
    
    {{-- Header: Imagen o Icono --}}
    <div class="relative h-44 w-full shrink-0 bg-gray-100 dark:bg-zinc-800 flex items-center justify-center overflow-hidden">
        
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
                <div class="p-5 rounded-2xl bg-green-50 text-[#00A344] dark:bg-[#07b25f]/10 dark:text-[#00D65B] shadow-sm border border-green-100 dark:border-[#07b25f]/20 transition-transform duration-300 group-hover:scale-110">
                    <x-icon-servicio-card :tipo="$p->tipoId()" class="size-10" />
                </div>
            </div>
        @endif

    </div>

    {{-- Body --}}
    <div class="flex flex-1 flex-col p-5 md:p-6">
        
        {{-- Datos desde el Modelo --}}
        <h3 class="text-lg md:text-xl font-bold text-[#06281E] dark:text-white leading-tight line-clamp-1" title="{{ $servicio->nombre }}">
            {{ $servicio->nombre }}
        </h3>
        
        <p class="mt-2 line-clamp-2 text-xs text-gray-600 dark:text-gray-400 font-medium leading-relaxed">
            {{ $servicio->descripcion ?? 'Sin descripción detallada.' }}
        </p>

        {{-- Footer --}}
        <div class="mt-auto pt-5 flex flex-wrap items-center justify-between gap-3 border-t border-gray-100 dark:border-white/5">
            
            {{-- Contenedor del precio estructurado --}}
            <div class="flex flex-col">
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-0.5">Precio base</span>
                <span class="text-lg font-black text-[#00A344] dark:text-[#00D65B] truncate leading-none">
                    {{ $p->precio() }}
                </span>
            </div>
            
            {{-- Contenedor de Botones (Renderiza los tuyos) --}}
            <div class="shrink-0 flex items-center gap-2">
                <x-botones-servicio-card :servicio="$servicio" />
            </div>
        </div>
    </div>
</div>