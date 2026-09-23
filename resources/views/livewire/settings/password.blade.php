<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Configuración de contraseña') }}</flux:heading>

    <x-settings.layout :heading="__('Actualizar contraseña')" :subheading="__('Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantenerse segura')">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6" x-data="{ password: @entangle('password'), confirmation: @entangle('password_confirmation') }">
            <flux:input
                wire:model="current_password"
                :label="__('Contraseña actual')"
                type="password"
                required
                autocomplete="current-password"
            />
            <div>
                <flux:input
                    x-model="password"
                    :label="__('Nueva contraseña')"
                    type="password"
                    required
                    autocomplete="new-password"
                />

                <div class="mt-3 space-y-2 mb-3">
                    <div class="flex items-center gap-2 text-xs transition-colors duration-300" :class="password.length >= 8 ? 'text-[#00D65B]' : 'text-gray-500'">
                        <svg x-cloak x-show="password.length >= 8" class="w-4 h-4 shrink-0 text-[#00D65B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <svg x-cloak x-show="password.length < 8" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                        <span>Al menos 8 caracteres</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs transition-colors duration-300" :class="/[A-Z]/.test(password) ? 'text-[#00D65B]' : 'text-gray-500'">
                        <svg x-cloak x-show="/[A-Z]/.test(password)" class="w-4 h-4 shrink-0 text-[#00D65B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <svg x-cloak x-show="!/[A-Z]/.test(password)" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                        <span>Una mayúscula</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs transition-colors duration-300" :class="/[a-z]/.test(password) ? 'text-[#00D65B]' : 'text-gray-500'">
                        <svg x-cloak x-show="/[a-z]/.test(password)" class="w-4 h-4 shrink-0 text-[#00D65B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <svg x-cloak x-show="!/[a-z]/.test(password)" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" d="M12 3v18M3 12h18"/></svg>
                        <span>Una minúscula</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs transition-colors duration-300" :class="/[^a-zA-Z0-9]/.test(password) ? 'text-[#00D65B]' : 'text-gray-500'">
                        <svg x-cloak x-show="/[^a-zA-Z0-9]/.test(password)" class="w-4 h-4 shrink-0 text-[#00D65B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <svg x-cloak x-show="!/[^a-zA-Z0-9]/.test(password)" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                        <span>Un carácter especial</span>
                    </div>
                </div>
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <flux:input
                wire:model="password_confirmation"
                x-model="confirmation"
                :label="__('Confirmar contraseña')"
                type="password"
                required
                autocomplete="new-password"
            />
            <p x-cloak x-show="confirmation.length > 0 && confirmation !== password" class="mt-2 text-sm text-red-600">
                Las contraseñas no coinciden.
            </p>
            @error('password_confirmation')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <div class="flex items-center gap-4 pt-3">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full bg-[#00D65B] text-[#06281E] hover:bg-[#00c052] transition-colors">{{ __('Guardar') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="password-updated">
                    {{ __('Guardado.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
