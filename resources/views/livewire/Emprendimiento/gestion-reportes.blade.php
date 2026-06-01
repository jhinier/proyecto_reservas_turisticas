<div class="p-6">
    <h2 class="text-2xl font-black text-black mb-6">Reportes</h2>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
        <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-4">Filtros</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="text-xs font-bold text-gray-600 block mb-1">Desde</label>
                <input type="date" wire:model.live="fechaDesde" class="w-full border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-600 block mb-1">Hasta</label>
                <input type="date" wire:model.live="fechaHasta" class="w-full border-gray-300 rounded-lg text-sm">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-600 block mb-1">Categoría</label>
                <select wire:model.live="categoria_id" class="w-full border-gray-300 rounded-lg text-sm">
                    <option value="">Todas</option>
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>
            
            <a href="{{ route('reportes.descargar', ['desde' => $fechaDesde, 'hasta' => $fechaHasta, 'categoria' => $categoria_id]) }}" 
               target="_blank"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg font-black text-xs uppercase flex items-center justify-center gap-2 hover:bg-blue-700 transition">
                <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Descargar PDF
            </a>
        </div>
    </div>
</div>