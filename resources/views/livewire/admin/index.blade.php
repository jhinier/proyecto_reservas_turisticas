<x-admin-layout>

    <div class="p-6 space-y-10"> <!-- 🔥 CONTENEDOR GENERAL -->

        <!-- 🔹 EMPRENDIMIENTOS -->
        <div>
            <flux:heading size="xl" level="1">
                Gestión de Emprendimientos
            </flux:heading>

            <div class="mt-6">
                @livewire('admin.gestion-emprendimientos')
            </div>
        </div>

        <!-- 🔹 FESTIVIDADES -->
        <div>
            <flux:heading size="xl" level="1">
                Gestión de Festividades
            </flux:heading>

            <div class="mt-6">
                @livewire('admin.gestion-festividades')
            </div>
        </div>

    </div>

</x-admin-layout>