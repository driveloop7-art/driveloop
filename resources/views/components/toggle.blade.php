@props([
'title' => null,
])

@if(is_null($title))
<div x-data="{ active: null }" class="space-y-2">
    {{ $slot }}
</div>
@else
<div x-id="['item']" class="bg-gray-50 xl:rounded-lg">
    <button
        type="button"
        @click="active === $id('item') ? active = null : active = $id('item')"
        class="w-full flex justify-between items-center p-3 text-left font-medium transition">


        <span>{{ $title }}</span>

        <span class="text-dl text-lg transition-transform"
            :class="active === $id('item') ? 'rotate-45' : ''">
            +
        </span>
    </button>

    <div x-show="active === $id('item')" x-collapse class="p-3 text-sm">
        {{ $slot }}
    </div>
</div>
@endif