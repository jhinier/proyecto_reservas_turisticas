<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navegación Penguin UI Test</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class', // O 'media'
            theme: {
                extend: {
                    colors: {
                        primary: '#3b82f6', // Azul Tailwind (puedes cambiarlo)
                        'primary-dark': '#60a5fa',
                        'on-primary': '#ffffff',
                        'on-primary-dark': '#000000',
                        
                        surface: '#ffffff',
                        'surface-alt': '#f8fafc',
                        'surface-dark': '#0f172a',
                        'surface-dark-alt': '#1e293b',
                        
                        'on-surface': '#475569',
                        'on-surface-strong': '#0f172a',
                        'on-surface-dark': '#cbd5e1',
                        'on-surface-dark-strong': '#f8fafc',
                        
                        outline: '#e2e8f0',
                        'outline-dark': '#334155',
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
        /* Oculta elementos de Alpine hasta que carguen para evitar parpadeos */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

   <nav x-data="{ mobileMenuIsOpen: false }" x-on:click.away="mobileMenuIsOpen = false" class="flex items-center justify-between bg-surface-alt border-outline dark:border-outline-dark px-6 py-4 dark:border-outline-dark dark:bg-surface-dark-alt" aria-label="penguin ui menu">
    <a href="#" class="text-2xl font-bold text-on-surface-strong dark:text-on-surface-dark-strong">
        <span>Peng<span class="text-primary dark:text-primary-dark">ui</span>n</span>
        </a>
    <ul class="hidden items-center gap-4 sm:flex">
        <li><a href="#" class="font-bold text-primary underline-offset-2 hover:text-primary focus:outline-hidden focus:underline dark:text-primary-dark dark:hover:text-primary-dark" aria-current="page">Inicio</a></li>
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
                class="absolute left-0 top-12 flex w-fit min-w-60 flex-col overflow-hidden rounded-radius border border-outline bg-surface-alt py-1.5 dark:border-outline-dark dark:bg-surface-dark-alt"
            >
                <li>
                    <a href="#" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-strong">Hospedaje</a>
                </li>
                <li>
                    <a href="#" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-strong">Alimentación</a>
                </li>
                <li>
                    <a href="#" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-strong">Guianza</a>
                </li>
                <li>
                    <a href="#" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-strong">Equipos turisticos</a>
                </li>
                <li>
                    <a href="#" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-strong">Paquetes turisticos</a>
                </li>
            </ul>
        </li>

        <li x-data="{ userDropDownIsOpen: false, openWithKeyboard: false }" x-on:keydown.esc.window="userDropDownIsOpen = false, openWithKeyboard = false" class="relative flex items-center">
            <button x-on:click="userDropDownIsOpen = ! userDropDownIsOpen" x-bind:aria-expanded="userDropDownIsOpen" x-on:keydown.space.prevent="openWithKeyboard = true" x-on:keydown.enter.prevent="openWithKeyboard = true" x-on:keydown.down.prevent="openWithKeyboard = true" class="rounded-full focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary dark:focus-visible:outline-primary-dark" aria-controls="userMenu">
                <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-8.webp" alt="User Profile" class="size-10 rounded-full object-cover" />
            </button>
            <ul x-cloak x-show="userDropDownIsOpen || openWithKeyboard" x-transition.opacity x-trap="openWithKeyboard" x-on:click.outside="userDropDownIsOpen = false, openWithKeyboard = false" x-on:keydown.down.prevent="$focus.wrap().next()" x-on:keydown.up.prevent="$focus.wrap().previous()" id="userMenu" class="absolute right-0 top-12 flex w-fit min-w-48 flex-col overflow-hidden rounded-radius border border-outline bg-surface-alt py-1.5 dark:border-outline-dark dark:bg-surface-dark-alt">
                <li class="border-b border-outline dark:border-outline-dark">
                    <div class="flex flex-col px-4 py-2">   
                        <span class="text-sm font-medium text-on-surface-strong dark:text-on-surface-dark-strong">Alice Brown</span>
                        <p class="text-xs text-on-surface dark:text-on-surface-dark">alice.brown@gmail.com</p>
                    </div>
                </li>
                <li><a href="#" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong">Dashboard</a></li>
                <li><a href="#" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong">Subscription</a></li>
                <li><a href="#" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong">Configuración</a></li>
                <li><a href="{{ route('login') }}" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong">Iniciar Sesión</a></li>
                <li><a href="{{ route('register') }}" class="block bg-surface-alt px-4 py-2 text-sm text-on-surface hover:bg-surface-dark-alt/5 hover:text-on-surface-strong focus-visible:bg-surface-dark-alt/10 focus-visible:text-on-surface-strong focus-visible:outline-hidden dark:bg-surface-dark-alt dark:text-on-surface-dark dark:hover:bg-surface-alt/5 dark:hover:text-on-surface-dark-strong dark:focus-visible:bg-surface-alt/10 dark:focus-visible:text-on-surface-dark-strong">Registrarse</a></li>
            </ul>
        </li>
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
        
        <li class="mb-4 border-none">
            <div class="flex items-center gap-2 py-2">
                <img src="https://penguinui.s3.amazonaws.com/component-assets/avatar-8.webp" alt="User Profile" class="size-12 rounded-full object-cover"  />
                <div>
                    <span class="font-medium text-on-surface-strong dark:text-on-surface-dark-strong">Bienvenido</span>
                    <p class="text-sm text-on-surface dark:text-on-surface-dark">Turista</p>
                </div>  
            </div>
        </li>

        <li class="p-2"><a href="#" class="w-full text-lg font-bold text-primary focus:underline dark:text-primary-dark" aria-current="page">Inicio</a></li>
        <li class="p-2"><a href="#" class="w-full text-lg font-medium text-on-surface focus:underline dark:text-on-surface-dark">Sitios Turísticos</a></li>
        <li class="p-2"><a href="#" class="w-full text-lg font-medium text-on-surface focus:underline dark:text-on-surface-dark">Actividades</a></li>
        <li class="p-2"><a href="#" class="w-full text-lg font-medium text-on-surface focus:underline dark:text-on-surface-dark">Eventos</a></li>

        <li class="p-2" x-data="{ serviciosDropDownIsOpenMobile: false }">
            <button
                x-on:click="serviciosDropDownIsOpenMobile = !serviciosDropDownIsOpenMobile"
                class="w-full text-left text-lg font-medium text-on-surface focus:underline dark:text-on-surface-dark"
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
                <li><a href="#" class="w-full text-base font-medium text-on-surface hover:text-primary focus:underline dark:text-on-surface-dark">Hospedaje</a></li>
                <li><a href="#" class="w-full text-base font-medium text-on-surface hover:text-primary focus:underline dark:text-on-surface-dark">Alimentación</a></li>
                <li><a href="#" class="w-full text-base font-medium text-on-surface hover:text-primary focus:underline dark:text-on-surface-dark">Guianza</a></li>
                <li><a href="#" class="w-full text-base font-medium text-on-surface hover:text-primary focus:underline dark:text-on-surface-dark">Equipos turisticos</a></li>
                <li><a href="#" class="w-full text-base font-medium text-on-surface hover:text-primary focus:underline dark:text-on-surface-dark">Paquetes turisticos</a></li>
            </ul>
        </li>

        <hr role="none" class="my-4 border-outline dark:border-outline-dark">
        
        <li class="mt-2 w-full border-none">
            <a href="{{ route('login') }}" class="rounded-radius bg-surface-alt border border-outline px-4 py-2 block text-center font-medium tracking-wide text-on-surface hover:bg-surface-dark-alt/5 focus-visible:outline-2 dark:bg-surface-dark-alt dark:border-outline-dark dark:text-on-surface-dark">
                Iniciar Sesión
            </a>
        </li>
        <li class="mt-4 w-full border-none">
            <a href="{{ route('register') }}" class="rounded-radius bg-primary border-primary px-4 py-2 block text-center font-medium tracking-wide text-on-primary hover:opacity-75 focus-visible:outline-2 focus-visible:outline-primary dark:bg-primary-dark dark:border-primary-dark dark:text-on-primary-dark">
                Registrarse
            </a>
        </li>
    </ul>
</nav>

</body>
</html>