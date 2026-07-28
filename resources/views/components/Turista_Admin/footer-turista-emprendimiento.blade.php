{{-- Espaciador dinámico para separar el contenido de arriba --}}
<div class="h-16 md:h-24 w-full bg-transparent"></div>

<footer class="w-full bg-gradient-to-br from-emerald-900 to-green-700 text-white mt-auto border-t border-white/10">
    {{-- Aquí cambiamos pb-20 por pb-6 para quitar el hueco inferior --}}
    <div class="max-w-screen-2xl mx-auto px-4 md:px-16 lg:px-32 xl:px-64 pt-12 pb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            {{-- Sección Nosotros --}}
            <div class="space-y-3">
                <h4 class="text-sm font-bold uppercase tracking-wider text-green-300">Nosotros</h4>
                <h3 class="text-xl font-bold">{{ $emprendimiento->nombre }}</h3>
                <p class="text-xs md:text-sm text-gray-200 leading-relaxed">
                    {{ $emprendimiento->descripcion ?: 'Información del emprendimiento turístico.' }}
                </p>
            </div>

            {{-- Sección Contacto --}}
            <div class="space-y-3">
                <h4 class="text-sm font-bold uppercase tracking-wider text-green-300">Contacto</h4>
                <ul class="space-y-2.5 text-xs md:text-sm text-gray-200">
                    @if($emprendimiento->user)
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-green-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span>{{ $emprendimiento->user->telefono ?: 'Teléfono no registrado' }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-green-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="break-all">{{ $emprendimiento->user->email }}</span>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Sección Enlaces --}}
            <div class="space-y-3">
                <h4 class="text-sm font-bold uppercase tracking-wider text-green-300">Síguenos</h4>
                <div class="flex flex-col gap-2 text-xs md:text-sm">
                    @if(!empty($emprendimiento->enlaces))
                        @foreach($emprendimiento->enlaces as $link)
                            @php
                                $url = strtolower($link);
                                $esFacebook = str_contains($url, 'facebook.com');
                                $esInstagram = str_contains($url, 'instagram.com');
                                $esWhatsapp = str_contains($url, 'wa.me') || str_contains($url, 'whatsapp.com');
                            @endphp
                            <a href="{{ $link }}" target="_blank" rel="noopener noreferrer" class="text-gray-200 hover:text-green-300 transition-colors truncate flex items-center gap-2">
                                @if($esFacebook)
                                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" /></svg>
                                @elseif($esInstagram)
                                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" /></svg>
                                @elseif($esWhatsapp)
                                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.305-.885-.653-1.482-1.459-1.655-1.757-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51h-.573c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" /></svg>
                                @else
                                    <svg class="w-4 h-4 text-green-200 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                                @endif
                                <span class="underline decoration-white/20 hover:decoration-green-300 truncate">
                                    {{ parse_url($link, PHP_URL_HOST) ?? $link }}
                                </span>
                            </a>
                        @endforeach
                    @else
                        <span class="text-gray-200 text-xs font-normal">No hay enlaces registrados para este lugar.</span>
                    @endif
                </div>
            </div>

        </div>

        {{-- Derechos reservados --}}
        <div class="mt-12 pt-6 border-t border-white/10 text-center text-xs text-gray-200">
            <p>&copy; {{ date('Y') }} {{ $emprendimiento->nombre }}. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>