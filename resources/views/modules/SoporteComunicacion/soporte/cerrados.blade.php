<x-page>
    <x-card class="max-w-7xl mx-auto p-8 w-full">
        <h3 class="pl-2 md:pl-4 mb-4 text-lg font-medium text-left">Detalle Ticket # {{ $ticket->cod }}</h3>

        <div class="grid grid-col-1 p-2 gap-8 md:grid-cols-2 md:p-4">
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Asunto</h4>
                <p class="mt-1 text-sm">{{ $ticket->asu }}</p>
            </div>

            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Fecha de creación</h4>
                <p class="mt-1 text-sm">{{ $ticket->feccre }}</p>
            </div>

            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Usuario</h4>
                <p class="mt-1 text-sm">{{ $ticket->user->nom . ' ' . $ticket->user->ape }}</p>
            </div>

            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Adjunto</h4>
                @if ($ticket->urlpdf)
                    <a href="{{ route('tickets.adjuntos', $ticket->cod) }}" target="_blank">
                        <span
                            class="px-4 py-1 text-xs leading-5 font-semibold rounded-full bg-indigo-100 hover:bg-indigo-200 text-indigo-800">
                            Ver
                        </span>
                    </a>
                @else
                    <p class="mt-1 text-sm">No hay archivo</p>
                @endif
            </div>

            <div class="md:col-span-2">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Descripción</h4>
                <p class="mt-2 text-sm bg-gray-50 p-2 xl:rounded-md whitespace-pre-line">{{ $ticket->des }}</p>
            </div>
        </div>

        <div class="px-4 mb-3">
            <hr class="border-t-2 border-gray-300 my-5">
            <h4 class="text-md font-bold uppercase tracking-wider">Area de soporte</h4>
        </div>

        <div class="grid grid-col-1 p-2 gap-8 md:grid-cols-2 md:p-4">
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Personal</h4>
                <p class="mt-1 text-sm">{{ $ticket->user_soporte->nom . ' ' . $ticket->user_soporte->ape }}</p>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Adjunto</h4>
                @if ($ticket->urlpdfres)
                    <a href="{{ route('tickets.adjuntos.respuesta', $ticket->cod) }}" target="_blank">
                        <span
                            class="px-4 py-1 text-xs leading-5 font-semibold rounded-full bg-indigo-100 hover:bg-indigo-200 text-indigo-800">
                            Ver
                        </span>
                    </a>
                @else
                    <p class="mt-1 text-sm">No hay archivo</p>
                @endif
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Inicio de gestión</h4>
                <p class="mt-1 text-sm">{{ $ticket->fecpro }}</p>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Cierre de ticket</h4>
                <p class="mt-1 text-sm">{{ $ticket->feccie }}</p>
            </div>

            <div class="md:col-span-2">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Respuesta</h4>
                <p class="mt-2 text-sm bg-gray-50 p-2 xl:rounded-md whitespace-pre-line">{{ $ticket->res }}</p>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ route('tickets.export.pdf', '') }}/{{ $ticket->cod }}"
                class="bg-dl hover:bg-dl-two border border-transparent text-white text-xs inline-flex xl:rounded-md justify-center px-5 py-3 tracking-widest font-semibold uppercase transition ease-in-out duration-150 items-center"
                target="_blank">
                Descargar PDF
            </a>
        </div>
    </x-card>
</x-page>