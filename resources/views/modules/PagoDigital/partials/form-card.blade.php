<div class="mt-2 space-y-4">
    <x-input type="text" name="card_number" label="Número de la tarjeta" maxlength="16"
        @input="event.target.value = event.target.value.replace(/\D/g, '')" />
    <x-input type="text" name="card_holder" label="Nombre del titular"
        @input="event.target.value = event.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" />
    <div class="grid grid-cols-2 gap-4">
        <x-input type="text" name="card_expiry" label="Vencimiento" maxlength="5" placeholder="MM/AA"
            @input="
                let value = event.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                event.target.value = value;
            " />
        <x-input type="text" name="card_cvv" label="Código de seguridad (CVV)" maxlength="3"
            @input="event.target.value = event.target.value.replace(/\D/g, '')" />
    </div>
    <x-input type="text" name="card_doc" label="Documento del titular" maxlength="10"
        @input="event.target.value = event.target.value.replace(/\D/g, '').substring(0, 10)" />

    <div class="flex items-center gap-2 mt-2">
        <span class="text-xs text-gray-500">¿Quieres guardar este método de pago para
            alquileres
            futuros?</span>
    </div>
    <div class="flex items-center gap-4">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="save_card" value="yes"
                class="text-dl focus:ring-dl">
            <span class="text-xs text-gray-600">Si</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="save_card" value="no"
                class="text-dl focus:ring-dl" checked>
            <span class="text-xs text-gray-600">No</span>
        </label>
    </div>
</div>