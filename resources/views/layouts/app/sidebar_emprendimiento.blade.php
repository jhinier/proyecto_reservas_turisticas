<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('emprendimiento.panel') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Mi Negocio')" class="grid">
                    
                    <flux:sidebar.item icon="layout-grid" :href="route('emprendimiento.panel')" :current="request()->routeIs('emprendimiento.panel')" wire:navigate>
                        Panel Principal
                    </flux:sidebar.item>
                    
                    <flux:sidebar.item icon="briefcase" href="{{ route('emprendimiento.servicios.index') }}" :current="request()->routeIs('emprendimiento.servicios.*')">
                        Mis Servicios
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="calendar" href="#" wire:navigate>
                        Gestión de Reservas
                    </flux:sidebar.item>

                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />
    
            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            Ajustes de Perfil
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full cursor-pointer">
                            Cerrar Sesión
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        <div x-data="{ show: false, type: 'success', title: '', message: '' }"
             x-init="
                @if(session()->has('notify'))
                    type = '{{ session('notify')['type'] }}';
                    title = '{{ session('notify')['title'] }}';
                    message = '{{ session('notify')['message'] }}';
                    show = true;
                    setTimeout(() => show = false, 4000);
                @endif
             "
             @notify.window="
                type = $event.detail.type;
                title = $event.detail.title;
                message = $event.detail.message;
                show = true;
                setTimeout(() => show = false, 4000);
             "
             class="fixed top-4 right-4 z-[100] w-full max-w-sm space-y-2 pointer-events-none"
             x-show="show"
             x-transition.opacity.duration.300ms
             style="display: none;">
             
            <div x-show="type === 'success'" class="relative w-full overflow-hidden rounded-sm border border-green-500 bg-white text-gray-900 dark:bg-zinc-900 dark:text-white shadow-lg pointer-events-auto" role="alert">
                <div class="flex w-full items-center gap-2 bg-green-500/10 p-4">
                    <div class="bg-green-500/20 text-green-600 rounded-full p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-sm font-semibold text-green-600" x-text="title"></h3>
                        <p class="text-xs font-medium sm:text-sm" x-text="message"></p>
                    </div>
                </div>
            </div>

            <div x-show="type === 'danger'" class="relative w-full overflow-hidden rounded-sm border border-red-500 bg-white text-gray-900 dark:bg-zinc-900 dark:text-white shadow-lg pointer-events-auto" role="alert">
                <div class="flex w-full items-center gap-2 bg-red-500/10 p-4">
                    <div class="bg-red-500/20 text-red-600 rounded-full p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" /></svg>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-sm font-semibold text-red-600" x-text="title"></h3>
                        <p class="text-xs font-medium sm:text-sm" x-text="message"></p>
                    </div>
                </div>
            </div>
        </div>

        <flux:main>
            {{ $slot }}
        </flux:main>

        @fluxScripts
    </body>
</html>