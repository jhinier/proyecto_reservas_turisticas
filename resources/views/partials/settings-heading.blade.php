@php
    $isTouristSettings = auth()->user()?->hasRole('turista');
@endphp

<div @class([
    'relative mb-6 w-full',
    'rounded-lg border border-emerald-100 bg-white p-6 shadow-sm dark:border-white/10 dark:bg-zinc-900' => $isTouristSettings,
])>
    @if ($isTouristSettings)
        <span class="mb-3 inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-emerald-700 dark:bg-emerald-400/10 dark:text-emerald-300">
            Mi cuenta
        </span>
    @endif

    <flux:heading size="xl" level="1" class="!text-zinc-900 dark:!text-white">
        {{ $isTouristSettings ? 'Configuración de cuenta' : __('Configuración') }}
    </flux:heading>

    <flux:subheading size="lg" class="mb-6 !text-zinc-600 dark:!text-slate-300">
        {{ $isTouristSettings ? 'Administra tu perfil, seguridad y preferencias personales.' : __('Administra tu perfil y la configuración de tu cuenta') }}
    </flux:subheading>

    <flux:separator variant="subtle" class="!border-emerald-200 dark:!border-emerald-400/20" />
</div>
