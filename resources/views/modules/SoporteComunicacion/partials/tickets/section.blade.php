<x-card class="mx-auto p-8">
    @php
        $allTickets = auth()->user()->tickets;
        $grpTickets = [$allTickets->where('codesttic', 1), $allTickets->where('codesttic', 2), $allTickets->where('codesttic', 3)];
    @endphp
    <h3 class="text-xl font-bold mb-6 text-left">{{ __('Estado de Tickets') }}</h3>
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