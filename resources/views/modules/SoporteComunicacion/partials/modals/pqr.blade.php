@php
    $reservas = \App\Models\MER\Reserva::where('idusu', Auth::user()->id)->get();
@endphp

<x-modal class="xl:max-w-4xl" name="mdl-pqr" title="pqr" :show="$errors->isNotEmpty()" focusable>
    <form onsubmit="return validarReserva()" action="{{ route('soporte.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <x-input name="asu" label="Asunto" type="text" :value="old('subject')" required />
        <x-input class="h-72 text-pretty" name="des" label="Descripción" type="textarea" :value="old('description')"
            required />

        <x-select class="w-full" id="codres" name="codres" label="Código de reserva" :options="$reservas->pluck('val', 'cod')->toArray()" required />

        <x-input id="file_pdf" name="pdf" label="PDF con fotos (Máx. 5MB)" type="file" accept="application/pdf" />
        <div class="mt-6 flex justify-end">
            <x-button class="text-xs">{{ __('Submit') }}</x-button>
        </div>
    </form>
    <script>
        const validarReserva = () => {
            const codres = document.getElementById('codres');
            if (codres.selectedIndex > 0) {
                return true;
            }
            alert("Por favor, seleccione un código de reserva válido.");
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
    </script>
</x-modal>