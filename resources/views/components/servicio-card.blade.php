@props(['servicio'])

@php
    $p = $servicio->presenter();
@endphp

<div class="flex flex-col h-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
    
    {{-- Header: Imagen o Icono (Lógica Original Restaurada) --}}
    <div class="relative h-32 w-full shrink-0 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
        
        @if($p->imagenUrl())
            {{-- Si hay imagen, la mostramos ocupando todo el header --}}
            <img src="{{ $p->imagenUrl() }}" alt="{{ $servicio->nombre }}" class="h-full w-full object-cover">
        @else
            {{-- Si NO hay imagen, mostramos tu icono centrado en el fondo gris --}}
            <div class="p-4 rounded-full bg-[#1a4031]/10 text-[#1a4031] dark:bg-success/20 dark:text-success">
                <x-icon-servicio-card :tipo="$p->tipoId()" class="size-10" />
            </div>
        @endif

    </div>

    {{-- Body --}}
    <div class="flex flex-1 flex-col p-4">
        
        {{-- Datos desde el Modelo --}}
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $servicio->nombre }}</h3>
        <p class="mt-1 line-clamp-2 text-sm text-gray-500 dark:text-gray-400">{{ $servicio->descripcion ?? 'Sin descripción.' }}</p>

        {{-- Footer --}}
        <div class="mt-auto pt-4 flex flex-wrap items-center justify-between gap-2 border-t border-gray-50 dark:border-gray-700/50">
            <span class="text-lg font-black text-[#1a4031] dark:text-success truncate">
                {{ $p->precio() }}
            </span>
            
            <x-botones-servicio-card :servicio="$servicio" />
        </div>
    </div>
</div>