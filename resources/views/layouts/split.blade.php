<x-app-layout>
    <div class="min-h-screen flex bg-white rounded-md">

        <div class="hidden lg:flex lg:w-1/2 relative bg-gray-900 justify-center items-center bg-cover bg-center rounded-md"
        style="background-image: url('https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=2070&auto=format&fit=crop');">
            {{ $banner ?? '' }}
            <div class="absolute inset-0 bg-black opacity-50 rounded-md"></div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 overflow-y-auto ">
            <div class="w-full max-w-md">

                <div class="flex justify-center mb-8">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>

                {{ $slot }}

            </div>
        </div>

    </div>
</x-app-layout>