<x-app-layout>
    <section class="flex text-white px-4">
        <div class="flex flex-col lg:flex-row items-center lg:items-start w-full ">

            <div class="lg:ml-[10rem] text-center lg:text-left">

                <h1 class="text-xl sm:text-3xl md:text-5xl lg:text-7xl 
                           font-extrabold italic drop-shadow-xl 
                           mt-6 md:mt-10 lg:mt-20 
                           leading-tight md:leading-snug">

                    EL AUTO QUE BUSCAS,<br class="hidden md:block">
                    LA OPORTUNIDAD<br class="hidden md:block">
                    QUE NECESITAS
                </h1>

                <p class="text-sm sm:text-base md:text-xl 
                          mt-4 md:mt-8 lg:mt-[7rem] 
                          leading-relaxed">

                    Reserva el auto que necesitas para tu viaje o genera ingresos
                    poniendo el tuyo en movimiento.
                </p>

                <div class="flex flex-col sm:flex-row 
                            font-semibold shadow-lg 
                            gap-4 sm:gap-6 
                            mt-8 md:mt-12 
                            text-center justify-center lg:justify-start">

                    {{-- BOTÓN RESERVA --}}
                    <button type="button"
                        onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'search-car' }))"
                        class="bg-dl hover:bg-dl-two 
                               px-6 md:px-8 py-3 
                               w-full sm:w-auto 
                               tracking-wide -skew-x-12">

                        <span class="skew-x-12 block">RESERVA</span>
                    </button>

                    {{-- BOTÓN GENERA INGRESOS --}}
                    <a href="{{ route('publicacion.vehiculo') }}"
                        class="hover:from-dl-two hover:to-dl-two 
                               px-6 md:px-8 py-3 
                               w-full sm:w-auto 
                               tracking-wide -skew-x-12
                               bg-gradient-to-r from-dl to-dl-two transition-all">

                        <span class="skew-x-12 block">GENERA INGRESOS</span>
                    </a>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>

{{-- Sección de autos recomendados --}}
@include('modules.PublicacionVehiculo.components.tarjVehiculosPrinc')
