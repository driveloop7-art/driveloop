@props([
    'type' => 'primary',
    'gradient' => false,
])

@php
    $types = [
        'primary' => 'bg-dl hover:bg-dl-two border border-transparent text-white',
        'secondary' => 'bg-dl-two hover:bg-dl-four border border-transparent text-white',
        'tertiary' => 'bg-white hover:bg-dl hover:text-white border-2 border-dl text-dl',
    ];
    $gradients = [
        'primary' => 'bg-gradient-to-r from-dl to-dl-two hover:from-dl-two hover:to-dl-two text-white',
        'secondary' => 'bg-gradient-to-r from-dl-two to-dl-four hover:from-dl-four hover:to-dl-four text-white',
        'tertiary' => '',
    ];
    $gdnt = $gradient ? $gradients[$type] : '';
@endphp

<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex
        xl:rounded-md
        justify-center
        px-14 py-3
        tracking-widest
        font-semibold uppercase
        transition ease-in-out duration-150 items-center ' . $types[$type] . ' ' . $gdnt]) }}>
        
    {{ $slot }}
</button>   