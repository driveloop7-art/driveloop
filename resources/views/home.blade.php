<x-app-layout>
    <!-- PROVISIONAL -->
    <nav class="text-white space-x-16 flex justify-center bg-black">
        <a href="/calificaciones-resenas">Calificaciones y Reseñas</a>
        <a href="/contratos-garantias">Contratos y Garantias</a>
        <a href="/gestion-usuarios">Gestión de Usuarios</a>
        <a href="/pagos-digitales">Pagos Digitales</a>
        <a href="/publicacion-vehiculos">Publicación Vehículos</a>
        <a href="/soporte-comunicacion">Soporte y Comunicación
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
                    <a href="{{ route('reservas') }}"
                        class="bg-[#C81743] hover:bg-[#9B1B39] px-8 py-3 w-[13.5rem] tracking-wide -skew-x-25">
                        <span class="skew-x-25 block">RESERVA</span>
                    </a>
                    <a href="{{ route('login') }}"
                        class="bg-[#C81743] hover:from-[#9B1B39] hover:to-[#9B1B39] px-8 py-3 w-[13.5rem] tracking-wide -skew-x-25
                                bg-gradient-to-r from-[#C81743] to-[#9B1B39] transition-all">
                        <span class="skew-x-25 block">GENERA INGRESOS</span>
                    </a>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>