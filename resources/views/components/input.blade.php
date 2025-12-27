@props([
    'type' => 'text',
])

@php
    $txtarea = $type === 'textarea' ? true: false;
@endphp

<div class="relative mb-4">
    <div class="absolute left-2 top-[15px] -translate-y-1/2 text-xs w-[96%] h-7 {{ $txtarea ? 'bg-white': '' }}">
        <label
            for="{{ $attributes->get('label', $attributes->get('name')) }}"
            class="absolute left-2 top-[6px] text-xs font-medium text-gray-400 tracking-wider whitespace-nowrap">
            {{ $attributes->get('label', $attributes->get('name')) }}
        </label>
    </div>

    @if ($txtarea)
        <textarea
            {{ $attributes->merge([
                'class' => 'w-full px-4 pt-7
                text-sm leading-relaxed
                border border-dl rounded-md']) }}
        ></textarea>
    @else
        <input
        type="{{ $type }}"
        placeholder=""
        {{ $attributes->merge([
            'class' => 'w-full px-4 pt-7
            text-sm 
            border border-dl rounded-md']) }}>
        </input>
    @endif
</div>