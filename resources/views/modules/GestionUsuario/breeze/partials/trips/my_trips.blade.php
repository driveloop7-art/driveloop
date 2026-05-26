@foreach ($reservas as $reserva)
    @php
        $vehiculo = $reserva->vehiculo;

        $fotoObj = $vehiculo?->fotos?->first();
        $foto = $fotoObj?->url ?? asset('img/no-image.jpg');

        $marca = $vehiculo?->marca?->des ?? 'Sin marca';
        $linea = $vehiculo?->linea?->des ?? 'Sin línea';
        $modelo = $vehiculo?->mod ?? 'N/A';
        $color = $vehiculo?->col ?? 'N/A';
        $pasajeros = $vehiculo?->pas ?? 'N/A';
        $combustible = $vehiculo?->combustible?->des ?? 'N/A';

        $fechaInicio = $reserva->fecini
            ? \Carbon\Carbon::parse($reserva->fecini)->format('d/m/Y H:i')
            : 'N/A';

        $fechaFin = $reserva->fecfin
            ? \Carbon\Carbon::parse($reserva->fecfin)->format('d/m/Y H:i')
            : 'N/A';

        $pagoEstado = $reserva->pago?->estado ?? 'sin pago';

        $tieneContrato = !is_null($reserva->contrato);
        $tienePoliza = !is_null($reserva->polizaServicio);
    @endphp

    <div class="mb-3 rounded-xl border border-gray-200 x-4 py-3 shadow-sm overflow-x-auto">
        <div class="block xl:flex xl:flex-cols-2 items-center">
            <div class="flex w-[65%] items-center">
                <div class="h-20 w-24 shrink-0 overflow-hidden rounded-lg flex items-center px-2">
                    <img
                        src="{{ $foto }}"
                        alt="{{ $marca }} {{ $linea }}"
                        class="w-full object-cover"
                        loading="lazy"
                        onerror="this.onerror=null;this.src='{{ asset('img/no-image.jpg') }}';"
                    >
                </div>

                <div>
                    <h4 class="text-lg font-bold uppercase text-gray-900">
                        {{ $marca }}
                    </h4>
                    <p class="text-sm text-gray-600">
                        {{ $linea }} {{ $modelo }}
                    </p>
                    <p class="mt-1 text-sm text-gray-500">
                        Recogida: {{ $fechaInicio }}
                    </p>
                </div>
            </div>

            <div class="block mx-4 xl:grid xl:grid-cols-2 xl:gap-2">
                <div class="min-w-36 my-4 text-center">
                    @if($pagoEstado === 'aprobado')
                    <span class="items-center rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                        Pago aprobado
                    </span>
                    @elseif($pagoEstado === 'pendiente')
                        <span class="items-center rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                            Pago pendiente
                        </span>
                        @else
                        <span class="items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                            Sin pago confirmado
                        </span>
                        @endif
                    </div>
                <div class="min-w-52 block">
                    <x-button class="text-xs w-full" x-on:click="$dispatch('open-modal', 'trip-detail-{{ $reserva->cod }}')"> Ver detalle</x-button>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="trip-detail-{{ $reserva->cod }}" title="Detalle del viaje" maxWidth="7xl" focusable>
        <div class="p-2 lg:p-4">
            <div class="flex flex-col gap-4 border-b border-gray-200 pb-5 md:flex-row md:items-start md:justify-between">
                <div>
                    <h3 class="text-3xl font-extrabold uppercase tracking-tight text-gray-900">
                        {{ $marca }}
                    </h3>
                    <p class="mt-1 text-base text-gray-500">
                        {{ $linea }} {{ $modelo }}
                    </p>
                </div>

                <div>
                    @if($pagoEstado === 'aprobado')
                        <span class="inline-flex items-center rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-700">
                            Pago aprobado
                        </span>
                    @elseif($pagoEstado === 'pendiente')
                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-700">
                            Pago pendiente
                        </span>
                    @else
                        <span class="inline-flex items-center rounded-full bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700">
                            Sin pago confirmado
                        </span>
                    @endif
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-8 xl:grid-cols-[420px_minmax(0,1fr)]">
                <div>
                    <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                        <img
                            src="{{ $foto }}"
                            alt="{{ $marca }} {{ $linea }}"
                            class="w-full object-cover"
                            loading="lazy"
                            onerror="this.onerror=null;this.src='{{ asset('img/no-image.jpg') }}';"
                        >
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <h4 class="mb-3 text-lg font-bold text-gray-900">Información del vehículo</h4>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Marca</p>
                                <p class="mt-2 text-base font-semibold text-gray-900">{{ $marca }}</p>
                            </div>

                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Línea</p>
                                <p class="mt-2 text-base font-semibold text-gray-900">{{ $linea }}</p>
                            </div>

                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Modelo</p>
                                <p class="mt-2 text-base font-semibold text-gray-900">{{ $modelo }}</p>
                            </div>

                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Color</p>
                                <p class="mt-2 text-base font-semibold text-gray-900">{{ $color }}</p>
                            </div>

                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Pasajeros</p>
                                <p class="mt-2 text-base font-semibold text-gray-900">{{ $pasajeros }}</p>
                            </div>

                            <div class="rounded-2xl bg-gray-50 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Combustible</p>
                                <p class="mt-2 text-base font-semibold text-gray-900">{{ $combustible }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 class="mb-3 text-lg font-bold text-gray-900">Información de la reserva</h4>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                            <div class="rounded-2xl border border-gray-200 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Reserva</p>
                                <p class="mt-2 text-base font-semibold text-gray-900">#{{ $reserva->cod }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 p-4">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Valor</p>
                                <p class="mt-2 text-base font-semibold text-gray-900">
                                    ${{ number_format($reserva->val, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 p-4 sm:col-span-2">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Recogida</p>
                                <p class="mt-2 text-base font-semibold text-gray-900">{{ $fechaInicio }}</p>
                            </div>

                            <div class="rounded-2xl border border-gray-200 p-4 sm:col-span-2 xl:col-span-2">
                                <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Entrega</p>
                                <p class="mt-2 text-base font-semibold text-gray-900">{{ $fechaFin }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-5">
                        <h4 class="text-lg font-bold text-gray-900">Documentos del viaje</h4>
                        <p class="mt-1 text-sm text-gray-500">
                            Descarga aquí los archivos asociados a tu reserva.
                        </p>

                        <div class="mt-4 flex flex-wrap gap-3">
                            @if($tieneContrato)
                                <a
                                    href="{{ route('usuario.reservas.contrato.pdf', $reserva->cod) }}"
                                    class="rounded-md bg-[#C91843] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#9B1B39] uppercase"
                                >
                                    Descargar contrato
                                </a>
                            @endif

                            @if($tienePoliza)
                                <a
                                    href="{{ route('usuario.reservas.poliza.pdf', $reserva->cod) }}"
                                    class="rounded-md border border-[#C91843] px-5 py-3 text-sm font-semibold text-[#C91843] transition hover:bg-[#C91843] hover:text-white uppercase"
                                >
                                    Descargar póliza
                                </a>
                            @endif

                            @if(!$tieneContrato && !$tienePoliza)
                                <div class="rounded-xl border border-dashed border-gray-300 px-4 py-3 text-sm text-gray-500">
                                    No hay documentos disponibles para esta reserva.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
@endforeach