@php
    $isTouristSettings = auth()->user()?->hasRole('turista');
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
            'rounded-lg border border-slate-200 bg-white p-2 shadow-sm' => $isTouristSettings,
        ])>
            <flux:navlist aria-label="{{ __('Configuración') }}">
                <flux:navlist.item :href="route('profile.edit')" wire:navigate>{{ $isTouristSettings ? 'Perfil' : __('Perfil') }}</flux:navlist.item>
                <flux:navlist.item :href="route('user-password.edit')" wire:navigate>{{ $isTouristSettings ? 'Contraseña' : __('Contraseña') }}</flux:navlist.item>
            </flux:navlist>
        </div>
    </div>

    @unless ($isTouristSettings)
        <flux:separator class="md:hidden" />
    @endunless

    <div @class([
        'flex-1 self-stretch max-md:pt-6' => ! $isTouristSettings,
        'min-w-0 rounded-lg border border-slate-200 bg-white p-6 shadow-sm sm:p-8' => $isTouristSettings,
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