<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Explora Candelaria</title>
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
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/70 to-[#0b1a0b]/80"></div>
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

    <div class="relative z-20 flex flex-col lg:flex-row items-center justify-between w-full h-full px-6 lg:px-20 pt-24 pb-6 lg:pt-20 lg:pb-8 gap-6 lg:gap-10">

        <div class="max-w-xl hidden lg:block">
            <h6 class="text-3xl lg:text-5xl font-extrabold uppercase text-gray-200 leading-tight">
                Únete a <br>
                La Candelaria
            </h6>
            
            <p class="mt-4 text-base lg:text-lg text-gray-300 leading-relaxed">
                Crea tu cuenta para gestionar tus reservaciones, guardar tus lugares favoritos y planificar tu próxima aventura.
            </p>

            <div class="mt-6 border-l-4 border-[#7ed957] pl-5">
                <p class="text-white italic text-lg lg:text-xl">
                    “El primer paso hacia tu próxima experiencia.”
                </p>
            </div>
        </div>

        <div class="w-full max-w-2xl bg-black/50 backdrop-blur-xl border border-white/10 rounded-[2rem] p-6 lg:p-8 shadow-2xl">

            <h3 class="text-2xl lg:text-3xl font-black uppercase text-white mb-1 text-center lg:text-left">
                Crear cuenta
            </h3>

            <p class="text-gray-300 mb-5 text-sm lg:text-base text-center lg:text-left">
                Introduce tus datos a continuación
            </p>

            <x-auth-session-status class="mb-3 text-white text-center text-sm" :status="session('status')" />

            <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <div>
                        <label class="text-[11px] uppercase tracking-wider text-gray-300">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Tu nombre"
                            class="mt-1 w-full rounded-xl border border-white/10 bg-white/10 px-4 py-2.5 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none transition text-sm">
                        @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[11px] uppercase tracking-wider text-gray-300">Apellidos</label>
                        <input type="text" name="apellidos" value="{{ old('apellidos') }}" required autocomplete="apellidos" placeholder="Tus apellidos"
                            class="mt-1 w-full rounded-xl border border-white/10 bg-white/10 px-4 py-2.5 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none transition text-sm">
                        @error('apellidos') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[11px] uppercase tracking-wider text-gray-300">Cédula</label>
                        <input type="text" name="cedula" value="{{ old('cedula') }}" required autocomplete="cedula" placeholder="Número de cédula"
                            class="mt-1 w-full rounded-xl border border-white/10 bg-white/10 px-4 py-2.5 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none transition text-sm">
                        @error('cedula') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[11px] uppercase tracking-wider text-gray-300">Edad</label>
                        <input type="number" name="edad" value="{{ old('edad') }}" required autocomplete="edad" placeholder="Tu edad"
                            class="mt-1 w-full rounded-xl border border-white/10 bg-white/10 px-4 py-2.5 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none transition text-sm">
                        @error('edad') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[11px] uppercase tracking-wider text-gray-300">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}" required autocomplete="telefono" placeholder="Número telefónico"
                            class="mt-1 w-full rounded-xl border border-white/10 bg-white/10 px-4 py-2.5 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none transition text-sm">
                        @error('telefono') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[11px] uppercase tracking-wider text-gray-300">Correo electrónico</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="correo@ejemplo.com"
                            class="mt-1 w-full rounded-xl border border-white/10 bg-white/10 px-4 py-2.5 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none transition text-sm">
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[11px] uppercase tracking-wider text-gray-300">Contraseña</label>
                        <input type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                            class="mt-1 w-full rounded-xl border border-white/10 bg-white/10 px-4 py-2.5 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none transition text-sm">
                        @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[11px] uppercase tracking-wider text-gray-300">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••"
                            class="mt-1 w-full rounded-xl border border-white/10 bg-white/10 px-4 py-2.5 text-white placeholder-gray-400 focus:border-[#7ed957] focus:outline-none transition text-sm">
                        @error('password_confirmation') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full rounded-full bg-[#0b8a0f] hover:bg-[#276a25] transition duration-300 py-3 uppercase tracking-[0.2em] text-white font-bold shadow-2xl text-sm">
                        Registrarse
                    </button>
                </div>

            </form>

            <div class="mt-5 text-center text-sm text-gray-300">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="text-[#7ed957] hover:text-white transition font-semibold">
                    Inicia sesión
                </a>
            </div>

        </div>

    </div>

</div>

</body>
</html>
