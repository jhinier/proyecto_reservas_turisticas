@php

    $isHome = request()->routeIs('home');

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
    class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-8 lg:px-14 py-4 backdrop-blur-xl transition-all duration-300 {{ $navBg }}"
>

    {{-- LOGO --}}
    <a href="{{ route('home') }}" class="flex items-center gap-3">

        <img 
            src="{{ asset('img/Logo.png') }}"
            class="w-12 h-12 object-contain"
            alt="Explora Candelaria"
        >

        <div class="hidden sm:block">

            <h1 class="text-xl font-black uppercase tracking-wide leading-none {{ $logoText }}">
                Explora Candelaria
            </h1>

            <p class="text-xs text-slate-500 tracking-[0.2em] uppercase mt-1">
                Descubre · Reserva · Vive
            </p>

        </div>

    </a>

    {{-- MENU DESKTOP --}}
    <ul class="hidden items-center gap-6 sm:flex">

        {{-- INICIO --}}
        <li>
            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home')
                    ? 'font-bold text-emerald-600 underline underline-offset-4'
                    : 'font-medium ' . $menuText }}">

                Inicio

            </a>
        </li>

        {{-- SITIOS --}}
        <li>
            <a href="{{ route('sitios') }}"
               class="{{ request()->routeIs('sitios')
                    ? 'font-bold text-emerald-600 underline underline-offset-4'
                    : 'font-medium ' . $menuText }}">

                Sitios Turísticos

            </a>
        </li>

        {{-- ACTIVIDADES --}}
        <li>
            <a href="{{ route('actividades') }}"
               class="{{ request()->routeIs('actividades')
                    ? 'font-bold text-emerald-600 underline underline-offset-4'
                    : 'font-medium ' . $menuText }}">

                Actividades

            </a>
        </li>

        {{-- EVENTOS --}}
        <li>
            <a href="{{ route('festividades') }}"
               class="{{ request()->routeIs('festividades')
                    ? 'font-bold text-emerald-600 underline underline-offset-4'
                    : 'font-medium ' . $menuText }}">

                Eventos

            </a>
        </li>

        {{-- SERVICIOS --}}
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
                class="rounded-full"
                aria-controls="serviciosMenu">

                <span class="{{ request()->routeIs('turista.servicios.*')
                    ? 'font-bold text-emerald-600 underline underline-offset-4'
                    : 'font-medium ' . $menuText }}">

                    Servicios

                </span>

            </button>

            {{-- DROPDOWN --}}
            <ul
                x-cloak
                x-show="serviciosDropDownIsOpen || serviciosOpenWithKeyboard"
                x-transition:opacity
                x-trap="serviciosOpenWithKeyboard"
                x-on:click.outside="serviciosDropDownIsOpen = false, serviciosOpenWithKeyboard = false"
                id="serviciosMenu"
                class="absolute left-0 top-12 z-50 flex w-60 flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white py-2 shadow-xl">

                <li class="border-b border-slate-100">

                    <a href="{{ route('turista.servicios.index') }}"
                       class="block px-4 py-3 text-sm font-bold text-emerald-700 hover:bg-slate-50">

                        Ver todos los servicios

                    </a>

                </li>

                <li>
                    <a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                        Hospedaje
                    </a>
                </li>

                <li>
                    <a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                        Alimentación
                    </a>
                </li>

                <li>
                    <a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                        Guianza
                    </a>
                </li>

                <li>
                    <a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                        Equipos turísticos
                    </a>
                </li>

                <li>
                    <a href="#" class="block px-4 py-3 text-sm text-slate-700 hover:bg-slate-50">
                        Paquetes turísticos
                    </a>
                </li>

            </ul>

        </li>

        {{-- USUARIO --}}
        @auth

        <li 
            x-data="{ userDropDownIsOpen: false }"
            class="relative flex items-center ml-2">

            <button
                x-on:click="userDropDownIsOpen = ! userDropDownIsOpen"
                class="rounded-full"
                aria-controls="userMenu">

                <img
                    src="https://penguinui.s3.amazonaws.com/component-assets/avatar-8.webp"
                    alt="User Profile"
                    class="size-10 rounded-full object-cover border-2 border-emerald-500" />

            </button>

            <ul
                x-cloak
                x-show="userDropDownIsOpen"
                x-transition.opacity
                x-on:click.outside="userDropDownIsOpen = false"
                id="userMenu"
                class="absolute right-0 top-14 flex w-56 flex-col overflow-hidden rounded-3xl border border-white/10 bg-zinc-900/95 backdrop-blur-xl shadow-2xl py-2">

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

        {{-- INVITADO --}}
        @guest

        <li class="flex items-center gap-3 ml-2">

            <a href="{{ route('login') }}"
               class="text-sm font-medium {{ $menuText }} transition px-3 py-2">

                Iniciar Sesión

            </a>

            <a href="{{ route('register') }}"
               class="rounded-full bg-emerald-600 px-5 py-2 text-sm font-bold text-white hover:bg-emerald-700 transition shadow-lg">

                Registrarse

            </a>

        </li>

        @endguest

    </ul>

    {{-- BOTON MOBILE --}}
    <button
        x-on:click="mobileMenuIsOpen = !mobileMenuIsOpen"
        type="button"
        class="flex {{ $menuText }} sm:hidden"
        aria-label="mobile menu">

        <svg
            x-show="!mobileMenuIsOpen"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="size-6">

            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />

        </svg>

        <svg
            x-show="mobileMenuIsOpen"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="size-6">

            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 18 18 6M6 6l12 12" />

        </svg>

    </button>

    <!-- MENU MOBILE -->
    <ul x-cloak x-show="mobileMenuIsOpen" x-transition:enter="transition motion-reduce:transition-none ease-out duration-300" x-transition:enter-start="-translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition motion-reduce:transition-none ease-out duration-300" x-transition:leave-start="translate-y-0" x-transition:leave-end="-translate-y-full" class="fixed max-h-svh overflow-y-auto inset-x-0 top-0 z-10 flex flex-col rounded-b-radius border-b border-outline bg-surface-alt px-8 pb-6 pt-10 dark:border-outline-dark dark:bg-surface-dark-alt sm:hidden">
        
        @auth
        <li class="mb-4 border-none">
            <div class="flex items-center gap-3 py-2">
                <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-8.webp" alt="User Profile" class="size-12 rounded-full object-cover border-2 border-primary"  />
                <div>
                    <span class="font-medium {{ request()->routeIs('home')? 'text-white hover:text-[#77f062]': 'text-slate-700 hover:text-emerald-700'}}-strong dark:{{ request()->routeIs('home')? 'text-white hover:text-[#77f062]': 'text-slate-700 hover:text-emerald-700'}}-dark-strong">{{ Auth::user()->name }}</span>
                    <p class="text-sm {{ request()->routeIs('home')? 'text-white hover:text-[#77f062]': 'text-slate-700 hover:text-emerald-700'}} dark:{{ request()->routeIs('home')? 'text-white hover:text-[#77f062]': 'text-slate-700 hover:text-emerald-700'}}-dark">Turista</p>
                </div>  
            </div>
        </li>
        @endauth

        <li class="p-2"><a href="{{ route('home') }}" class="w-full text-lg font-bold text-primary focus:underline dark:text-primary-dark" aria-current="page">Inicio</a></li>
        <li class="p-2"><a href="#" class="w-full text-lg font-medium text-gray-800 focus:underline dark:{{ request()->routeIs('home')? 'text-white hover:text-[#77f062]': 'text-slate-700 hover:text-emerald-700'}}-dark">Sitios Turísticos</a></li>
        <li class="p-2"><a href="#" class="w-full text-lg font-medium text-gray-800 focus:underline dark:{{ request()->routeIs('home')? 'text-white hover:text-[#77f062]': 'text-slate-700 hover:text-emerald-700'}}-dark">Actividades</a></li>
        <li class="p-2"><a href="#" class="w-full text-lg font-medium text-gray-800 focus:underline dark:{{ request()->routeIs('home')? 'text-white hover:text-[#77f062]': 'text-slate-700 hover:text-emerald-700'}}-dark">Eventos</a></li>

        <li class="p-2" x-data="{ serviciosDropDownIsOpenMobile: false }">
            <button
                x-on:click="serviciosDropDownIsOpenMobile = !serviciosDropDownIsOpenMobile"
                class="w-full text-lg font-medium text-gray-800 focus:underline dark:{{ request()->routeIs('home')? 'text-white hover:text-[#77f062]': 'text-slate-700 hover:text-emerald-700'}}-dark">
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
                <li><a href="{{ route('turista.servicios.index') }}" class="w-full text-base font-bold text-[#0b8a0f] hover:text-primary focus:underline dark:text-primary-dark">Ver todos los servicios</a></li>
                <li><a href="#" class="w-full text-base font-medium text-zinc-900 hover:text-primary focus:underline dark:text-white">Hospedaje</a></li>
                <li><a href="#" class="w-full text-base font-medium text-zinc-900 hover:text-primary focus:underline dark:text-white">Alimentación</a></li>
                <li><a href="#" class="w-full text-base font-medium text-zinc-900 hover:text-primary focus:underline dark:text-white">Guianza</a></li>
                <li><a href="#" class="w-full text-base font-medium text-zinc-900 hover:text-primary focus:underline dark:text-white">Equipos turisticos</a></li>
                <li><a href="#" class="w-full text-base font-medium text-zinc-900 hover:text-primary focus:underline dark:text-white">Paquetes turisticos</a></li>
            </ul>
        </li>

        <hr role="none" class="my-4 border-outline dark:border-outline-dark">
        
        @guest
        <li class="mt-2 w-full border-none">
            <a href="{{ route('login') }}" class="rounded-radius bg-surface-alt border border-outline px-4 py-2 block text-center font-medium tracking-wide text-gray-800 hover:bg-surface-dark-alt/5 focus-visible:outline-2 dark:bg-surface-dark-alt dark:border-outline-dark dark:{{ request()->routeIs('home')? 'text-white hover:text-[#77f062]': 'text-slate-700 hover:text-emerald-700'}}-dark">
                Iniciar Sesión
            </a>
        </li>
        <li class="mt-4 w-full border-none">
            <a href="{{ route('register') }}" class="rounded-radius bg-primary border-primary px-4 py-2 block text-center font-medium tracking-wide text-on-primary hover:opacity-75 focus-visible:outline-2 focus-visible:outline-primary dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark">
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