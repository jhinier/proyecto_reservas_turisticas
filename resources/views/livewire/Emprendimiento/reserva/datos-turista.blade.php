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
        <div class="mb-5 p-3 bg-red-50 text-red-800 rounded-xl text-xs font-bold border border-red-200 flex items-center gap-2">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            Turista no encontrado. El usuario debe crear una cuenta en la plataforma antes de reservar.
        </div>
    @endif

    <form wire:submit="procesarDatos" class="space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            
            {{-- Campo de Identificación --}}
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

            {{-- Todos estos campos ahora están estrictamente bloqueados --}}
            <x-input-form id="correo" type="email" label="Correo Electrónico" wire:model="correo" :readonly="true" class="bg-gray-100 text-gray-500 cursor-not-allowed border-gray-200 focus:ring-0" />
            <x-input-form id="nombres" label="Nombres" wire:model="nombres" :readonly="true" class="bg-gray-100 text-gray-500 cursor-not-allowed border-gray-200 focus:ring-0" />
            <x-input-form id="apellidos" label="Apellidos" wire:model="apellidos" :readonly="true" class="bg-gray-100 text-gray-500 cursor-not-allowed border-gray-200 focus:ring-0" />
            <x-input-form id="edad" type="number" label="Edad" wire:model="edad" :readonly="true" class="bg-gray-100 text-gray-500 cursor-not-allowed border-gray-200 focus:ring-0" />
            <x-input-form id="telefono" label="Teléfono" wire:model="telefono" :readonly="true" class="bg-gray-100 text-gray-500 cursor-not-allowed border-gray-200 focus:ring-0" />
            
        </div>

        <div class="pt-4 border-t border-gray-100 flex justify-end">
            {{-- El botón Continuar ahora exige que $usuarioEncontrado sea true --}}
            <button type="submit"
                    @if(!$usuarioEncontrado) disabled @endif
                    wire:loading.attr="disabled"
                    class="px-8 py-3 rounded-xl font-black uppercase text-sm tracking-wider transition-colors disabled:opacity-50 {{ $usuarioEncontrado ? 'bg-[#1a4031] text-white hover:bg-green-950' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}">
                <span wire:loading.remove wire:target="procesarDatos">Continuar</span>
                <span wire:loading wire:target="procesarDatos">Procesando...</span>
            </button>
        </div>
    </form>
</div>