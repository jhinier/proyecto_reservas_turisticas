<footer class="relative mt-10 overflow-hidden bg-[#014726] text-white dark:bg-[#031f17] sm:mt-16">
    {{-- Linea decorativa superior --}}
    <div class="h-1 w-full bg-gradient-to-r from-[#0b8a0f] via-[#7ed957] to-[#0b8a0f] dark:from-[#052d1e] dark:via-[#7ed957] dark:to-[#052d1e]"></div>

    {{-- Decoracion sutil de fondo --}}
    <div class="pointer-events-none absolute -right-32 -top-32 h-80 w-80 rounded-full bg-[#7ed957]/5 blur-3xl dark:bg-[#7ed957]/10"></div>
    <div class="pointer-events-none absolute -bottom-32 -left-32 h-80 w-80 rounded-full bg-[#0b8a0f]/10 blur-3xl dark:bg-[#7ed957]/5"></div>

    <div class="relative mx-auto max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-10">
        <div class="-mx-4 flex snap-x snap-mandatory gap-3 overflow-x-auto overscroll-x-contain px-4 pb-3 [scrollbar-width:none] sm:-mx-6 sm:gap-4 sm:px-6 sm:pb-4 lg:mx-0 lg:grid lg:snap-none lg:grid-cols-[1.2fr_0.9fr_0.95fr_1fr] lg:gap-10 lg:overflow-visible lg:overscroll-auto lg:px-0 lg:pb-0 [&::-webkit-scrollbar]:hidden">
            {{-- Nosotros --}}
            <div class="w-[72vw] min-w-[13.75rem] max-w-[16rem] shrink-0 snap-start rounded-xl border border-white/10 bg-white/5 p-3.5 shadow-sm shadow-black/10 backdrop-blur-sm dark:border-[#7ed957]/15 dark:bg-[#02170f]/70 sm:w-[68vw] sm:min-w-[15rem] sm:max-w-xs sm:rounded-2xl sm:p-4 lg:w-auto lg:min-w-0 lg:max-w-none lg:shrink lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:pr-6 lg:shadow-none lg:backdrop-blur-none lg:dark:bg-transparent">
                <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 p-2.5 ring-1 ring-white/10 backdrop-blur-sm dark:bg-[#7ed957]/10 dark:ring-[#7ed957]/15 sm:mb-5 sm:h-14 sm:w-14 sm:rounded-2xl sm:p-3 lg:h-16 lg:w-16">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#7ed957] sm:h-7 sm:w-7 lg:h-8 lg:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6" />
                    </svg>
                </div>

                <p class="text-xs font-semibold uppercase tracking-widest text-white/45">
                    Nosotros
                </p>

                <h2 class="mt-2 text-base font-bold tracking-tight text-white sm:text-lg lg:text-xl">
                    {{ $emprendimiento->nombre }}
                </h2>

                <p class="mt-3 text-xs leading-5 text-white/60 sm:mt-4 sm:text-sm sm:leading-6">
                    {{ $emprendimiento->descripcion ?: 'Información del emprendimiento turístico.' }}
                </p>
            </div>

            {{-- Contacto --}}
            <div class="w-[72vw] min-w-[13.75rem] max-w-[16rem] shrink-0 snap-start rounded-xl border border-white/10 bg-white/5 p-3.5 shadow-sm shadow-black/10 backdrop-blur-sm dark:border-[#7ed957]/15 dark:bg-[#02170f]/70 sm:w-[68vw] sm:min-w-[15rem] sm:max-w-xs sm:rounded-2xl sm:p-4 lg:w-auto lg:min-w-0 lg:max-w-none lg:shrink lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none lg:backdrop-blur-none lg:dark:bg-transparent">
                <div class="mb-3 sm:mb-5">
                    <h3 class="text-sm font-bold text-white sm:text-base">
                        Contacto
                    </h3>

                    <div class="mt-2 flex items-center gap-1">
                        <span class="h-1 w-9 rounded-full bg-white/90"></span>
                        <span class="h-1 w-7 rounded-full bg-[#7ed957]"></span>
                    </div>
                </div>

                <div class="space-y-3 sm:space-y-4">
                    @if($emprendimiento->user)
                        <div class="flex items-start gap-2.5 sm:gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/5 text-[#7ed957] dark:bg-[#7ed957]/10 sm:h-9 sm:w-9 sm:rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.22 2 2 0 014.11 2h3a2 2 0 012 1.72c.12.9.33 1.78.62 2.63a2 2 0 01-.45 2.11L8 9.73a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0122 16.92z" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-white sm:text-sm">
                                    Tel&eacute;fono
                                </p>
                                <p class="mt-1 text-xs text-white/60 sm:text-sm">
                                    {{ $emprendimiento->user->telefono ?: 'Teléfono no registrado' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-2.5 sm:gap-3">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/5 text-[#7ed957] dark:bg-[#7ed957]/10 sm:h-9 sm:w-9 sm:rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5h18v14H3V5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7l9 6 9-6" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-white sm:text-sm">
                                    Correo
                                </p>
                                <a href="mailto:{{ $emprendimiento->user->email }}" class="mt-1 block break-all text-xs text-white/60 transition hover:text-[#7ed957] sm:text-sm">
                                    {{ $emprendimiento->user->email }}
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Enlaces Directos --}}
            <div class="w-[72vw] min-w-[13.75rem] max-w-[16rem] shrink-0 snap-start rounded-xl border border-white/10 bg-white/5 p-3.5 shadow-sm shadow-black/10 backdrop-blur-sm dark:border-[#7ed957]/15 dark:bg-[#02170f]/70 sm:w-[68vw] sm:min-w-[15rem] sm:max-w-xs sm:rounded-2xl sm:p-4 lg:w-auto lg:min-w-0 lg:max-w-none lg:shrink lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none lg:backdrop-blur-none lg:dark:bg-transparent">
                <div class="mb-3 sm:mb-5">
                    <h3 class="text-sm font-bold text-white sm:text-base">
                        Enlaces Directos
                    </h3>

                    <div class="mt-2 flex items-center gap-1">
                        <span class="h-1 w-9 rounded-full bg-white/90"></span>
                        <span class="h-1 w-7 rounded-full bg-[#7ed957]"></span>
                    </div>
                </div>

                <nav class="space-y-2 sm:space-y-3">
                    <a
                        href="{{ route('home') }}"
                        class="group flex items-center gap-2.5 text-xs text-white/60 transition duration-200 hover:translate-x-1 hover:text-[#7ed957] sm:gap-3 sm:text-sm"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#7ed957]/70 transition group-hover:bg-[#7ed957]"></span>
                        Inicio
                    </a>

                    <a
                        href="{{ route('turista.servicios.index') }}"
                        class="group flex items-center gap-2.5 text-xs text-white/60 transition duration-200 hover:translate-x-1 hover:text-[#7ed957] sm:gap-3 sm:text-sm"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#7ed957]/70 transition group-hover:bg-[#7ed957]"></span>
                        Servicios
                    </a>

                    <a
                        href="{{ route('sitios') }}"
                        class="group flex items-center gap-2.5 text-xs text-white/60 transition duration-200 hover:translate-x-1 hover:text-[#7ed957] sm:gap-3 sm:text-sm"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#7ed957]/70 transition group-hover:bg-[#7ed957]"></span>
                        Sitios Tur&iacute;sticos
                    </a>

                    <a
                        href="{{ route('actividades') }}"
                        class="group flex items-center gap-2.5 text-xs text-white/60 transition duration-200 hover:translate-x-1 hover:text-[#7ed957] sm:gap-3 sm:text-sm"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#7ed957]/70 transition group-hover:bg-[#7ed957]"></span>
                        Actividades
                    </a>

                    <a
                        href="{{ route('festividades') }}"
                        class="group flex items-center gap-2.5 text-xs text-white/60 transition duration-200 hover:translate-x-1 hover:text-[#7ed957] sm:gap-3 sm:text-sm"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#7ed957]/70 transition group-hover:bg-[#7ed957]"></span>
                        Eventos
                    </a>
                </nav>
            </div>

            {{-- Siguenos --}}
            <div class="w-[72vw] min-w-[13.75rem] max-w-[16rem] shrink-0 snap-start rounded-xl border border-white/10 bg-white/5 p-3.5 shadow-sm shadow-black/10 backdrop-blur-sm dark:border-[#7ed957]/15 dark:bg-[#02170f]/70 sm:w-[68vw] sm:min-w-[15rem] sm:max-w-xs sm:rounded-2xl sm:p-4 lg:w-auto lg:min-w-0 lg:max-w-none lg:shrink lg:rounded-none lg:border-0 lg:bg-transparent lg:p-0 lg:shadow-none lg:backdrop-blur-none lg:dark:bg-transparent">
                <div class="mb-3 sm:mb-5">
                    <h3 class="text-sm font-bold text-white sm:text-base">
                        S&iacute;guenos
                    </h3>

                    <div class="mt-2 flex items-center gap-1">
                        <span class="h-1 w-9 rounded-full bg-white/90"></span>
                        <span class="h-1 w-7 rounded-full bg-[#7ed957]"></span>
                    </div>
                </div>

                @if(!empty($emprendimiento->enlaces))
                    <div class="space-y-2 sm:space-y-3">
                        @foreach($emprendimiento->enlaces as $link)
                            @php
                                $url = strtolower($link);
                                $esFacebook = str_contains($url, 'facebook.com');
                                $esInstagram = str_contains($url, 'instagram.com');
                                $esWhatsapp = str_contains($url, 'wa.me') || str_contains($url, 'whatsapp.com');
                            @endphp

                            <a
                                href="{{ $link }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="group flex min-w-0 items-center gap-2.5 text-xs text-white/60 transition duration-200 hover:translate-x-1 hover:text-[#7ed957] sm:gap-3 sm:text-sm"
                            >
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg border border-white/10 bg-white/5 text-white/60 transition duration-200 group-hover:border-[#7ed957]/30 group-hover:bg-[#7ed957]/10 group-hover:text-[#7ed957] dark:border-[#7ed957]/15 dark:bg-[#7ed957]/5 sm:h-9 sm:w-9 sm:rounded-xl">
                                    @if($esFacebook)
                                        <span class="text-sm font-bold">f</span>
                                    @elseif($esInstagram)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <rect width="17" height="17" x="3.5" y="3.5" rx="4" />
                                            <circle cx="12" cy="12" r="3.5" />
                                            <circle cx="17.5" cy="6.5" r=".7" fill="currentColor" stroke="none" />
                                        </svg>
                                    @elseif($esWhatsapp)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.305-.885-.653-1.482-1.459-1.655-1.757-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51h-.573c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3" />
                                        </svg>
                                    @endif
                                </span>

                                <span class="truncate">
                                    {{ parse_url($link, PHP_URL_HOST) ?? $link }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs leading-5 text-white/60 sm:text-sm sm:leading-6">
                        No hay enlaces registrados para este lugar.
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- Barra inferior --}}
    <div class="border-t border-white/10 dark:border-[#7ed957]/15">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-3 text-center sm:px-6 md:flex-row md:text-left lg:px-8 lg:py-4">
            <p class="text-xs text-white/45">
                &copy; {{ date('Y') }}
                <span class="font-medium text-white/65">
                    Gobierno Parroquial Rural La Candelaria
                </span>
                &middot; Todos los derechos reservados.
            </p>

            <p class="text-xs text-white/35">
                Administraci&oacute;n 2023 - 2027
            </p>
        </div>
    </div>

    <button
        type="button"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        aria-label="Volver arriba"
        class="group fixed bottom-4 right-4 z-50 flex h-10 w-10 items-center justify-center rounded-xl bg-[#7ed957] text-[#10251b] shadow-lg shadow-black/20 transition duration-300 hover:-translate-y-1 hover:bg-[#91e76b] focus:outline-none focus:ring-2 focus:ring-[#7ed957] focus:ring-offset-2 focus:ring-offset-[#10251b] dark:focus:ring-offset-[#031f17] sm:bottom-6 sm:right-6 sm:h-11 sm:w-11"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover:-translate-y-0.5 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>
</footer>
