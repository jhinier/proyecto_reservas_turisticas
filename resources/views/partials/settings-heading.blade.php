@php
    $isTouristSettings = auth()->user()?->hasRole('turista');
@endphp

<div @class([
    'relative mb-6 w-full',
    'rounded-lg border border-emerald-100 bg-white p-6 shadow-sm' => $isTouristSettings,
])>
    @if ($isTouristSettings)
        <span class="mb-3 inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-emerald-700">
            Mi cuenta
        </span>
    @endif

    <flux:heading size="xl" level="1">
        {{ $isTouristSettings ? 'Configuración de cuenta' : __('Configuración') }}
    </flux:heading>

    <flux:subheading size="lg" class="mb-6">
        {{ $isTouristSettings ? 'Administra tu perfil, seguridad y preferencias personales.' : __('Administra tu perfil y la configuración de tu cuenta') }}
    </flux:subheading>

    <flux:separator variant="subtle" />
</div>
