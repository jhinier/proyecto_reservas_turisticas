<div class="min-h-screen bg-white relative">
    
    <div class="p-6 lg:p-10 space-y-8 max-w-7xl mx-auto">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div class="w-full md:w-96 relative">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 size-5 text-[#8DBEA2]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" /></svg>
                <input type="search" class="w-full bg-white border border-[#CFE2CF] rounded-full py-3 pl-12 pr-4 text-sm text-[#3B4D36] placeholder-[#8DBEA2] focus:ring-2 focus:ring-[#32744C] focus:border-[#32744C] shadow-sm transition outline-none" placeholder="Buscar turista por cédula o nombre...">
            </div>
            
            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-[#7C8D54] uppercase tracking-widest">Filtrar por</span>
                <select wire:model.live="periodoFiltro" class="bg-white border border-[#CFE2CF] rounded-xl py-2 pl-4 pr-10 text-sm font-bold text-[#3B4D36] shadow-sm focus:ring-[#32744C] focus:border-[#32744C] cursor-pointer appearance-none outline-none">
                    <option value="hoy">Hoy</option>
                    <option value="esta_semana">Esta semana</option>
                    <option value="este_mes">Este mes</option>
                </select>
            </div>
        </div>

        <h1 class="text-3xl font-extrabold text-[#3B4D36] tracking-tight">¡Hola, {{ Auth::user()->name }}!</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative">
            <div wire:loading.flex wire:target="periodoFiltro" class="absolute inset-0 bg-white/60 backdrop-blur-sm z-10 items-center justify-center rounded-3xl">
                <div class="animate-spin size-8 border-4 border-[#8DBEA2] border-t-[#32744C] rounded-full"></div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-[#CFE2CF] shadow-sm hover:shadow-md transition duration-300">
                <div class="flex items-center gap-3 mb-6">
                    <div class="size-8 rounded-full bg-[#F1EAD7] flex items-center justify-center">
                        <svg class="size-4 text-[#C6A24D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-sm font-bold text-[#7C8D54]">Pendientes</h3>
                </div>
                <div class="text-4xl font-black text-[#3B4D36] mb-2">{{ $this->metricas['pendientes'] ?? 0 }}</div>
                <p class="text-xs font-medium text-[#8DBEA2] tracking-wide">Esperando confirmación</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-[#CFE2CF] shadow-sm hover:shadow-md transition duration-300">
                <div class="flex items-center gap-3 mb-6">
                    <div class="size-8 rounded-full bg-[#8DBEA2]/20 flex items-center justify-center">
                        <svg class="size-4 text-[#32744C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    </div>
                    <h3 class="text-sm font-bold text-[#7C8D54]">Reagendadas</h3>
                </div>
                <div class="text-4xl font-black text-[#3B4D36] mb-2">{{ $this->metricas['reagendadas'] ?? 0 }}</div>
                <p class="text-xs font-medium text-[#8DBEA2] tracking-wide">Fechas modificadas</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-[#CFE2CF] shadow-sm hover:shadow-md transition duration-300">
                <div class="flex items-center gap-3 mb-6">
                    <div class="size-8 rounded-full bg-[#855A37]/10 flex items-center justify-center">
                        <svg class="size-4 text-[#855A37]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                    </div>
                    <h3 class="text-sm font-bold text-[#7C8D54]">Canceladas</h3>
                </div>
                <div class="text-4xl font-black text-[#855A37] mb-2">{{ $this->metricas['canceladas'] ?? 0 }}</div>
                <p class="text-xs font-medium text-[#8DBEA2] tracking-wide">Servicios anulados</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            
            <div class="bg-white p-8 rounded-[2rem] shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[300px] border border-[#CFE2CF]">
                <div class="relative z-10">
                    <h3 class="text-lg font-extrabold text-[#3B4D36] mb-1">Rendimiento</h3>
                    <p class="text-sm text-[#7C8D54] font-medium">Actividad reciente de reservas.</p>
                </div>
                
                <div class="absolute bottom-0 left-0 right-0 h-40">
                    <svg viewBox="0 0 400 150" class="w-full h-full text-[#8DBEA2]/20" preserveAspectRatio="none">
                        <path d="M0 100 Q 50 150 150 100 T 250 50 T 400 80 L 400 150 L 0 150 Z" fill="currentColor"></path>
                        <path d="M0 100 Q 50 150 150 100 T 250 50 T 400 80" fill="none" stroke="#32744C" stroke-width="3"></path>
                        <circle cx="250" cy="50" r="4" fill="white" stroke="#32744C" stroke-width="2"></circle>
                    </svg>
                    <div class="absolute top-[20px] left-[215px] bg-[#3B4D36] text-[#F1EAD7] text-[10px] font-bold px-3 py-1.5 rounded-lg shadow-lg">
                        Hoy
                        <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 size-2 bg-[#3B4D36] rotate-45"></div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <div class="bg-[#3B4D36] p-8 rounded-[2rem] relative overflow-hidden flex flex-col justify-center text-[#F1EAD7] shadow-md group border border-[#3B4D36]">
                    <svg class="absolute -bottom-6 -right-6 size-40 text-white opacity-5 group-hover:scale-110 transition duration-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 3C21 3 20 2 14 2C8 2 3 7 3 13C3 16 4 18 6 20L3 23L5 24L8 21C10 22 12 22 15 22C21 22 23 16 23 10C23 6 21 3 21 3ZM15 20C12 20 9.5 19.5 8 18.5L16.5 10C17 9.5 17 8.5 16.5 8C16 7.5 15 7.5 14.5 8L6 16.5C5 14.5 5 12 5 13C5 8 9 4 14 4C18 4 19.5 6 19.5 10C19.5 15 18 20 15 20Z" />
                    </svg>
                    <div class="relative z-10">
                        <div class="bg-white/10 w-fit p-3 rounded-2xl mb-4 backdrop-blur-sm">
                            <svg class="size-6 text-[#C6A24D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <div class="text-5xl font-black mb-2">{{ $this->metricas['confirmadas'] ?? 0 }}</div>
                        <h3 class="text-sm font-bold tracking-wide uppercase text-[#8DBEA2]">Reservas<br>Confirmadas</h3>
                    </div>
                </div>

                <div class="bg-[#32744C] p-8 rounded-[2rem] relative overflow-hidden flex flex-col justify-center text-[#F1EAD7] shadow-md group border border-[#32744C]">
                    <svg class="absolute -top-6 -right-6 size-40 text-white opacity-5 group-hover:-rotate-12 transition duration-500" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 8C8 10 5 16 5 22c2-2 6-4 10-4s5-2 6-5-1-4-4-5z" />
                    </svg>
                    <div class="relative z-10">
                        <div class="bg-white/10 w-fit p-3 rounded-2xl mb-4 backdrop-blur-sm">
                            <svg class="size-6 text-[#C6A24D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <div class="text-5xl font-black mb-2">{{ $this->metricas['completadas'] ?? 0 }}</div>
                        <h3 class="text-sm font-bold tracking-wide uppercase text-[#8DBEA2]">Reservas<br>Completadas</h3>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <a href="{{ route('emprendimiento.reservas.crear') }}" wire:navigate class="fixed bottom-8 right-8 size-14 bg-[#3B4D36] hover:bg-[#C6A24D] transition rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] flex items-center justify-center text-[#F1EAD7] hover:text-[#3B4D36] hover:scale-105 z-50">
        <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
    </a>

</div>