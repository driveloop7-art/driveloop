@props([
    'name',
    'title' => '',
    'show' => false,
    'maxWidth' => '2xl',
])

@php
    $maxWidthClass = match ($maxWidth) {
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
        'full' => 'sm:max-w-[96vw]',
        default => 'sm:max-w-2xl',
    };
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
    x-show="show"
    class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:px-6"
    style="display: {{ $show ? 'block' : 'none' }};"
>
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-500/75"></div>
    </div>

    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        {{ $attributes->merge([
            'class' => "relative mb-6 mx-auto w-full {$maxWidthClass} bg-transparent overflow-hidden transform transition-all"
        ]) }}
    >
        @if($title !== '')
            <div class="bg-gradient-to-r from-dl to-dl-two -ml-8 w-[72%] px-6 py-3 text-2xl font-bold uppercase text-white skew-x-[35deg] xl:w-[58%]">
                <span class="block ml-8 -skew-x-[35deg]">{{ $title }}</span>
            </div>
        @endif

        <div class="bg-white xl:rounded-r-lg xl:rounded-bl-lg p-6 shadow-xl">
            {{ $slot }}
        </div>
    </div>
</div>