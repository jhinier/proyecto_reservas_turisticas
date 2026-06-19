<footer class="bg-gradient-to-br from-emerald-900 to-green-700 text-white mt-auto">
    
    <div class="max-w-7xl mx-auto px-6 py-12">

        <div class="grid md:grid-cols-4 gap-10">-->

            <!-- Información -->
            <div>
                <h3 class="text-xl font-bold mb-4">
                    Turismo Rural
                </h3>

                <p class="text-gray-300 text-sm leading-relaxed">
                    Plataforma turística para promover atractivos,
                    emprendimientos, servicios y festividades de la parroquia.
                </p>
            </div>

            <!-- Navegación -->
            <div>
                <h3 class="font-semibold text-lg mb-4">
                    Navegación
                </h3>

                <ul class="space-y-2 text-gray-300">

                    <li>
                        <a href="{{ route('home') }}"
                           class="hover:text-green-400 transition">
                            Inicio
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('sitios') }}"
                           class="hover:text-green-400 transition">
                            Atractivos
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('actividades') }}"
                           class="hover:text-green-400 transition">
                            Servicios
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('festividades') }}"
                           class="hover:text-green-400 transition">
                            Festividades
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Contacto -->
            <div>

                <h3 class="font-semibold text-lg mb-4">
                    Contacto
                </h3>

                <div class="space-y-2 text-gray-300 text-sm">

                    <p>
                        GAD Parroquial
                    </p>

                    <p>
                        Chimborazo - Ecuador
                    </p>

                    <p>
                        info@turismo.gob.ec
                    </p>

                    <p>
                        +593 999 999 999
                    </p>

                </div>

            </div> 

            <!-- Redes -->
            <div>

                <h3 class="font-semibold text-lg mb-4">
                    Síguenos
                </h3>

                <div class="flex gap-4">

                    <a href="#"
                       class="bg-slate-800 hover:bg-green-600 p-3 rounded-full transition">
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    <a href="#"
                       class="bg-slate-800 hover:bg-green-600 p-3 rounded-full transition">
                        <i class="fab fa-instagram"></i>
                    </a>

                    <a href="#"
                       class="bg-slate-800 hover:bg-green-600 p-3 rounded-full transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>

    <div class="border-t border-slate-800">

        <div class="max-w-7xl mx-auto px-6 py-4 text-center text-sm text-gray-400">

            © {{ date('Y') }} Sistema de Promoción y Reservas Turísticas.
            Todos los derechos reservados.

        </div>

    </div>

</footer>
