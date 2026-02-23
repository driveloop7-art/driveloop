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
            <!-- Usuarios -->
            <x-settings-tab name="users" label="Usuarios">
                @include('modules.GestionUsuario.admin.partials.users')
            </x-settings-tab>

            <!-- Vehiculos -->
            <x-settings-tab name="vehiculos" label="Vehículos">
                @include('modules.GestionUsuario.admin.partials.vehiculos')
            </x-settings-tab>

            <!-- Mis viajes -->
            <x-settings-tab name="reservas" label="Reservas">
                @include('modules.GestionUsuario.admin.partials.reservas')
            </x-settings-tab>

        </x-settings-layout>
    </div>
</x-page>