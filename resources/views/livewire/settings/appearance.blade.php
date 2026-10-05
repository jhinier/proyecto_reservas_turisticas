<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Configuración de apariencia') }}</flux:heading>

    <x-settings.layout :heading="__('Apariencia')" :subheading=" __('Actualiza la configuración de apariencia de tu cuenta')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio
                value="light"
                icon="sun"
                x-bind:class="$flux.appearance === 'light' ? '!bg-emerald-100 !text-emerald-800 !ring-1 !ring-emerald-300 dark:!bg-emerald-400/20 dark:!text-emerald-200 dark:!ring-emerald-400/30' : ''"
            >{{ __('Claro') }}</flux:radio>

            <flux:radio
                value="dark"
                icon="moon"
                x-bind:class="$flux.appearance === 'dark' ? '!bg-emerald-100 !text-emerald-800 !ring-1 !ring-emerald-300 dark:!bg-emerald-400/20 dark:!text-emerald-200 dark:!ring-emerald-400/30' : ''"
            >{{ __('Oscuro') }}</flux:radio>

            <flux:radio
                value="system"
                icon="computer-desktop"
                x-bind:class="$flux.appearance === 'system' ? '!bg-emerald-100 !text-emerald-800 !ring-1 !ring-emerald-300 dark:!bg-emerald-400/20 dark:!text-emerald-200 dark:!ring-emerald-400/30' : ''"
            >{{ __('Sistema') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>
