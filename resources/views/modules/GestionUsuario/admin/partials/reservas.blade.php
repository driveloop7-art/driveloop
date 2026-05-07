<x-card class="w-full p-8">
    <div class="flex flex-col gap-4 mb-6 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <h3 class="text-lg font-medium text-left">{{ __('Reservas') }}</h3>
            <span class="text-sm text-gray-500">Total: {{ $reservas->total() }}</span>
        </div>

        <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-3">
            <input type="hidden" name="tab" value="reservas">

            <label for="per_page" class="text-sm text-gray-600 whitespace-nowrap">
                Mostrar
            </label>

            <select name="per_page" id="per_page" onchange="this.form.submit()"
                class="rounded-lg border-gray-300 text-sm focus:ring-red-500 focus:border-red-500">
                @foreach ([5, 10, 15, 20, 30, 50] as $size)
                    <option value="{{ $size }}" {{ request('per_page', 10) == $size ? 'selected' : '' }}>
                        {{ $size }}
                    </option>
                @endforeach
            </select>

            <span class="text-sm text-gray-600">registros</span>
        </form>
    </div>

    <div class="rounded-xl border border-gray-200 overflow-hidden">

        {{-- CONTENEDOR CON SCROLL --}}
        <div class="max-h-[400px] overflow-y-auto overflow-x-auto custom-scrollbar">

            <table class="min-w-full divide-y divide-gray-200 text-gray-600">
                <thead class="bg-gray-100 text-xs font-semibold uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-4 py-3 text-left">ID</th>
                        <th class="px-4 py-3 text-left">Vehículo</th>
                        <th class="px-4 py-3 text-left">Usuario</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">Acción</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 bg-white text-sm">
                    @forelse ($reservas as $reserva)
                        @php
                            $vehiculo = $reserva->vehiculo;
                            $usuario = $reserva->user;
                            $estado = $reserva->estado_reserva;

                            $marca = $vehiculo?->marca?->des ?? 'Sin marca';
                            $linea = $vehiculo?->linea?->des ?? 'Sin línea';
                            $modelo = $vehiculo?->mod ?? 'N/A';
                            $clase = $vehiculo?->clase?->des ?? 'N/A';
                            $combustible = $vehiculo?->combustible?->des ?? 'N/A';
                            $ciudad = $vehiculo?->ciudad?->des ?? 'N/A';
                            $color = $vehiculo?->col ?? 'N/A';
                            $pasajeros = $vehiculo?->pas ?? 'N/A';
                            $precio = $vehiculo?->prerent
                                ? '$' . number_format((float) $vehiculo->prerent, 0, ',', '.')
                                : 'N/A';
                            $disponible = is_null($vehiculo?->disp) ? 'N/A' : ($vehiculo->disp ? 'Sí' : 'No');

                            $foto = $vehiculo?->fotos?->first()?->url ?? asset('img/no-image.jpg');

                            $nombreUsuario = $usuario
                                ? trim(($usuario->nom ?? '') . ' ' . ($usuario->ape ?? ''))
                                : 'Sin usuario';
                        @endphp

                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-3 whitespace-nowrap">#{{ $reserva->cod }}</td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $marca }} {{ $linea }} {{ $modelo }}
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $nombreUsuario }}
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                    {{ $estado?->des ?? 'Sin estado' }}
                                </span>
                            </td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                <button type="button"
                                    class="rounded-lg bg-[#981B39] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#7c1630]"
                                    x-on:click="$dispatch('open-modal', 'reserva-vehiculo-{{ $reserva->cod }}')">
                                    Ver reserva
                                </button>
                            </td>
                        </tr>

                        <x-modal name="reserva-vehiculo-{{ $reserva->cod }}" title="Detalle del vehículo"
                            maxWidth="6xl" focusable>
                            <div class="p-2 lg:p-4">
                                <div class="grid grid-cols-1 gap-8 xl:grid-cols-[360px_minmax(0,1fr)]">
                                    <div>
                                        <div
                                            class="overflow-hidden rounded-2xl border border-gray-200 bg-gray-100 shadow-sm">
                                            <img src="{{ $foto }}"
                                                alt="{{ $marca }} {{ $linea }}"
                                                class="h-[280px] w-full object-cover" loading="lazy"
                                                onerror="this.onerror=null;this.src='{{ asset('img/no-image.jpg') }}';">
                                        </div>
                                    </div>

                                    <div class="space-y-6">
                                        <div>
                                            <h3 class="text-3xl font-extrabold uppercase tracking-tight text-gray-900">
                                                {{ $marca }}
                                            </h3>
                                            <p class="mt-1 text-base text-gray-500">
                                                {{ $linea }} {{ $modelo }}
                                            </p>
                                        </div>

                                        <div>
                                            <h4 class="mb-3 text-lg font-bold text-gray-900">Información del vehículo
                                            </h4>

                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">
                                                <div class="rounded-2xl bg-gray-50 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Marca</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $marca }}</p>
                                                </div>

                                                <div class="rounded-2xl bg-gray-50 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Línea</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $linea }}</p>
                                                </div>

                                                <div class="rounded-2xl bg-gray-50 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Modelo</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $modelo }}</p>
                                                </div>

                                                <div class="rounded-2xl bg-gray-50 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Clase</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $clase }}</p>
                                                </div>

                                                <div class="rounded-2xl bg-gray-50 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Color</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $color }}</p>
                                                </div>

                                                <div class="rounded-2xl bg-gray-50 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Pasajeros</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $pasajeros }}</p>
                                                </div>

                                                <div class="rounded-2xl bg-gray-50 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Combustible</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $combustible }}</p>
                                                </div>

                                                <div class="rounded-2xl bg-gray-50 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Ciudad</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $ciudad }}</p>
                                                </div>

                                                <div class="rounded-2xl bg-gray-50 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Precio por día</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $precio }}</p>
                                                </div>

                                                <div class="rounded-2xl bg-gray-50 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Disponible</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $disponible }}</p>
                                                </div>

                                                <div class="rounded-2xl bg-gray-50 p-4 xl:col-span-2">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        VIN</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900 break-all">
                                                        {{ $vehiculo?->vin ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <h4 class="mb-3 text-lg font-bold text-gray-900">Información de la reserva
                                            </h4>

                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                                <div class="rounded-2xl border border-gray-200 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Reserva</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        #{{ $reserva->cod }}</p>
                                                </div>

                                                <div class="rounded-2xl border border-gray-200 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Usuario</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $nombreUsuario }}</p>
                                                </div>

                                                <div class="rounded-2xl border border-gray-200 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Creación</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ optional($reserva->fecrea)->format('d/m/Y H:i') }}</p>
                                                </div>

                                                <div class="rounded-2xl border border-gray-200 p-4">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Estado</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ $estado?->des ?? 'Sin estado' }}</p>
                                                </div>

                                                <div class="rounded-2xl border border-gray-200 p-4 sm:col-span-2">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Fecha inicio</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ optional($reserva->fecini)->format('d/m/Y H:i') }}</p>
                                                </div>

                                                <div class="rounded-2xl border border-gray-200 p-4 sm:col-span-2">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Fecha fin</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        {{ optional($reserva->fecfin)->format('d/m/Y H:i') }}</p>
                                                </div>

                                                <div class="rounded-2xl border border-gray-200 p-4 xl:col-span-2">
                                                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">
                                                        Valor de la reserva</p>
                                                    <p class="mt-2 text-base font-semibold text-gray-900">
                                                        ${{ number_format((float) $reserva->val, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </x-modal>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-400">
                                No hay reservas registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($reservas->hasPages())
        <div class="mt-6">
            {{ $reservas->appends(['tab' => 'reservas'])->links() }}
        </div>
    @endif
</x-card>
