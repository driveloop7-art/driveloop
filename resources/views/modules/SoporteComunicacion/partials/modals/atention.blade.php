<x-modal class="xl:max-w-4xl" name="mdl-atention" title="centro de atención" :show="$errors->isNotEmpty()" focusable>
    <x-toggle>
        <x-toggle title="Reservas">
            <x-toggle>
                <x-toggle title="¿Cómo busco y reservo un vehículo?">
                    Utiliza el buscador en la página principal ingresando la ubicación y las fechas deseadas. Selecciona
                    el vehículo que mejor se adapte a tus necesidades y sigue los pasos de confirmación y pago.
                </x-toggle>
                <x-toggle title="¿Qué debo hacer si voy a llegar tarde a recoger el vehículo?">
                    Si prevés un retraso, por favor contacta directamente al propietario a través del chat de la reserva
                    para coordinar la entrega. Retrasos mayores a 1 hora sin aviso podrían afectar la reserva.
                </x-toggle>
                <x-toggle title="¿Puedo agregar un conductor adicional a mi reserva?">
                    Sí, puedes añadir conductores adicionales antes de que inicie el viaje. Cada conductor debe estar
                    registrado y verificado en la plataforma para contar con la cobertura del seguro.
                </x-toggle>
            </x-toggle>
        </x-toggle>

        <x-toggle title="Pagos y facturación">
            <x-toggle>
                <x-toggle title="¿Dónde puedo descargar mi factura?">
                    Puedes descargar tus facturas directamente desde el historial de reservas en tu perfil, dentro de la
                    sección "Mis Viajes", una vez que el alquiler haya finalizado.
                </x-toggle>
                <x-toggle title="¿Cómo solicito una factura electrónica personalizada?">
                    Si necesitas una factura con datos fiscales específicos, asegúrate de actualizar tu información de
                    facturación en "Configuración de Cuenta" antes de finalizar tu reserva.
                </x-toggle>
                <x-toggle title="¿Qué cargos adicionales podrían aplicarse al final de mi viaje?">
                    Podrían aplicarse cargos por combustible faltante, limpieza excesiva, peajes electrónicos procesados
                    durante el viaje o entrega tardía, según lo acordado.
                </x-toggle>
            </x-toggle>
        </x-toggle>

        <x-toggle title="Mi cuenta">
            <x-toggle>
                <x-toggle title="¿Cómo puedo cambiar mi contraseña?">
                    Ve a la configuración de tu perfil, selecciona la pestaña de "Seguridad" y allí encontrarás la
                    opción para actualizar tu contraseña de acceso.
                </x-toggle>
                <x-toggle title="¿Cómo verifico mi identidad?">
                    Para mayor seguridad, debes subir fotos claras de tu licencia de conducir y documento de identidad
                    en la sección de "Verificación de Cuenta".
                </x-toggle>
                <x-toggle title="¿Cómo puedo actualizar mi licencia de conducir en el sistema?">
                    Dirígete a "Verificación de Cuenta" en tu perfil. Allí podrás subir las fotos de tu nueva licencia.
                    Nuestro equipo revisará los documentos en un plazo de 24 a 48 horas.
                </x-toggle>
                <x-toggle title="¿Qué hago si olvidé mi correo electrónico de acceso?">
                    Contacta a nuestro equipo de soporte técnico proporcionando tu nombre completo y número de
                    identificación para que podamos ayudarte a recuperar el acceso.
                </x-toggle>
            </x-toggle>
        </x-toggle>

        <x-toggle title="Propietarios">
            <x-toggle>
                <x-toggle title="¿Cómo publico mi vehículo en la plataforma?">
                    Regístrate como propietario, completa la información técnica, sube fotos de alta calidad y adjunta
                    los documentos legales del vehículo para revisión.
                </x-toggle>
                <x-toggle title="¿Cómo gestiono la disponibilidad de mi auto?">
                    Desde tu panel de control de propietario, puedes bloquear días específicos en el calendario para que
                    tu vehículo no sea reservado cuando lo necesites.
                </x-toggle>
                <x-toggle title="¿Cuándo recibo los pagos por mis alquileres?">
                    El pago por cada alquiler se procesa automáticamente y se transfiere a tu cuenta bancaria registrada
                    48 horas después de que el viaje haya concluido.
                </x-toggle>
                <x-toggle title="¿Qué cobertura de seguro tengo durante un alquiler?">
                    Tu vehículo cuenta con una póliza de seguro integral que cubre daños por colisión, robo y
                    responsabilidad civil mientras esté bajo un contrato de alquiler activo.
                </x-toggle>
                <x-toggle title="¿Cómo debo actuar si el arrendatario devuelve el vehículo con daños?">
                    Debes reportar cualquier anomalía a través de la aplicación en el momento de la entrega, adjuntando
                    fotos claras. Nuestro equipo de mediación revisará el caso.
                </x-toggle>
            </x-toggle>
        </x-toggle>
    </x-toggle>


</x-modal>