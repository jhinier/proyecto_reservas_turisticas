<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explora Candelaria</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class', 
            theme: {
                extend: {
                colors: {
            
                    /* VERDES PRINCIPALES */
                    primary: '#07b25f',
                    'primary-dark': '#87ec83',
                    secondary: '#7ed957',
                
                    /* TEXTOS */
                    'on-primary': '#ffffff',
                    'on-primary-dark': '#ffffff',
                
                    /* FONDOS */
                    surface: '#ffffff',
                    'surface-alt': '#f5fdf5',
                
                    'surface-dark': '#0b1a0b',
                    'surface-dark-alt': '#163016',
                
                   /* TEXTOS GENERALES */
                    'on-surface': '#f3f4f6',
                    'on-surface-strong': '#ffffff',

                    'on-surface-dark': '#d1fae5',
                    'on-surface-dark-strong': '#ffffff',
                
                    /* BORDES */
                    outline: '#d1d5db',
                    'outline-dark': '#276a25',
                },
                    borderRadius: {
                        radius: '0.5rem',
                    }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

   <nav 
        x-data="{ mobileMenuIsOpen: false }"
        x-on:click.away="mobileMenuIsOpen = false"
        class="absolute top-0 left-0 w-full z-50 flex items-center justify-between px-8 lg:px-14 py-6 bg-zinc-900/60 backdrop-blur-md border-b border-white/10"
        aria-label="menu principal">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
    
            <!-- LOGO -->
            <img 
                src="{{ asset('img/Logo1.png') }}"
                class="w-14 h-14 object-contain"
                alt="Explora Candelaria"
            >
    
            <!-- TEXTO -->
            <div class="hidden sm:block">
                <h1 class="text-xl font-black uppercase tracking-wide text-[#77f062] leading-none">
                    Explora Candelaria
                </h1>
    
                <p class="text-xs text-gray-500 tracking-[0.2em] uppercase mt-1">
                    Descubre · Reserva · Vive
                </p>
            </div>
    
        </a>
    <ul class="hidden items-center gap-4 sm:flex">
        <li><a href="{{ route('home') }}" class="font-bold text-primary underline-offset-2 hover:text-primary focus:outline-hidden focus:underline dark:text-primary-dark dark:hover:text-primary-dark" aria-current="page">Inicio</a></li>
        <li><a href="#" class="font-medium text-on-surface underline-offset-2 hover:text-primary focus:outline-hidden focus:underline dark:text-on-surface-dark dark:hover:text-primary-dark">Sitios Turisticos</a></li>
        <li><a href="#" class="font-medium text-on-surface underline-offset-2 hover:text-primary focus:outline-hidden focus:underline dark:text-on-surface-dark dark:hover:text-primary-dark">Actividades</a></li>
        <li><a href="#" class="font-medium text-on-surface underline-offset-2 hover:text-primary focus:outline-hidden focus:underline dark:text-on-surface-dark dark:hover:text-primary-dark">Eventos</a></li>

        <li x-data="{ serviciosDropDownIsOpen: false, serviciosOpenWithKeyboard: false }" x-on:keydown.esc.window="serviciosDropDownIsOpen = false, serviciosOpenWithKeyboard = false" class="relative flex items-center">
            <button
                x-on:click="serviciosDropDownIsOpen = ! serviciosDropDownIsOpen"
                x-bind:aria-expanded="serviciosDropDownIsOpen"
                x-on:keydown.space.prevent="serviciosOpenWithKeyboard = true"
                x-on:keydown.enter.prevent="serviciosOpenWithKeyboard = true"
                x-on:keydown.down.prevent="serviciosOpenWithKeyboard = true"
                class="rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:focus-visible:outline-primary-dark"
                aria-controls="serviciosMenu"
            >
                <span class="font-medium text-on-surface underline-offset-2 hover:text-primary focus:outline-hidden focus:underline dark:text-primary-dark dark:hover:text-primary-dark">Servicios</span>
            </button>

            <ul
                x-cloak
                x-show="serviciosDropDownIsOpen || serviciosOpenWithKeyboard"
                x-transition:opacity
                x-trap="serviciosOpenWithKeyboard"
                x-on:click.outside="serviciosDropDownIsOpen = false, serviciosOpenWithKeyboard = false"
                x-on:keydown.down.prevent="$focus.wrap().next()"
                x-on:keydown.up.prevent="$focus.wrap().previous()"
                id="serviciosMenu"
                class="absolute left-0 top-12 z-50 flex w-fit min-w-60 flex-col overflow-hidden rounded-radius border border-outline bg-white py-1.5 shadow-lg dark:border-outline-dark dark:bg-surface-dark-alt"
            >
                <li>
                    <a href="{{ route('turista.servicios.index') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 focus-visible:bg-gray-100 focus-visible:text-gray-800 focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-white dark:hover:bg-surface-alt/5 dark:hover:text-white">Hospedaje</a>
                </li>
                <li>
                    <a href="{{ route('turista.servicios.index') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 focus-visible:bg-gray-100 focus-visible:text-gray-800 focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-white dark:hover:bg-surface-alt/5 dark:hover:text-white">Alimentación</a>
                </li>
                <li>
                    <a href="{{ route('turista.servicios.index') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 focus-visible:bg-gray-100 focus-visible:text-gray-800 focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-white dark:hover:bg-surface-alt/5 dark:hover:text-white">Guianza</a>
                </li>
                <li>
                    <a href="{{ route('turista.servicios.index') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 focus-visible:bg-gray-100 focus-visible:text-gray-800 focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-white dark:hover:bg-surface-alt/5 dark:hover:text-white">Equipos turisticos</a>
                </li>
                <li>
                    <a href="{{ route('turista.servicios.index') }}" class="block px-4 py-2 text-sm text-gray-800 hover:bg-gray-100 focus-visible:bg-gray-100 focus-visible:text-gray-800 focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-white dark:hover:bg-surface-alt/5 dark:hover:text-white">Paquetes turisticos</a>
                </li>
            </ul>
        </li>

        <!-- VISTA PARA USUARIOS INVITADOS -->
        @guest
        <li class="flex items-center gap-3 ml-4">
            <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:text-[#7ed957] transition px-3 py-2">
                Iniciar Sesión
            </a>
            <a href="{{ route('register') }}" class="rounded-full bg-[#0b8a0f] px-5 py-2 text-sm font-bold text-white hover:bg-[#276a25] transition shadow-lg">
                Registrarse
            </a>
        </li>
        @endguest

        <!-- VISTA PARA USUARIOS AUTENTICADOS -->
        @auth
        <li x-data="{ userDropDownIsOpen: false, openWithKeyboard: false }" x-on:keydown.esc.window="userDropDownIsOpen = false, openWithKeyboard = false" class="relative flex items-center ml-4">
            <button x-on:click="userDropDownIsOpen = ! userDropDownIsOpen" x-bind:aria-expanded="userDropDownIsOpen" x-on:keydown.space.prevent="openWithKeyboard = true" x-on:keydown.enter.prevent="openWithKeyboard = true" x-on:keydown.down.prevent="openWithKeyboard = true" class="rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:focus-visible:outline-primary-dark" aria-controls="userMenu">
                <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-8.webp" alt="User Profile" class="size-10 rounded-full object-cover border-2 border-primary" />
            </button>
                <ul x-cloak x-show="userDropDownIsOpen || openWithKeyboard"
                        x-transition.opacity
                        x-trap="openWithKeyboard"
                        x-on:click.outside="userDropDownIsOpen = false, openWithKeyboard = false"
                        x-on:keydown.down.prevent="$focus.wrap().next()"
                        x-on:keydown.up.prevent="$focus.wrap().previous()"
                        id="userMenu"

                        class="absolute right-0 top-14 flex w-56 flex-col overflow-hidden rounded-3xl
                        border border-white/10 bg-zinc-900/95 backdrop-blur-xl shadow-2xl py-2">

                        <li class="border-b border-white/10">
                            <div class="flex flex-col px-5 py-4">
                                <span class="text-sm font-semibold text-white">
                                    {{ Auth::user()->name }}
                                </span>

                                <p class="text-xs text-gray-400">
                                    Turista
                                </p>
                            </div>
                        </li>

                        <li>
                            <a href="{{ route('profile.edit') }}"
                            class="block px-5 py-3 text-sm text-gray-200 hover:bg-white/10 hover:text-[#7ed957] transition">
                                Mi Perfil
                            </a>
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block px-5 py-3 text-sm text-gray-200 hover:bg-red-500/20 hover:text-red-400 transition">
                                    Cerrar Sesión
                                </a>
                            </form>
                        </li>

                </ul>
        </li>
        @endauth

    </ul>
    <button x-on:click="mobileMenuIsOpen = !mobileMenuIsOpen" x-bind:aria-expanded="mobileMenuIsOpen" x-bind:class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20' : null" type="button" class="flex text-on-surface dark:text-on-surface-dark sm:hidden" aria-label="mobile menu" aria-controls="mobileMenu">
        <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
        <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" aria-hidden="true" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    </button>
    <ul x-cloak x-show="mobileMenuIsOpen" x-transition:enter="transition motion-reduce:transition-none ease-out duration-300" x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition motion-reduce:transition-none ease-out duration-300" x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col rounded-b-radius border-b border-outline bg-surface-alt px-8 pb-6 pt-10 dark:border-outline-dark dark:bg-surface-dark-alt sm:hidden">
        
        @auth
        <li class="mb-4 border-none">
            <div class="flex items-center gap-3 py-2">
                <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-8.webp" alt="User Profile" class="size-12 rounded-full object-cover border-2 border-primary"  />
                <div>
                    <span class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">{{ Auth::user()->name }}</span>
                    <p class="text-sm text-on-surface dark:text-on-surface-dark">Turista</p>
                </div>  
            </div>
        </li>
        @endauth

        <li class="p-2"><a href="{{ route('home') }}" class="w-full text-lg font-bold text-primary focus:underline dark:text-primary-dark" aria-current="page">Inicio</a></li>
        <li class="p-2"><a href="#" class="w-full text-lg font-medium text-gray-800 focus:underline dark:text-on-surface-dark">Sitios Turísticos</a></li>
        <li class="p-2"><a href="#" class="w-full text-lg font-medium text-gray-800 focus:underline dark:text-on-surface-dark">Actividades</a></li>
        <li class="p-2"><a href="#" class="w-full text-lg font-medium text-gray-800 focus:underline dark:text-on-surface-dark">Eventos</a></li>

        <li class="p-2" x-data="{ serviciosDropDownIsOpenMobile: false }">
            <button
                x-on:click="serviciosDropDownIsOpenMobile = !serviciosDropDownIsOpenMobile"
                class="w-full text-left text-lg font-medium text-gray-800 focus:underline dark:text-on-surface-dark"
                type="button"
                aria-controls="serviciosMenuMobile"
                x-bind:aria-expanded="serviciosDropDownIsOpenMobile"
            >
                Servicios
            </button>

            <ul
                id="serviciosMenuMobile"
                x-cloak
                x-show="serviciosDropDownIsOpenMobile"
                class="mt-2 flex flex-col gap-2 pl-2"
            >
                <li><a href="{{ route('turista.servicios.index') }}" class="w-full text-base font-medium text-zinc-900 hover:text-primary focus:underline dark:text-white">Hospedaje</a></li>
                <li><a href="{{ route('turista.servicios.index') }}" class="w-full text-base font-medium text-zinc-900 hover:text-primary focus:underline dark:text-white">Alimentación</a></li>
                <li><a href="{{ route('turista.servicios.index') }}" class="w-full text-base font-medium text-zinc-900 hover:text-primary focus:underline dark:text-white">Guianza</a></li>
                <li><a href="{{ route('turista.servicios.index') }}" class="w-full text-base font-medium text-zinc-900 hover:text-primary focus:underline dark:text-white">Equipos turisticos</a></li>
                <li><a href="{{ route('turista.servicios.index') }}" class="w-full text-base font-medium text-zinc-900 hover:text-primary focus:underline dark:text-white">Paquetes turisticos</a></li>
            </ul>
        </li>

        <hr role="none" class="my-4 border-outline dark:border-outline-dark">
        
        @guest
        <li class="mt-2 w-full border-none">
            <a href="{{ route('login') }}" class="rounded-radius bg-surface-alt border border-outline px-4 py-2 block text-center font-medium tracking-wide text-gray-800 hover:bg-surface-dark-alt/5 focus-visible:outline-2 dark:bg-surface-dark-alt dark:border-outline-dark dark:text-on-surface-dark">
                Iniciar Sesión
            </a>
        </li>
        <li class="mt-4 w-full border-none">
            <a href="{{ route('register') }}" class="rounded-radius bg-[#0b8a0f] border-[#0b8a0f] px-4 py-2 block text-center font-medium tracking-wide text-white hover:opacity-75 focus-visible:outline-2 focus-visible:outline-primary dark:bg-primary-dark dark:border-primary-dark">
                Registrarse
            </a>
        </li>
        @endguest

        @auth
        <li class="mt-2 w-full border-none">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="rounded-radius border border-red-500/50 bg-red-500/10 px-4 py-2 block text-center font-medium tracking-wide text-red-500 hover:bg-red-500/20">
                    Cerrar Sesión
                </a>
            </form>
        </li>
        @endauth
    </ul>
</nav>

<!-- DISEÑO  -->
<!-- HERO PRINCIPAL -->
<section class="relative w-full h-screen overflow-hidden">

    <!-- IMAGEN FONDO -->
    <div class="absolute inset-0">

        <img 
            src="{{ asset('img/fondo4.png') }}"
            class="w-full h-full object-cover"
            alt="Explora Candelaria"
        >

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-black/20"></div>

    </div>

    <!-- CONTENIDO -->
    <div class="relative z-20 flex h-full">

        <!-- SIDEBAR -->
        <div class="hidden lg:flex w-28 bg-black/40 backdrop-blur-md flex-col items-center justify-between py-10 border-r border-white/10">

            <!-- LOGO -->
            <div class="flex flex-col items-center">


            </div>

            <!-- TEXTO -->
            <div class="rotate-[-90deg] whitespace-nowrap text-white/50 tracking-[0.4em] text-xs uppercase">
                Descubre · Reserva · Vive experiencias
            </div>

            <!-- BOTON -->
            <button class="w-14 h-14 rounded-full bg-[#0b8a0f] hover:bg-[#276a25] transition flex items-center justify-center text-white text-2xl shadow-2xl">
                ↓
            </button>

        </div>

        <!-- TEXO PRINCIPAL -->
        <div class="flex items-center px-10 lg:px-24 w-full">

            <div class="max-w-3xl mt-24">
                 
                <!-- MINI TEXTO -->
                <p class="uppercase tracking-[0.5em] text-[#7ed957] text-sm mb-5">
                    Turismo • Naturaleza • Cultura
                </p>

                <!-- TITULO -->
                <h1 class="text-white text-6xl md:text-8xl font-black uppercase leading-none drop-shadow-2xl">
                    Explora <br>
                    La Candelaria
                </h1>

                <!-- DESCRIPCION -->
                <p class="mt-8 text-lg md:text-xl text-gray-200 leading-relaxed max-w-2xl">
                    Descubre destinos únicos, reserva experiencias inolvidables
                    y vive la magia turística de La Candelaria desde un solo lugar.
                </p>

                <!-- BOTONES -->
                <div class="flex flex-wrap gap-5 mt-10">

                    <a href="{{ route('turista.servicios.index') }}"
                    class="px-8 py-4 bg-[#0b8a0f] hover:bg-[#276a25] text-white rounded-full text-sm uppercase tracking-[0.3em] transition duration-300 shadow-2xl">
                        Explorar
                    </a>

                    <a href="{{ route('turista.servicios.index') }}"
                    class="px-8 py-4 border border-white/40 hover:bg-white hover:text-black text-white rounded-full text-sm uppercase tracking-[0.3em] transition duration-300 backdrop-blur-md">
                        Reservar Ahora
                    </a>

                </div>

            </div>

        </div>

    </div>

    <!-- SOCIAL BAR -->
    <div class="absolute bottom-0 right-0 z-30">

        <div class="flex items-center gap-8 bg-black/50 backdrop-blur-md px-10 py-5 border-t border-l border-white/10 rounded-tl-3xl">

            <span class="text-white/60 uppercase tracking-[0.3em] text-xs">
                Síguenos
            </span>

            <a href="https://www.facebook.com/parroquia.lacandelaria.5" class="text-white hover:text-[#7ed957] transition text-lg">
                Facebook
            </a>

            <a href="" class="text-white hover:text-[#7ed957] transition text-lg">
                Instagram
            </a>

            <a href="https://www.tiktok.com/@gadlacandelaria" class="text-white hover:text-[#7ed957] transition text-lg">
                TikTok
            </a>

        </div>

    </div>

</section>

</body>
</html>