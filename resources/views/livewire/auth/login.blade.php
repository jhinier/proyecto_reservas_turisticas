<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explora Candelaria</title>

    <link rel="preload" as="image" href="{{ asset('img/fondop.jpeg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen overflow-hidden bg-black">

<!-- CONTENEDOR PRINCIPAL -->
<div class="relative w-full h-screen overflow-hidden">

    <!-- IMAGEN FONDO -->
    <div class="absolute inset-0">

        <img 
            src="{{ asset('img/fondop.jpeg') }}"
            class="w-full h-full object-cover"
            alt="Fondo"
        >

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/60 to-[#0b1a0b]/80"></div>

    </div>

    <!-- NAVBAR -->
    <div class="absolute top-0 left-0 z-30 w-full">

        <div class="flex items-center justify-between px-8 lg:px-16 py-8">

            <!-- LOGO -->
            <div class="flex items-center gap-4">

                <img 
                    src="{{ asset('img/logo1.png') }}"
                    class="w-16 h-16 object-contain"
                    alt="Logo"
                >

                <div>

                    <h3 class="text-2xl font-black uppercase text-white leading-none">
                        Explora Candelaria
                    </h3>

                    <p class="text-xs text-[#7ed957] uppercase tracking-[0.4em] mt-1">
                        Turismo & Experiencias
                    </p>

                </div>

            </div>

        </div>

    </div>

    <!-- CONTENIDO -->
    <div class="relative z-20 flex items-center justify-between h-full px-8 lg:px-20">

        <!-- TEXTO IZQUIERDA -->
        <div class="max-w-3xl">


           <h6 class="text-4xl lg:text-6xl font-extrabold uppercase text-gray-200 leading-tight">
                Explora <br>
                La Candelaria
            </h6>

            <p class="mt-8 text-xl text-gray-300 max-w-2xl leading-relaxed">
                
            </p>

            <!-- FRASE -->
            <div class="mt-10 border-l-4 border-[#7ed957] pl-6">

                <p class="text-white italic text-xl">
                    “Descubre, reserva y vive experiencias.”
                </p>

            </div>

        </div>

        <!-- LOGIN -->
        <div class="hidden md:flex">

            <div class="w-[450px] bg-black/50 backdrop-blur-xl border border-white/10 rounded-[2rem] p-10 shadow-2xl">

                <h3 class="text-4xl font-black uppercase text-white mb-2">
                    Bienvenido
                </h3>

                <p class="text-gray-300 mb-8">
                    Inicia sesión para continuar
                </p>

                <!-- STATUS -->
                <x-auth-session-status 
                    class="mb-4 text-white" 
                    :status="session('status')" 
                />

                <!-- FORM -->
                <form method="POST" action="{{ route('login.store') }}" class="space-y-6">
                    @csrf

                    @if(request()->boolean('reserva') || session()->has('reserva_login_pendiente'))
                        <input type="hidden" name="reserva" value="1">
                    @endif

                    <!-- EMAIL -->
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
                            class="mt-2 w-full rounded-xl border border-white/10 bg-white/10 px-5 py-4 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none"
                        >
                        @error('email') <span class="mt-2 block text-sm text-red-400">{{ $message }}</span> @enderror

                    </div>

                    <!-- PASSWORD -->
                    <div>

                        <div class="flex items-center justify-between mb-2">

                            <label class="text-sm uppercase tracking-wider text-gray-300">
                                Contraseña
                            </label>

                            @if (Route::has('password.request'))
                                <a 
                                    href="{{ route('password.request') }}"
                                    class="text-sm text-[#7ed957] hover:text-white transition">

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
                            class="w-full rounded-xl border border-white/10 bg-white/10 px-5 py-4 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none"
                        >
                        @error('password') <span class="mt-2 block text-sm text-red-400">{{ $message }}</span> @enderror

                    </div>

                    <!-- REMEMBER -->
                    <label class="flex items-center gap-3 text-gray-300">

                        <input 
                            type="checkbox"
                            name="remember"
                            class="rounded border-white/20 bg-white/10 text-[#0b8a0f]"
                        >

                        Recuérdame

                    </label>

                    <!-- BOTON -->
                    <button
                        type="submit"
                        class="w-full rounded-full bg-[#0b8a0f] hover:bg-[#276a25] transition duration-300 py-4 uppercase tracking-[0.3em] text-white font-bold shadow-2xl">

                        Iniciar sesión

                    </button>

                </form>

                <!-- REGISTER -->
                @if (Route::has('register'))
                    <div class="mt-8 text-center text-gray-300">

                        ¿No tienes una cuenta?

                        <a 
                            href="{{ route('register') }}"
                            class="text-[#7ed957] hover:text-white transition font-semibold">

                            Regístrate

                        </a>

                    </div>
                @endif

            </div>

        </div>

    </div>

</div>

</body>
</html>
