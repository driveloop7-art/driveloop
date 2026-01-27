<!--Si es un usuario registrado: -->
@if (Auth::check())
    <x-modal xs:max-w-xs name="verification-warning" title="Documentos No Verificados" focusable>
        <div class="p-6 text-center">
            <h2 class="text-lg font-medium text-gray-900">
                ¡Atención!
            </h2>
            <p class="mt-4 text-sm text-gray-600 mb-6">
                Para realizar una reserva, es necesario que sus documentos estén aprobados.
            </p>
            <div class="mt-6 flex justify-center gap-4">
                <x-button type="tertiary" class="!px-6 !py-2" x-on:click="$dispatch('close-modal', 'verification-warning')">
                    Volver
                </x-button>
                <x-button type="primary" class="!px-6 !py-2"
                    onclick="window.location.href='{{ route('usuario.documentos.index') }}'">
                    Cargar Documentos
                </x-button>
            </div>
        </div>
    </x-modal>
@else
    <!--Si es un usuario no registrado: -->
    <x-modal xs:max-w-xs name="verification-warning" title="{{ __('Log In') }}" focusable>
        <div class="p-6 text-center">
            <h2 class="text-lg font-medium text-gray-900">
                ¡Atención!
            </h2>
            <p class="mt-4 text-sm text-gray-600 mb-6">
                Para realizar una búsqueda o reserva, debes iniciar sesión.
            </p>
            <div class="mt-6 flex justify-center gap-4">
                <x-button type="tertiary" class="!px-6 !py-2" x-on:click="$dispatch('close-modal', 'verification-warning')">
                    {{__('Back')}}
                </x-button>
                <x-button type="primary" class="!px-6 !py-2" onclick="window.location.href='{{ route('login') }}'">
                    {{__('Log In')}}
                </x-button>
            </div>
        </div>
    </x-modal>
@endif