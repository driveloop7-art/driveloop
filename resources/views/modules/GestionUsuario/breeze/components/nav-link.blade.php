@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-dl
            text-sm text-dl font-medium leading-5
            focus:outline-none focus:border-dl-three focus:text-dl-three
            hover:text-dl-three hover:border-dl-three
            transition duration-150 ease-in-out'
            :
            'inline-flex items-center px-1 pt-1 border-b-2 border-transparent
            text-sm font-medium leading-5 text-gray-500
            hover:text-dl-three hover:border-dl-three
            focus:outline-none focus:text-dl-three focus:border-dl-three
            transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
