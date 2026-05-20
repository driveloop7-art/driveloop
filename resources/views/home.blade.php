<x-app-layout>
    <section class="flex text-white px-4">
        <div class="flex flex-col lg:flex-row items-center lg:items-start w-full ">

            <div class="lg:ml-[10rem] text-center lg:text-left">

                <h1 class="mt-32 text-3xl md:text-5xl lg:text-7xl font-extrabold italic drop-shadow-xl lg:mt-20">

                    EL AUTO QUE BUSCAS,<br class="hidden md:block">
                    LA OPORTUNIDAD<br class="hidden md:block">
                    QUE NECESITAS
                </h1>

                <p class="text-base sm:text-base md:text-xl 
                          mt-4 md:mt-8 lg:mt-[7rem] 
                          leading-relaxed">

                    Reserva el auto que necesitas para tu viaje o genera ingresos
                    poniendo el tuyo en movimiento.
                </p>

                <div
                    class="flex flex-col lg:flex-row items-center lg:items-start font-semibold shadow-lg space-x-0 lg:space-x-8 space-y-5 lg:space-y-0 mt-36 lg:mt-12 text-center">

                    {{-- BOTÓN RESERVA --}}
                    <button type="button"
                        onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'search-car' }))"
                        class="bg-dl hover:bg-dl-two px-8 py-3 w-[13.5rem] tracking-wide -skew-x-25">
                        <span class="skew-x-25 block">RESERVA</span>
                    </button>

                    {{-- BOTÓN GENERA INGRESOS --}}
                    <a href="{{ route('publicacion.vehiculo') }}" class="hover:from-dl-two hover:to-dl-two px-8 py-3 w-[13.5rem] tracking-wide -skew-x-25
                                bg-gradient-to-r from-dl to-dl-two transition-all">
                        <span class="skew-x-25 block">GENERA INGRESOS</span>
                    </a>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>

{{-- Sección de autos recomendados --}}
@include('modules.PublicacionVehiculo.components.tarjVehiculosPrinc')

<!-- Warning Modal -->
@include('modules.BusquedaReserva.partials.modals.verification-warning')
<!-- Si existe la variable de sesión enviada por el middleware -->
@if (session('show_verification-warning'))
    <!-- Usamos Alpine para despachar el evento apenas cargue el DOM -->
    <div x-data
        x-init="$nextTick(() => { window.dispatchEvent(new CustomEvent('open-modal', { detail: 'verification-warning' })) })">
    </div>
@endif