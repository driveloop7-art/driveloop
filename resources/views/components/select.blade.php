@props([
    'disabled' => false,
    'options' => []
])

<div class="relative mb-4">
    <div class="absolute left-2 top-[15px] -translate-y-1/2 text-xs w-[96%] h-7">
        <label for="{{ $attributes->get('label', $attributes->get('name')) }}"
            class="absolute left-2 top-[6px] text-xs font-medium text-gray-400 tracking-wider whitespace-nowrap">
            {{ $attributes->get('label', $attributes->get('name')) }}
        </label>
    </div>
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border border-dl xl:rounded-md pt-7 text-sm']) !!}>
        <option value="" selected disabled hidden>Seleccione una opción</option>
        @foreach($options as $value => $display)
            <option value="{{ $value }}">{{ $display }}</option>
        @endforeach
    </select>
    {{ $slot }}
</div>