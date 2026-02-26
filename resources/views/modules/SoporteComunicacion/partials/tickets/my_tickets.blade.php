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
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y text-gray-500">
                <thead class="bg-gray-200 text-xs font-medium uppercase tracking-wider">
                    <tr>
                        <th class="py-2">Detalle</th>
                        <th class="py-2">Asunto</th>
                        <th class="py-2">Fecha de creación</th>
                        @php
                            switch ($i) {
                                case 1:
                                    echo '<th class="py-2">Fecha inicio proceso</th>';
                                    break;
                                case 2:
                                    echo '<th class="py-2">Fecha de cierre</th>';
                                    echo '<th class="py-2">Satisfacción</th>';
                                    break;
                            }                            
                        @endphp
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-center">
                    @if ($tickets->isNotEmpty())
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td class="px-4 py-2 flex justify-center">
                                    @php
                                        $ticket_dto = [
                                            'cod' => $ticket->cod,
                                            'asu' => $ticket->asu,
                                            'des' => $ticket->des,
                                            'feccre' => $ticket->feccre,
                                            'nomsop' => $ticket->user_soporte ? "{$ticket->user_soporte->nom} {$ticket->user_soporte->ape}" : 'Pendiente'
                                        ];

                                        if ($ticket->urlpdf !== null) {
                                            $ticket_dto['urlpdf'] = $ticket->urlpdf;
                                        }
                                        if ($ticket->urlpdfres !== null) {
                                            $ticket_dto['urlpdfres'] = $ticket->urlpdfres;
                                        }
                                        if ($ticket->res !== null) {
                                            $ticket_dto['res'] = $ticket->res;
                                        }

                                        switch ($i) {
                                            case 0:
                                                $ticket_dto['estado'] = $i;
                                                break;
                                            case 1:
                                                $ticket_dto['estado'] = $i;
                                                $ticket_dto['fecpro'] = $ticket->fecpro;
                                                break;
                                            case 2:
                                                $ticket_dto['estado'] = $i;
                                                $ticket_dto['fecpro'] = $ticket->fecpro;
                                                $ticket_dto['feccie'] = $ticket->feccie;
                                                break;
                                        }                                        
                                    @endphp
                                    <button
                                        x-on:click.prevent="$dispatch('open-modal', {name:'mdl-ticket-detail', ticket: {{ json_encode($ticket_dto) }}})">
                                        <span
                                            class="px-4 py-1 text-xs leading-5 font-semibold rounded-full bg-indigo-100 hover:bg-indigo-200 text-indigo-800">
                                            Ver
                                        </span>
                                    </button>
                                </td>
                                <td class="px-4 py-2 text-sm text-left">{{ $ticket->asu }}</td>
                                <td class="px-4 py-2 text-sm">{{ $ticket->feccre }}</td>
                                @switch($i) 
                                    @case(1)
                                        <td class='px-4 py-2 text-sm'>{{ $ticket->fecpro }}</td>
                                        @break
                                    @case(2)
                                        <td class='px-4 py-2 text-sm'>{{ $ticket->feccie }}</td>
                                        @if ($ticket->score->count() == 0)
                                            <td class='px-4 py-2 text-sm'>
                                                <button
                                                    x-on:click.prevent="$dispatch('open-modal', {name: 'mdl-score-ticket', codtic: '{{ $ticket->cod }}'})">
                                                <span
                                                    class="px-4 py-1 text-xs leading-5 font-semibold rounded-full bg-yellow-100 hover:bg-yellow-200 text-yellow-800">
                                                    Calificar
                                                </span>
                                            </button>
                                        </td>
                                    @else
                                        <td class='px-9 py-2'>
                                            <p class="text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">OK</p>
                                        </td>
                                    @endif
                                    @break
                                @endswitch
                            </tr>
                        @endforeach
                        @include('modules.SoporteComunicacion.soporte.partials.modal.score-ticket')
                    @else
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-sm text-center">
                                No existen tickets {{ Str::lower($title) }}.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </x-toggle>
@endfor