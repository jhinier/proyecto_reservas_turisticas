<div x-data="{ show: @entangle('abierto') }" x-show="show" 
     class="fixed inset-0 z-[70] flex items-center justify-center p-4 bg-gray-900/60 backdrop-blur-sm" style="display: none;">
    
    <div @click.outside="show = false" class="bg-white dark:bg-gray-900 w-full max-w-4xl max-h-[90vh] overflow-y-auto rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-800 flex flex-col">
        
        {{-- Header Compacto --}}
        <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center sticky top-0 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md z-20">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Gestor de Galería</h3>
                <p class="text-xs text-gray-500 line-clamp-1">{{ $servicio?->nombre }}</p>
            </div>
            <button @click="show = false" class="p-1.5 hover:bg-gray-100 rounded-lg dark:hover:bg-gray-800 transition-colors text-gray-500">
                <svg class="size-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 flex-1">
            {{-- 1. Imágenes Existentes (En la nube) --}}
            <div class="mb-8">
                <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Fotos Guardadas</h4>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-3">
                    @if($servicio)
                        @foreach($servicio->imagenes as $imagen)
                            <div wire:key="cloud-img-{{ $imagen->id }}" class="group relative aspect-square rounded-xl overflow-hidden bg-gray-100 border border-gray-200 dark:border-gray-700 shadow-sm">
                                <img src="{{ Storage::url($imagen->imagen) }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110" loading="lazy">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <button wire:click="eliminarImagen({{ $imagen->id }})" wire:confirm="¿Borrar permanentemente?" class="bg-red-500 text-white p-1.5 rounded-lg hover:bg-red-600 transition shadow-lg transform hover:scale-105">
                                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <hr class="border-gray-200 dark:border-gray-700 mb-6">

            {{-- 2. Zona de Carga --}}
            <div class="w-full">
                
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Componente de subida --}}
                <x-image-upload 
                    id="upload-galeria" 
                    label="Añadir Nuevas Fotografías" 
                    model="nuevasImagenes" 
                    :imagesArray="$nuevasImagenes" 
                    deleteMethod="removerTemporal"
                    helpText="PNG, JPG o WEBP (Máx. 2MB por foto)"
                />

                {{-- Errores específicos de las fotos --}}
                @error('nuevasImagenes.*') 
                    <div class="mt-2 flex items-center gap-2 text-red-600 bg-red-50 p-2.5 rounded-lg border border-red-200 animate-bounce">
                        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-xs font-bold">{{ $message }}</span>
                    </div>
                @enderror
                
                @error('nuevasImagenes') 
                    <div class="mt-2 text-xs text-red-500 font-bold">
                        {{ $message }}
                    </div>
                @enderror

                {{-- Botón de Confirmación Principal (SIEMPRE VISIBLE) --}}
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button wire:click="subirFotos" 
                            wire:loading.attr="disabled" 
                            @disabled(empty($nuevasImagenes))
                            class="w-full bg-[#1a4031] text-white py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-[#132f24] transition disabled:opacity-50 disabled:cursor-not-allowed flex justify-center items-center gap-2">
                        
                        <span wire:loading.remove wire:target="subirFotos">
                            {{ empty($nuevasImagenes) ? 'Selecciona fotos para guardar' : 'Sincronizar y Guardar en la Nube' }}
                        </span>
                        
                        <span wire:loading wire:target="subirFotos">Guardando fotos...</span>
                        
                        <svg wire:loading wire:target="subirFotos" class="size-4 animate-spin" viewBox="0 0 24 24" fill="none"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>