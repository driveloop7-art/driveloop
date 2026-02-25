<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-medium text-left">{{ __('Tickets') }}</h3>
    <span class="text-sm text-gray-500">Total: {{ $allTickets->count() }}</span>
</div>
<div class="overflow-x-auto shadow border-b border-gray-200 xl:rounded-md">
    <table class="min-w-full divide-y text-gray-500">
        <thead class="bg-gray-200 text-xs font-medium uppercase tracking-wider">
            <tr>
                <th class="py-2">Detalle</th>
                <th class="py-2">Asunto</th>
                <th class="py-2">Usuario apertura</th>
                <th class="py-2">Fecha de apertura</th>
                <th class="py-2">Usuario soporte</th>
                <th class="py-2">Prioridad</th>
                <th class="py-2">Estado</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 text-center">
            @php
                $control = false;
            @endphp
            @foreach ($allTickets as $ticket)
                @php
                    $control = true;
                @endphp
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap flex justify-center">
                        <a
                            href="{{$ticket->codesttic == 3 ? route('tickets.soporte.cerrados', $ticket->cod) : route('tickets.soporte.enproceso', $ticket->cod) }}">
                            <span
                                class="px-4 py-1 text-xs leading-5 font-semibold rounded-full bg-indigo-100 hover:bg-indigo-200 text-indigo-800">
                                Ver
                            </span>
                        </a>
                    </td>
                    <td class="px-4 py-2 text-sm text-left">{{ $ticket->asu }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $ticket->user->nom . ' ' . $ticket->user->ape }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $ticket->feccre }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">
                        {{ $ticket->user_soporte ? $ticket->user_soporte->nom . ' ' . $ticket->user_soporte->ape : '' }}
                    </td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $ticket->prioridad_ticket->des }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm">{{ $ticket->estado_ticket->des }}</td>
                </tr>

            @endforeach
            @if (!$control)
                <tr>
                    <td colspan="4" class="px-4 py-2 whitespace-nowrap text-sm text-center">
                        No existen tickets {{ Str::lower($title) }}.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
<script>
    window.addEventListener('pageshow', function (event) {
        const historyTraversal = event.persisted ||
            (typeof window.performance != "undefined" &&
                window.performance.getEntriesByType("navigation")[0].type === "back_forward");

        if (historyTraversal) {
            window.location.reload();
        }
    });
</script>