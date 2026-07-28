<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap');

        body{
            /* FIX: Usar 'clip' en lugar de 'hidden' evita que se rompa el 'position: sticky' del sidebar al hacer scroll */
            overflow-x: clip; 
        }

        /* ═══════════════════════════════
           SOLO SIDEBAR - TEMA CLARO Y OSCURO
        ═══════════════════════════════ */

        /* Aplicar la fuente SOLO al sidebar y al header móvil, no al contenido general */
        [data-flux-sidebar],
        [data-flux-header] {
            font-family: 'Poppins', sans-serif !important;
        }

        [data-flux-sidebar],
        html [data-flux-sidebar] {
            width: 18rem !important;
            --color-accent:rgba(255,255,255,0.12)!important;
            --color-accent-foreground:#ffffff!important;
            --color-zinc-800:#ffffff!important;
            --color-zinc-900:#ffffff!important;

            /* Match admin utilities: bg-emerald-800 and border-emerald-900/20 */
            background: #065f46!important; /* emerald-800 */
            border-right: 1px solid rgba(6,78,59,0.20)!important; /* emerald-900/20 */
            box-shadow: 4px 0 25px rgba(0,0,0,0.08)!important;
            
            /* FIX: Forzar a que el sidebar siempre cubra el 100% del alto de la pantalla */
            height: 100dvh !important;
            max-height: 100dvh !important;
        }

        /* Modo oscuro para el fondo del Sidebar */
        html.dark [data-flux-sidebar] {
            background: #065f46!important;
            border-right: 1px solid rgba(6,78,59,0.20)!important;
        }

        /* HEADER SIDEBAR */
        [data-flux-sidebar-header]{
            padding:1.6rem 1.2rem!important;
            border-bottom:1px solid rgba(4,120,87,0.50)!important; /* emerald-700/50 */
            background: rgba(6,78,59,0.20)!important; /* emerald-900/20 */
        }
        html.dark [data-flux-sidebar-header] {
            background: rgba(6,78,59,0.20)!important;
            border-bottom: 1px solid rgba(4,120,87,0.50)!important;
        }

        .logo-wrapper{
            width:4.8rem;
            height:4.8rem;
            border-radius:1.5rem;
            background:#f8fafc;
            border:1px solid rgba(0,0,0,0.08);
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        .brand-title{
            color:#ffffff!important;
            font-size:1.35rem!important;
            font-weight:700!important;
            letter-spacing:-0.04em!important;
            line-height:1.1!important;
        }
        html.dark .brand-title { color: #ffffff!important; }

        .brand-subtitle{
            color: rgba(187,247,208,0.60)!important; /* emerald-200/60 */
            font-size:0.72rem!important;
            font-weight:800!important;
            letter-spacing:0.20em!important;
            margin-top:0.3rem!important;
        }
        html.dark .brand-subtitle { color: rgba(187,247,208,0.60)!important; }

        /* TEXTOS DE FLUX SOBRESCRITOS: only affect nav items inside sidebar, not popups */
        [data-flux-sidebar] nav .text-zinc-800,
        [data-flux-sidebar] nav .text-zinc-900,
        [data-flux-sidebar] nav .text-accent-foreground{
            color:#ffffff!important;
        }
        html.dark [data-flux-sidebar] nav .text-zinc-800,
        html.dark [data-flux-sidebar] nav .text-zinc-900,
        html.dark [data-flux-sidebar] nav .text-accent-foreground{
            color:#ffffff!important;
        }

        [data-flux-sidebar] nav .text-zinc-400,
        [data-flux-sidebar] nav .text-zinc-500{
            color:rgba(255,255,255,0.72)!important;
        }
        html.dark [data-flux-sidebar] nav .text-zinc-400,
        html.dark [data-flux-sidebar] nav .text-zinc-500{
            color:rgba(255,255,255,0.72)!important;
        }

        /* TITULOS DE GRUPO (GENERAL, GESTIÓN, ETC) */
        [data-flux-sidebar-group-heading]{
            color:rgba(187,247,208,0.40)!important; /* emerald-200/40 */
            font-size:0.72rem!important;
            font-weight:900!important;
            letter-spacing:0.18em!important;
            padding: 1.7rem 1.5rem 0.8rem!important;
        }
        html.dark [data-flux-sidebar-group-heading]{
            color:rgba(187,247,208,0.40)!important;
        }

        /* LINEA SEPARADORA */
        .sidebar-separator{
            height:1px;
            margin:1rem 1.5rem 0.4rem;
            background: rgba(4,120,87,0.40)!important; /* emerald-700/40 */
            border-radius:999px;
        }
        html.dark .sidebar-separator { background: rgba(4,120,87,0.40)!important; }

        /* ITEMS DEL MENÚ (BOTONES) */
        [data-flux-sidebar-item],
        [data-flux-sidebar] a[data-flux-sidebar-item]{
            position:relative!important;
            overflow:hidden!important;
            display:flex!important;
            align-items:center!important;
            gap:0.9rem!important;
            
            margin: 0.2rem 0 !important; 
            border-radius: 0 !important; 
            padding: 1rem 1.5rem !important;
            
            color: #ffffff!important;
            font-size: 1.05rem!important;
            font-weight: 800!important;
            letter-spacing:-0.02em!important;
            
            transition: background .2s ease, color .2s ease !important;
        }
        html.dark [data-flux-sidebar-item],
        html.dark [data-flux-sidebar] a[data-flux-sidebar-item] {
            color: #ffffff!important;
        }

        /* HOVER (match admin hover:bg-white/10) */
        [data-flux-sidebar-item]:hover,
        [data-flux-sidebar] a[data-flux-sidebar-item]:hover{
            background: rgba(255,255,255,0.10)!important; /* white/10 */
            color: #ffffff!important;
            transform: none !important;
            box-shadow: none !important;
        }
        html.dark [data-flux-sidebar-item]:hover,
        html.dark [data-flux-sidebar] a[data-flux-sidebar-item]:hover{
            background: rgba(255,255,255,0.10)!important;
            color: #ffffff!important;
        }

        /* ITEM ACTIVO */
        [data-flux-sidebar-item][data-current],
        [data-flux-sidebar-item][aria-current="page"],
        [data-flux-sidebar] a[data-flux-sidebar-item][data-current]{
            background: rgba(255,255,255,0.15)!important; /* white/15 */
            color: #ffffff!important;
            border-left: 5px solid rgba(255,255,255,0.70) !important;
            box-shadow: none !important;
        }
        html.dark [data-flux-sidebar-item][data-current],
        html.dark [data-flux-sidebar-item][aria-current="page"],
        html.dark [data-flux-sidebar] a[data-flux-sidebar-item][data-current]{
            background: rgba(255,255,255,0.15)!important;
            color: #ffffff!important;
            border-left: 5px solid rgba(255,255,255,0.70) !important;
        }

        /* ICONOS */
        [data-flux-sidebar-item] svg,
        [data-flux-sidebar-item] [data-flux-icon]{
            width:1.35rem!important;
            height:1.35rem!important;
            color: #ffffff!important;
            transition:all .2s ease!important;
        }
        html.dark [data-flux-sidebar-item] svg,
        html.dark [data-flux-sidebar-item] [data-flux-icon]{
            color: #ffffff!important;
        }

        [data-flux-sidebar-item]:hover svg,
        [data-flux-sidebar-item][data-current] svg{
            color: #ecfdf5!important; /* lighter emerald */
            transform:scale(1.08);
        }
        html.dark [data-flux-sidebar-item]:hover svg,
        html.dark [data-flux-sidebar-item][data-current] svg{
            color: #ecfdf5!important;
        }

        /* ZONA USER INFERIOR */
        [data-flux-sidebar] > *:last-child{
            border-top: 1px solid rgba(4,120,87,0.50)!important; /* emerald-700/50 */
            background: rgba(6,78,59,0.30)!important;
            padding:1rem 1.2rem!important;
        }
        html.dark [data-flux-sidebar] > *:last-child{
            border-top: 1px solid rgba(4,120,87,0.50)!important;
            background: rgba(6,78,59,0.30)!important;
        }

        /* Apply profile styles only for the profile shown inside the sidebar
           so dropdown/popover content (white background) keeps readable text */
        [data-flux-sidebar] [data-flux-profile]{
            border-radius:0.8rem!important;
            padding:0.75rem!important;
            color: #ffffff !important;
        }
        html.dark [data-flux-sidebar] [data-flux-profile]{ color: #2b4e3d !important; }

        [data-flux-sidebar] [data-flux-profile]:hover{
            background:rgba(255,255,255,0.12)!important;
        }
        html.dark [data-flux-sidebar] [data-flux-profile]:hover{ background:rgba(255,255,255,0.12)!important; }

        [data-flux-sidebar] [data-flux-menu] {
            background: #ffffff!important;
            color: #0f172a!important;
            box-shadow: 0 18px 35px rgba(0,0,0,0.18)!important;
            border-radius: 1rem!important;
        }
        [data-flux-sidebar] [data-flux-menu] *,
        [data-flux-sidebar] [data-flux-menu] [data-flux-menu-item],
        [data-flux-sidebar] [data-flux-menu] [data-flux-menu-item] svg,
        [data-flux-sidebar] [data-flux-menu] [data-flux-menu-item-icon],
        [data-flux-sidebar] [data-flux-menu] [data-flux-icon],
        [data-flux-sidebar] [data-flux-menu] svg {
            color: #0f172a!important;
            fill: currentColor!important;
        }
        [data-flux-sidebar] [data-flux-menu] [data-flux-menu-separator] {
            background: rgba(15,23,42,0.08)!important;
        }

        [data-flux-avatar]{
            background: #8c8c8e!important;
            color:#ffffff!important;
            border-radius:0.6rem!important;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1)!important;
        }

        /* MOBILE HEADER */
        [data-flux-header]{
            background: #ffffff!important;
            border-bottom: 1px solid rgba(0,0,0,0.08)!important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03)!important;
        }
        html.dark [data-flux-header]{
            background: #18181b!important;
            border-bottom: 1px solid rgba(255,255,255,0.08)!important;
        }
        
        [data-flux-header] [data-flux-sidebar-toggle],
        [data-flux-header] [data-flux-button]{
            color:#000000!important;
        }
        html.dark [data-flux-header] [data-flux-sidebar-toggle],
        html.dark [data-flux-header] [data-flux-button]{
            color:#ffffff!important;
        }

        /* RESPONSIVE */
        @media(max-width:768px){
            [data-flux-sidebar-header]{
                padding:1.2rem 1rem!important;
            }
            .logo-wrapper{
                width:4rem;
                height:4rem;
            }
            .brand-title{
                font-size:1.08rem!important;
            }
            [data-flux-sidebar],
            html [data-flux-sidebar] {
                --color-accent:rgba(255,255,255,0.12)!important;
                --color-accent-foreground:#ffffff!important;
                --color-zinc-800:#ffffff!important;
                --color-zinc-900:#ffffff!important;

                background: #065f46!important; /* emerald-800 */
                border-right: 1px solid rgba(6,78,59,0.20)!important;
                box-shadow: 4px 0 25px rgba(0,0,0,0.08)!important;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 dark:bg-zinc-900 text-[#123524] dark:text-white antialiased">

    {{-- SIDEBAR --}}
    <flux:sidebar sticky collapsible="mobile" class="border-e-0">

        {{-- HEADER --}}
        <flux:sidebar.header class="border-none">

            <div class="flex items-center gap-4">

                <div class="logo-wrapper">
                    <x-app-logo
                        :sidebar="true"
                        href="{{ route('emprendimiento.panel') }}"
                    />
                </div>

                <div class="leading-tight">
                    <h1 class="brand-title">
                        Explora Candelaria
                    </h1>
                    <p class="brand-subtitle">
                        {{ auth()->user()->emprendimiento?->nombre ?? 'ADMIN EMPRENDIMIENTO' }}
                    </p>
                </div>

            </div>

        </flux:sidebar.header>

        {{-- NAV --}}
        <flux:sidebar.nav>

            {{-- GENERAL --}}
            <flux:sidebar.group :heading="__('GENERAL')" class="grid">

                <flux:sidebar.item
                    icon="layout-grid"
                    :href="route('emprendimiento.panel')"
                    :current="request()->routeIs('emprendimiento.panel')">
                    Panel Principal
                </flux:sidebar.item>

            </flux:sidebar.group>

            <div class="sidebar-separator"></div>

            {{-- GESTIÓN --}}
            <flux:sidebar.group :heading="__('GESTIÓN')" class="grid">

                <flux:sidebar.item
                    icon="briefcase"
                    href="{{ route('emprendimiento.servicios.index') }}"
                    :current="request()->routeIs('emprendimiento.servicios.*')">
                    Mis Servicios
                </flux:sidebar.item>

                <flux:sidebar.item
                    icon="calendar"
                    href="{{ route('emprendimiento.reservas') }}"
                    :current="request()->routeIs('emprendimiento.reservas')">
                    Reservas
                </flux:sidebar.item>

            </flux:sidebar.group>

            <div class="sidebar-separator"></div>

            {{-- ANALÍTICAS --}}
            <flux:sidebar.group :heading="__('ANALÍTICAS')" class="grid">

                <flux:sidebar.item
                    icon="chart-bar"
                    href="{{ route('emprendimiento.reportes') }}"
                    :current="request()->routeIs('emprendimiento.reportes')">
                    Reportes
                </flux:sidebar.item>

            </flux:sidebar.group>

        </flux:sidebar.nav>

        <flux:spacer />

        {{-- USER --}}
        <x-desktop-user-menu
            class="hidden lg:block"
            :name="auth()->user()->name"
        />

    </flux:sidebar>

    {{-- HEADER MOBILE --}}
    <flux:header class="lg:hidden">

        <flux:sidebar.toggle
            class="lg:hidden"
            icon="bars-2"
            inset="left"
        />

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
                                <flux:heading class="truncate">
                                    {{ auth()->user()->name }}
                                </flux:heading>
                                <flux:text class="truncate">
                                    {{ auth()->user()->email }}
                                </flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item
                        :href="route('profile.edit')"
                        icon="cog"
                        wire:navigate>
                        Ajustes de Perfil
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item
                        as="button"
                        type="submit"
                        icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer">
                        Cerrar Sesión
                    </flux:menu.item>
                </form>

            </flux:menu>

        </flux:dropdown>

    </flux:header>

    {{-- CONTENIDO --}}
    <flux:main>
        {{ $slot }}
    </flux:main>

    {{-- JS FIX CLARO Y OSCURO --}}
    <script>
        function applyTourismStyles() {
            const sidebar = document.querySelector('[data-flux-sidebar]');
            if (!sidebar) return;

            /* Determinar si el modo oscuro está activo en el HTML */
            const isDarkMode = document.documentElement.classList.contains('dark');
            const targetColor = isDarkMode ? '#ffffff' : '#000000';

            /* Forzar textos del usuario inferior a color correcto según el modo */
            const nav = sidebar.querySelector('nav');
            sidebar.querySelectorAll('button, a').forEach(btn => {
                if (nav && nav.contains(btn)) return; 
                const popup = btn.closest('[role="menu"], [data-flux-menu]');
                if (popup) return; 

                btn.querySelectorAll('span, p, h2').forEach(el => {
                    const txt = el.textContent.trim();
                    if (txt.length > 3) {
                        el.style.setProperty('color', targetColor, 'important');
                        el.style.setProperty('font-weight', '800', 'important');
                        el.style.setProperty('opacity', '1', 'important');
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
        document.addEventListener('alpine:initialized', runFix);

        /* Escuchar cambios de clase dark en el HTML (si usas un toggle) */
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.attributeName === "class") {
                    runFix();
                }
            });
        });
        observer.observe(document.documentElement, { attributes: true });
    </script>

    @fluxScripts

</body>
</html>