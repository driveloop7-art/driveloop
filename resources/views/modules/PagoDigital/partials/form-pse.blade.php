<div class="mt-2 space-y-4">
    <div class="grid grid-cols-2 gap-4">
        <x-input type="text" name="pse_name" label="Nombre"
            @input="event.target.value = event.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" />
        <x-input type="text" name="pse_lastname" label="Apellido"
            @input="event.target.value = event.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '')" />
    </div>
    <div class="grid grid-cols-2 gap-4">
        <x-input type="text" name="pse_doc" label="Documento del titular" maxlength="10"
            @input="event.target.value = event.target.value.replace(/\D/g, '').substring(0, 10)" />
        <x-input type="text" name="pse_phone" label="Número celular" maxlength="10"
            @input="event.target.value = event.target.value.replace(/\D/g, '')" />
    </div>

    <div>
        <label for="pse_bank" class="block text-sm font-medium text-gray-700 mb-1">Selecciona el banco</label>
        <select id="pse_bank" name="pse_bank" class="w-full rounded-md border-gray-300 shadow-sm focus:border-dl focus:ring focus:ring-dl focus:ring-opacity-50">
            <option value="" disabled selected>Seleccione un banco</option>
            <option value="bancolombia">Bancolombia</option>
            <option value="davivienda">Davivienda</option>
            <option value="banco_de_bogota">Banco de Bogotá</option>
            <option value="bbva">BBVA</option>
            <option value="occidente">Banco de Occidente</option>
            <option value="popular">Banco Popular</option>
            <option value="nequi">Nequi</option>
            <option value="daviplata">Daviplata</option>
        </select>
    </div>

    <div class="flex items-center gap-2 mt-2">
        <span class="text-xs text-gray-500">¿Quieres guardar este método de pago para
            alquileres
            futuros?</span>
    </div>
    <div class="flex items-center gap-4">
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="save_pse" value="yes"
                class="text-dl focus:ring-dl">
            <span class="text-xs text-gray-600">Si</span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="radio" name="save_pse" value="no"
                class="text-dl focus:ring-dl" checked>
            <span class="text-xs text-gray-600">No</span>
        </label>
    </div>
</div>