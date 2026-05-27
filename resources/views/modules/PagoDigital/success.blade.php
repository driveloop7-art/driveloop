<x-page>
    <div class="min-h-screen bg-gradient-to-b from-white to-[#f8f1f3] flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-2xl overflow-hidden rounded-3xl border border-[#ead2d8] bg-white shadow-2xl">

            {{-- Encabezado --}}
            <div class="bg-white px-8 py-10 text-center border-b border-gray-100">
                <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-emerald-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-emerald-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h1 class="mt-6 text-3xl font-extrabold text-gray-900 md:text-4xl">
                    ¡Pago realizado con éxito!
                </h1>

                <p class="mt-3 text-sm text-gray-500 md:text-base">
                    Tu proceso fue completado correctamente y la reserva quedó registrada.
                </p>
            </div>

            {{-- Contenido --}}
            <div class="px-8 py-8">

                @if (request()->route('id'))
                    <div class="mb-6 rounded-2xl border border-emerald-100 bg-emerald-50/50 px-5 py-4">
                        <p class="text-sm font-semibold uppercase tracking-wide text-emerald-700">
                            Número de reserva
                        </p>
                        <p class="mt-1 text-2xl font-bold text-gray-900">
                            #{{ request()->route('id') }}
                        </p>
                    </div>
                @endif

                <div class="mb-8 grid gap-4 md:grid-cols-2">
                    <div class="rounded-2xl border border-gray-100 bg-gray-50 px-5 py-4">
                        <p class="text-sm font-semibold text-gray-600">Estado del pago</p>
                        <p class="mt-2 inline-flex items-center gap-2 text-sm font-bold text-emerald-600">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            Aprobado
                        </p>
                    </div>

                    <div class="rounded-2xl border border-gray-100 bg-gray-50 px-5 py-4">
                        <p class="text-sm font-semibold text-gray-600">Estado de la reserva</p>
                        <p class="mt-2 inline-flex items-center gap-2 text-sm font-bold text-emerald-600">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            Registrada correctamente
                        </p>
                    </div>
                </div>

                <div class="rounded-2xl border border-gray-100 bg-white px-5 py-5 shadow-sm">
                    <h2 class="mb-2 text-lg font-bold text-gray-900">
                        ¿Qué sigue ahora?
                    </h2>
                    <p class="text-sm leading-6 text-gray-600">
                        Puedes revisar el detalle de tu reserva, volver al inicio o continuar navegando en la
                        plataforma.
                    </p>
                </div>

                {{-- Botones --}}
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                  
                    <a href="{{ route('dashboard') }}"
                        class="flex-1 rounded-xl bg-[#C91843] py-3 text-center font-bold text-white transition hover:bg-[#981B39]">
                        Ir al panel
                    </a>

                    <a href="{{ route('busqueda.reserva') }}"
                        class="flex-1 rounded-xl border-2 border-[#981B39] py-3 text-center font-bold text-[#981B39] transition hover:bg-[#fdf1f4]">
                        Ver más vehículos
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-page>
