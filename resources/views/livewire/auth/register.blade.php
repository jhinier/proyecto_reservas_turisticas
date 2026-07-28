<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Explora Candelaria</title>
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
                Únete a <br>
                La Candelaria
            </h6>
            
            <p class="mt-4 text-base lg:text-lg text-gray-300 leading-relaxed">
                Crea tu cuenta para gestionar tus reservaciones, guardar tus lugares favoritos y planificar tu próxima aventura en la naturaleza.
            </p>

            <div class="mt-8 border-l-4 border-[#7ed957] pl-5">
                <p class="text-white italic text-lg lg:text-xl font-light">
                    “El primer paso hacia tu próxima experiencia inolvidable.”
                </p>
            </div>
        </div>

        <div class="w-full max-w-4xl bg-black/50 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 lg:p-10 shadow-2xl">

            <div class="mb-8 text-center lg:text-left">
                <h3 class="text-2xl lg:text-3xl font-black uppercase text-white mb-2">
                    Crear cuenta
                </h3>
                <p class="text-gray-300 text-sm lg:text-base">
                    Completa la información para tu perfil de turista
                </p>
            </div>

            <x-auth-session-status class="mb-4 text-white text-center text-sm" :status="session('status')" />

            <form method="POST" action="{{ route('register.store') }}" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                    
                    <div class="space-y-4">
                        <div class="border-b border-white/10 pb-2 mb-4">
                            <h4 class="text-[#7ed957] font-bold uppercase tracking-widest text-xs">Datos Personales</h4>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Nombre</label>
                                <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Tu nombre"
                                    class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm">
                                @error('name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Apellidos</label>
                                <input type="text" name="apellidos" value="{{ old('apellidos') }}" required autocomplete="apellidos" placeholder="Tus apellidos"
                                    class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm">
                                @error('apellidos') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Cédula</label>
                            <input type="text" name="cedula" value="{{ old('cedula') }}" required autocomplete="cedula" placeholder="Número de cédula (10 dígitos)"
                                class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm">
                            @error('cedula') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Edad</label>
                                <input type="number" name="edad" value="{{ old('edad') }}" required autocomplete="edad" placeholder="+18" min="18"
                                    class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm">
                                @error('edad') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Teléfono</label>
                                <input type="text" name="telefono" value="{{ old('telefono') }}" required autocomplete="telefono" placeholder="0900000000"
                                    class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm">
                                @error('telefono') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="border-b border-white/10 pb-2 mb-4 mt-6 md:mt-0">
                            <h4 class="text-[#7ed957] font-bold uppercase tracking-widest text-xs">Datos de la Cuenta</h4>
                        </div>

                        <div>
                            <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Correo electrónico</label>
                            <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="correo@ejemplo.com"
                                class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm">
                            @error('email') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div x-data="{ password: '', showPassword: false }">
                            <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Contraseña</label>
                            <div class="relative mt-1">
                                <input :type="showPassword ? 'text' : 'password'" name="password" x-model="password" required autocomplete="new-password" placeholder="••••••••"
                                    class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm pr-10">
                                
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
                                <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                                    class="w-full rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm pr-10">
                                
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#7ed957] focus:outline-none transition">
                                    <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    <svg x-cloak x-show="showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                                </button>
                            </div>
                            @error('password_confirmation') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full rounded-xl bg-[#0b8a0f] hover:bg-[#276a25] transition duration-300 py-3.5 uppercase tracking-[0.2em] text-white font-bold shadow-2xl text-sm">
                        Registrarse
                    </button>
                </div>

            </form>

            <div class="mt-6 text-center text-sm text-gray-400">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="text-[#7ed957] hover:text-white transition font-semibold ml-1">
                    Inicia sesión
                </a>
            </div>

        </div>

    </div>

</div>

<!-- Contenedor del traductor -->
<div id="google_translate_element"></div>

<!-- Estilos para el botón flotante oscuro -->
<style>
    body { top: 0 !important; }
    .skiptranslate iframe { display: none !important; }
    #goog-gt-tt { display: none !important; }
    
    /* Contenedor principal del widget */
    #google_translate_element {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 9999;
        background-color: rgba(0, 0, 0, 0.5); 
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 1rem;
        padding: 4px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
    }
    
    /* Limpia la estructura de Google */
    .goog-te-gadget { 
        font-size: 0px !important; 
        color: transparent !important; 
        display: flex !important;
        align-items: center;
    }
    
    /* Estilo exacto del selector */
    .goog-te-combo { 
        font-size: 0.875rem !important; 
        color: #ffffff !important; 
        background-color: transparent !important; 
        border: none !important; 
        border-radius: 0.75rem !important; 
        padding: 0.5rem 2.25rem 0.5rem 1rem !important; 
        cursor: pointer !important; 
        outline: none !important; 
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important; 
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%237ed957' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important; 
        background-position: right 0.75rem center !important; 
        background-repeat: no-repeat !important; 
        background-size: 1.2em 1.2em !important;
        margin: 0 !important;
    }

    /* Fondo de las opciones al desplegar */
    .goog-te-combo option {
        background-color: #18181b !important;
        color: #ffffff !important;
    }
    
    /* Oculta los logos y textos extras */
    .goog-logo-link, .goog-te-gadget span { display: none !important; }
    .goog-te-gadget img { display: none !important; }
</style>

<!-- Scripts de ejecución -->
<script type="text/javascript">
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'es',
            includedLanguages: 'es,en,fr,de,pt,it,zh-CN', 
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE
        }, 'google_translate_element');
    }
</script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>
</html>