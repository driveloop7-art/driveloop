@props([
    'name',
    'title' => '',
    'show' => false,
    'maxWidth' => '2xl'
])

@php
$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl',
    '4xl' => 'sm:max-w-4xl',
    '5xl' => 'sm:max-w-5xl',
    '6xl' => 'sm:max-w-6xl',
    '7xl' => 'sm:max-w-7xl',
][$maxWidth];
@endphp

<div
    x-data="{show: @js($show), params: {}}"
    x-on:open-modal.window="if (typeof $event.detail === 'string' && $event.detail === '{{ $name }}') {
                            show = true;
                            params = {};
                        } else if (typeof $event.detail === 'object' && $event.detail.name === '{{ $name }}') {
                            show = true;
                            params = $event.detail;
                        }"
    x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50" style="display: {{ $show ? 'block' : 'none' }};">
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
    
    <div
        x-show="show"
        class="mb-6 bg-transparent overflow-hidden transform transition-all mx-auto {{ $maxWidth }}"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
        
        @if($title)
        <div class="bg-gradient-to-r from-dl to-dl-two -ml-8 px-6 py-3 text-white text-2xl font-bold w-[70%] xl:w-[60%] skew-x-35 uppercase">
            <span class="-skew-x-35 block ml-8">{{ $title }}</span>
        </div>
        @endif
            
        <div x-data="{ active: null }"
            class="bg-white xl:rounded-r-lg xl:rounded-bl-lg p-6">
            {{ $slot }}
        </div>
    </div>
</div>