<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    @include('partials.head')
    @stack('styles')
</head>

<body class="min-h-screen flex bg-slate-50 text-zinc-800 font-sans antialiased">

    {{-- SIDEBAR WRAPPER REAL --}}
    <aside class="w-72 min-h-screen flex flex-col shadow-2xl sticky top-0 z-50 text-white bg-emerald-800 border-r border-emerald-900/20">

        {{-- LOGO SECTION --}}
        <div class="px-6 py-6 border-b border-emerald-700/50 bg-emerald-900/20">
            <a href="{{ route('admin.dashboard') }}"
               wire:navigate
               class="flex items-center gap-3 group">
               
                <img src="{{ asset('img/logo1.png') }}"
                     class="h-11 w-11 rounded-xl bg-white p-1.5 shadow-md transform group-hover:scale-105 transition-all duration-200"
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
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.dashboard') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                    <flux:icon.home class="w-5 h-5" style="color: white !important;" />
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="border-t border-emerald-700/40 mx-2"></div>

            <div class="space-y-1.5">
                <p class="px-4 text-[10px] font-bold text-emerald-200/40 uppercase tracking-widest mb-2">Módulos</p>

                <a href="{{ route('admin.emprendimientos.gestion') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.emprendimientos.gestion') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                    <flux:icon.clapperboard class="w-5 h-5" style="color: white !important;" />
                    <span>Emprendimientos</span>
                </a>

                <a href="{{ route('admin.festividades.gestion') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.festividades.gestion') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                    <flux:icon.calendar class="w-5 h-5" style="color: white !important;" />
                    <span>Festividades</span>
                </a>
            </div>

            <div class="border-t border-emerald-700/40 mx-2"></div>

            <div class="space-y-1.5">
                <p class="px-4 text-[10px] font-bold text-emerald-200/40 uppercase tracking-widest mb-2">Exploración</p>

                <a href="{{ route('admin.sitios.gestion') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.sitios.gestion') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                    <flux:icon.map class="w-5 h-5" style="color: white !important;" />
                    <span>Sitios Turísticos</span>
                </a>

                <a href="{{ route('admin.actividades') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white {{ request()->routeIs('admin.actividades') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                    <flux:icon.sparkles class="w-5 h-5" style="color: white !important;" />
                    <span>Actividades</span>
                </a>

                <a href="{{ route('admin.mapa.turistico') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-all duration-200 text-white 
                   {{ request()->routeIs('admin.mapa.turistico') ? 'bg-white/15 shadow-sm font-semibold' : 'hover:bg-white/10 text-emerald-100' }}">
                
                    <flux:icon.map class="w-5 h-5" style="color: white !important;" />
                    <span>Mapa Turístico</span>
                </a>
            </div>

        </nav>

        {{-- USER SECTION --}}
        <div class="p-4 bg-emerald-950/30 border-t border-emerald-700/50">
            <div class="p-1 rounded-xl text-white hover:bg-white/5 transition duration-200">
                <x-desktop-user-menu :name="auth()->user()->name" />
            </div>
        </div>

    </aside>

    {{-- CONTENIDO PRINCIPAL --}}
    <main class="flex-1 min-h-screen overflow-y-auto bg-slate-50">
        <div class="mx-auto max-w-7xl p-8">
            {{ $slot }}
        </div>
    </main>

    @stack('scripts')
    @fluxScripts

</body>
</html>