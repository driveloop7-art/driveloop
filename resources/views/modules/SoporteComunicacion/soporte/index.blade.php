<x-page>
    @if(session()->has('message'))
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif

    @if($allTickets->isEmpty())
        <div class="text-center py-8 text-gray-500">
            No hay usuarios con tickets pendientes de revisión.
        </div>
    @else
        <x-card class="max-w-7xl mx-auto p-8 w-full">
            <h3 class="text-lg font-medium mb-6 text-left">{{ __('Validación de Tickets') }}</h3>
            @php
                $grpTickets = [$allTickets->where('codesttic', 1), $allTickets->where('codesttic', 2), $allTickets->where('codesttic', 3)];
            @endphp
            <x-toggle>
                @if (Auth::user()->hasRole('Soporte'))
                    @include('modules.SoporteComunicacion.soporte.partials.allSoporteTickets')
                @else
                    @include('modules.SoporteComunicacion.soporte.partials.allAdminTickets')
                @endif
            </x-toggle>
        </x-card>
    @endif
</x-page>