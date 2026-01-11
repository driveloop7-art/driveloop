<x-app-layout>
    <div class="min-h-[calc(100vh-10rem)] flex bg-white xl:rounded-lg">

        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 justify-center items-center bg-cover bg-center xl:rounded-tl-lg xl:rounded-bl-lg"
            style="background-image: url('{{ asset('images/split.jpg') }}');">
            {{ $banner ?? '' }}
            <div class="absolute inset-0 bg-black opacity-50 xl:rounded-tl-lg xl:rounded-bl-lg"></div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 overflow-y-auto ">
            <div class="w-full max-w-md">

                <div class="flex justify-center mb-1">
                    <a href="/">
                        <img src="{{ asset('images/logo_black.svg') }}" alt="Logo" class="w-24 h-20" />
                    </a>
                </div>

                {{ $slot }}

            </div>
        </div>

    </div>
</x-app-layout>