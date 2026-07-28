<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explora Candelaria</title>

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
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-[#0b1a0b]/80"></div>
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
            <h6 class="text-4xl lg:text-6xl font-extrabold uppercase text-gray-200 leading-tight">
                Explora <br>
                La Candelaria
            </h6>
            
            <p class="mt-8 text-xl text-gray-300 max-w-2xl leading-relaxed">
            </p>

            <div class="mt-10 border-l-4 border-[#7ed957] pl-6">
                <p class="text-white italic text-xl">
                    “Descubre, reserva y vive experiencias.”
                </p>
            </div>
        </div>

        <div class="w-full max-w-md bg-black/50 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 lg:p-10 shadow-2xl">
            
            <h3 class="text-3xl lg:text-4xl font-black uppercase text-white mb-2 text-center lg:text-left">
                Bienvenido
            </h3>
            
            <p class="text-gray-300 mb-8 text-center lg:text-left">
                Inicia sesión para continuar
            </p>

            <x-auth-session-status class="mb-4 text-white text-center text-sm" :status="session('status')" />

            <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                @csrf

                @if(request()->boolean('reserva') || session()->has('reserva_login_pendiente'))
                    <input type="hidden" name="reserva" value="1">
                @endif

                <div>
                    <label class="text-sm uppercase tracking-wider text-gray-300">
                        Correo electrónico
                    </label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="correo@ejemplo.com"
                        class="mt-2 w-full rounded-xl border border-white/10 bg-white/10 px-5 py-4 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none text-sm lg:text-base"
                    >
                    @error('email') <span class="mt-2 block text-sm text-red-400">{{ $message }}</span> @enderror
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-sm uppercase tracking-wider text-gray-300">
                            Contraseña
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs lg:text-sm text-[#7ed957] hover:text-white transition">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>
                    <input
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full rounded-xl border border-white/10 bg-white/10 px-5 py-4 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none text-sm lg:text-base"
                    >
                    @error('password') <span class="mt-2 block text-sm text-red-400">{{ $message }}</span> @enderror
                </div>

                <label class="flex items-center gap-3 text-gray-300 text-sm">
                    <input 
                        type="checkbox"
                        name="remember"
                        class="rounded border-white/20 bg-white/10 text-[#0b8a0f]"
                    >
                    Recuérdame
                </label>

                <div class="pt-2">
                    <button type="submit" class="w-full rounded-full bg-[#0b8a0f] hover:bg-[#276a25] transition duration-300 py-4 uppercase tracking-[0.3em] text-white font-bold shadow-2xl text-sm lg:text-base">
                        Iniciar sesión
                    </button>
                </div>
            </form>

            @if (Route::has('register'))
                <div class="mt-8 text-center text-gray-300 text-sm">
                    ¿No tienes una cuenta?
                    <a href="{{ route('register') }}" class="text-[#7ed957] hover:text-white transition font-semibold ml-1">
                        Regístrate
                    </a>
                </div>
            @endif

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