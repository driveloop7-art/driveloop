<x-app-layout>
    <!-- PROVISIONAL -->
    <nav class="text-white space-x-16 flex justify-center bg-black">
        <a href="/calificacion-resena">Calificaciones y Reseñas</a>
        <a href="/contrato-garantia">Contratos y Garantias</a>
        <a href="/gestion-usuario">Gestión de Usuarios</a>
        <a href="/pago-digital">Pagos Digitales</a>
        <a href="/publicacion-vehiculo">Publicación Vehículos</a>
        <a href="/soporte-comunicacion">Soporte y Comunicación</a>
    </nav>
    <!-- ========== -->

    <section class="flex text-white min-w-[15rem]">
        <div class="flex flex-col lg:flex-row items-center lg:items-start">
            <div class="lg:ml-[10rem]">

                <h1 class="text-2xl md:text-5xl lg:text-7xl font-extrabold italic drop-shadow-xl lg:mt-20 ">
                    EL AUTO QUE BUSCAS,<br>
                    LA OPORTUNIDAD<br>
                    QUE NECESITAS
                </h1>
                
                <p class="text-xl mt-4 lg:mt-[7rem] ">
                    Reserva el auto que necesitas para tu viaje o genera ingresos<br>
                    poniendo el tuyo en movimiento.
                </p>

                <div class="flex flex-col lg:flex-row font-semibold shadow-lg space-x-0 lg:space-x-8 space-y-5 lg:space-y-0 mt-12 text-center">
                    <a href="{{ route('busqueda.reserva') }}"
                        class="bg-dl hover:bg-dl-two px-8 py-3 w-[13.5rem] tracking-wide -skew-x-25">
                        <span class="skew-x-25 block">RESERVA</span>
                    </a>
                    <a href="{{ route('login') }}"
                        class="bg-dl hover:from-dl-two hover:to-dl-two px-8 py-3 w-[13.5rem] tracking-wide -skew-x-25
                                bg-gradient-to-r from-dl to-dl-two transition-all">
                        <span class="skew-x-25 block">GENERA INGRESOS</span>
                    </a>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>