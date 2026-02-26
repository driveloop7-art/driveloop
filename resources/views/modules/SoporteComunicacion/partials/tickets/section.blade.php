<x-card class="max-w-7xl mx-auto p-8">
    @php
        $allTickets = auth()->user()->tickets;
        $grpTickets = [$allTickets->where('codesttic', 1), $allTickets->where('codesttic', 2), $allTickets->where('codesttic', 3)];
    @endphp
    <div class="grid grid-cols-1 items-center justify-between mb-6 lg:flex">
        <h3 class="text-lg font-medium mb-6 text-left">{{ __('Mis Tickets') }}</h3>
        <div class="grid grid-cols-1 gap-4 lg:flex">
            <span class="text-sm text-gray-500">Total abiertos: <span
                    class="font-semibold">{{ $grpTickets[0]->count() }}</span></span>
            <span class="text-sm text-gray-500">Total en proceso: <span
                    class="font-semibold">{{ $grpTickets[1]->count() }}</span></span>
            <span class="text-sm text-gray-500">Total cerrados: <span
                    class="font-semibold">{{ $grpTickets[2]->count() }}</span></span>
        </div>
    </div>
    @if($allTickets->isNotEmpty())
        <x-toggle>
            @include('modules.SoporteComunicacion.partials.tickets.my_tickets')
        </x-toggle>
    @else
        <tr>
            <td colspan="3" class="px-4 py-2 whitespace-nowrap text-sm text-center">
                {{ __('No existen tickets creados.') }}
            </td>
        </tr>
    @endif
    <div>@include('modules.SoporteComunicacion.partials.modals.ticket-detail')</div>
</x-card>