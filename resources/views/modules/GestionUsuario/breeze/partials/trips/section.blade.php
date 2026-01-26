<x-card class="max-w-7xl mx-auto p-8">
    <h3 class="text-lg font-medium mb-6 text-left">{{ __('Mis Viajes') }}</h3>
    @php
        $reservas = auth()->user()->reservas()
            ->orderBy('cod', 'desc')
            ->get();
    @endphp

    @if($reservas->isNotEmpty())
        <div class="max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
            @include('modules.GestionUsuario.breeze.partials.trips.my_trips')
        </div>
    @else
        <div class="p-4 text-center text-gray-500">
            {{ __('No has realizado ningún viaje aún.') }}
        </div>
    @endif
</x-card>
