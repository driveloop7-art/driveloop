<div class="mt-2 space-y-4">
    <div class="grid grid-cols-2 gap-4">
        <x-input type="text" name="nequi_name" label="Nombre"
            @input="event.target.value = event.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" />
        <x-input type="text" name="nequi_lastname" label="Apellido"
            @input="event.target.value = event.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" />
    </div>
    <x-input type="text" name="nequi_phone" label="Numero de telefono" maxlength="10"
        @input="event.target.value = event.target.value.replace(/\D/g, '')" />

    <div class="flex items-center gap-2 mt-2">
        <span class="text-xs text-gray-500">¿Quieres guardar este método de pago para
            alquileres
            futuros?</span>
    </div>
    <div class="flex items-center gap-4">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="save_nequi" value="yes"
                class="text-dl focus:ring-dl">
            <span class="text-xs text-gray-600">Si</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="save_nequi" value="no"
                class="text-dl focus:ring-dl" checked>
            <span class="text-xs text-gray-600">No</span>
        </label>
    </div>
</div>