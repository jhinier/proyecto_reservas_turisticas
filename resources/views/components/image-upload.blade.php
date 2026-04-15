@props([
    'id' => 'imagenes', 
    'label' => 'Fotografías', 
    'model' => 'imagenes', 
    'imagesArray' => [], 
    'deleteMethod' => 'eliminarImagen',
    'helpText' => 'PNG, JPG o WEBP (Máx. 2MB por foto)'
])

<div class="col-span-1 md:col-span-2 pt-2">
    <label class="flex w-fit items-center gap-1 pl-0.5 text-sm text-gray-700 dark:text-gray-300 mb-2">
        {{ $label }}
    </label>
    
    <div class="flex justify-center rounded-xl border border-dashed {{ $errors->has($model.'.*') ? 'border-danger bg-danger/5' : 'border-gray-300 dark:border-gray-600 bg-surface-alt dark:bg-surface-dark-alt/50' }} px-6 py-8 transition-colors">
        <div class="text-center">
            <div wire:loading wire:target="{{ $model }}" class="mb-4">
                <svg class="animate-spin mx-auto h-8 w-8 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-sm text-gray-500 mt-2">Subiendo archivos...</p>
            </div>

            <div wire:loading.remove wire:target="{{ $model }}">
                <svg class="mx-auto h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M1.5 6a2.25 2.25 0 012.25-2.25h16.5A2.25 2.25 0 0122.5 6v12a2.25 2.25 0 01-2.25 2.25H3.75A2.25 2.25 0 011.5 18V6zM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0021 18v-1.94l-2.69-2.689a1.5 1.5 0 00-2.12 0l-.88.879.97.97a.75.75 0 11-1.06 1.06l-5.16-5.159a1.5 1.5 0 00-2.12 0L3 16.061zm10.125-7.81a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0z" clip-rule="evenodd" />
                </svg>
                <div class="mt-4 flex justify-center text-sm leading-6 text-gray-600 dark:text-gray-400">
                    <label for="{{ $id }}" class="relative cursor-pointer rounded-md font-semibold text-primary hover:text-primary/80 focus-within:outline-none dark:text-success">
                        <span>Sube archivos</span>
                        <input id="{{ $id }}" wire:model="{{ $model }}" type="file" multiple accept="image/*" class="sr-only">
                    </label>
                    <p class="pl-1">o arrastra y suelta</p>
                </div>
                <p class="text-xs leading-5 text-gray-500 mt-1">{{ $helpText }}</p>
            </div>
        </div>
    </div>
    
    @error($model.'.*') <small class="pl-0.5 text-danger mt-1 block">{{ $message }}</small> @enderror

    @if ($imagesArray)
        <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
            @foreach ($imagesArray as $index => $imagen)
                <div class="relative group rounded-lg overflow-hidden border border-gray-200 shadow-sm h-24 bg-gray-100">
                    <img src="{{ $imagen->temporaryUrl() }}" 
                         class="w-full h-full object-cover transition-all duration-300 group-hover:opacity-50" 
                         alt="Preview">
                    
                    <button type="button" 
                            wire:click="{{ $deleteMethod }}({{ $index }})"
                            wire:loading.attr="disabled"
                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                            title="Descartar imagen">
                        <div class="bg-danger text-white rounded-full p-1.5 shadow-lg transform transition-transform hover:scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 1 .75.75l-.23 6.75a.75.75 0 1 1-1.5-.05l.23-6.75a.75.75 0 0 1 .75-.75Zm4.59.75a.75.75 0 1 0-1.5.05l.23 6.75a.75.75 0 1 0 1.5-.05l-.23-6.75Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
    
                    <div class="absolute top-1 right-1 bg-white/80 rounded-full p-0.5 shadow-sm group-hover:hidden">
                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>