<div class="flex items-center justify-between mb-6">
    <h3 class="text-lg font-medium text-left">{{ __('Tickets') }}</h3>
    <div class="flex gap-4">
        <span class="text-sm text-gray-500">Total abiertos: <span
                class="font-semibold">{{ $grpTickets[0]->count() }}</span></span>
        <span class="text-sm text-gray-500">Total en proceso: <span
                class="font-semibold">{{ $allTickets->where('codesttic', 2)->where('idususop', Auth::user()->id)->count() }}</span></span>
        <span class="text-sm text-gray-500">Total cerrados: <span
                class="font-semibold">{{ $allTickets->where('codesttic', 3)->where('idususop', Auth::user()->id)->count() }}</span></span>
    </div>
</div>
@for ($i = 0; $i < count($grpTickets); $i++)
    @php
        $title = match ($i) {
            0 => 'Abiertos',
            1 => 'En proceso',
            2 => 'Cerrados',
        };

        $tickets = $grpTickets[$i];
    @endphp
    <x-toggle :title="$title">
        <div class="overflow-x-auto shadow border-b border-gray-200 xl:rounded-md">
            <table class="min-w-full divide-y text-gray-500">
                <thead class="bg-gray-200 text-xs font-medium uppercase tracking-wider">
                    <tr>
                        <th class="py-2">Detalle</th>
                        <th class="py-2">Asunto</th>
                        @php
                            switch ($i) {
                                case 0:
                                    echo '<th class="py-2">Usuario apertura</th>';
                                    echo '<th class="py-2">Fecha de apertura</th>';
                                    break;
                                case 1:
                                    echo '<th class="py-2">Fecha inicio proceso</th>';
                                    break;
                                case 2:
                                    echo '<th class="py-2">Fecha de cierre</th>';
                                    break;
                            }                            
                        @endphp
                        <th class="py-2">Prioridad</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-center">
                    @php
                        $control = false;
                    @endphp
                    @foreach ($tickets as $ticket)
                        @if ($i === 0)
                            @php
                                $control = true;
                            @endphp
                            <tr>
                                <td class="px-4 py-2 flex justify-center">
                                    <a href="{{ route('tickets.soporte.enproceso', $ticket->cod) }}">
                                        <span
                                            class="px-4 py-1 text-xs leading-5 font-semibold rounded-full bg-indigo-100 hover:bg-indigo-200 text-indigo-800">
                                            Ver
                                        </span>
                                    </a>
                                </td>
                                <td class="px-4 py-2 text-sm text-left">{{ $ticket->asu }}</td>
                                <td class="px-4 py-2 text-sm">{{ $ticket->user->nom . ' ' . $ticket->user->ape }}
                                </td>
                                <td class="px-4 py-2 text-sm">{{ $ticket->feccre }}</td>
                                <td class="px-4 py-2 text-sm">{{ $ticket->prioridad_ticket->des }}</td>
                            </tr>
                        @else
                            @if ($ticket->user_soporte->id == Auth::user()->id)
                                @php
                                    $control = true;
                                @endphp
                                <tr>
                                    <td class="px-4 py-2 flex justify-center">
                                        <a
                                            href="{{ $i === 2 ? route('tickets.soporte.cerrados', $ticket->cod) : route('tickets.soporte.enproceso', $ticket->cod) }}">
                                            <span
                                                class="px-4 py-1 text-xs leading-5 font-semibold rounded-full bg-indigo-100 hover:bg-indigo-200 text-indigo-800">
                                                Ver
                                            </span>
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-left">{{ $ticket->asu }}</td>
                                    @php
                                        switch ($i) {
                                            case 1:
                                                echo "<td class='px-4 py-2 text-sm'>{$ticket->fecpro}</td>";
                                                break;
                                            case 2:
                                                echo "<td class='px-4 py-2 text-sm'> $ticket->feccie </td>";
                                                break;
                                        }
                                    @endphp
                                    <td class="px-4 py-2 text-sm">{{ $ticket->prioridad_ticket->des }}</td>
                                </tr>
                            @endif
                        @endif
                    @endforeach
                    @if (!$control)
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-sm text-center">
                                No existen tickets {{ Str::lower($title) }} por este usuario.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </x-toggle>
@endfor
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