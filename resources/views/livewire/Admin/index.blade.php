<x-admin-layout> {{-- Esto le dice a Laravel que use el Layout que me mostraste --}}
    <div class="p-6">
        <flux:heading size="xl" level="1">Gestión de Emprendimientos</flux:heading>
        
        <div class="mt-6">
            {{-- Aquí llamas a tu componente de Interacción (Livewire) --}}
            @livewire('admin.gestion-emprendimientos')
        </div>
    </div>
</x-admin-layout