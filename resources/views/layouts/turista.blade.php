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

    body { top: 0 !important; }
    .skiptranslate iframe { display: none !important; }
    #goog-gt-tt { display: none !important; }
    .goog-tooltip, .goog-tooltip:hover { display: none !important; }
    .goog-text-highlight { background: none !important; box-shadow: none !important; }

    #google_translate_element {
        display: flex;
        align-items: center;
        min-width: 140px;
        min-height: 36px;
    }

    .goog-te-gadget {
        font-size: 0px !important;
        color: transparent !important;
        display: flex !important;
        align-items: center !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .goog-logo-link { display: none !important; }
    .goog-te-gadget img { display: none !important; }

    .goog-te-gadget > span {
        display: inline-block !important;
        width: auto !important;
    }

    .goog-te-combo {
        font-family: inherit !important;
        font-size: 0.875rem !important;
        font-weight: 600 !important;
        color: #10b981 !important;
        border: 1px solid #d1fae5 !important;
        border-radius: 9999px !important;
        padding: 0.35rem 2.25rem 0.35rem 1rem !important;
        background-color: #ecfdf5 !important;
        cursor: pointer !important;
        outline: none !important;
        margin: 0 !important;
        -webkit-appearance: none !important;
        -moz-appearance: none !important;
        appearance: none !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%2310b981' stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
        background-position: right 0.75rem center !important;
        background-repeat: no-repeat !important;
        background-size: 1.25em 1.25em !important;
        height: 36px !important;
        width: 140px !important;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
        transition: all 0.3s ease;
    }

    .goog-te-combo option {
        background-color: #ffffff !important;
        color: #374151 !important;
        font-size: 14px !important;
    }

    .goog-te-combo:hover {
        border-color: #10b981 !important;
        background-color: #d1fae5 !important;
    }

    .goog-te-gadget-simple {
        font-family: inherit !important;
        font-size: 0.875rem !important;
        font-weight: 600 !important;
        color: #10b981 !important;
        border: 1px solid #d1fae5 !important;
        border-radius: 9999px !important;
        padding: 0.4rem 1rem !important;
        background-color: #ecfdf5 !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 0.35rem !important;
        height: 36px !important;
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
        transition: all 0.3s ease !important;
        line-height: 1 !important;
        text-decoration: none !important;
    }

    .goog-te-gadget-simple:hover {
        border-color: #10b981 !important;
        background-color: #d1fae5 !important;
    }

    .goog-te-gadget-simple .VIpgJd-ZVi9od-ORHb-OEVmcd,
    .goog-te-gadget-simple .goog-te-menu-value,
    .goog-te-gadget-simple .goog-te-menu-value span {
        color: #10b981 !important;
        font-size: 0.875rem !important;
        font-weight: 600 !important;
    }

    .goog-te-gadget-simple img {
        display: none !important;
    }

    .goog-te-gadget-simple .goog-te-menu-value:after,
    .goog-te-gadget-simple .goog-te-menu-value span:last-child {
        border: none !important;
    }

    .dark .tourist-app .goog-te-combo,
    .dark .tourist-app .goog-te-gadget-simple {
        color: #d1fae5 !important;
        border-color: rgba(134, 239, 172, 0.28) !important;
        background-color: rgba(20, 83, 45, 0.35) !important;
        box-shadow: none !important;
    }

    .dark .tourist-app #google_translate_element .goog-te-combo,
    .dark .tourist-app #google_translate_element .goog-te-combo *,
    .dark .tourist-app #google_translate_element .goog-te-gadget-simple,
    .dark .tourist-app #google_translate_element .goog-te-gadget-simple *,
    .dark .tourist-app #google_translate_element .goog-te-menu-value,
    .dark .tourist-app #google_translate_element .goog-te-menu-value span {
        color: #d1fae5 !important;
    }

    .dark .tourist-app #google_translate_element .goog-te-combo {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23d1fae5' stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e") !important;
    }

    .dark .tourist-app .goog-te-combo option {
        background-color: #18181b !important;
        color: #f8fafc !important;
    }

    .dark .tourist-app main,
    .dark .tourist-app main [class*="bg-[#f4f9f4]"] {
        background-color: #07110d !important;
    }

    .dark .tourist-app main .bg-white,
    .dark .tourist-app main [class*="bg-white/90"],
    .dark .tourist-app main [class*="bg-white/100"] {
        background-color: #18181b !important;
    }

    .dark .tourist-app main .h-2.rounded-full.bg-white {
        background-color: #ffffff !important;
    }

    .dark .tourist-app main .bg-gray-50,
    .dark .tourist-app main .bg-slate-50 {
        background-color: #162018 !important;
    }

    .dark .tourist-app main .bg-gray-100,
    .dark .tourist-app main .bg-slate-100 {
        background-color: #101713 !important;
    }

    .dark .tourist-app main .bg-gray-200,
    .dark .tourist-app main .bg-slate-200 {
        background-color: #263126 !important;
    }

    .dark .tourist-app main .text-gray-900,
    .dark .tourist-app main .text-gray-800,
    .dark .tourist-app main .text-slate-900,
    .dark .tourist-app main .text-slate-800,
    .dark .tourist-app main .text-black,
    .dark .tourist-app main [class*="text-[#06281E]"],
    .dark .tourist-app main [class*="text-[#123524]"] {
        color: #f8fafc !important;
    }

    .dark .tourist-app main .text-gray-700,
    .dark .tourist-app main .text-slate-700,
    .dark .tourist-app main [class*="text-[#464646]"] {
        color: #e2e8f0 !important;
    }

    .dark .tourist-app main .text-gray-600,
    .dark .tourist-app main .text-gray-500,
    .dark .tourist-app main .text-slate-600,
    .dark .tourist-app main .text-slate-500 {
        color: #cbd5e1 !important;
    }

    .dark .tourist-app main .text-gray-400,
    .dark .tourist-app main .text-slate-400 {
        color: #94a3b8 !important;
    }

    .dark .tourist-app main .border-gray-100,
    .dark .tourist-app main .border-gray-200,
    .dark .tourist-app main .border-gray-300,
    .dark .tourist-app main .border-slate-100,
    .dark .tourist-app main .border-slate-200,
    .dark .tourist-app main .border-slate-300 {
        border-color: rgba(148, 163, 184, 0.28) !important;
    }

    .dark .tourist-app main input,
    .dark .tourist-app main textarea,
    .dark .tourist-app main select {
        background-color: #0f172a !important;
        border-color: rgba(148, 163, 184, 0.35) !important;
        color: #f8fafc !important;
    }

    .dark .tourist-app main input::placeholder,
    .dark .tourist-app main textarea::placeholder {
        color: #94a3b8 !important;
    }

    .dark .tourist-app main .shadow-sm,
    .dark .tourist-app main .shadow-lg,
    .dark .tourist-app main .shadow-xl,
    .dark .tourist-app main .shadow-2xl {
        box-shadow: 0 18px 45px rgba(0, 0, 0, 0.35) !important;
    }

    .dark .tourist-app main .bg-emerald-50,
    .dark .tourist-app main .bg-emerald-100,
    .dark .tourist-app main .bg-green-50,
    .dark .tourist-app main .bg-green-100 {
        background-color: rgba(34, 197, 94, 0.14) !important;
    }

    .dark .tourist-app main .text-emerald-700,
    .dark .tourist-app main .text-green-700 {
        color: #86efac !important;
    }

    .dark .tourist-app main .bg-red-50,
    .dark .tourist-app main .bg-red-100 {
        background-color: rgba(239, 68, 68, 0.14) !important;
    }

    .dark .tourist-app main .text-red-600,
    .dark .tourist-app main .text-red-700,
    .dark .tourist-app main .text-red-800,
    .dark .tourist-app main .text-red-900 {
        color: #fca5a5 !important;
    }

    .dark .tourist-app main .bg-yellow-50,
    .dark .tourist-app main .bg-yellow-100,
    .dark .tourist-app main .bg-orange-50,
    .dark .tourist-app main .bg-orange-100 {
        background-color: rgba(245, 158, 11, 0.16) !important;
    }

    .dark .tourist-app main .text-yellow-600,
    .dark .tourist-app main .text-yellow-700,
    .dark .tourist-app main .text-yellow-800,
    .dark .tourist-app main .text-yellow-900,
    .dark .tourist-app main .text-orange-700 {
        color: #fde68a !important;
    }

    .dark .tourist-app main .bg-blue-50,
    .dark .tourist-app main .bg-blue-100,
    .dark .tourist-app main .bg-indigo-50,
    .dark .tourist-app main .bg-indigo-100 {
        background-color: rgba(59, 130, 246, 0.16) !important;
    }

    .dark .tourist-app main .text-blue-600,
    .dark .tourist-app main .text-blue-700,
    .dark .tourist-app main .text-blue-800,
    .dark .tourist-app main .text-indigo-700 {
        color: #93c5fd !important;
    }

    .dark .tourist-app nav .bg-white,
    .dark .tourist-app nav [class*="bg-white/90"],
    .dark .tourist-app nav .bg-slate-50,
    .dark .tourist-app nav .bg-slate-100 {
        background-color: #18181b !important;
    }

    .dark .tourist-app nav .text-slate-800,
    .dark .tourist-app nav .text-slate-700,
    .dark .tourist-app nav .text-gray-700 {
        color: #e2e8f0 !important;
    }

    .dark .tourist-app nav .text-slate-600,
    .dark .tourist-app nav .text-slate-500,
    .dark .tourist-app nav .text-gray-500 {
        color: #94a3b8 !important;
    }

    .dark .tourist-app nav .border-slate-100,
    .dark .tourist-app nav .border-slate-200,
    .dark .tourist-app nav .border-gray-200 {
        border-color: rgba(255, 255, 255, 0.12) !important;
    }

    .dark .tourist-app nav a:hover,
    .dark .tourist-app nav button:hover {
        color: #86efac;
    }

    .dark .tourist-app nav #serviciosMenu a,
    .dark .tourist-app nav #serviciosMenuMobile a {
        color: #e2e8f0 !important;
    }

    .dark .tourist-app nav #serviciosMenu li:first-child a,
    .dark .tourist-app nav #serviciosMenuMobile li:first-child a {
        color: #86efac !important;
    }

    .dark .tourist-app nav #serviciosMenu a:hover,
    .dark .tourist-app nav #serviciosMenu a:focus-visible,
    .dark .tourist-app nav #serviciosMenuMobile a:hover,
    .dark .tourist-app nav #serviciosMenuMobile a:focus-visible {
        background-color: rgba(16, 185, 129, 0.14) !important;
        color: #bbf7d0 !important;
    }

    .dark .tourist-app nav #userMenu,
    .dark .tourist-app nav #userMenu li,
    .dark .tourist-app nav #userMenu div {
        background-color: #18181b !important;
    }

    .dark .tourist-app nav #userMenu a,
    .dark .tourist-app nav #userMenu a *,
    .dark .tourist-app nav #userMenu a font,
    .dark .tourist-app nav #userMenu a span {
        color: #e2e8f0 !important;
        background: transparent !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }

    .dark .tourist-app nav #userMenu a:hover,
    .dark .tourist-app nav #userMenu a:focus-visible {
        background-color: rgba(16, 185, 129, 0.14) !important;
        color: #bbf7d0 !important;
    }

    .dark .tourist-app nav #userMenu a:hover *,
    .dark .tourist-app nav #userMenu a:focus-visible *,
    .dark .tourist-app nav #userMenu a:hover font,
    .dark .tourist-app nav #userMenu a:focus-visible font,
    .dark .tourist-app nav #userMenu a:hover span,
    .dark .tourist-app nav #userMenu a:focus-visible span {
        color: #bbf7d0 !important;
        background: transparent !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }

    .dark .tourist-app nav #userMenu form a,
    .dark .tourist-app nav #userMenu form a *,
    .dark .tourist-app nav #userMenu form a font,
    .dark .tourist-app nav #userMenu form a span {
        color: #f87171 !important;
    }

    .dark .tourist-app nav #userMenu form a:hover,
    .dark .tourist-app nav #userMenu form a:focus-visible {
        background-color: rgba(239, 68, 68, 0.14) !important;
        color: #fca5a5 !important;
    }

    .dark .tourist-app nav #userMenu form a:hover *,
    .dark .tourist-app nav #userMenu form a:focus-visible *,
    .dark .tourist-app nav #userMenu form a:hover font,
    .dark .tourist-app nav #userMenu form a:focus-visible font,
    .dark .tourist-app nav #userMenu form a:hover span,
    .dark .tourist-app nav #userMenu form a:focus-visible span {
        color: #fca5a5 !important;
        background: transparent !important;
        box-shadow: none !important;
        text-shadow: none !important;
    }
