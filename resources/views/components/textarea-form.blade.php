@props(['id', 'label', 'rows' => 4, 'placeholder' => '', 'model' => null])

<div class="flex w-full flex-col gap-1 text-on-surface dark:text-on-surface-dark">
    <label for="{{ $id }}" class="flex w-fit items-center gap-1 pl-0.5 text-sm {{ $errors->has($model) ? 'text-danger' : 'text-gray-700 dark:text-gray-300' }}">
        @if($errors->has($model))
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" aria-hidden="true" fill="currentColor" class="w-4 h-4"><path d="M5.28 4.22a.75.75 0 0 0-1.06 1.06L6.94 8l-2.72 2.72a.75.75 0 1 0 1.06 1.06L8 9.06l2.72 2.72a.75.75 0 1 0 1.06-1.06L9.06 8l2.72-2.72a.75.75 0 0 0-1.06-1.06L8 6.94 5.28 4.22Z"/></svg>
        @endif
        {{ $label }}
    </label>
    
    <textarea id="{{ $id }}" rows="{{ $rows }}" {{ $model ? 'wire:model='.$model : '' }} placeholder="{{ $placeholder }}" 
              {{ $attributes->merge(['class' => 'w-full rounded-radius border ' . ($errors->has($model) ? 'border-danger' : 'border-gray-300 dark:border-gray-600') . ' bg-surface-alt px-2.5 py-2 text-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary disabled:cursor-not-allowed disabled:opacity-75 dark:bg-surface-dark-alt/50 dark:focus-visible:outline-primary-dark']) }}></textarea>
    
    @if($model)
        @error($model) <small class="pl-0.5 text-danger">{{ $message }}</small> @enderror
    @endif
</div>