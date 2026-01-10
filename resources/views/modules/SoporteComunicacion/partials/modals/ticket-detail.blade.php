<x-modal name="mdl-ticket-detail" title="Detalle de ticket" :show="$errors->isNotEmpty()" focusable>
    <x-card class="mb-4">
        <div class="grid grid-cols-1 gap-6 p-4 sm:grid-cols-2">
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider"
                    x-text="params.ticket.urlpdf?'Código/Adjunto':'Código'"></h4>
                <button x-on:click="window.open('tickets/' + params.ticket.cod, '_blank')"
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
                    x-text="new Date(params.ticket.feccre).toUTCString('es-ES', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).replace(' GMT', ' UTC')">
                </p>
            </div>
            <div :class="params.ticket.fecpro?'':'hidden'">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Fecha inicio proceso</h4>
                <p class="mt-1 text-sm font-semibold"
                    x-text="new Date(params.ticket.fecpro).toUTCString('es-ES', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).replace(' GMT', ' UTC')">
                </p>
            </div>
            <div :class="params.ticket.feccie?'':'hidden'">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Fecha de cierre</h4>
                <p class="mt-1 text-sm font-semibold"
                    x-text="new Date(params.ticket.feccie).toUTCString('es-ES', { weekday: 'short', day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false }).replace(' GMT', ' UTC')">
                </p>
            </div>
            <div class="sm:col-span-2">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Descripción</h4>
                <div class="mt-2 text-sm bg-gray-50 p-4 xl:rounded-lg border border-gray-100 whitespace-pre-line"
                    x-text="params.ticket.des"></div>
            </div>
        </div>
    </x-card>
    <div :class="params.ticket.feccie || params.ticket.fecpro?'hidden':''">
        <div class="md:mt-6 md:space-x-2 md:flex md:justify-end grid grid-cols-1 gap-4">
            <x-button class="text-xs" type="tertiary"
                x-on:click="if (confirm('Esta acción cambiará el estado del ticket a cerrado.\n\n¿Está seguro que desea continuar?')) { $dispatch('close'); axios.post('{{ route('soporte.index') }}/' + params.ticket.cod).then(res => { alert(res.data.message) }).catch(err => { alert(err.response.data.message) }).finally(() => { window.location.reload() }) }">
                Cerrar ticket
            </x-button>
        </div>
    </div>
</x-modal>