</style>

    @livewireStyles
    @fluxAppearance
</head>
<body class="tourist-app bg-[#f4f9f4] min-h-screen flex flex-col text-slate-900 transition-colors dark:bg-[#07110d] dark:text-slate-100">

    @php
        $isHome = request()->routeIs('home');
        $isSettingsRoute = request()->routeIs('profile.edit', 'user-password.edit', 'two-factor.show', 'appearance.edit');

        $navBg = $isHome
            ? 'bg-zinc-900/60 border-b border-white/10'
            : 'bg-white/90 border-b border-slate-200 shadow-sm dark:bg-zinc-950/90 dark:border-white/10';

        $logoText = $isHome
            ? 'text-[#77f062]'
            : 'text-emerald-700 dark:text-emerald-300';

        $menuText = $isHome
            ? 'text-white hover:text-[#77f062]'
            : 'text-slate-700 hover:text-emerald-700 dark:text-slate-200 dark:hover:text-emerald-300';

        $mainBg = $isSettingsRoute
            ? 'bg-slate-50 dark:bg-[#07110d]'
            : 'bg-[#f4f9f4] dark:bg-[#07110d]';
    @endphp

    <nav 
        x-data="{ mobileMenuIsOpen: false }"
        x-on:click.away="mobileMenuIsOpen = false"
        class="fixed top-0 left-0 w-full z-50 flex items-center justify-between px-6 lg:px-14 py-4 backdrop-blur-xl transition-all duration-300 {{ $navBg }}"
        aria-label="menu principal"
    >
        <div class="flex items-center gap-4 lg:gap-8 shrink-0">
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
                    <p class="text-[10px] lg:text-xs text-slate-500 dark:text-slate-400 tracking-[0.2em] uppercase mt-1">
                        Descubre · Reserva · Vive
                    </p>
                </div>
            </a>
            <div id="google_translate_element" wire:ignore class="hidden sm:block pt-1 shrink-0"></div>
        </div>

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
                    class="absolute left-0 top-12 z-50 flex w-60 flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white py-2 shadow-xl dark:border-white/10 dark:bg-zinc-900"
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
                <li x-data="{ userDropDownIsOpen: false }" class="relative flex items-center ml-4">
                    <button x-on:click="userDropDownIsOpen = ! userDropDownIsOpen" class="rounded-full focus:outline-none" aria-controls="userMenu">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full border-2 border-emerald-500 bg-slate-100 text-slate-500 hover:text-emerald-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.751 20.105a8.25 8.25 0 0 1 16.498 0 .75.75 0 0 1-.437.695A18.683 18.683 0 0 1 12 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 0 1-.437-.695Z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                    <ul x-cloak x-show="userDropDownIsOpen" x-transition.opacity x-on:click.outside="userDropDownIsOpen = false" id="userMenu" class="absolute right-0 top-14 flex w-56 flex-col overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-2xl py-2">
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
            x-bind:class="mobileMenuIsOpen ? 'fixed top-6 right-6 z-20 text-slate-800 dark:text-white' : '{{ $menuText }}'"
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
                </li>
                @endif
            @endauth

            <li class="p-2"><a href="{{ route('home') }}" class="w-full text-lg font-bold text-emerald-600 focus:underline">Inicio</a></li>
            <li class="p-2"><a href="{{ route('sitios') ?? '#' }}" class="w-full text-lg font-medium text-slate-700 hover:text-emerald-600 focus:underline">Sitios Turísticos</a></li>
            <li class="p-2"><a href="{{ route('actividades') ?? '#' }}" class="w-full text-lg font-medium text-slate-700 hover:text-emerald-600 focus:underline">Actividades</a></li>
            <li class="p-2"><a href="{{ route('festividades') ?? '#' }}" class="w-full text-lg font-medium text-slate-700 hover:text-emerald-600 focus:underline">Eventos</a></li>
            <li class="p-2" x-data="{ serviciosDropDownIsOpenMobile: false }">
                <button x-on:click="serviciosDropDownIsOpenMobile = !serviciosDropDownIsOpenMobile" class="w-full text-left text-lg font-medium text-slate-700 focus:outline-none" type="button" x-bind:aria-expanded="serviciosDropDownIsOpenMobile">Servicios</button>
                <ul id="serviciosMenuMobile" x-cloak x-show="serviciosDropDownIsOpenMobile" class="mt-2 flex flex-col gap-2 pl-4 border-l-2 border-slate-100 ml-2">
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
                    <a href="{{ route('profile.edit') }}" class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 block text-center font-bold text-slate-700 hover:bg-slate-100">Mi Perfil</a>
                </li>
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

    <main class="{{ $isHome ? '' : 'pt-28' }} min-h-screen flex-1 {{ $mainBg }} transition-colors">
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
    @php
        $footerEmprendimiento = null;

        if (request()->routeIs('turista.empresa.servicios')) {
            $footerEmprendimiento = request()->route('emprendimiento');
        } elseif (request()->routeIs('turista.reservas.checkout')) {
            $emprendimientoId = session('reserva_turista_datos.emprendimiento_id');
            if ($emprendimientoId) {
                $footerEmprendimiento = \App\Models\Emprendimiento::with('user')->find($emprendimientoId);
            }
        }

        if (is_numeric($footerEmprendimiento)) {
            $footerEmprendimiento = \App\Models\Emprendimiento::with('user')->find($footerEmprendimiento);
        } elseif ($footerEmprendimiento instanceof \App\Models\Emprendimiento) {
            $footerEmprendimiento->loadMissing('user');
        }
    @endphp

    @if($footerEmprendimiento instanceof \App\Models\Emprendimiento)
        @include('components.Turista_Admin.footer-turista-emprendimiento', ['emprendimiento' => $footerEmprendimiento])
    @elseif(!$isHome && !View::hasSection('ocultar_footer_gad'))
        @include('components.Turista_Admin.footer_turista')
    @endif

    {{-- Aquí se inyectará el footer del negocio si la vista lo solicita --}}
    @yield('footer_personalizado')

    @include('components.asistente-virtual')

    <!-- Scripts del traductor de Google -->
    <script type="text/javascript">
        function actualizarEtiquetaIdioma() {
            const container = document.getElementById('google_translate_element');
            if (!container) return false;

            let actualizado = false;
            const combos = document.querySelectorAll('#google_translate_element .goog-te-combo, .goog-te-combo');

            combos.forEach((combo) => {
                const defaultOption = combo.querySelector('option[value=""]') || combo.options[0];
                if (defaultOption && /seleccionar|select/i.test(defaultOption.textContent.trim())) {
                    defaultOption.textContent = 'Español';
                    defaultOption.text = 'Español';
                    defaultOption.label = 'Español';
                    defaultOption.innerHTML = 'Español';
                    actualizado = true;
                }
                combo.setAttribute('aria-label', 'Español');
                combo.setAttribute('title', 'Español');
            });

            container.querySelectorAll('.goog-te-menu-value span').forEach((span) => {
                if (span.textContent.trim().toLowerCase().includes('seleccionar')) {
                    span.textContent = 'Español';
                    actualizado = true;
                }
            });

            const walker = document.createTreeWalker(container, NodeFilter.SHOW_TEXT);
            const textNodes = [];
            while (walker.nextNode()) {
                textNodes.push(walker.currentNode);
            }

            textNodes.forEach((node) => {
                if (/seleccionar\s+idioma/i.test(node.nodeValue)) {
                    node.nodeValue = node.nodeValue.replace(/seleccionar\s+idioma/ig, 'Español');
                    actualizado = true;
                }
            });

            return actualizado;
        }

        function programarEtiquetaIdioma() {
            const container = document.getElementById('google_translate_element');
            if (container && !container.dataset.labelObserver) {
                new MutationObserver(actualizarEtiquetaIdioma).observe(container, {
                    childList: true,
                    subtree: true,
                    characterData: true,
                });
                container.dataset.labelObserver = '1';
            }

            [0, 100, 500, 1200, 2500].forEach((delay) => {
                window.setTimeout(actualizarEtiquetaIdioma, delay);
            });

            window.clearInterval(window.__googleTranslateLabelTimer);
            let intentos = 0;
            window.__googleTranslateLabelTimer = window.setInterval(() => {
                actualizarEtiquetaIdioma();
                intentos++;
                if (intentos >= 40) {
                    window.clearInterval(window.__googleTranslateLabelTimer);
                }
            }, 250);
        }

        function googleTranslateElementInit() {
            let container = document.getElementById('google_translate_element');
            if (container && container.innerHTML === '') {
                new google.translate.TranslateElement({
                    pageLanguage: 'es',
                    includedLanguages: 'es,en,fr,de,pt,it,zh-CN',
                    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
                }, 'google_translate_element');
            }
            programarEtiquetaIdioma();
        }

        document.addEventListener('livewire:navigated', () => {
            if (window.google && window.google.translate) {
                googleTranslateElementInit();
            }
            programarEtiquetaIdioma();
        });

        document.addEventListener('DOMContentLoaded', programarEtiquetaIdioma);
        window.addEventListener('load', programarEtiquetaIdioma);
    </script>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    @fluxScripts
    @livewireScripts
</body>
</html>
