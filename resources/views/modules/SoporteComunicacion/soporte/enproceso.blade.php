<x-page>
    @error('pdf')
        <script>
            alert("{{ $message }}");
            window.location.reload();
        </script>
    @enderror

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
                @if ($ticket->pdf)
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

            <div class="col-span-2">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Descripción</h4>
                <p class="mt-2 text-sm bg-gray-50 p-2 xl:rounded-md">{{ $ticket->des }}</p>
            </div>
        </div>


        <div class="px-4">
            <hr class="border-t-2 border-gray-300 my-5">
            <h4 class="text-md font-bold uppercase tracking-wider my-5">Area de soporte</h4>
            <p class="text-sm text-gray-500 my-5 xl:rounded-md">Puede responder escribiendo directamente en el
                siguiente espacio o adjuntando un archivo PDF</p>
            <form onsubmit="return validarRespuesta()" action="{{ route('tickets.soporte.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="cod" value="{{ $ticket->cod }}">
                <x-input id="id_res" name="res" label="Respuesta" type="textarea" />
                <x-input id="file_pdf" name="pdf" label="Respuesta en PDF (Máx. 5MB)" type="file"
                    accept="application/pdf" />
                <div class="mt-6 flex justify-end">
                    <x-button class="text-xs">{{ __('Submit') }}</x-button>
                </div>
            </form>
        </div>
    </x-card>
    <script>
        const validarRespuesta = () => {
            const res = document.getElementById('id_res');
            const pdf = document.getElementById('file_pdf');
            if (res.value.length > 0 || pdf.files.length > 0) {
                return true;
            }
            alert("Por favor escriba una respuesta o adjunte un archivo PDF.");
            return false;
        };

        document.getElementById('file_pdf').addEventListener('change', function () {
            const limiteMB = 5;
            const limiteBytes = limiteMB * (1024 ** 2); // Potencia de 2
            if (this.files[0].size > limiteBytes) {
                alert("El archivo es muy grande. El máximo permitido son " + limiteMB + "MB.");
                this.value = "";
            }
        });

        function preventBack() {
            window.history.forward();
        }
        setTimeout("preventBack()", 0);
        window.onunload = function () { null };
    </script>
</x-page>