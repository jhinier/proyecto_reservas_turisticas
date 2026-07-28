<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña - Explora Candelaria</title>
    <link rel="preload" as="image" href="{{ asset('img/fondop.jpeg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                Recupera tu <br>
                Acceso
            </h6>
            
            <p class="mt-4 text-base lg:text-lg text-gray-300 leading-relaxed">
                Ingresa tu correo electrónico y te enviaremos las instrucciones paso a paso para restablecer tu contraseña de forma segura.
            </p>
        </div>

        <div class="w-full max-w-lg bg-black/50 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 lg:p-10 shadow-2xl">

            <div class="mb-8 text-center lg:text-left">
                <h3 class="text-2xl lg:text-3xl font-black uppercase text-white mb-2">
                    Contraseña
                </h3>
                <p class="text-gray-300 text-sm lg:text-base">
                    Introduce tu correo electrónico para recibir un enlace de restablecimiento.
                </p>
            </div>

            <x-auth-session-status class="mb-4 text-[#7ed957] text-center text-sm font-bold" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="text-[10px] uppercase tracking-wider text-gray-400 font-semibold">Correo electrónico</label>
                    <input 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        placeholder="correo@ejemplo.com"
                        class="mt-1 w-full rounded-xl border border-white/10 bg-white/5 px-4 py-3 text-white placeholder-gray-500 focus:border-[#7ed957] focus:bg-white/10 focus:outline-none transition text-sm"
                    >
                    @error('email') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full rounded-xl bg-[#0b8a0f] hover:bg-[#276a25] transition duration-300 py-3.5 uppercase tracking-[0.2em] text-white font-bold shadow-2xl text-sm outline-none">
                        Enviar enlace
                    </button>
                </div>

            </form>

            <div class="mt-6 text-center text-sm text-gray-400">
                O, volver para
                <a href="{{ route('login') }}" class="text-[#7ed957] hover:text-white transition font-semibold ml-1 outline-none">
                    iniciar sesión
                </a>
            </div>

        </div>

    </div>

</div>

</body>
</html>