<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <style>
        [x-cloak] { display: none !important; }

        html.dark .admin-gad-shell {
            color-scheme: dark;
            background: #050b09;
            color: #f8fafc;
        }

        html.dark .admin-gad-sidebar {
            background: #01120d !important;
            border-color: rgba(16, 185, 129, 0.12) !important;
            box-shadow: 10px 0 38px rgba(0, 0, 0, 0.46) !important;
        }

        html.dark .admin-gad-sidebar-header {
            background: rgba(1, 23, 19, 0.78) !important;
            border-color: rgba(16, 185, 129, 0.13) !important;
        }

        html.dark .admin-gad-separator {
            border-color: rgba(16, 185, 129, 0.16) !important;
        }

        html.dark .admin-gad-user {
            background: rgba(1, 23, 19, 0.82) !important;
            border-color: rgba(16, 185, 129, 0.13) !important;
        }

        html.dark .admin-gad-sidebar nav p {
            color: rgba(187, 247, 208, 0.52) !important;
        }

        html.dark .admin-gad-sidebar nav a {
            color: #ffffff !important;
        }

        html.dark .admin-gad-sidebar nav a:hover {
            background: rgba(16, 185, 129, 0.13) !important;
            color: #ffffff !important;
        }

        html.dark .admin-gad-sidebar nav a.bg-white\/15 {
            background: rgba(16, 185, 129, 0.18) !important;
            color: #ffffff !important;
            box-shadow: inset 5px 0 0 rgba(110, 231, 183, 0.95) !important;
        }

        html.dark .admin-gad-sidebar nav a.bg-white\/15 svg,
        html.dark .admin-gad-sidebar nav a:hover svg {
            color: #ecfdf5 !important;
        }

        .admin-gad-user [data-test="sidebar-menu-button"] > span {
            color: #ffffff !important;
        }

        html.dark .admin-gad-main {
            background: #050b09 !important;
        }

        html.dark .admin-gad-mobile-header {
            background: rgba(5, 11, 9, 0.94) !important;
            border-color: rgba(16, 185, 129, 0.14) !important;
        }

        html.dark .admin-gad-mobile-button {
            background: #0b1512 !important;
            border-color: rgba(16, 185, 129, 0.18) !important;
            color: #ecfdf5 !important;
        }

        html.dark .admin-gad-logo {
            background: #ffffff !important;
        }

        html.dark .admin-gad-mobile-title {
            color: #ffffff !important;
        }

        html.dark .admin-gad-mobile-subtitle {
            color: rgba(187, 247, 208, 0.75) !important;
        }

        html.dark .admin-gad-shell main .bg-white,
        html.dark .admin-gad-shell [data-flux-modal] .bg-white {
            background-color: #0b1512 !important;
            color: #f8fafc !important;
        }

        html.dark .admin-gad-shell main .bg-white\/95 {
            background-color: rgba(11, 21, 18, 0.95) !important;
        }

        html.dark .admin-gad-shell main .bg-white\/70,
        html.dark .admin-gad-shell main .bg-white\/60 {
            background-color: rgba(5, 11, 9, 0.78) !important;
        }

        html.dark .admin-gad-shell main .bg-slate-50,
        html.dark .admin-gad-shell main .bg-gray-50,
        html.dark .admin-gad-shell main .bg-neutral-50,
        html.dark .admin-gad-shell main .bg-zinc-50,
        html.dark .admin-gad-shell main .bg-\[\#F8F9FA\] {
            background-color: rgba(16, 185, 129, 0.06) !important;
        }

        html.dark .admin-gad-shell main .bg-slate-50\/70,
        html.dark .admin-gad-shell main .bg-slate-50\/80 {
            background-color: rgba(16, 185, 129, 0.08) !important;
        }

        html.dark .admin-gad-shell main .bg-slate-100,
        html.dark .admin-gad-shell main .bg-gray-100,
        html.dark .admin-gad-shell main .bg-neutral-100,
        html.dark .admin-gad-shell main .bg-zinc-100 {
            background-color: rgba(16, 185, 129, 0.10) !important;
        }

        html.dark .admin-gad-shell main .hover\:bg-slate-50:hover,
        html.dark .admin-gad-shell main .hover\:bg-slate-50\/80:hover,
        html.dark .admin-gad-shell main .hover\:bg-gray-100:hover,
        html.dark .admin-gad-shell main .hover\:bg-slate-100:hover,
        html.dark .admin-gad-shell main tr.hover\:bg-slate-50\/80:hover {
            background-color: rgba(16, 185, 129, 0.10) !important;
        }

        html.dark .admin-gad-shell main .border-slate-100,
        html.dark .admin-gad-shell main .border-slate-200,
        html.dark .admin-gad-shell main .border-gray-100,
        html.dark .admin-gad-shell main .border-gray-200,
        html.dark .admin-gad-shell main .border-neutral-100,
        html.dark .admin-gad-shell main .border-neutral-200,
        html.dark .admin-gad-shell main .border-zinc-100,
        html.dark .admin-gad-shell main .border-zinc-200,
        html.dark .admin-gad-shell main .border-outline,
        html.dark .admin-gad-shell main .divide-gray-200 > :not([hidden]) ~ :not([hidden]),
        html.dark .admin-gad-shell main .divide-slate-200 > :not([hidden]) ~ :not([hidden]),
        html.dark .admin-gad-shell main .divide-neutral-200 > :not([hidden]) ~ :not([hidden]) {
            border-color: rgba(16, 185, 129, 0.14) !important;
        }

        html.dark .admin-gad-shell main .border-emerald-100,
        html.dark .admin-gad-shell main .border-emerald-200,
        html.dark .admin-gad-shell main .border-green-500 {
            border-color: rgba(16, 185, 129, 0.36) !important;
        }

        html.dark .admin-gad-shell main .border-yellow-200,
        html.dark .admin-gad-shell main .border-amber-500 {
            border-color: rgba(245, 158, 11, 0.38) !important;
        }

        html.dark .admin-gad-shell main .border-red-200,
        html.dark .admin-gad-shell main .border-red-500,
        html.dark .admin-gad-shell main .border-danger {
            border-color: rgba(248, 113, 113, 0.42) !important;
        }

        html.dark .admin-gad-shell main .text-slate-900,
        html.dark .admin-gad-shell main .text-gray-900,
        html.dark .admin-gad-shell main .text-zinc-900,
        html.dark .admin-gad-shell main .text-neutral-900,
        html.dark .admin-gad-shell main .text-on-surface-strong {
            color: #f8fafc !important;
        }

        html.dark .admin-gad-shell main .text-slate-800,
        html.dark .admin-gad-shell main .text-gray-800,
        html.dark .admin-gad-shell main .text-zinc-800,
        html.dark .admin-gad-shell main .text-neutral-800,
        html.dark .admin-gad-shell main .text-on-surface,
        html.dark .admin-gad-shell main .text-on-surface-dark {
            color: #ecfdf5 !important;
        }

        html.dark .admin-gad-shell main .text-slate-700,
        html.dark .admin-gad-shell main .text-gray-700,
        html.dark .admin-gad-shell main .text-zinc-700,
        html.dark .admin-gad-shell main .text-neutral-700 {
            color: #d1fae5 !important;
        }

        html.dark .admin-gad-shell main .text-slate-600,
        html.dark .admin-gad-shell main .text-gray-600,
        html.dark .admin-gad-shell main .text-zinc-600,
        html.dark .admin-gad-shell main .text-neutral-600 {
            color: #a7f3d0 !important;
        }

        html.dark .admin-gad-shell main .text-slate-500,
        html.dark .admin-gad-shell main .text-gray-500,
        html.dark .admin-gad-shell main .text-zinc-500,
        html.dark .admin-gad-shell main .text-neutral-500,
        html.dark .admin-gad-shell main .text-slate-400,
        html.dark .admin-gad-shell main .text-gray-400,
        html.dark .admin-gad-shell main .text-zinc-400,
        html.dark .admin-gad-shell main .text-neutral-400 {
            color: rgba(209, 250, 229, 0.72) !important;
        }

        html.dark .admin-gad-shell main .bg-emerald-50,
        html.dark .admin-gad-shell main .bg-green-50,
        html.dark .admin-gad-shell main .bg-primary\/10,
        html.dark .admin-gad-shell main .bg-success\/10 {
            background-color: rgba(16, 185, 129, 0.13) !important;
        }

        html.dark .admin-gad-shell main .text-emerald-700,
        html.dark .admin-gad-shell main .text-emerald-800,
        html.dark .admin-gad-shell main .text-green-500,
        html.dark .admin-gad-shell main .text-green-600,
        html.dark .admin-gad-shell main .text-green-700,
        html.dark .admin-gad-shell main .text-success {
            color: #6ee7b7 !important;
        }

        html.dark .admin-gad-shell main .bg-blue-50,
        html.dark .admin-gad-shell main .bg-sky-50 {
            background-color: rgba(59, 130, 246, 0.14) !important;
        }

        html.dark .admin-gad-shell main .text-blue-500,
        html.dark .admin-gad-shell main .text-blue-600,
        html.dark .admin-gad-shell main .text-blue-700,
        html.dark .admin-gad-shell main .text-sky-500,
        html.dark .admin-gad-shell main .text-sky-600,
        html.dark .admin-gad-shell main .text-sky-700,
        html.dark .admin-gad-shell main .text-primary {
            color: #93c5fd !important;
        }

        html.dark .admin-gad-shell main .bg-amber-50,
        html.dark .admin-gad-shell main .bg-yellow-50,
        html.dark .admin-gad-shell main .bg-orange-50 {
            background-color: rgba(245, 158, 11, 0.14) !important;
        }

        html.dark .admin-gad-shell main .text-amber-600,
        html.dark .admin-gad-shell main .text-amber-700,
        html.dark .admin-gad-shell main .text-yellow-600,
        html.dark .admin-gad-shell main .text-yellow-700,
        html.dark .admin-gad-shell main .text-orange-600,
        html.dark .admin-gad-shell main .text-orange-700 {
            color: #fcd34d !important;
        }

        html.dark .admin-gad-shell main .bg-red-50,
        html.dark .admin-gad-shell main .bg-danger\/10 {
            background-color: rgba(239, 68, 68, 0.13) !important;
        }

        html.dark .admin-gad-shell main .text-red-500,
        html.dark .admin-gad-shell main .text-red-600,
        html.dark .admin-gad-shell main .text-red-700,
        html.dark .admin-gad-shell main .text-danger {
            color: #fca5a5 !important;
        }

        html.dark .admin-gad-shell main input:not([type="checkbox"]):not([type="radio"]),
        html.dark .admin-gad-shell main textarea,
        html.dark .admin-gad-shell main select {
            background-color: #07110d !important;
            border-color: rgba(16, 185, 129, 0.22) !important;
            color: #f8fafc !important;
        }

        html.dark .admin-gad-shell main input::placeholder,
        html.dark .admin-gad-shell main textarea::placeholder {
            color: rgba(209, 250, 229, 0.45) !important;
        }

        html.dark .admin-gad-shell main input[type="file"]::file-selector-button {
            background-color: rgba(16, 185, 129, 0.16) !important;
            color: #6ee7b7 !important;
            border-color: transparent !important;
        }

        html.dark .admin-gad-shell main table {
            color: #d1fae5;
        }

        html.dark .admin-gad-shell main thead,
        html.dark .admin-gad-shell main thead.bg-slate-50,
        html.dark .admin-gad-shell main thead.bg-gray-50 {
            background-color: rgba(16, 185, 129, 0.08) !important;
        }

        html.dark .admin-gad-shell main tbody.bg-white {
            background-color: #0b1512 !important;
        }

        html.dark .admin-gad-shell main .shadow-sm,
        html.dark .admin-gad-shell main .shadow-md,
        html.dark .admin-gad-shell main .shadow-xl,
        html.dark .admin-gad-shell main .shadow-2xl {
            box-shadow: 0 18px 42px rgba(0, 0, 0, 0.24) !important;
        }

        html.dark .admin-gad-shell [data-flux-menu] {
            background: #ffffff !important;
            color: #0f172a !important;
            border: 1px solid rgba(15, 23, 42, 0.08) !important;
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.22) !important;
        }

        html.dark .admin-gad-shell [data-flux-menu] *,
        html.dark .admin-gad-shell [data-flux-menu] svg {
            color: #0f172a !important;
            fill: currentColor !important;
        }
    </style>
    @stack('styles')
