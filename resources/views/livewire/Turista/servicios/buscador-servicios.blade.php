<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="mb-10 flex justify-center">
        <div class="relative w-full max-w-3xl">
            <input
                type="text"
                wire:model.live.debounce.500ms="busqueda"
                placeholder="Buscar lugares, servicios o actividades..."
                class="w-full rounded-full border-gray-300 pl-6 pr-32 py-4 shadow-sm focus:border-green-500 focus:ring-green-500 text-lg"
            >
            <button class="absolute inset-y-1.5 right-2 bg-[#00D65B] hover:bg-green-600 text-black font-semibold rounded-full px-8 transition-colors">
                Buscar
            </button>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
        
        <div class="w-full md:w-64 shrink-0">
            <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-100">
                <h3 class="font-bold text-gray-900 mb-5 text-lg">Filtrar resultados</h3>
                <ul class="space-y-4">
                    <li>
                        <button
                            wire:click="$set('tipoServicioSeleccionado', null)"
                            class="w-full text-left {{ is_null($tipoServicioSeleccionado) ? 'text-green-700 font-semibold' : 'text-gray-600 hover:text-green-600' }}"
                        >
                            Todos los resultados
                        </button>
                    </li>
                    @foreach($tiposServicio as $tipo)
                        <li>
                            <button
                                wire:click="$set('tipoServicioSeleccionado', {{ $tipo->id }})"
                                class="w-full text-left {{ $tipoServicioSeleccionado === $tipo->id ? 'text-green-700 font-semibold underline decoration-2 underline-offset-4' : 'text-gray-600 hover:text-green-600' }}"
                            >
                                {{ $tipo->nombre }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="flex-1">
            @if($busqueda)
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Resultados para "{{ $busqueda }}"
                </h2>
            @endif

            <div class="space-y-5">
                @forelse($resultados as $servicio)
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden flex flex-col sm:flex-row">
                        
                        <div class="w-full sm:w-72 h-48 bg-gray-100 shrink-0">
                            @if($servicio->imagenes->isNotEmpty())
                                <img src="{{ asset('storage/' . $servicio->imagenes->first()->imagen) }}" class="w-full h-full object-cover" alt="Imagen de {{ $servicio->nombre }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">Sin foto</div>
                            @endif
                        </div>

                        <div class="p-6 flex flex-col justify-center">
                            <span class="inline-block px-2 py-1 text-xs font-medium uppercase text-gray-600 border border-gray-300 rounded mb-3 w-max">
                                {{ $servicio->emprendimientoTipoServicio->tipoServicio->nombre ?? 'Servicio' }}
                            </span>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $servicio->nombre }}</h3>
                            <p class="text-sm text-green-700 font-medium mb-3">
                                {{ $servicio->emprendimientoTipoServicio->emprendimiento->nombre ?? 'Sin Emprendimiento' }}
                            </p>
                            <p class="text-gray-600 line-clamp-2">{{ $servicio->descripcion }}</p>
                            <div class="mt-3 text-lg font-bold text-gray-900">
                                ${{ number_format($servicio->precio, 2) }}
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="bg-white p-10 text-center rounded-lg border border-gray-200">
                        <p class="text-gray-500 text-lg">No hay coincidencias para tu búsqueda.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $resultados->links() }}
            </div>
        </div>
    </div>
</div>