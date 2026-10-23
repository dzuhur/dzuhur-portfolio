@props(['name', 'label', 'type' => 'text', 'value' => null, 'hint' => null])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium">{{ $label }}</label>

    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
           value="{{ old($name, $value) }}"
           @error($name) aria-invalid="true" aria-describedby="{{ $name }}-error" @enderror
           {{ $attributes->class([
               'mt-2 block w-full rounded-lg border bg-white px-4 py-2.5 outline-none transition-colors focus:border-accent dark:bg-neutral-900',
               'border-red-500' => $errors->has($name),
               'border-neutral-300 dark:border-neutral-700' => ! $errors->has($name),
           ]) }}>

    @if ($hint)
        <p class="mt-1 text-xs text-neutral-500">{{ $hint }}</p>
    @endif

    @error($name)
        <p id="{{ $name }}-error" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>