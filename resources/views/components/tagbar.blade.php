@props(['active' => 'Mi perfil'])

@php
$items = [
    'Mi perfil' => route('dashboard'),
    'Mis vehiculos' => '#',
    'Mis viajes' => route('my-trips'),
    'Pagos' => '#',
    'Seguridad' => '#',
];
@endphp

<div class="w-16 md:w-64 flex-shrink-0">
    <ul class="space-y-6">
        @foreach($items as $label => $route)
            <li>
                <a href="{{ $route }}"
                   class="block pr-6 pl-6 py-3 text-base font-medium transition-colors duration-200
                          text-gray-600 hover:text-white hover:bg-dl bg-transparent">
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>
</div>
