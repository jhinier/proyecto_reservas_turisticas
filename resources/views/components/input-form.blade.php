@props(['id', 'label', 'type' => 'text', 'placeholder' => '', 'model' => null, 'simbolo' => null])

<div class="flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
    <label for="{{ $id }}" class="flex w-fit items-center gap-1 pl-0.5 text-sm {{ $errors->has($model) ? 'text-danger' : ($errors->any() ? 'text-success' : 'text-gray-700 dark:text-gray-300') }}">
        @if($errors->has($model))
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
        @elseif($errors->any())
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M12.416 3.376a.75.75 0 0 1 .208 1.04l-5 7.5a.75.75 0 0 1-1.154.114l-3-3a.75.75 0 0 1 1.06-1.06l2.353 2.353 4.493-6.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" /></svg>
        @endif
        {{ $label }}
    </label>
    
    <div class="relative w-full">
        @if($simbolo)
            <span class="absolute left-3 top-2 text-sm {{ $errors->has($model) ? 'text-danger' : ($errors->any() ? 'text-success' : 'text-gray-500') }}">{{ $simbolo }}</span>
        @endif
        
        <input id="{{ $id }}" type="{{ $type }}" placeholder="{{ $placeholder }}" 
       @if($model) wire:model="{{ $model }}" @endif
       {{ $attributes->merge(['class' => 'w-full rounded-radius border ' . ($errors->has($model) ? 'border-danger' : ($errors->any() ? 'border-success' : 'border-gray-300 dark:border-gray-600')) . ' bg-surface-alt py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark ' . ($simbolo ? 'pl-7' : 'px-2')]) }} />
    </div>
    
    @if($model)
        @error($model) <small class="pl-0.5 text-danger">{{ $message }}</small> @enderror
    @endif
</div>