<section>
    <header>
        <h2 class="text-lg font-medium text-black-900">
            {{ __('Documents') }}
        </h2>

        <p class="mt-1 text-sm text-black-600">
            {{ __("Upload or view the status of your documents") }}
        </p>
    </header>
    <div class="flex items-center gap-4 pt-4">
        <a href="{{ route('usuario.documentos.index') }}">
            <x-button class="text-xs w-60" x-data="">{{ __('View documents') }}</x-button>
        </a>
    </div>
</section>