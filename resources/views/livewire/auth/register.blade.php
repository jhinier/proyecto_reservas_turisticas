<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Crear cuenta')" :description="__('Introduce tus datos a continuación para crear tu cuenta')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Nombre')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Nombre')"
            />

            <!-- Apellidos -->
            <flux:input
                name="apellidos"
                :label="__('Apellidos')"
                :value="old('apellidos')"
                type="text"
                required
                autocomplete="apellidos"
                :placeholder="__('Apellidos')"
            />

            <!-- Cédula -->
            <flux:input
                name="cedula"
                :label="__('Cédula')"
                :value="old('cedula')"
                type="text"
                required
                autocomplete="cedula"
                :placeholder="__('Cédula')"
            />

            <!-- Edad -->
            <flux:input
                name="edad"
                :label="__('Edad')"
                :value="old('edad')"
                type="number"
                required
                autocomplete="edad"
                :placeholder="__('Edad')"
                required
                autocomplete="cedula"
                :placeholder="__('Cédula')"
            />

            <!-- Telefono -->
            <flux:input
                name="telefono"
                :label="__('Telefono')"
                :value="old('telefono')"
                type="text"
                required
                autocomplete="telefono"
                :placeholder="__('Telefono')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Correo electrónico')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Contraseña')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Contraseña')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirmar contraseña')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirmar contraseña')"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Crear cuenta') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('¿Ya tienes una cuenta?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Inicia sesión') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
