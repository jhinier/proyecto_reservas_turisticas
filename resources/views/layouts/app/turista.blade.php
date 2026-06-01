<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Explora Candelaria' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>

<body class="bg-gray-100 min-h-screen">

    @include('partials.banner')

    {{-- CONTENIDO --}}
    <main>

        @yield('content')

    </main>

    {{-- FOOTER --}}
    <footer
        class="bg-zinc-950 text-white mt-24">

        <div
            class="max-w-7xl mx-auto px-6 lg:px-10 py-14">

            <div
                class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <div>

                    <h2
                        class="text-2xl font-bold mb-4">

                        Explora Candelaria

                    </h2>

                    <p class="text-gray-400 leading-relaxed">

                        Descubre paisajes, cultura,
                        festividades y experiencias únicas.

                    </p>

                </div>

                <div>

                    <h3 class="font-semibold text-lg mb-4">
                        Navegación
                    </h3>

                    <ul class="space-y-3 text-gray-400">

                        <li>
                            <a href="{{ route('sitios') }}"
                                class="hover:text-white">
                                Sitios Turísticos
                            </a>
                        </li>

                        <li>
                            <a href="#"
                                class="hover:text-white">
                                Actividades
                            </a>
                        </li>

                        <li>
                            <a href="#"
                                class="hover:text-white">
                                Festividades
                            </a>
                        </li>

                    </ul>

                </div>

                <div>

                    <h3 class="font-semibold text-lg mb-4">
                        Turismo
                    </h3>

                    <p class="text-gray-400">

                        Vive la experiencia de La Candelaria.

                    </p>

                </div>

            </div>

            <div
                class="border-t border-white/10 mt-10 pt-6 text-center text-gray-500 text-sm">

                © {{ date('Y') }} Explora Candelaria.

            </div>

        </div>

    </footer>

    @livewireScripts

</body>

</html> -->