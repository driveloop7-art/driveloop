<x-page>
    @if(session()->has('message'))
        <script>
            alert("{{ session('message') }}");
        </script>
    @endif

    <x-card class="max-w-7xl mx-auto p-8 w-full">
        @include('modules.SoporteComunicacion.soporte.partials.formFilter')

        @if($allTickets->isEmpty())
            @include('modules.SoporteComunicacion.soporte.partials.filterEmpty')
        @else
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
        @endif
    </x-card>
</x-page>