<x-page>
    @if(session()->has('message'))
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif

    <div class="w-full px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900">Panel de control</h1>
             <div class="w-24 h-1 bg-gray-200 mx-auto mt-4 rounded"></div>
        </div>

        <x-settings-layout>
            <!-- Mis vehículos -->
            <x-settings-tab name="vehicles" label="Mis vehículos">
                <div class="bg-white p-6 md:p-8 border border-gray-400 rounded-lg shadow-sm">
                    <p class="text-gray-500">Gestión de vehículos próximamente.</p>
                </div>
            </x-settings-tab>

             <!-- Mis viajes -->
             <x-settings-tab name="trips" label="Mis viajes">
                <div class="bg-white p-6 md:p-8 border border-gray-400 rounded-lg shadow-sm">
                     <p class="text-gray-500">Historial de viajes próximamente.</p>
                </div>
            </x-settings-tab>

            <!-- Tickets -->
             <x-settings-tab name="tickets" label="Tickets">
                @include('modules.SoporteComunicacion.partials.tickets.section')
            </x-settings-tab>

        </x-settings-layout>
    </div>
</x-page>