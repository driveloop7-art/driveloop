@props([
    'type' => 'text',
])

<div class="relative shadow-md">
    <input
        type="{{ $type }}"
        placeholder=""
        {{ $attributes->merge(['class' => 'w-full px-4 pt-7 text-sm 
             border border-dl rounded-md']) }}>
        {{ $slot }}
    </input>
    <label
        for="{{ $attributes->get('id', $attributes->get('name')) }}"
        class="absolute left-4 top-4 -translate-y-1/2 text-xs">
        {{ $attributes->get('placeholder', $attributes->get('name')) }}
    </label>
    
</div>