@props([
    'name' => 'password',
    'label' => 'Contraseña',
])

<div x-data="{ show: false }" class="relative mb-4">
    <div class="absolute left-2 top-[15px] -translate-y-1/2 text-xs w-[96%] h-7">
        <label
            for="{{ $name }}"
            class="absolute left-2 top-[6px] text-xs font-medium text-gray-400 tracking-wider whitespace-nowrap">
            {{ $label }}
        </label>
    </div>

    <input
        :type="show ? 'text' : 'password'"
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge([
            'class' => 'w-full px-4 pt-7 text-sm border border-dl xl:rounded-md pr-10'
        ]) }}
    />

    <button type="button" @click="show = !show" class="absolute right-3 top-3.5 translate-y-1 focus:outline-none">
        <!-- ojo abierto-->
        <img src="{{ asset('images/logo_ojo1.png') }}" alt="Mostrar Contraseña" x-show="!show" class="w-7 h-5" />
        <!-- ojo cerrado-->
        <img src="{{ asset('images/logo_ojo2.png') }}" alt="Ocultar Contraseña" x-show="show" class="w-7 h-5" style="display: none;" />
    </button>
</div>
