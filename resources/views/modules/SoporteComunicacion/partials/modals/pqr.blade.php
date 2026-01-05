<x-modal name="mdl-pqr" title="pqr" :show="$errors->isNotEmpty()" focusable>
    <form action="{{ route('soporte.store') }}" method="POST">
        @csrf
        <x-input name="asu" label="Asunto" type="text" :value="old('subject')" required />
        <x-input class="h-96 text-pretty" name="des" label="Descripción" type="textarea" :value="old('description')"
            required />
        <div class="mt-6 flex justify-end">
            <x-button>{{ __('Submit') }}</x-button>
        </div>
    </form>
</x-modal>