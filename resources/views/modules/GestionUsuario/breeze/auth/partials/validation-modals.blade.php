<!-- Modal para mostrar error si las contraseñas no coinciden -->
<x-modal name="password-mismatch-modal" title="Error de validación">
    <div class="p-6 text-center">
        <h3 class="mb-5 text-lg font-normal text-gray-500">Las contraseñas no coinciden. Por favor, asegúrate de
            escribir la misma contraseña en ambos campos.</h3>
        <x-button class="text-xs w-50"
            x-on:click="$dispatch('close-modal', 'password-mismatch-modal')">Entendido</x-button>
    </div>
</x-modal>

<!-- Modal para mostrar error si el correo ya está registrado -->
<x-modal name="email-exists-modal" title="Correo en uso">
    <div class="p-6 text-center">
        <h3 class="mb-5 text-lg font-normal text-gray-500">El correo electrónico que intentas usar ya se encuentra
            registrado. Por favor, utiliza otro o inicia sesión.</h3>
        <x-button class="text-xs w-50" x-on:click="$dispatch('close-modal', 'email-exists-modal')">Entendido</x-button>
    </div>
</x-modal>

<!-- Modal para mostrar error si el nombre es invalido -->
<x-modal name="nombre-invalido-modal" title="Nombre inválido">
    <div class="p-6 text-center">
        <h3 class="mb-5 text-lg font-normal text-gray-500">El nombre no es válido, debe contar con mínimo 2 carácteres y
            deben ser exclusivamente letras.</h3>
        <x-button class="text-xs w-50"
            x-on:click="$dispatch('close-modal', 'nombre-invalido-modal')">Entendido</x-button>
    </div>
</x-modal>

<!-- Modal para mostrar error si el apellido es invalido -->
<x-modal name="apellido-invalido-modal" title="Apellido inválido">
    <div class="p-6 text-center">
        <h3 class="mb-5 text-lg font-normal text-gray-500">El apellido no es válido, debe contar con mínimo 2 carácteres
            y deben ser exclusivamente letras.</h3>
        <x-button class="text-xs w-50"
            x-on:click="$dispatch('close-modal', 'apellido-invalido-modal')">Entendido</x-button>
    </div>
</x-modal>