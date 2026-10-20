<x-layouts::auth :title="__('Confirmar contraseña')">
    <x-slot:navigation>
        <a href="{{ route('home') }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-900 shadow-sm transition hover:bg-zinc-50 dark:border-white/10 dark:bg-white/10 dark:text-white dark:hover:bg-white/15">
            {{ __('Inicio') }}
        </a>

        <a href="{{ route('profile.edit') }}" class="inline-flex min-h-9 items-center justify-center rounded-lg px-4 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-white/10 dark:hover:text-white">
            {{ __('Volver') }}
        </a>
    </x-slot:navigation>

    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Confirmar contraseña')"
            :description="__('Esta es un área segura de la aplicación. Confirma tu contraseña antes de continuar.')"
        />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                name="password"
                :label="__('Contraseña')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('Contraseña')"
                viewable
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="confirm-password-button">
                {{ __('Confirmar') }}
            </flux:button>
        </form>
    </div>
</x-layouts::auth>
