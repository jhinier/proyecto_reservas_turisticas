@props([
    'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Explora Candelaria" description="Admin Panel" {{ $attributes }}>
        <x-slot name="logo">
            {{-- Contenedor con fondo blanco y bordes redondeados --}}
            <div class="flex items-center justify-center size-10 bg-white rounded-lg overflow-hidden shrink-0 p-1">
                <img src="{{ asset('img/Logo3.png') }}" class="w-full h-full object-contain" alt="Logo" />
            </div>
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Explora Candelaria" {{ $attributes }}>
        <x-slot name="logo">
            <div class="flex items-center justify-center size-10 bg-white rounded-lg overflow-hidden shrink-0 p-1">
                <img src="{{ asset('img/Logo3.png') }}" class="w-full h-full object-contain" alt="Logo" />
            </div>
        </x-slot>
    </flux:brand>
@endif