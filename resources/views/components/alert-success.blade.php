@if(session()->has('success'))
    <div x-data="{ open: true }" 
         x-init="setTimeout(() => open = false, 4000)" 
         x-show="open" 
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 translate-y-[-1rem] sm:translate-y-0 sm:translate-x-4"
         x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200 transform"
         x-transition:leave-start="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave-end="opacity-0 translate-y-[-1rem] sm:translate-y-0 sm:translate-x-4"
         class="fixed top-6 right-6 z-[100] w-full max-w-sm overflow-hidden rounded-radius border border-green-500 bg-surface text-on-surface shadow-2xl dark:bg-surface-dark dark:text-on-surface-dark" 
         role="alert">
        <div class="flex w-full items-center gap-2 bg-success/10 p-4">
            <div class="bg-green-500/15 text-green-500 rounded-full p-1 shadow-sm" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-6">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm3.857-9.809a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 1 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-2">
                <h3 class="text-sm font-bold text-success">¡Acción Exitosa!</h3>
                <p class="text-xs font-medium sm:text-sm mt-0.5">{{ session('success') }}</p>
            </div>
            <button @click="open = false" type="button" class="ml-auto hover:opacity-75 transition bg-transparent p-1 rounded-full hover:bg-success/20" aria-label="dismiss alert">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" stroke="currentColor" fill="none" stroke-width="2.5" class="size-4 shrink-0 text-success">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
@endif