@props(['sidebar' => false])

@if($sidebar)
    <a {{ $attributes }} class="w-full h-full flex items-center justify-center">
        <img src="{{ asset('img/Logo1.png') }}" class="w-full h-full object-contain p-1" alt="Logo">
    </a>
@else
    <a {{ $attributes }} class="w-10 h-10 flex items-center justify-center">
        <img src="{{ asset('img/Logo1.png') }}" class="w-full h-full object-contain" alt="Logo">
    </a>
@endif