@props([
    'type' => 'text',
])

<div class="relative mb-4">
    <div class="absolute left-2 top-[15px] -translate-y-1/2 text-xs w-[96%] h-7 bg-white">
        <label
            for="{{ $attributes->get('label', $attributes->get('name')) }}"
            class="absolute left-2 top-[6px]">
            {{ $attributes->get('label', $attributes->get('name')) }}
        </label>
    </div>

    @if ($type === 'textarea')
        <textarea
            {{ $attributes->merge([
                'class' => 'w-full px-4 pt-7
                text-sm leading-relaxed
                border border-dl rounded-md shadow-md']) }}
        ></textarea>
    @else
        <input
        type="{{ $type }}"
        placeholder=""
        {{ $attributes->merge([
            'class' => 'w-full px-4 pt-7
            text-sm 
            border border-dl rounded-md shadow-md']) }}>
        </input>
    @endif
</div>