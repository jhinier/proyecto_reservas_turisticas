<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-slate-50 dark:bg-zinc-900">

        {{-- ═══════════════════════════════════════
             ESTILOS PERSONALIZADOS DEL SIDEBAR
        ═══════════════════════════════════════ --}}
        <style>
            /* ════════════════════════════════════════
               SIDEBAR — TEMA TURISMO VERDE
            ════════════════════════════════════════ */

            /* ── OVERRIDE de variables CSS de Flux (modo claro Y oscuro) ── */
            [data-flux-sidebar],
            html [data-flux-sidebar],
            html.dark [data-flux-sidebar] {
                --color-accent:            rgba(255,255,255,0.18) !important;
                --color-accent-foreground: #ffffff !important;
                --color-zinc-800:          #ffffff !important;
                --color-zinc-900:          #ffffff !important;
            }

            /* ── Clases Tailwind que Flux inyecta en texto ── */
            [data-flux-sidebar] .text-zinc-800,
            [data-flux-sidebar] .text-zinc-900 {
                color: #ffffff !important;
            }
            [data-flux-sidebar] .text-zinc-500,
            [data-flux-sidebar] .text-zinc-400 {
                color: rgba(187,247,208,0.88) !important;
            }
            /* Clases de texto accent en modo claro */
            [data-flux-sidebar] .text-accent-foreground {
                color: #ffffff !important;
            }

            /* ── Logo: contenedor con bg-accent de Flux → blanco ── */
            [data-flux-sidebar] header .bg-accent,
            [data-flux-sidebar] header [class*="bg-accent"],
            [data-flux-sidebar] header span.rounded-lg,
            [data-flux-sidebar] header span.rounded-md,
            [data-flux-sidebar] header div.rounded-lg,
            [data-flux-sidebar] header div.overflow-hidden {
                background: #ffffff !important;
                border-radius: 10px !important;
            }

            /* ── Avatar usuario: gris neutro ── */
            /* El profile button está fuera del <nav>, en el último hijo del sidebar */
            [data-flux-sidebar] > div:last-child span.rounded-lg,
            [data-flux-sidebar] > div:last-child span.rounded-md,
            [data-flux-sidebar] > div:last-child span.rounded,
            [data-flux-sidebar] > div:last-child .bg-accent,
            [data-flux-sidebar] > div:last-child [class*="bg-accent"],
            [data-flux-sidebar] button[class*="profile"] > span:first-child,
            [data-flux-sidebar] a[class*="profile"] > span:first-child {
                background: #4b5563 !important;
                color: #ffffff !important;
                font-weight: 700 !important;
                border-radius: 7px !important;
            }

            /* ── Nombre usuario: blanco en modo claro ── */
            [data-flux-sidebar] > div:last-child .text-zinc-800,
            [data-flux-sidebar] > div:last-child .text-zinc-900,
            [data-flux-sidebar] > div:last-child span:not(.rounded-lg):not(.rounded-md) {
                color: rgba(220,252,231,0.95) !important;
            }

            /* ── Base del sidebar ── */
            [data-flux-sidebar],
            html [data-flux-sidebar] {
                background: linear-gradient(180deg, #064E3B 0%, #064E3B 55%, #064E3B 100%) !important;
                border-right: none !important;
                box-shadow: 2px 0 12px rgba(0,0,0,0.18) !important;
            }
            .dark [data-flux-sidebar] {
                background: linear-gradient(180deg, #052e16 0%, #5eb37e 55%, #276841 100%) !important;
            }

            /* ── Header: zona del logo y nombre ── */
            [data-flux-sidebar-header] {
                padding: 1.25rem 1rem 1.15rem !important;
                border-bottom: 1px solid rgba(255,255,255,0.1) !important;
                background: rgba(0,0,0,0.18) !important;
            }

            /* ── Contenedor interno del brand (el <a> o <div> flex) ── */
            [data-flux-sidebar] [data-flux-brand],
            [data-flux-sidebar] [data-flux-sidebar-brand] {
                display: flex !important;
                align-items: center !important;
                gap: 0.65rem !important;
                text-decoration: none !important;
            }

            /* ── Wrapper del logo: fondo BLANCO con sombra suave ── */
            [data-flux-sidebar] [data-flux-brand] > span:first-child,
            [data-flux-sidebar] [data-flux-sidebar-brand] > span:first-child,
            [data-flux-sidebar-header] a > span:first-child {
                background: #ffffff !important;
                border-radius: 10px !important;
                border: none !important;
                padding: 3px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                overflow: hidden !important;
            }

            /* ── Nombre de la app ── */
            [data-flux-sidebar] [data-flux-brand] [data-flux-heading],
            [data-flux-sidebar] [data-flux-sidebar-brand] [data-flux-heading],
            [data-flux-sidebar-header] [data-flux-heading] {
                color: #ffffff !important;
                font-size: 1.05rem !important;
                font-weight: 700 !important;
                letter-spacing: -0.01em !important;
                text-transform: none !important;
                padding: 0 !important;
                opacity: 1 !important;
                line-height: 1.2 !important;
            }

            /* ── Subtítulo "ADMIN PANEL" ── */
            [data-flux-sidebar] [data-flux-brand] [data-flux-text],
            [data-flux-sidebar] [data-flux-sidebar-brand] [data-flux-text],
            [data-flux-sidebar-header] [data-flux-text] {
                color: rgba(134,239,172,0.85) !important;
                font-size: 0.68rem !important;
                font-weight: 600 !important;
                letter-spacing: 0.08em !important;
                text-transform: uppercase !important;
                opacity: 1 !important;
            }

            /* ── Encabezados de grupo (PRINCIPAL, MÓDULOS…) ── */
            [data-flux-sidebar-group-heading] {
                color: rgba(134,239,172,0.65) !important;
                font-size: 0.68rem !important;
                font-weight: 700 !important;
                letter-spacing: 0.1em !important;
                text-transform: uppercase !important;
                padding: 1.3rem 1rem 0.45rem !important;
            }

            /* ── Items de navegación ── */
            [data-flux-sidebar-item],
            [data-flux-sidebar] a[data-flux-sidebar-item] {
                color: rgba(220,252,231,0.88) !important;
                font-size: 1.05rem !important;
                font-weight: 500 !important;
                border-radius: 0.6rem !important;
                margin: 0.15rem 0.6rem !important;
                padding: 0.7rem 0.9rem !important;
                transition: background 0.15s ease, color 0.15s ease !important;
                letter-spacing: -0.01em !important;
            }

            /* ── Hover ── */
            [data-flux-sidebar-item]:hover,
            [data-flux-sidebar] a[data-flux-sidebar-item]:hover {
                background: rgba(255,255,255,0.1) !important;
                color: #ffffff !important;
            }

            /* ── Item activo ── */
            [data-flux-sidebar-item][data-current],
            [data-flux-sidebar-item][aria-current="page"],
            [data-flux-sidebar] a[data-flux-sidebar-item][data-current] {
                background: rgba(255,255,255,0.15) !important;
                color: #ffffff !important;
                font-weight: 600 !important;
            }

            /* ── Íconos de los items ── */
            [data-flux-sidebar-item] svg,
            [data-flux-sidebar-item] [data-flux-icon] {
                color: rgba(187,247,208,0.85) !important;
                width: 1.3rem !important;
                height: 1.3rem !important;
            }
            [data-flux-sidebar-item][data-current] svg,
            [data-flux-sidebar-item][data-current] [data-flux-icon] {
                color: #ffffff !important;
            }

            /* ── Botón collapse mobile ── */
            [data-flux-sidebar-collapse] {
                color: rgba(220,252,231,0.7) !important;
            }
            [data-flux-sidebar-collapse]:hover {
                color: #ffffff !important;
                background: rgba(255,255,255,0.1) !important;
            }

            /* ════════ ZONA INFERIOR — USUARIO ════════ */
            [data-flux-sidebar] > *:last-child {
                border-top: 1px solid rgba(255,255,255,0.1) !important;
                background: rgba(0,0,0,0.15) !important;
                padding: 0.9rem 0.75rem !important;
            }

            /* Botón de perfil */
            [data-flux-sidebar] [data-flux-profile] {
                display: flex !important;
                align-items: center !important;
                gap: 0.65rem !important;
                border-radius: 0.6rem !important;
                padding: 0.45rem 0.5rem !important;
                width: 100% !important;
                transition: background 0.15s !important;
                color: #ffffff !important;
            }
            [data-flux-sidebar] [data-flux-profile]:hover {
                background: rgba(255,255,255,0.08) !important;
            }

            /* Avatar — gris neutro con inicial blanca, igual a la referencia */
            [data-flux-sidebar] [data-flux-avatar] {
                background: #4b5563 !important;
                color: #ffffff !important;
                font-size: 0.82rem !important;
                font-weight: 700 !important;
                border-radius: 0.45rem !important;
                min-width: 2.15rem !important;
                width: 2.15rem !important;
                height: 2.15rem !important;
                flex-shrink: 0 !important;
                border: none !important;
            }

            /* Nombre del usuario */
            [data-flux-sidebar] [data-flux-profile] [data-flux-heading],
            [data-flux-sidebar] [data-flux-profile] span,
            [data-flux-sidebar] [data-flux-profile] p {
                color: rgba(220,252,231,0.92) !important;
                font-size: 0.92rem !important;
                font-weight: 500 !important;
                opacity: 1 !important;
            }

            /* Chevron */
            [data-flux-sidebar] [data-flux-profile] svg:last-child {
                color: rgba(187,247,208,0.6) !important;
                margin-left: auto !important;
            }

            /* ════════ HEADER MOBILE ════════ */
            [data-flux-header] {
                background: #14532d !important;
                border-bottom: 1px solid rgba(255,255,255,0.1) !important;
            }
            .dark [data-flux-header] {
                background: #052e16 !important;
            }
            [data-flux-header] [data-flux-sidebar-toggle],
            [data-flux-header] [data-flux-button] {
                color: rgba(220,252,231,0.85) !important;
            }
            [data-flux-header] [data-flux-profile] {
                color: rgba(220,252,231,0.9) !important;
            }
            [data-flux-header] [data-flux-profile] [data-flux-avatar] {
                background: rgba(255,255,255,0.15) !important;
                color: #ffffff !important;
            }

            /* ════════ POPUP DROPDOWN ════════ */
            [data-flux-menu] [data-flux-avatar],
            [data-flux-dropdown] [data-flux-avatar] {
                background: #166534 !important;
                color: #ffffff !important;
                font-weight: 700 !important;
                opacity: 1 !important;
            }
            [data-flux-menu] [data-flux-heading],
            [data-flux-dropdown] [data-flux-heading] {
                color: #14532d !important;
                opacity: 1 !important;
            }
            [data-flux-menu] [data-flux-text],
            [data-flux-dropdown] [data-flux-text] {
                color: #374151 !important;
                opacity: 1 !important;
            }
            .dark [data-flux-menu] [data-flux-avatar],
            .dark [data-flux-dropdown] [data-flux-avatar] {
                background: #15803d !important;
                color: #ffffff !important;
            }
            .dark [data-flux-menu] [data-flux-heading],
            .dark [data-flux-dropdown] [data-flux-heading] {
                color: #dcfce7 !important;
            }
            .dark [data-flux-menu] [data-flux-text],
            .dark [data-flux-dropdown] [data-flux-text] {
                color: #86efac !important;
            }

            /* ════════ SCROLLBAR ════════ */
            [data-flux-sidebar]::-webkit-scrollbar { width: 3px; }
            [data-flux-sidebar]::-webkit-scrollbar-track { background: transparent; }
            [data-flux-sidebar]::-webkit-scrollbar-thumb {
                background: rgba(255,255,255,0.18);
                border-radius: 99px;
            }
        </style>

        {{-- ═══════════════════════════════════════
             SIDEBAR
        ═══════════════════════════════════════ --}}
        <flux:sidebar sticky collapsible="mobile" class="border-e-0">
            <flux:sidebar.header class="px-6 py-8 border-none">
                <div class="flex items-center gap-4">
                    {{-- Cambié size-10 por size-16 para hacerlo más grande --}}
                    <div class="size-16 shrink-0 rounded-2xl bg-white/10 flex items-center justify-center overflow-hidden shadow-lg">
                        <x-app-logo :sidebar="true" href="{{ route('emprendimiento.panel') }}" wire:navigate />
                    </div>
                    <div class="leading-tight">
                        <h1 class="text-white font-bold text-lg">Explora Candelaria</h1>
                        <p class="text-emerald-200 text-[10px] uppercase tracking-widest font-bold opacity-80">Admin Emprendimiento</p>
                    </div>
                </div>
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Mi Negocio')" class="grid">

                    <flux:sidebar.item
                        icon="layout-grid"
                        :href="route('emprendimiento.panel')"
                        :current="request()->routeIs('emprendimiento.panel')"
                        wire:navigate>
                        Panel Principal
                    </flux:sidebar.item>

                    <flux:sidebar.item
                        icon="briefcase"
                        href="{{ route('emprendimiento.servicios.index') }}"
                        :current="request()->routeIs('emprendimiento.servicios.*')">
                        Mis Servicios
                    </flux:sidebar.item>

                    <flux:sidebar.item
                        icon="calendar"
                        href="{{ route('emprendimiento.reservas') }}"
                        :current="request()->routeIs('emprendimiento.reservas')"
                        wire:navigate>
                        Gestión de Reservas
                    </flux:sidebar.item>

                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        {{-- ═══════════════════════════════════════
             HEADER MOBILE
        ═══════════════════════════════════════ --}}
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

        {{-- ═══════════════════════════════════════
             NOTIFICACIONES (sin cambios)
        ═══════════════════════════════════════ --}}
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

        {{-- ═══════════════════════════════════════
             CONTENIDO PRINCIPAL
        ═══════════════════════════════════════ --}}
        <flux:main>
            {{ $slot }}
        </flux:main>

        {{-- ═══════════════════════════════════════
             FIX DE ESTILOS: aplica directo al DOM
        ═══════════════════════════════════════ --}}
        <script>
        function applyTourismStyles() {
            const sidebar = document.querySelector('[data-flux-sidebar]');
            if (!sidebar) return;

            /* ─── 1. LOGO: fondo blanco en el contenedor que Flux genera ─── */
            const headerImgs = sidebar.querySelectorAll('header img');
            headerImgs.forEach(img => {
                /* Sube hasta 3 niveles buscando el contenedor del logo */
                let el = img.parentElement;
                for (let i = 0; i < 3; i++) {
                    if (!el || el.tagName === 'A' || el.tagName === 'HEADER') break;
                    el.style.setProperty('background', '#ffffff', 'important');
                    el.style.setProperty('border-radius', '10px', 'important');
                    el.style.setProperty('overflow', 'hidden', 'important');
                    el.style.setProperty('border', 'none', 'important');
                    el = el.parentElement;
                }
            });

            /* ─── 2. Textos del brand: forzar blanco ─── */
            const header = sidebar.querySelector('header');
            if (header) {
                header.querySelectorAll('span, div, p').forEach(el => {
                    if (el.children.length === 0 && el.textContent.trim().length > 0) {
                        const bg = window.getComputedStyle(el).backgroundColor;
                        /* Solo textos (no contenedores con fondo) */
                        if (bg === 'rgba(0, 0, 0, 0)' || bg === 'transparent') {
                            el.style.setProperty('color', '#ffffff', 'important');
                            el.style.setProperty('opacity', '1', 'important');
                        }
                    }
                });
            }

            /* ─── 3. AVATAR USUARIO (zona inferior): gris #4b5563 ─── */
            /* El desktop-user-menu está como último descendiente fuera del nav */
            const nav = sidebar.querySelector('nav');
            sidebar.querySelectorAll('button, a').forEach(btn => {
                if (nav && nav.contains(btn)) return; /* saltar ítems de nav */
                const popup = btn.closest('[role="menu"], [data-flux-menu]');
                if (popup) return; /* saltar popups */

                /* Busca el span con las iniciales (texto corto, sin hijos) */
                btn.querySelectorAll('span, abbr').forEach(el => {
                    if (el.children.length === 0) {
                        const txt = el.textContent.trim();
                        /* Iniciales: 1-3 caracteres */
                        if (txt.length >= 1 && txt.length <= 3) {
                            el.style.setProperty('background', '#4b5563', 'important');
                            el.style.setProperty('color', '#ffffff', 'important');
                            el.style.setProperty('font-weight', '700', 'important');
                            el.style.setProperty('border-radius', '7px', 'important');
                            el.style.setProperty('border', 'none', 'important');
                            el.style.setProperty('opacity', '1', 'important');
                            el.style.setProperty('display', 'inline-flex', 'important');
                            el.style.setProperty('align-items', 'center', 'important');
                            el.style.setProperty('justify-content', 'center', 'important');
                        } else if (txt.length > 3) {
                            /* Nombre del usuario */
                            el.style.setProperty('color', 'rgba(220,252,231,0.95)', 'important');
                            el.style.setProperty('opacity', '1', 'important');
                        }
                    }
                });
            });
        }

        function runFix() {
            applyTourismStyles();
            setTimeout(applyTourismStyles, 200);
            setTimeout(applyTourismStyles, 600);
        }

        document.addEventListener('DOMContentLoaded', runFix);
        document.addEventListener('livewire:navigated', runFix);
        document.addEventListener('livewire:load', runFix);
        /* Alpine termina después de DOMContentLoaded */
        document.addEventListener('alpine:initialized', runFix);
        </script>

        @fluxScripts
    </body>
</html>