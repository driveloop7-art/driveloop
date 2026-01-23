<x-app-layout>
    <div {{ $attributes->merge(['class' => 'flex flex-col py-10 px-6 bg-white xl:rounded-xl']) }}>
        {{ $slot }}
    </div>
</x-app-layout>