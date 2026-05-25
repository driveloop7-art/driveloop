<x-page>
    @if(session()->has('message'))
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif

    <div class="w-full">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold">Panel de control</h1>
             <div class="w-24 h-1 bg-gray-200 mx-auto mt-4 rounded"></div>
        </div>

        <x-settings-layout>
            <!-- Mis vehículos -->
            <x-settings-tab name="vehicles" label="Mis vehículos">
                @include('modules.GestionUsuario.breeze.partials.vehUsuarios')                
            </x-settings-tab>

             <!-- Mis viajes -->
             <x-settings-tab name="trips" label="Mis viajes">
                @include('modules.GestionUsuario.breeze.partials.trips.section')
            </x-settings-tab>

            <x-settings-tab name="payments" label="Mis pagos">
                @include('modules.GestionUsuario.breeze.partials.payments.section')
            </x-settings-tab>

            <!-- Tickets -->
             <x-settings-tab name="tickets" label="Mis tickets">
                @include('modules.SoporteComunicacion.partials.tickets.section')
            </x-settings-tab>
        </x-settings-layout>
    </div>
</x-page>