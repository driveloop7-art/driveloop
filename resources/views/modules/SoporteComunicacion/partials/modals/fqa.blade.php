<x-modal class="xl:max-w-4xl" name="mdl-fqa" title="preguntas frecuentes" :show="$errors->isNotEmpty()" focusable>
    <x-toggle>
        <x-toggle title="¿Cuáles son los requisitos para alquilar un vehículo?">
            Debes tener una licencia de conducir vigente (con al menos 1 o 2 años de antigüedad, según la categoría del
            vehículo), ser mayor de 21 o 25 años (dependiendo de la categoría) y presentar una tarjeta de crédito a
            nombre del conductor principal para el depósito de seguridad.
        </x-toggle>
        <x-toggle title="¿Qué métodos de pago aceptan?">
            Aceptamos la mayoría de las tarjetas de crédito y débito principales (Visa, MasterCard, American Express).
            Es importante notar que la tarjeta de crédito es obligatoria para el depósito de seguridad, incluso si el
            pago del alquiler se hace con débito.
        </x-toggle>
        <x-toggle title="¿Qué incluye el precio del alquiler?">
            El precio base generalmente incluye el alquiler del vehículo por el período acordado, el kilometraje
            limitado o ilimitado (especificado en la reserva) y el seguro obligatorio básico (que cubre daños a
            terceros).
        </x-toggle>
        <x-toggle title="¿Cómo funciona el depósito de seguridad?">
            Al recoger el vehículo, se retendrá un depósito de seguridad en tu tarjeta de crédito para cubrir posibles
            franquicias, multas o daños menores no cubiertos por el seguro básico. Este monto se desbloquea/reembolsa
            completamente después de la devolución del vehículo, si este se encuentra en las mismas condiciones.
        </x-toggle>
        <x-toggle title="¿Qué sucede si necesito cancelar o modificar mi reserva?">
            La política de cancelación y modificación varía según la tarifa reservada. Consulta los términos específicos
            de tu reserva. Si cancelas con suficiente antelación (ej. 48 o 72 horas), el reembolso suele ser total o
            parcial. Las modificaciones pueden estar sujetas a la disponibilidad y a la tarifa actual.
        </x-toggle>
        <x-toggle title="¿Qué debo hacer si el vehículo sufre un accidente o avería?">
            En caso de accidente o avería, debes contactar inmediatamente a nuestra asistencia en carretera (número
            proporcionado en el contrato). En caso de accidente, es crucial obtener un informe policial o de la
            autoridad competente. Nunca intentes reparaciones por tu cuenta.
        </x-toggle>
        <x-toggle title="¿Cuál es la política de combustible?">
            La política estándar es lleno/lleno. Debes recoger el vehículo con el tanque lleno y devolverlo también
            lleno. Si lo devuelves con menos combustible, se te cobrará el faltante más una tasa de servicio por
            reabastecimiento.
        </x-toggle>
        <x-toggle title="¿Puedo devolver el vehículo en una oficina diferente a la de recogida?">
            Sí, ofrecemos el servicio de "One-Way" (ida y vuelta diferente), sujeto a disponibilidad y a un cargo extra
            por la devolución en una ubicación distinta. Este cargo varía según la distancia entre las oficinas.
        </x-toggle>
    </x-toggle>
</x-modal>