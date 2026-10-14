@props(['title' => null])

<x-layouts::auth.simple :title="$title">
    @isset($navigation)
        <x-slot:navigation>
            {{ $navigation }}
        </x-slot:navigation>
    @endisset

    {{ $slot }}
</x-layouts::auth.simple>
