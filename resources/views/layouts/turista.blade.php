<!DOCTYPE html>
<html lang="es">
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
                        primary: '#07b25f',
                        'primary-dark': '#87ec83',
                        secondary: '#7ed957',
                        'on-primary': '#ffffff',
                        'on-primary-dark': '#ffffff',
                        surface: '#ffffff',
                        'surface-alt': '#f5fdf5',
                        'surface-dark': '#0b1a0b',
                        'surface-dark-alt': '#163016',
                        'on-surface': '#f3f4f6',
                        'on-surface-strong': '#ffffff',
                        'on-surface-dark': '#d1fae5',
                        'on-surface-dark-strong': '#ffffff',
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

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @livewireStyles
    @fluxAppearance
</head>
<body class="bg-green-50 min-h-screen flex flex-col">

    @php
        $isHome = request()->routeIs('home');
        $isSettingsRoute = request()->routeIs('profile.edit', 'user-password.edit', 'two-factor.show', 'appearance.edit');

        $navBg = $isHome
            ? 'bg-zinc-900/60 border-b border-white/10'
            : 'bg-white/90 border-b border-slate-200 shadow-sm';

        $logoText = $isHome
            ? 'text-[#77f062]'
            : 'text-emerald-700';

        $menuText = $isHome
            ? 'text-white hover:text-[#77f062]'
            : 'text-slate-700 hover:text-emerald-700';
    @endphp

    <nav 
        x-data="{ mobileMenuIsOpen: false }"
        x-on:click.away="mobileMenuIsOpen = false"
        class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 lg:px-14 py-4 backdrop-blur-xl transition-all duration-300 {{ $navBg }}"
        aria-label="menu principal"
    >
        <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
            <img 
                src="{{ asset('img/Logo1.png') }}"
                class="w-12 h-12 lg:w-14 lg:h-14 object-contain"
                alt="Explora Candelaria"
            >
            <div class="hidden sm:block">
                <h1 class="text-lg lg:text-xl font-black uppercase tracking-wide leading-none {{ $logoText }}">
                    Explora Candelaria
                </h1>
                <p class="text-[10px] lg:text-xs text-slate-500 tracking-[0.2em] uppercase mt-1">
                    Descubre · Reserva · Vive
                </p>
            </div>
        </a>

        <ul class="hidden items-center gap-6 lg:flex">
            <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'font-bold text-emerald-600 underline underline-offset-4' : 'font-medium ' . $menuText }}">Inicio</a></li>
            <li><a href="{{ route('sitios') ?? '#' }}" class="{{ request()->routeIs('sitios') ? 'font-bold text-emerald-600 underline underline-offset-4' : 'font-medium ' . $menuText }}">Sitios Turísticos</a></li>
            <li><a href="{{ route('actividades') ?? '#' }}" class="{{ request()->routeIs('actividades') ? 'font-bold text-emerald-600 underline underline-offset-4' : 'font-medium ' . $menuText }}">Actividades</a></li>
            <li><a href="{{ route('festividades') ?? '#' }}" class="{{ request()->routeIs('festividades') ? 'font-bold text-emerald-600 underline underline-offset-4' : 'font-medium ' . $menuText }}">Eventos</a></li>

            <li 
                x-data="{ serviciosDropDownIsOpen: false, serviciosOpenWithKeyboard: false }"
                x-on:keydown.esc.window="serviciosDropDownIsOpen = false, serviciosOpenWithKeyboard = false"
                class="relative flex items-center">

                <button
                    x-on:click="serviciosDropDownIsOpen = ! serviciosDropDownIsOpen"
                    x-bind:aria-expanded="serviciosDropDownIsOpen"
                    x-on:keydown.space.prevent="serviciosOpenWithKeyboard = true"
                    x-on:keydown.enter.prevent="serviciosOpenWithKeyboard = true"
                    x-on:keydown.down.prevent="serviciosOpenWithKeyboard = true"
                    class="rounded-full focus:outline-none"
                    aria-controls="serviciosMenu"
                >
                    <span class="{{ request()->routeIs('turista.servicios.*') ? 'font-bold text-emerald-600 underline underline-offset-4' : 'font-medium ' . $menuText }}">
                        Servicios
                    </span>
                </button>

                <ul
                    x-cloak
                    x-show="serviciosDropDownIsOpen || serviciosOpenWithKeyboard"
                    x-transition:opacity
                    x-trap="serviciosOpenWithKeyboard"
                    x-on:click.outside="serviciosDropDownIsOpen = false, serviciosOpenWithKeyboard = false"
                    id="serviciosMenu"
                    class="absolute left-0 top-12 z-50 flex w-60 flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white py-2 shadow-xl"
                >
                    <li class="border-b border-slate-100"><a href="{{ route('turista.servicios.index') }}" class="block px-4 py-3 text-sm font-bold text-emerald-700 hover:bg-slate-50">Ver todos los servicios</a></li>
                    <li><a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => 4]) }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">Hospedaje</a></li>
                    <li><a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => 3]) }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">Alimentación</a></li>
                    <li><a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => 1]) }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">Guianza</a></li>
                    <li><a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => 5]) }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">Equipos turísticos</a></li>
                    <li><a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => 2]) }}" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">Paquetes turísticos</a></li>
                </ul>
            </li>

            @auth
                @if(auth()->user()->hasRole('admin'))
                <li class="flex items-center ml-4">
                    <a href="{{ url('/admin') }}" class="rounded-full bg-slate-800 px-5 py-2 text-sm font-bold text-white hover:bg-slate-700 transition shadow-lg shrink-0">Ir a Panel Admin</a>
                </li>
                @elseif(auth()->user()->hasRole('emprendimiento'))
                <li class="flex items-center ml-4">
                    <a href="{{ route('emprendimiento.panel') }}" class="rounded-full bg-slate-800 px-5 py-2 text-sm font-bold text-white hover:bg-slate-700 transition shadow-lg shrink-0">Ir a Gestión</a>
                </li>
                @else
                <li 
                    x-data="{ userDropDownIsOpen: false }"
                    class="relative flex items-center ml-4">

                    <button x-on:click="userDropDownIsOpen = ! userDropDownIsOpen" class="rounded-full focus:outline-none" aria-controls="userMenu">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-emerald-500 bg-slate-100 text-slate-500 hover:text-emerald-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>

                    <ul
                        x-cloak
                        x-show="userDropDownIsOpen"
                        x-transition.opacity
                        x-on:click.outside="userDropDownIsOpen = false"
                        id="userMenu"
                        class="absolute right-0 top-14 flex w-56 flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl py-2"
                    >
                        <li class="border-b border-slate-100">
                            <div class="flex flex-col px-5 py-4">
                                <span class="text-sm font-bold text-slate-800">{{ Auth::user()->name }}</span>
                                <p class="text-xs text-slate-500">Turista</p>
                            </div>
                        </li>
                        
                        <li><a href="{{ route('profile.edit') }}" class="block px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-emerald-600 transition">Mi Perfil</a></li>
                        <li><a href="{{ route('turista.reservas.historial') ?? '#' }}" class="block px-5 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-emerald-600 transition">Mis Reservas</a></li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-5 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition">Cerrar Sesión</a>
                            </form>
                        </li>
                    </ul>
                </li>
                @endif
            @endauth

            @guest
            <li class="flex items-center gap-3 ml-4">
                <a href="{{ route('login') }}" class="text-sm font-medium {{ $menuText }} transition px-3 py-2">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="rounded-full bg-emerald-600 px-5 py-2 text-sm font-bold text-white hover:bg-emerald-700 transition shadow-lg shrink-0">Registrarse</a>
            </li>
            @endguest
        </ul>

        <button
            x-on:click="mobileMenuIsOpen = !mobileMenuIsOpen"
            x-bind:aria-expanded="mobileMenuIsOpen"
            x-bind:class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20 text-slate-800' : '{{ $menuText }}'"
            type="button"
            class="flex lg:hidden focus:outline-none"
            aria-label="mobile menu"
        >
            <svg x-cloak x-show="!mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
            <svg x-cloak x-show="mobileMenuIsOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
        </button>

        <ul x-cloak x-show="mobileMenuIsOpen" x-transition:enter="transition motion-reduce:transition-none ease-out duration-300" x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition motion-reduce:transition-none ease-out duration-300" x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col rounded-b-2xl border-b border-gray-200 bg-white px-8 pb-6 pt-10 shadow-xl lg:hidden">
            @auth
                @if(auth()->user()->hasRole('admin'))
                <li class="mt-2 w-full border-none">
                    <a href="{{ url('/admin') }}" class="rounded-xl bg-slate-800 border border-slate-800 px-4 py-3 block text-center font-bold text-white hover:bg-slate-700 shadow-sm">Ir a Panel Admin</a>
                </li>
                @elseif(auth()->user()->hasRole('emprendimiento'))
                <li class="mt-2 w-full border-none">
                    <a href="{{ route('emprendimiento.panel') }}" class="rounded-xl bg-slate-800 border border-slate-800 px-4 py-3 block text-center font-bold text-white hover:bg-slate-700 shadow-sm">Ir a Mi Gestión</a>
                </li>
                @else
                <li class="mb-4 border-none">
                    <div class="flex items-center gap-3 py-2">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full border-2 border-emerald-500 bg-slate-100 text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-slate-800">{{ Auth::user()->name }}</span>
                            <p class="text-sm text-slate-500">Turista</p>
                        </div>  
                    </div>
                </li>
                @endif
            @endauth

            <li class="p-2"><a href="{{ route('home') }}" class="w-full text-lg font-bold text-emerald-600 focus:underline">Inicio</a></li>
            <li class="p-2"><a href="{{ route('sitios') ?? '#' }}" class="w-full text-lg font-medium text-slate-700 hover:text-emerald-600 focus:underline">Sitios Turísticos</a></li>
            <li class="p-2"><a href="{{ route('actividades') ?? '#' }}" class="w-full text-lg font-medium text-slate-700 hover:text-emerald-600 focus:underline">Actividades</a></li>
            <li class="p-2"><a href="{{ route('festividades') ?? '#' }}" class="w-full text-lg font-medium text-slate-700 hover:text-emerald-600 focus:underline">Eventos</a></li>

            <li class="p-2" x-data="{ serviciosDropDownIsOpenMobile: false }">
                <button
                    x-on:click="serviciosDropDownIsOpenMobile = !serviciosDropDownIsOpenMobile"
                    class="w-full text-left text-lg font-medium text-slate-700 focus:outline-none"
                    type="button"
                    x-bind:aria-expanded="serviciosDropDownIsOpenMobile"
                >
                    Servicios
                </button>

                <ul
                    id="serviciosMenuMobile"
                    x-cloak
                    x-show="serviciosDropDownIsOpenMobile"
                    class="mt-2 flex flex-col gap-2 pl-4 border-l-2 border-slate-100 ml-2"
                >
                    <li><a href="{{ route('turista.servicios.index') }}" class="w-full text-base font-bold text-emerald-600 focus:underline">Ver todos los servicios</a></li>
                    <li><a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => 4]) }}" class="w-full text-base font-medium text-slate-600 hover:text-emerald-600 focus:underline">Hospedaje</a></li>
                    <li><a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => 3]) }}" class="w-full text-base font-medium text-slate-600 hover:text-emerald-600 focus:underline">Alimentación</a></li>
                    <li><a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => 1]) }}" class="w-full text-base font-medium text-slate-600 hover:text-emerald-600 focus:underline">Guianza</a></li>
                    <li><a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => 5]) }}" class="w-full text-base font-medium text-slate-600 hover:text-emerald-600 focus:underline">Equipos turisticos</a></li>
                    <li><a href="{{ route('turista.servicios.index', ['tipoServicioSeleccionado' => 2]) }}" class="w-full text-base font-medium text-slate-600 hover:text-emerald-600 focus:underline">Paquetes turisticos</a></li>
                </ul>
            </li>

            <hr role="none" class="my-4 border-slate-200">
            
            @guest
            <li class="mt-2 w-full border-none">
                <a href="{{ route('login') }}" class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 block text-center font-bold text-slate-700 hover:bg-slate-100">Iniciar Sesión</a>
            </li>
            <li class="mt-3 w-full border-none">
                <a href="{{ route('register') }}" class="rounded-xl bg-emerald-600 border border-emerald-600 px-4 py-3 block text-center font-bold text-white hover:opacity-90 shadow-sm">Registrarse</a>
            </li>
            @endguest

            @auth
                @if(auth()->user()->hasRole('admin'))
                <li class="mt-3 w-full border-none">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="rounded-xl border border-red-500/50 bg-red-50 px-4 py-3 block text-center font-bold text-red-600 hover:bg-red-100">Cerrar Sesión</a>
                    </form>
                </li>
                @elseif(auth()->user()->hasRole('emprendimiento'))
                <li class="mt-3 w-full border-none">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="rounded-xl border border-red-500/50 bg-red-50 px-4 py-3 block text-center font-bold text-red-600 hover:bg-red-100">Cerrar Sesión</a>
                    </form>
                </li>
                @else
                <li class="mt-2 w-full border-none">
                    <a href="{{ route('turista.reservas.historial') ?? '#' }}" class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 block text-center font-bold text-slate-700 hover:bg-slate-100">Mis Reservas</a>
                </li>
                <li class="mt-3 w-full border-none">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="rounded-xl border border-red-500/50 bg-red-50 px-4 py-3 block text-center font-bold text-red-600 hover:bg-red-100">Cerrar Sesión</a>
                    </form>
                </li>
                @endif
            @endauth
        </ul>
    </nav>

    <main class="{{ $isHome ? '' : 'pt-28' }} min-h-screen flex-1 {{ $isSettingsRoute ? 'bg-slate-50' : '' }}">
        @yield('content')

        @if ($isSettingsRoute)
            <section class="mx-auto w-full max-w-6xl px-4 pb-14 pt-6 sm:px-6 lg:px-8">
                {{ $slot ?? '' }}
            </section>
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    {{-- FOOTER INSTITUCIONAL DEL GAD (Por defecto) --}}
    @if(!View::hasSection('ocultar_footer_gad'))
        @include('components.Turista_Admin.footer_turista')
    @endif

    {{-- Aquí se inyectará el footer del negocio si la vista lo solicita --}}
    @yield('footer_personalizado')

    {{-- ¡ESTAS TRES LÍNEAS SE QUEDAN! --}}
    @include('components.asistente-virtual')

    @fluxScripts
    @livewireScripts

</body>
</html>