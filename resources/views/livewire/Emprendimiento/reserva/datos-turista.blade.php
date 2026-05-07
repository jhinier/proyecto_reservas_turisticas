<div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 max-w-2xl mx-auto relative">
    <h3 class="text-lg font-black text-gray-900 mb-6 uppercase">Datos del turista</h3>

    @error('general')
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded-xl text-sm font-bold border border-red-100">
            {{ $message }}
        </div>
    @enderror

    @if($usuarioEncontrado)
        <div class="mb-5 p-3 bg-green-50 text-green-800 rounded-xl text-xs font-bold border border-green-200 flex items-center gap-2">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Turista encontrado. Los datos se completaron automáticamente.
        </div>
    @endif

    @if($busquedaRealizada && !$usuarioEncontrado)
        <div class="mb-5 p-3 bg-blue-50 text-blue-800 rounded-xl text-xs font-bold border border-blue-200 flex items-center gap-2">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            El usuario no existe. Ingrese los datos para crear una nueva cuenta.
        </div>
    @endif

    <form wire:submit="procesarDatos" class="space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            
            {{-- Campo de Identificación modificado con botón --}}
            <div class="flex flex-col gap-1">
                <label class="flex w-fit items-center gap-1 pl-0.5 text-sm text-gray-700">Identificación</label>
                <div class="flex gap-2">
                    <input type="text" wire:model="identificacion" 
                           class="w-full rounded-xl border border-gray-200 bg-gray-50 py-2 px-3 text-sm focus:ring-[#1a4031] focus:border-[#1a4031]">
                    <button type="button" wire:click="buscarTurista" 
                            class="bg-[#1a4031] text-white px-4 rounded-xl hover:bg-green-950 transition-colors flex items-center justify-center">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
                @error('identificacion') <small class="text-red-500 pl-0.5">{{ $message }}</small> @enderror
            </div>

            <x-input-form
                id="correo"
                type="email"
                label="Correo Electrónico"
                model="correo"
                wire:model="correo"
                class="rounded-xl border-gray-200 focus:ring-[#1a4031] focus:border-[#1a4031]"
                :readonly="$usuarioEncontrado"
            />

            <x-input-form
                id="nombres"
                label="Nombres"
                model="nombres"
                wire:model="nombres"
                class="rounded-xl border-gray-200 focus:ring-[#1a4031] focus:border-[#1a4031]"
                :readonly="$usuarioEncontrado"
            />

            <x-input-form
                id="apellidos"
                label="Apellidos"
                model="apellidos"
                wire:model="apellidos"
                class="rounded-xl border-gray-200 focus:ring-[#1a4031] focus:border-[#1a4031]"
                :readonly="$usuarioEncontrado"
            />

            <x-input-form
                id="edad"
                type="number"
                label="Edad"
                model="edad"
                min="1"
                wire:model="edad"
                class="rounded-xl border-gray-200 focus:ring-[#1a4031] focus:border-[#1a4031]"
                :readonly="$usuarioEncontrado"
            />

            <x-input-form
                id="telefono"
                label="Teléfono (Opcional)"
                model="telefono"
                wire:model="telefono"
                class="rounded-xl border-gray-200 focus:ring-[#1a4031] focus:border-[#1a4031]"
                :readonly="$usuarioEncontrado"
            />
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end">
            <button type="submit"
                    @if(!$busquedaRealizada) disabled @endif
                    wire:loading.attr="disabled"
                    class="px-8 py-3 rounded-xl font-black uppercase text-sm tracking-wider transition-colors disabled:opacity-50 {{ $busquedaRealizada ? 'bg-[#1a4031] text-white hover:bg-green-950' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}">
                <span wire:loading.remove wire:target="procesarDatos">Continuar</span>
                <span wire:loading wire:target="procesarDatos">Procesando...</span>
            </button>
        </div>
    </form>
</div>