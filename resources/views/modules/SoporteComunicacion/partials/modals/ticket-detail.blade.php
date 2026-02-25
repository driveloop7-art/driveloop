<x-modal name="mdl-ticket-detail" title="Detalle de ticket" :show="$errors->isNotEmpty()" focusable>
    <x-card class="mb-4">
        <div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2">
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider"
                    x-text="params.ticket.urlpdf?'Código/Adjunto':'Código'"></h4>
                <button x-on:click="window.open('{{ route('tickets.adjuntos') }}/' + params.ticket.cod, '_blank')"
                    :class="params.ticket.urlpdf?'':'hidden'">
                    <span
                        class="px-4 py-1 text-xs leading-5 font-semibold rounded-full bg-indigo-100 hover:bg-indigo-200 text-indigo-800"
                        x-text="params.ticket.cod">
                    </span>
                </button>
                <p class="mt-1 text-sm font-mono font-bold" :class="params.ticket.urlpdf?'hidden':''"
                    x-text="params.ticket.cod"></p>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Asunto</h4>
                <p class="mt-1 text-sm font-semibold" x-text="params.ticket.asu"></p>
            </div>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Fecha de creación</h4>
                <p class="mt-1 text-sm font-semibold"
                    x-text="new Date(params.ticket.feccre).toUTCString('es-ES', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).replace(' GMT', '')">
                </p>
            </div>

            <div class="md:col-span-2">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Descripción</h4>
                <div class="mt-2 text-sm bg-gray-50 p-4 xl:rounded-lg border border-gray-100 whitespace-pre-line"
                    x-text="params.ticket.des"></div>
            </div>
        </div>

        <div :class="params.ticket.estado == '0'?'hidden':''" class="grid grid-col-1 gap-6 p-4 md:grid-cols-2">
            <hr class="md:col-span-2 border-t-1 border-gray-300">
            <h4 class="md:col-span-2 text-sm font-bold text-gray-400 uppercase tracking-wider"
                x-text="params.ticket.estado == '1'?'Datos de gestión':'Datos de cierre'"></h4>
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Personal</h4>
                <p class="mt-1 text-sm font-semibold" x-text="params.ticket.nomsop"></p>
            </div>

            <div :class="params.ticket.estado != '0'?'':'hidden'">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider"
                    x-text="params.ticket.estado == '1'?'Inicio gestión':'Cierre de ticket'"></h4>
                <p class="mt-1 text-sm font-semibold"
                    x-text="new Date(params.ticket.estado == '1'?params.ticket.fecpro:params.ticket.feccie).toUTCString('es-ES', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).replace(' GMT', '')">
                </p>
            </div>

            <div :class="params.ticket.estado == '1'?'hidden':''" class="md:col-span-2">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Respuesta</h4>
                <p class="mt-1 text-sm bg-gray-50 p-4 xl:rounded-lg border border-gray-100 whitespace-pre-line"
                    x-text="params.ticket.res"></p>
            </div>


            <div :class="params.ticket.urlpdfres?'':'hidden'" class="flex items-center space-x-2">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Adjunto</h4>
                <button
                    x-on:click="window.open('{{ route('tickets.adjuntos.respuesta') }}/' + params.ticket.cod, '_blank')">
                    <span
                        class="px-4 py-1 text-xs leading-5 font-semibold rounded-full bg-indigo-100 hover:bg-indigo-200 text-indigo-800">
                        Ver archivo
                    </span>
                </button>
            </div>

        </div>
    </x-card>
    <div class="px-6 pb-6">
        <div class="md:space-x-2 md:flex md:justify-end grid grid-cols-1 gap-4">
            <x-button class="text-xs" type="primary"
                x-on:click="window.open('{{ route('tickets.export.pdf') }}/' + params.ticket.cod, '_blank')">
                Ver PDF
            </x-button>
            <div :class="params.ticket.estado == '0'?'':'hidden'">
                <x-button class="text-xs" type="tertiary"
                    x-on:click="if (confirm('Esta acción cambiará el estado del ticket a cerrado.\n\n¿Está seguro que desea continuar?')) { $dispatch('close'); axios.post('{{ route('soporte.index') }}/' + params.ticket.cod).then(res => { alert(res.data.message) }).catch(err => { alert(err.response.data.message) }).finally(() => { window.location.reload() }) }">
                    Cerrar ticket
                </x-button>
            </div>
        </div>
    </div>
</x-modal>