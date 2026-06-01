<div class="max-w-6xl mx-auto px-4 py-8 ">
    
    <div class="flex justify-center mb-12">
        <div class="relative w-full max-w-2xl border border-gray-300 bg-white rounded-full p-1.5 flex items-center shadow-sm focus-within:border-gray-400 transition-colors">
            <span class="pl-4 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input
                type="text"
                wire:model="busqueda"
                wire:keydown.enter="$refresh"
                placeholder="Buscar..."
                class="w-full py-3 px-4 outline-none text-lg text-gray-700 bg-transparent border-0 focus:ring-0"
            >
            <button wire:click="$refresh" class="bg-[#00D65B] text-black font-bold px-8 py-3 rounded-full border border-black hover:bg-green-500 transition-colors shrink-0">
                Buscar
            </button>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-8" >
        
        <div class="w-full md:w-64 shrink-0">
            <h3 class="font-bold text-[#06281E] mb-4 text-lg hidden md:block">Filtrar resultados</h3>
            
            <ul class="flex md:flex-col overflow-x-auto md:overflow-visible border-b border-gray-200 md:border-b-0 space-x-2 md:space-x-0 md:space-y-1 pb-px md:pb-0 hide-scrollbar">
                @foreach($tiposServicio as $tipo)
                    <li class="shrink-0">
                        <button 
                            wire:click="$set('tipoServicioSeleccionado', {{ $tipo->id }})" 
                            class="w-full text-left px-4 py-3 transition flex items-center whitespace-nowrap 
                            border-b-4 md:border-b-0 md:border-l-4 
                            {{ $tipoServicioSeleccionado == $tipo->id ? 'bg-transparent font-bold text-[#06281E] border-[#00D65B]' : 'text-gray-600 hover:bg-gray-50 border-transparent hover:text-gray-900' }}"
                        >
                            {{ $tipo->nombre }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="flex-1">
            <h2 class="text-[26px] font-bold text-[#06281E] mb-6 tracking-tight">
                @if($busqueda)
                    {{ $nombreCategoria }} que coinciden con "{{ $busqueda }}"
                @else
                    Resultados de {{ $nombreCategoria }}
                @endif
            </h2>

            <div class="space-y-6">
                @forelse($resultados as $emprendimiento)
                    
                    <a href="{{ route('turista.empresa.servicios', ['emprendimiento' => $emprendimiento->id, 'tipo' => $tipoServicioSeleccionado]) }}" 
                       class="bg-white rounded-2xl border border-gray-300 overflow-hidden flex flex-col sm:flex-row shadow-sm hover:shadow-md transition-shadow min-h-[200px] group block no-underline">
                        
                        <div class="w-full sm:w-80 h-64 sm:h-auto bg-gray-100 shrink-0 relative overflow-hidden">
                            @if($emprendimiento->imagen)
                                <img src="{{ asset('storage/' . $emprendimiento->imagen) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $emprendimiento->nombre }}">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-gray-400">Sin foto</div>
                            @endif
                        </div>

                        <div class="p-6 flex flex-col justify-between w-full">
                            <div>
                                <span class="inline-block px-2 py-1 text-xs font-semibold uppercase border border-[#06281E] rounded-md text-[#06281E] mb-2 tracking-wide">
                                    EMPRENDIMIENTO
                                </span>
                                
                                <h3 class="text-[19px] font-semibold text-[#123524] leading-snug tracking-[-0.3px] group-hover:underline decoration-2 underline-offset-2">
                                    {{ $emprendimiento->nombre }}
                                </h3>
                                
                                <p class="text-[15px] text-gray-600 mt-1.5 line-clamp-3 leading-relaxed">
                                    {{ $emprendimiento->descripcion }}
                                </p>
                            </div>
                        </div>
                        
                    </a>
                @empty
                    <div class="bg-white p-12 text-center rounded-2xl border border-gray-200">
                        <p class="text-lg font-medium text-gray-600">No hay resultados disponibles en esta categoría.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</div>