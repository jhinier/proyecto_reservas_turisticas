@props([
    'etiqueta',
    'valor' => null,
    'amplio' => false,
])

<div {{ $attributes->class([
    'border-b border-gray-100 py-3 dark:border-white/10',
    'sm:col-span-2' => $amplio,
]) }}>
    <dt class="text-[11px] font-semibold uppercase text-gray-500 dark:text-gray-400">
        {{ $etiqueta }}
    </dt>
    <dd class="mt-1 whitespace-pre-line break-words text-sm font-medium leading-relaxed text-gray-900 dark:text-gray-100">
        {{ filled($valor) ? $valor : 'No registrado' }}
    </dd>
</div>
