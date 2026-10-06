@php
    $isTouristSettings = auth()->user()?->hasRole('turista');
    $isEntrepreneurSettings = auth()->user()?->hasRole('emprendimiento');
@endphp

<div @class([
    'flex items-start max-md:flex-col' => ! $isTouristSettings,
    'grid gap-6 lg:grid-cols-[240px_minmax(0,1fr)]' => $isTouristSettings,
])>
    <div @class([
        'me-10 w-full pb-4 md:w-[220px]' => ! $isTouristSettings,
        'w-full' => $isTouristSettings,
    ])>
        <div @class([
            'rounded-lg border border-slate-200 bg-white p-2 shadow-sm dark:border-white/10 dark:bg-zinc-900' => $isTouristSettings,
        ])>
            <flux:navlist aria-label="{{ __('Configuración') }}">
                <flux:navlist.item
                    :href="route('profile.edit')"
                    wire:navigate
                    class="{{ request()->routeIs('profile.edit') ? 'bg-emerald-50 text-emerald-700 font-semibold ring-1 ring-emerald-200 dark:bg-emerald-400/10 dark:text-emerald-300 dark:ring-emerald-400/20' : 'text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-emerald-300' }}"
                >{{ $isTouristSettings ? 'Perfil' : __('Perfil') }}</flux:navlist.item>

                @if ($isEntrepreneurSettings)
                    <flux:navlist.item
                        :href="route('emprendimiento-profile.edit')"
                        wire:navigate
                        class="{{ request()->routeIs('emprendimiento-profile.edit') ? 'bg-emerald-50 text-emerald-700 font-semibold ring-1 ring-emerald-200 dark:bg-emerald-400/10 dark:text-emerald-300 dark:ring-emerald-400/20' : 'text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-emerald-300' }}"
                    >Datos del emprendimiento</flux:navlist.item>

                    <flux:navlist.item
                        :href="route('emprendimiento-payment.edit')"
                        wire:navigate
                        class="{{ request()->routeIs('emprendimiento-payment.edit') ? 'bg-emerald-50 text-emerald-700 font-semibold ring-1 ring-emerald-200 dark:bg-emerald-400/10 dark:text-emerald-300 dark:ring-emerald-400/20' : 'text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-emerald-300' }}"
                    >Datos de pago</flux:navlist.item>
                @endif

                <flux:navlist.item
                    :href="route('user-password.edit')"
                    wire:navigate
                    class="{{ request()->routeIs('user-password.edit') ? 'bg-emerald-50 text-emerald-700 font-semibold ring-1 ring-emerald-200 dark:bg-emerald-400/10 dark:text-emerald-300 dark:ring-emerald-400/20' : 'text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-emerald-300' }}"
                >{{ $isTouristSettings ? 'Contraseña' : __('Contraseña') }}</flux:navlist.item>
                <flux:navlist.item
                    :href="route('appearance.edit')"
                    wire:navigate
                    class="{{ request()->routeIs('appearance.edit') ? 'bg-emerald-50 text-emerald-700 font-semibold ring-1 ring-emerald-200 dark:bg-emerald-400/10 dark:text-emerald-300 dark:ring-emerald-400/20' : 'text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 dark:text-slate-300 dark:hover:bg-white/5 dark:hover:text-emerald-300' }}"
                >{{ $isTouristSettings ? 'Apariencia' : __('Apariencia') }}</flux:navlist.item>
            </flux:navlist>
        </div>
    </div>

    @unless ($isTouristSettings)
        <flux:separator class="md:hidden" />
    @endunless

    <div @class([
        'flex-1 self-stretch max-md:pt-6' => ! $isTouristSettings,
        'min-w-0 rounded-lg border border-slate-200 bg-white p-6 shadow-sm sm:p-8 dark:border-white/10 dark:bg-zinc-900' => $isTouristSettings,
    ])>
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

        <div @class([
            'mt-5 w-full max-w-lg' => ! $isTouristSettings,
            'mt-6 w-full max-w-2xl' => $isTouristSettings,
        ])>
            {{ $slot }}
        </div>
    </div>
</div>
