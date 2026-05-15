<div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-2 py-3">
    
    {{-- Resumen de Resultados --}}
    <div class="text-sm text-gray-500">
        @if ($paginator->total() > 0)
            Mostrando <span class="font-bold text-gray-900">{{ $paginator->firstItem() }}</span> a <span class="font-bold text-gray-900">{{ $paginator->lastItem() }}</span> de <span class="font-bold text-gray-900">{{ $paginator->total() }}</span> resultados
        @else
            Mostrando 0 resultados
        @endif
    </div>

    {{-- Enlaces de Paginación --}}
    @if ($paginator->hasPages())
        <nav aria-label="pagination">
            <ul class="flex shrink-0 items-center gap-2 text-sm font-medium">
                {{-- Botón Anterior --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <span class="flex items-center rounded-lg p-1 text-gray-400 cursor-not-allowed" aria-label="previous page">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg>
                            Anterior
                        </span>
                    </li>
                @else
                    <li>
                        <button wire:click="previousPage" wire:loading.attr="disabled" class="flex items-center rounded-lg p-1 text-gray-700 hover:text-[#1a4031] transition" aria-label="previous page">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                            </svg>
                            Anterior
                        </button>
                    </li>
                @endif

                {{-- Números de Página --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li><span class="flex size-6 items-center justify-center p-1 text-gray-500">{{ $element }}</span></li>
                    @endif
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li><span class="flex size-6 items-center justify-center rounded-md bg-[#1a4031] p-1 font-bold text-white shadow" aria-current="page">{{ $page }}</span></li>
                            @else
                                <li><button wire:click="gotoPage({{ $page }})" class="flex size-6 items-center justify-center rounded-md p-1 text-gray-700 hover:bg-gray-100 transition">{{ $page }}</button></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Botón Siguiente --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <button wire:click="nextPage" wire:loading.attr="disabled" class="flex items-center rounded-lg p-1 text-gray-700 hover:text-[#1a4031] transition" aria-label="next page">
                            Siguiente
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </li>
                @else
                    <li>
                        <span class="flex items-center rounded-lg p-1 text-gray-400 cursor-not-allowed" aria-label="next page">
                            Siguiente
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" class="size-6">
                                <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>