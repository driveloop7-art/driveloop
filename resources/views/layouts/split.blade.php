<x-app-layout>
    <div class="min-h-[calc(100vh-10rem)] flex bg-white rounded-md">

        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 justify-center items-center bg-cover bg-center rounded-md"
            style="background-image: url('{{ asset('images/imagen_log_reg.avif') }}');">
            {{ $banner ?? '' }}
            <div class="absolute inset-0 bg-black opacity-50 rounded-md"></div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-4 overflow-y-auto ">
            <div class="w-full max-w-md">

                <div class="flex justify-center mb-0">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>

                {{ $slot }}

            </div>
        </div>

    </div>
</x-app-layout>