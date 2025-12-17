@props([
    'width' => 'auto',
    'gradient' => false,
])

@php
    $width = [
        'auto' => 'w-auto',
        'sm' => 'w-[5%]',
        'md' => 'w-[15%]',
        'lg' => 'w-[30%]',
        'xl' => 'w-[40%]',
        '2xl' => 'w-[50%]',
        'full' => 'w-full',
    ][$width];

    if ($gradient) {
        $gdnt = 'bg-gradient-to-r from-dl to-dl-two hover:from-dl-two hover:to-dl-two';
    } else {
        $gdnt = 'bg-dl hover:bg-dl-two';
    }
@endphp

<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'inline-flex
        xl:rounded-md
        justify-center
        px-14 py-3
        tracking-widest
        border border-transparent
        font-semibold text-xs text-white uppercase
        active:bg-dl-two focus:outline-none focus:ring-1 focus:ring-dl-three
        transition ease-in-out duration-150 ' . $width . ' ' . $gdnt]) }}>
        
    {{ $slot }}
</button>