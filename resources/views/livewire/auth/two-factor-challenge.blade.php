<x-layouts::auth :title="__('Autenticación de dos factores')">
    <x-slot:navigation>
        <a href="{{ route('home') }}" class="inline-flex min-h-9 items-center justify-center rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-900 shadow-sm transition hover:bg-zinc-50 dark:border-white/10 dark:bg-white/10 dark:text-white dark:hover:bg-white/15">
            {{ __('Inicio') }}
        </a>

        <a href="{{ url()->previous() ?: route('login') }}" class="inline-flex min-h-9 items-center justify-center rounded-lg px-4 py-2 text-sm font-medium text-zinc-600 transition hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-300 dark:hover:bg-white/10 dark:hover:text-white">
            {{ __('Volver') }}
        </a>
    </x-slot:navigation>

    <div class="flex flex-col gap-6">
        <div
            class="relative w-full h-auto"
            x-cloak
            x-data="{
                showRecoveryInput: @js($errors->has('recovery_code')),
                code: '',
                recovery_code: '',
                toggleInput() {
                    this.showRecoveryInput = !this.showRecoveryInput;

                    this.code = '';
                    this.recovery_code = '';

                    $dispatch('clear-2fa-auth-code');

                    $nextTick(() => {
                        this.showRecoveryInput
                            ? this.$refs.recovery_code?.focus()
                            : $dispatch('focus-2fa-auth-code');
                    });
                },
            }"
        >
            <div x-show="!showRecoveryInput">
                <x-auth-header
                    :title="__('Código de autenticación')"
                    :description="__('Abre la app Authenticator donde vinculaste esta cuenta y escribe el código de 6 dígitos que aparece. No llega por correo ni por SMS.')"
                />
            </div>

            <div x-show="showRecoveryInput">
                <x-auth-header
                    :title="__('Código de recuperación')"
                    :description="__('Usa uno de los códigos de recuperación que guardaste al activar la autenticación en dos pasos. Sirve para entrar si no tienes acceso a la app Authenticator y cada código se usa una sola vez.')"
                />
            </div>

            <form method="POST" action="{{ route('two-factor.login.store') }}">
                @csrf

                <div class="space-y-5 text-center">
                    <div x-show="!showRecoveryInput">
                        <div class="flex items-center justify-center my-5">
                            <flux:otp
                                x-model="code"
                                length="6"
                                name="code"
                                label="Código OTP"
                                label:sr-only
                                class="mx-auto"
                             />
                        </div>
                    </div>

                    <div x-show="showRecoveryInput">
                        <div class="my-5">
                            <flux:input
                                type="text"
                                name="recovery_code"
                                x-ref="recovery_code"
                                x-bind:required="showRecoveryInput"
                                autocomplete="one-time-code"
                                placeholder="{{ __('Pega aquí un código de recuperación guardado') }}"
                                x-model="recovery_code"
                            />
                        </div>

                        @error('recovery_code')
                            <flux:text color="red">
                                {{ $message }}
                            </flux:text>
                        @enderror
                    </div>

                    <flux:button
                        variant="primary"
                        type="submit"
                        class="w-full"
                    >
                        {{ __('Continuar') }}
                    </flux:button>
                </div>

                <div class="mt-5 space-x-0.5 text-sm leading-5 text-center">
                    <span class="opacity-50">{{ __('o puedes') }}</span>
                    <div class="inline font-medium underline cursor-pointer opacity-80">
                        <span x-show="!showRecoveryInput" @click="toggleInput()">{{ __('usar un código de recuperación guardado') }}</span>
                        <span x-show="showRecoveryInput" @click="toggleInput()">{{ __('usar el código de 6 dígitos de Authenticator') }}</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts::auth>
