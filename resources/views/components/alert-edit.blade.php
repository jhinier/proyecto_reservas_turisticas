@if (session()->has('edit'))
    <div x-data="{ show: true }" 
         x-init="setTimeout(() => show = false, 4000)" 
         x-show="show" 
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-4 right-4 z-50 w-full max-w-sm overflow-hidden rounded-lg border border-sky-500 bg-white shadow-xl dark:bg-gray-800 pointer-events-auto" 
         role="alert">
         
        <div class="flex w-full items-start gap-3 bg-sky-50/50 p-4 dark:bg-sky-900/20">
            <div class="bg-sky-100 text-sky-500 rounded-full p-1 dark:bg-sky-500/20" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6"><path fill-rule="evenodd" d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-7-4a1 1 0 1 1-2 0 1 1 0 0 1 2 0ZM9 9a.75.75 0 0 0 0 1.5h.253a.25.25 0 0 1 .244.304l-.459 2.066A1.75 1.75 0 0 0 10.747 15H11a.75.75 0 0 0 0-1.5h-.253a.25.25 0 0 1-.244-.304l.459-2.066A1.75 1.75 0 0 0 9.253 9H9Z" clip-rule="evenodd" /></svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-sky-700 dark:text-sky-400">{{ session('edit')['title'] ?? 'Actualizado' }}</h3>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ session('edit')['message'] ?? session('edit') }}</p>
            </div>
            <button @click="show = false" type="button" class="mt-0.5 text-gray-400 hover:text-gray-600 transition-colors" aria-label="Cerrar">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
@endif