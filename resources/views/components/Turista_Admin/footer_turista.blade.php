<!-- =========================================================
     FOOTER - EXPLORA CANDELARIA
     Diseño institucional, moderno y responsive
========================================================= -->

<footer class="relative mt-16 overflow-hidden bg-[#014726] text-white">

    <!-- Línea decorativa superior -->
    <div class="h-1 w-full bg-gradient-to-r from-[#0b8a0f] via-[#7ed957] to-[#0b8a0f]"></div>

    <!-- Decoración sutil de fondo -->
    <div class="pointer-events-none absolute -right-32 -top-32 h-80 w-80 rounded-full bg-[#7ed957]/5 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-32 -left-32 h-80 w-80 rounded-full bg-[#0b8a0f]/10 blur-3xl"></div>


    <!-- =====================================================
         CONTENIDO PRINCIPAL
    ====================================================== -->

    <div class="relative mx-auto max-w-7xl px-5 py-10 sm:px-6 lg:px-8">

        <div class="grid gap-10 lg:grid-cols-[1.25fr_1fr_1.25fr_0.9fr]">


            <!-- =================================================
                 IDENTIDAD INSTITUCIONAL
            ================================================== -->

            <div class="lg:pr-6">

                <!-- Logo -->
                <div class="mb-5 flex items-center">

                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 p-2 ring-1 ring-white/10 backdrop-blur-sm">

                        <img
                            src="{{ asset('images/logo-gad.png') }}"
                            alt="GAD Parroquial Rural La Candelaria"
                            class="h-full w-full object-contain"
                            onerror="this.style.display='none'"
                        >

                    </div>

                </div>


                <!-- Nombre -->
                <h2 class="text-xl font-bold tracking-tight text-white">
                    Gobierno Parroquial
                </h2>

                <p class="mt-1 text-base font-semibold text-[#7ed957]">
                    La Candelaria
                </p>


                <!-- Presidente -->
                <div class="mt-5">

                    <p class="text-sm font-semibold text-white">
                        Sr. Diego Barba Pusay
                    </p>

                    <p class="mt-1 text-xs uppercase tracking-wide text-white/55">
                        Presidente del GADPRLC
                    </p>

                    <p class="mt-1 text-xs text-white/45">
                        Administración 2023 - 2027
                    </p>

                </div>


                <!-- Horario -->
                <div class="mt-5 flex items-start gap-3">

                    <div class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#7ed957]/10 text-[#7ed957]">

                        <!-- Icono reloj -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"
                            />
                        </svg>

                    </div>

                    <div>
                        <p class="text-sm font-semibold text-white">
                            Horario de Atención
                        </p>

                        <p class="mt-1 text-xs text-white/55">
                            Lun - Vie · 08:00 a 17:00
                        </p>
                    </div>

                </div>

            </div>



            <!-- =================================================
                 ENLACES DIRECTOS
            ================================================== -->

            <div>

                <div class="mb-5">

                    <h3 class="text-base font-bold text-white">
                        Enlaces Directos
                    </h3>

                    <!-- Decoración -->
                    <div class="mt-2 flex items-center gap-1">
                        <span class="h-1 w-9 rounded-full bg-white/90"></span>
                        <span class="h-1 w-7 rounded-full bg-[#7ed957]"></span>
                    </div>

                </div>


                <nav class="space-y-3">

                    <a
                        href="{{ route('home') }}"
                        class="group flex items-center gap-3 text-sm text-white/60 transition duration-200 hover:translate-x-1 hover:text-[#7ed957]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#7ed957]/70 transition group-hover:bg-[#7ed957]"></span>
                        Inicio
                    </a>


                    <a
                        href="{{ route('sitios') }}"
                        class="group flex items-center gap-3 text-sm text-white/60 transition duration-200 hover:translate-x-1 hover:text-[#7ed957]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#7ed957]/70 transition group-hover:bg-[#7ed957]"></span>
                        Atractivos Turísticos
                    </a>


                    <a
                        href="{{ route('actividades') }}"
                        class="group flex items-center gap-3 text-sm text-white/60 transition duration-200 hover:translate-x-1 hover:text-[#7ed957]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#7ed957]/70 transition group-hover:bg-[#7ed957]"></span>
                        Actividades
                    </a>


                    <a
                        href="{{ route('festividades') }}"
                        class="group flex items-center gap-3 text-sm text-white/60 transition duration-200 hover:translate-x-1 hover:text-[#7ed957]"
                    >
                        <span class="h-1.5 w-1.5 rounded-full bg-[#7ed957]/70 transition group-hover:bg-[#7ed957]"></span>
                        Festividades    
                    </a>

                </nav>

            </div>



            <!-- =================================================
                 NUESTRAS OFICINAS
            ================================================== -->

            <div>

                <div class="mb-5">

                    <h3 class="text-base font-bold text-white">
                        Nuestras Oficinas
                    </h3>

                    <div class="mt-2 flex items-center gap-1">
                        <span class="h-1 w-9 rounded-full bg-white/90"></span>
                        <span class="h-1 w-7 rounded-full bg-[#7ed957]"></span>
                    </div>

                </div>


                <div class="space-y-4">


                    <!-- Dirección -->
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/5 text-[#7ed957]">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 21s8-7.2 8-13a8 8 0 10-16 0c0 5.8 8 13 8 13z"
                                />

                                <circle
                                    cx="12"
                                    cy="8"
                                    r="2.5"
                                />
                            </svg>

                        </div>

                        <p class="text-sm leading-6 text-white/60">
                            Calle Principal S/N,<br>
                            frente al Parque Central<br>
                            Penipe - Ecuador
                        </p>

                    </div>


                    <!-- Teléfonos -->
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/5 text-[#7ed957]">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6A19.79 19.79 0 012.12 4.22 2 2 0 014.11 2h3a2 2 0 012 1.72c.12.9.33 1.78.62 2.63a2 2 0 01-.45 2.11L8 9.73a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.85.29 1.73.5 2.63.62A2 2 0 0122 16.92z"
                                />
                            </svg>

                        </div>

                        <div class="text-sm leading-6 text-white/60">

                            <p>
                                Oficina:
                                <span class="text-white/80">
                                    (+593) 3 301 4044
                                </span>
                            </p>

                            <p>
                                Móvil:
                                <span class="text-white/80">
                                    (+593) 980 465 168
                                </span>
                            </p>

                        </div>

                    </div>


                    <!-- Correo -->
                    <div class="flex items-start gap-3">

                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/5 text-[#7ed957]">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 5h18v14H3V5z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 7l9 6 9-6"
                                />
                            </svg>

                        </div>

                        <a
                            href="mailto:lacandelaria_penipe@hotmail.com"
                            class="break-all pt-1 text-sm text-white/60 transition hover:text-[#7ed957]"
                        >
                            lacandelaria_penipe@hotmail.com
                        </a>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 REDES SOCIALES -->


                <!-- Redes sociales -->
                <div class="mt-5">

                    <p class="mb-3 text-xs font-semibold uppercase tracking-widest text-white/40">
                        Síguenos
                    </p>

                    <div class="flex gap-2">

                        <a
                            href="https://www.facebook.com/gadlacandelaria"
                            aria-label="Facebook"
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/60 transition duration-200 hover:-translate-y-1 hover:border-[#7ed957]/30 hover:bg-[#7ed957]/10 hover:text-[#7ed957]"
                        >
                            <span class="text-sm font-bold">f</span>
                        </a>


                        <a
                            href="https://www.instagram.com/gadlacandelaria/"
                            aria-label="Instagram"
                            class="flex h-9 w-9 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/60 transition duration-200 hover:-translate-y-1 hover:border-[#7ed957]/30 hover:bg-[#7ed957]/10 hover:text-[#7ed957]"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <rect
                                    width="17"
                                    height="17"
                                    x="3.5"
                                    y="3.5"
                                    rx="4"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3.5"
                                />

                                <circle
                                    cx="17.5"
                                    cy="6.5"
                                    r=".7"
                                    fill="currentColor"
                                    stroke="none"
                                />
                            </svg>
                        </a>
            
                        <a
                        href="https://www.tiktok.com/@gadlacandelaria"
                        target="_blank"
                        rel="noopener noreferrer"
                        aria-label="TikTok"
                        class="flex h-9 w-9 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-white/60 transition duration-200 hover:-translate-y-1 hover:border-[#7ed957]/30 hover:bg-[#7ed957]/10 hover:text-[#7ed957]"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                        >
                            <path d="M19.589 6.686a4.793 4.793 0 0 1-3.77-3.77A4.804 4.804 0 0 1 15.726 2h-3.695v13.333a2.228 2.228 0 1 1-2.228-2.228c.124 0 .246.01.365.03v-3.75a5.98 5.98 0 0 0-.365-.011A5.981 5.981 0 1 0 15.785 15V8.263a8.464 8.464 0 0 0 3.804.899V5.467z"/>
                        </svg>
                    </a>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- =====================================================
         BARRA INFERIOR
    ====================================================== -->

    <div class="border-t border-white/10">

        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-5 py-4 text-center sm:px-6 md:flex-row md:text-left lg:px-8">

            <p class="text-xs text-white/45">
                © {{ date('Y') }}
                <span class="font-medium text-white/65">
                    Gobierno Parroquial Rural La Candelaria
                </span>
                · Todos los derechos reservados.
            </p>


            <p class="text-xs text-white/35">
                Administración 2023 - 2027
            </p>

        </div>

    </div>



    <!-- =====================================================
         BOTÓN VOLVER ARRIBA
    ====================================================== -->

    <button
        type="button"
        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
        aria-label="Volver arriba"
        class="group fixed bottom-6 right-6 z-50 flex h-11 w-11 items-center justify-center rounded-xl bg-[#7ed957] text-[#10251b] shadow-lg shadow-black/20 transition duration-300 hover:-translate-y-1 hover:bg-[#91e76b] focus:outline-none focus:ring-2 focus:ring-[#7ed957] focus:ring-offset-2 focus:ring-offset-[#10251b]"
    >

        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-5 w-5 transition-transform duration-300 group-hover:-translate-y-0.5"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            stroke-width="2"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M5 15l7-7 7 7"
            />
        </svg>

    </button>

</footer>