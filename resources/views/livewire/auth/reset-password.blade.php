<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña - Explora Candelaria</title>
    <link rel="preload" as="image" href="{{ asset('img/fondop.jpeg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>[x-cloak] { display: none !important; }</style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-black overflow-x-hidden overflow-y-auto">

<div class="relative w-full min-h-screen flex flex-col justify-center">

    <div class="absolute inset-0 z-0">
        <img 
            src="{{ asset('img/fondop.jpeg') }}"
            class="w-full h-full object-cover"
            alt="Fondo"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/80 to-[#0b1a0b]/90"></div>
    </div>

    <div class="absolute top-0 left-0 z-30 w-full">
        <div class="flex items-center justify-between px-6 lg:px-16 py-5">
            <a href="{{ route('home') }}" class="flex items-center gap-4">
                <img 
                    src="{{ asset('img/logo1.png') }}"
                    class="w-10 h-10 lg:w-14 lg:h-14 object-contain"
                    alt="Logo"
                >
                <div class="hidden sm:block">
                    <h3 class="text-lg lg:text-xl font-black uppercase text-white leading-none">
                        Explora Candelaria
                    </h3>
                    <p class="text-[10px] text-[#7ed957] uppercase tracking-[0.4em] mt-1">
                        Turismo & Experiencias
                    </p>
                </div>
            </a>
        </div>
    </div>

    <div class="relative z-20 flex flex-col lg:flex-row items-center justify-center lg:justify-between w-full h-full px-6 lg:px-20 pt-28 pb-10 lg:pt-24 lg:pb-12 gap-8 lg:gap-12">

        <div class="max-w-md hidden lg:block">
            <h6 class="text-3xl lg:text-5xl font-extrabold uppercase text-gray-200 leading-tight">
                Nueva <br>
                Contraseña
            </h6>
            
            <p class="mt-4 text-base lg:text-lg text-gray-300 leading-relaxed">
                Estás a un paso de recuperar tu acceso. Crea una contraseña segura que puedas recordar para seguir planificando tus aventuras.
            </p>
        </div>

        <div class="w-full max-w-lg bg-black/50 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 lg:p-10 shadow-2xl">

            <div class="mb-8 text-center lg:text-left">
                <h3 class="text-2xl lg:text-3xl font-black uppercase text-white mb-2">
                    Restablecer
                </h3>
                <p class="text-gray-300 text-sm lg:text-base">
                    Ingresa tu nueva contraseña a continuación.
                </p>
            </div>

            <x-auth-session-status class="mb-4 text-[#7ed957] text-center text-sm font-bold" :status="session('status')" />

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ request()->route('token') }}">

                <div>
                    <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Correo electrónico</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email', request('email')) }}" 
                        required 
                        autocomplete="email"
                        class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm"
                    >
                    @error('email') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div x-data="{ password: '', showPassword: false }">
                    <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Nueva contraseña</label>
                    <div class="relative mt-1">
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            name="password" 
                            x-model="password"
                            required 
                            autocomplete="new-password" 
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm pr-10"
                        >
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7ed957] focus:outline-none transition">
                            <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-cloak x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror

                    <div class="mt-3 space-y-2">
                        <div class="flex items-center gap-2 text-[10px] md:text-xs transition-colors duration-300" :class="password.length >= 8 ? 'text-[#7ed957]' : 'text-gray-400'">
                            <svg x-cloak x-show="password.length >= 8" class="w-4 h-4 shrink-0 text-[#7ed957]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <svg x-cloak x-show="password.length < 8" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                            <span>Al menos 8 caracteres</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px] md:text-xs transition-colors duration-300" :class="/[A-Z]/.test(password) ? 'text-[#7ed957]' : 'text-gray-400'">
                            <svg x-cloak x-show="/[A-Z]/.test(password)" class="w-4 h-4 shrink-0 text-[#7ed957]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <svg x-cloak x-show="!/[A-Z]/.test(password)" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                            <span>Una mayúscula</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px] md:text-xs transition-colors duration-300" :class="/[a-z]/.test(password) ? 'text-[#7ed957]' : 'text-gray-400'">
                            <svg x-cloak x-show="/[a-z]/.test(password)" class="w-4 h-4 shrink-0 text-[#7ed957]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <svg x-cloak x-show="!/[a-z]/.test(password)" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                            <span>Una minúscula</span>
                        </div>
                        <div class="flex items-center gap-2 text-[10px] md:text-xs transition-colors duration-300" :class="/[^a-zA-Z0-9]/.test(password) ? 'text-[#7ed957]' : 'text-gray-400'">
                            <svg x-cloak x-show="/[^a-zA-Z0-9]/.test(password)" class="w-4 h-4 shrink-0 text-[#7ed957]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <svg x-cloak x-show="!/[^a-zA-Z0-9]/.test(password)" class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/></svg>
                            <span>Un carácter especial</span>
                        </div>
                    </div>
                </div>

                <div x-data="{ showConfirmPassword: false }">
                    <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Confirmar contraseña</label>
                    <div class="relative mt-1">
                        <input 
                            :type="showConfirmPassword ? 'text' : 'password'" 
                            name="password_confirmation" 
                            required 
                            autocomplete="new-password" 
                            placeholder="••••••••"
                            class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm pr-10"
                        >
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7ed957] focus:outline-none transition">
                            <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            <svg x-cloak x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                        </button>
                    </div>
                    @error('password_confirmation') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full rounded-xl bg-[#0b8a0f] hover:bg-[#276a25] transition duration-300 py-3.5 uppercase tracking-[0.2em] text-white font-bold shadow-2xl text-sm outline-none">
                        Restablecer contraseña
                    </button>
                </div>

            </form>
        </div>

    </div>

</div>

</body>
</html>