</head>

<body
    x-data="{ adminSidebarOpen: false }"
    @keydown.escape.window="adminSidebarOpen = false"
    class="admin-gad-shell min-h-screen bg-slate-50 text-zinc-800 font-sans antialiased overflow-x-hidden"
>

    {{-- SIDEBAR WRAPPER REAL --}}
    <div
        x-cloak
        x-show="adminSidebarOpen"
        x-transition.opacity
        @click="adminSidebarOpen = false"
        class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>

    <div class="flex min-h-screen w-full">
    <aside
        x-bind:class="adminSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="admin-gad-sidebar fixed inset-y-0 left-0 z-50 w-72 max-w-[85vw] flex flex-col shadow-2xl text-white bg-emerald-800 border-r border-emerald-900/20 transition-transform duration-300 ease-out lg:sticky lg:top-0 lg:min-h-screen lg:translate-x-0"
    >

        {{-- LOGO SECTION --}}
        <div class="admin-gad-sidebar-header px-6 py-6 border-b border-emerald-700/50 bg-emerald-900/20">
            <a href="{{ route('admin.dashboard') }}"
               wire:navigate
               @click="adminSidebarOpen = false"
               class="flex items-center gap-3 group">
               
                <img src="{{ asset('img/Logo1.png') }}"
                     class="admin-gad-logo h-11 w-11 rounded-xl bg-white p-1.5 shadow-md transform group-hover:scale-105 transition-all duration-200"
                     alt="Explora Candelaria">

                <div>
                    <h1 class="font-bold text-base tracking-wide text-white transition-colors">
                        Explora Candelaria
                    </h1>
                    <p class="text-xs text-emerald-200/60 font-medium tracking-wider uppercase">Admin Panel</p>
                </div>
            </a>
        </div>

        {{-- MENU NAVIGATION --}}
        <nav class="flex-1 px-4 py-6 space-y-7 overflow-y-auto">

            <div class="space-y-1.5">
                <p class="px-4 text-[10px] font-bold text-emerald-200/40 uppercase tracking-widest mb-2">Principal</p>
                
                <a href="{{ route('admin.dashboard') }}"
                   @click="adminSidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                    <flux:icon.home class="w-5 h-5" style="color: white !important;" />
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="admin-gad-separator border-t border-emerald-700/40 mx-2"></div>

            <div class="space-y-1.5">
                <p class="px-4 text-[10px] font-bold text-emerald-200/40 uppercase tracking-widest mb-2">Módulos</p>

                <a href="{{ route('admin.emprendimientos.gestion') }}"
                   @click="adminSidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.emprendimientos.gestion') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                    <flux:icon.clapperboard class="w-5 h-5" style="color: white !important;" />
                    <span>Emprendimientos</span>
                </a>

                <a href="{{ route('admin.festividades.gestion') }}"
                   @click="adminSidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.festividades.gestion') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                    <flux:icon.calendar class="w-5 h-5" style="color: white !important;" />
                    <span>Festividades</span>
                </a>
            </div>

            <div class="admin-gad-separator border-t border-emerald-700/40 mx-2"></div>

            <div class="space-y-1.5">
                <p class="px-4 text-[10px] font-bold text-emerald-200/40 uppercase tracking-widest mb-2">Exploración</p>

                <a href="{{ route('admin.sitios.gestion') }}"
                   @click="adminSidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.sitios.gestion') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                    <flux:icon.map class="w-5 h-5" style="color: white !important;" />
                    <span>Sitios Turísticos</span>
                </a>

                <a href="{{ route('admin.actividades') }}"
                   @click="adminSidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.actividades') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                    <flux:icon.sparkles class="w-5 h-5" style="color: white !important;" />
                    <span>Actividades</span>
                </a>
                
                <a href="{{ route('admin.reportes') }}"
                   @click="adminSidebarOpen = false"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.reportes*') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                
                    <flux:icon.chart-bar class="w-5 h-5" style="color:white!important;" />
                
                    <span>Reportes</span>
                
                </a>

            </div>

        </nav>

        {{-- USER SECTION --}}
        <div class="admin-gad-user p-4 bg-emerald-950/30 border-t border-emerald-700/50">
            <div class="p-1 rounded-xl text-white hover:bg-white/5 transition duration-200">
                @auth
                    <x-desktop-user-menu :name="auth()->user()->name" />
                @endauth
            </div>
        </div>

    </aside>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="admin-gad-main flex-1 min-w-0 min-h-screen overflow-y-auto bg-slate-50">
        <header class="admin-gad-mobile-header sticky top-0 z-30 flex items-center justify-between gap-3 border-b border-slate-200 bg-white/95 px-4 py-3 shadow-sm backdrop-blur lg:hidden">
            <button
                type="button"
                @click="adminSidebarOpen = true"
                class="admin-gad-mobile-button inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:bg-slate-50"
                aria-label="Abrir menu"
            >
                <flux:icon.bars-2 class="h-5 w-5" />
            </button>

            <a href="{{ route('admin.dashboard') }}" wire:navigate class="flex min-w-0 items-center gap-2">
                <img src="{{ asset('img/Logo1.png') }}" class="admin-gad-logo h-9 w-9 shrink-0 rounded-lg bg-white p-1 shadow-sm" alt="Explora Candelaria">
                <div class="min-w-0">
                    <p class="admin-gad-mobile-title truncate text-sm font-bold text-emerald-900">Explora Candelaria</p>
                    <p class="admin-gad-mobile-subtitle text-[10px] font-semibold uppercase tracking-wider text-emerald-700/70">Admin Panel</p>
                </div>
            </a>
        </header>

        <div class="mx-auto w-full max-w-7xl px-4 py-5 sm:px-6 lg:p-8">
            {{ $slot }}
        </div>
    </main>
    </div>

    @stack('scripts')
    @fluxScripts

</body>
</html>
