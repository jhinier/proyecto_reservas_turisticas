@props(['servicio'])

<div class="group relative rounded-xl border border-gray-200 bg-white p-4 transition-all hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
    <div class="flex flex-col gap-1">
        <h4 class="font-bold text-gray-900 dark:text-white">{{ $servicio->nombre }}</h4>
        <p class="text-xs text-gray-500 line-clamp-2 mb-2">{{ $servicio->descripcion }}</p>
        <div class="flex items-center justify-between border-t border-gray-100 pt-2 dark:border-gray-700">
            <span class="text-sm font-bold text-[#1a4031] dark:text-success">
                ${{ number_format($servicio->precio, 2) }}
            </span>
            <span class="text-[10px] uppercase font-semibold text-gray-400">
                Stock: {{ $servicio->stock }}
            </span>
        </div>
    </div>
</div>