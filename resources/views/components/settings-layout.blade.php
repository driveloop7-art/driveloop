@props(['active'])

<x-page>
    @if(session()->has('message'))
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif

    <div class="w-full px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900">Configuración de cuenta</h1>
             <div class="w-24 h-1 bg-gray-200 mx-auto mt-4 rounded"></div>
        </div>

        <div class="flex flex-col md:flex-row gap-12 align-top">
            <!-- Sidebar -->
            <div class="w-10 md:w-64 flex-shrink-0">
                 <x-tagbar :active="$active" />
            </div>

            <!-- Main Content -->
            <div class="flex-1 space-y-8">
                {{ $slot }}
            </div>
        </div>
    </div>
</x-page>
