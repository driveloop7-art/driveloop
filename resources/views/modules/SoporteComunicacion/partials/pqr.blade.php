<x-modal name="mdl-pqr" title="pqr" :show="$errors->isNotEmpty()" btn="false" focusable>
    <x-input
        name="subject"
        label="Asunto"
        type="text"
        :value="old('subject')"
        required/>
    <x-input
        name="description"
        label="Descripción"
        class="h-96 text-pretty"
        type="textarea"
        :value="old('description')"
        required/>
    <div class="mt-6 flex justify-end">
        <x-button>
            Enviar PQR
        </x-button>
    </div>
</x-modal>
