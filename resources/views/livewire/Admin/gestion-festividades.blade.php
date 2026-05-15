<div>

    <!-- 🔔 NOTIFICACIONES (YA LO TIENES ✔) -->
            <!-- SCRIPT CALENDARIO -->
        @push('scripts')
       
        @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
        @endpush

        @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
        @endpush

        <script>
        document.addEventListener('livewire:load', function () {

            var calendarEl = document.getElementById('calendar');
            var calendar;

            function renderCalendar(eventos) {

                if (calendar) {
                    calendar.destroy();
                }

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    events: eventos
                });

                calendar.render();
            }

            // ✅ AQUÍ YA NO HAY ERROR
            renderCalendar(@json($eventos));

            Livewire.on('actualizarCalendario', eventos => {
                renderCalendar(eventos);
            });

        });
        </script>
        @endpush

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Gestión de Festividades</h1>

        <button 
            x-on:click="$flux.modal('modal-festividad').show()"
            class="bg-green-300 text-white px-4 py-2 rounded-lg flex items-center gap-2">
            
            ➕ Nueva Festividad
        </button>
    </div>

    <!-- 📊 TABLA -->
    <div class="w-full overflow-x-auto rounded-xl border bg-[#0f172a] border-gray-700 shadow">

        <table class="w-full text-sm">
            <thead class="bg-[#1e293b] text-gray-300">
                <tr class="border-t border-gray-700 hover:bg-[#1e293b]">

                    <th class="p-4 text-left">Nombre</th>
                    <th class="p-4 text-left">Fecha</th>
                    <th class="p-4 text-left">Lugar</th>
                    <th class="p-4 text-left">Estado</th>
                    <th class="p-4 text-right">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($festividades as $festividad)

                <tr class="border-t border-gray-700 hover:bg-[#1e293b]">

                    <td class="p-4 font-medium">
                        {{ $festividad->nombre }}
                    </td>

                    <td class="p-4 text-gray-300">
                        {{ $festividad->fecha_inicio }} - {{ $festividad->fecha_fin }}
                    </td>

                    <td class="p-4 text-gray-300">
                        {{ $festividad->lugar }}
                    </td>

                    <td class="p-4">
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                            Activo
                        </span>
                    </td>

                    <td class="p-4 text-right">
                        <div class="flex justify-end gap-2">

                            <!-- ACTIVIDADES -->
                            <button 
                                wire:click="seleccionarFestividad({{ $festividad->publicacion_id }})"
                                x-on:click="$flux.modal('modal-actividad').show()"
                                class="bg-blue-600 text-white px-3 py-1 rounded text-xs">
                                Actividades
                            </button>

                            <!-- ELIMINAR -->
                            <button 
                                wire:click="eliminar({{ $festividad->publicacion_id }})"
                                class="text-red-600">
                                🗑
                            </button>

                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="5" class="text-center p-6 text-gray-500">
                        No hay festividades registradas
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="mt-8 bg-[#0f172a] p-5 rounded-xl shadow border border-gray-700">
    <h2 class="text-lg font-bold mb-4">Calendario de Festividades</h2>

    <div id="calendar" style="min-height: 500px;"></div>
    </div>
    
            <style>
        #calendar {
            color: white;
        }

        .fc {
            background-color: #0f172a;
            color: white;
        }

        .fc-toolbar-title {
            color: white;
        }
    
        #calendar {
            min-height: 500px;
        }

        .fc {
            background-color: #0f172a;
            color: white;
        }

        .fc-toolbar-title {
            color: white;
        }

        .fc-button {
            background-color: #1e293b !important;
            border: none !important;
        }
        </style>
        <style>
        .fc-theme-standard td, 
        .fc-theme-standard th {
            border-color: #374151;
        }

        .fc-daygrid-day-number {
            color: white;
        }
        </style>

    <!-- 🟢 MODAL FESTIVIDAD -->
    <flux:modal name="modal-festividad" class="md:w-96">

        <div class="p-6">
            <h2 class="text-lg font-bold mb-4">Nueva Festividad</h2>

            <input type="text" wire:model="nombre"
                placeholder="Nombre"
                class="w-full mb-2 border rounded p-2">

            <input type="date" wire:model="fecha_inicio"
                class="w-full mb-2 border rounded p-2">

            <input type="date" wire:model="fecha_fin"
                class="w-full mb-2 border rounded p-2">

            <input type="text" wire:model="lugar_festividad"
                placeholder="Lugar"
                class="w-full mb-2 border rounded p-2">

            <textarea wire:model="descripcion_festividad"
                placeholder="Descripción"
                class="w-full mb-2 border rounded p-2"></textarea>

            <button wire:click="guardarFestividad"
                class="bg-green-600 text-white w-full py-2 rounded">
                Guardar
            </button>
        </div>

    </flux:modal>

    <!-- 🔵 MODAL ACTIVIDADES -->
    <flux:modal name="modal-actividad" class="md:w-96">

        <div class="p-6">
            <h2 class="text-lg font-bold mb-4">Nueva Actividad</h2>

            <input type="text" wire:model="actividad_nombre"
                placeholder="Nombre"
                class="w-full mb-2 border rounded p-2">

            <input type="date" wire:model="fecha"
                class="w-full mb-2 border rounded p-2">

            <input type="time" wire:model="hora"
                class="w-full mb-2 border rounded p-2">

            <input type="text" wire:model="lugar_actividad"
                placeholder="Lugar"
                class="w-full mb-2 border rounded p-2">

            <textarea wire:model="descripcion_actividad"
                placeholder="Descripción"
                class="w-full mb-2 border rounded p-2"></textarea>

            <button wire:click="guardarActividad"
                class="bg-blue-600 text-white w-full py-2 rounded">
                Guardar
            </button>

        </div>

    </flux:modal>

</div>