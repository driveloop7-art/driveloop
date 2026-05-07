@php
    $vehiculos = \App\Models\MER\Vehiculo::query()
        ->where('user_id', auth()->id())
        ->whereHas('documentos_vehiculos', function ($q) {
            $q->where('idtipdocveh', 1)->where('estado', 'APROBADO');
        })
        ->whereHas('documentos_vehiculos', function ($q) {
            $q->where('idtipdocveh', 2)->where('estado', 'APROBADO');
        })
        ->whereHas('documentos_vehiculos', function ($q) {
            $q->where('idtipdocveh', 3)->where('estado', 'APROBADO');
        })
        ->with([
            'marca',
            'linea',
            'clase',
            'fotos_vehiculos',
            'reservas' => function ($q) {
                $q->with(['user', 'estado_reserva'])->orderByDesc('cod');
            },
        ])
        ->orderByDesc('cod')
        ->get();
@endphp

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<x-card class="w-full p-8">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium text-left">{{ __('Vehículos Registrados') }}</h3>
        <span class="text-sm text-gray-500">Total: {{ $vehiculos->count() }}</span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y text-gray-500">
            <thead class="bg-gray-200 text-xs font-medium uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Marca</th>
                    <th class="px-4 py-2 text-left">Línea</th>
                    <th class="px-4 py-2 text-left">Color</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($vehiculos as $vehiculo)
                    <tr class="hover:bg-gray-50 transition align-middle">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $vehiculo->cod }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $vehiculo->marca->des ?? '-' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $vehiculo->linea->des ?? '-' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $vehiculo->col ?? '-' }}</td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            <div x-data="{ openReservaModal: false }" class="flex items-center gap-2 flex-nowrap">

                                {{-- VER --}}
                                @include('modules.PublicacionVehiculo.components.tarjInforVeh')

                                {{-- EDITAR --}}
                                <a href="{{ route('vehiculos.edit', $vehiculo->cod) }}"
                                    class="inline-flex items-center justify-center h-6 px-2 text-[11px] font-medium rounded text-white bg-[#9B1839] hover:opacity-90 transition whitespace-nowrap">
                                    Editar
                                </a>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('vehiculos.destroy', $vehiculo->cod) }}" method="POST"
                                    class="inline-block m-0"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este vehículo?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="inline-flex items-center justify-center h-6 px-2 text-[11px] font-medium rounded text-white bg-[#870027] hover:opacity-90 transition whitespace-nowrap">
                                        Eliminar
                                    </button>
                                </form>

                                {{-- RESERVAS --}}
                                <button type="button" @click="openReservaModal = true"
                                    class="inline-flex items-center justify-center h-6 px-2 text-[11px] font-medium rounded text-white bg-[#282828] hover:opacity-90 transition whitespace-nowrap">
                                    Reservas
                                </button>

                                {{-- MODAL DE RESERVAS --}}
                                <div x-cloak x-show="openReservaModal" x-transition.opacity
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4"
                                    @keydown.escape.window="openReservaModal = false" style="display: none;">
                                    <div class="absolute inset-0" @click="openReservaModal = false"></div>

                                    <div
                                        class="relative w-full max-w-5xl max-h-[90vh] overflow-hidden rounded-2xl bg-white shadow-2xl">
                                        <div class="flex items-center justify-between border-b px-6 py-4 bg-gray-50">
                                            <div>
                                                <h3 class="text-lg font-semibold text-[#282828]">
                                                    Reservas del vehículo #{{ $vehiculo->cod }}
                                                </h3>
                                                <p class="text-sm text-gray-500">
                                                    {{ $vehiculo->marca->des ?? '' }} {{ $vehiculo->linea->des ?? '' }}
                                                </p>
                                            </div>

                                            <button type="button" @click="openReservaModal = false"
                                                class="inline-flex items-center justify-center h-8 w-8 rounded-md text-[#282828] hover:bg-gray-200 transition">
                                                ×
                                            </button>
                                        </div>

                                        <div class="max-h-[75vh] overflow-y-auto p-6">
                                            @if ($vehiculo->reservas->count() > 0)
                                                <div class="space-y-4">
                                                    @foreach ($vehiculo->reservas as $reserva)
                                                        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">
                                                            <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-2 lg:grid-cols-3">
                                                                <div>
                                                                    <span class="font-semibold text-[#282828]">Reserva:</span>
                                                                    <div class="text-gray-600">#{{ $reserva->cod }}</div>
                                                                </div>

                                                                <div>
                                                                    <span class="font-semibold text-[#282828]">Estado:</span>
                                                                    <div class="text-gray-600">
                                                                        {{ $reserva->estado_reserva->des ?? 'Sin estado' }}
                                                                    </div>
                                                                </div>

                                                                <div>
                                                                    <span class="font-semibold text-[#282828]">Cliente:</span>
                                                                    <div class="text-gray-600">
                                                                        {{ trim(($reserva->user->nom ?? '') . ' ' . ($reserva->user->ape ?? '')) ?: 'Sin información' }}
                                                                    </div>
                                                                </div>

                                                                <div>
                                                                    <span class="font-semibold text-[#282828]">Valor:</span>
                                                                    <div class="text-gray-600">
                                                                        ${{ number_format($reserva->val ?? 0, 0, ',', '.') }}
                                                                    </div>
                                                                </div>

                                                                <div>
                                                                    <span class="font-semibold text-[#282828]">Inicio:</span>
                                                                    <div class="text-gray-600">
                                                                        {{ optional($reserva->fecini)->format('d/m/Y H:i') }}
                                                                    </div>
                                                                </div>

                                                                <div>
                                                                    <span class="font-semibold text-[#282828]">Fin:</span>
                                                                    <div class="text-gray-600">
                                                                        {{ optional($reserva->fecfin)->format('d/m/Y H:i') }}
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            @if ((int) $reserva->codestres !== 3)
                                                                <div class="mt-4 border-t pt-4">
                                                                    <h4 class="mb-3 text-sm font-semibold text-[#9B1839]">
                                                                        Finalizar esta reserva
                                                                    </h4>

                                                                    <form action="{{ route('usuario.reservas.finalizar', $reserva->cod) }}"
                                                                        method="POST"
                                                                        class="space-y-3">
                                                                        @csrf

                                                                        <div>
                                                                            <label class="mb-1 block text-sm font-medium text-[#282828]">
                                                                                Estado del vehículo al recibirlo
                                                                            </label>

                                                                            <select name="recibido_buen_estado"
                                                                                class="w-full rounded-md border border-gray-300 text-sm focus:border-[#9B1839] focus:ring-[#9B1839]">
                                                                                <option value="">Seleccionar</option>
                                                                                <option value="1">Buen estado</option>
                                                                                <option value="0">Con novedad</option>
                                                                            </select>
                                                                        </div>

                                                                        <div>
                                                                            <label class="mb-1 block text-sm font-medium text-[#282828]">
                                                                                Observación
                                                                            </label>

                                                                            <textarea
                                                                                name="observacion_recepcion"
                                                                                rows="3"
                                                                                class="w-full rounded-md border border-gray-300 text-sm focus:border-[#9B1839] focus:ring-[#9B1839]"
                                                                                placeholder="Describe el estado del vehículo o cualquier novedad"></textarea>
                                                                        </div>

                                                                        <div>
                                                                            <button
                                                                                type="submit"
                                                                                onclick="return confirm('¿Confirmas que deseas finalizar esta reserva?')"
                                                                                class="inline-flex items-center justify-center h-7 px-3 text-[11px] font-medium rounded text-white bg-[#9B1839] hover:opacity-90 transition whitespace-nowrap">
                                                                                Finalizar reserva
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <div class="mt-4 border-t pt-4 text-sm">
                                                                    <span
                                                                        class="inline-flex items-center rounded-full bg-gray-100 px-3 py-1 font-medium text-[#282828]">
                                                                        Reserva finalizada
                                                                    </span>

                                                                    @if ($reserva->fecha_cierre_real)
                                                                        <div class="mt-2 text-gray-600">
                                                                            <strong>Fecha de cierre:</strong>
                                                                            {{ optional($reserva->fecha_cierre_real)->format('d/m/Y H:i') }}
                                                                        </div>
                                                                    @endif

                                                                    @if (!is_null($reserva->recibido_buen_estado))
                                                                        <div class="mt-2 text-gray-600">
                                                                            <strong>Estado del vehículo:</strong>
                                                                            {{ $reserva->recibido_buen_estado ? 'Buen estado' : 'Con novedad' }}
                                                                        </div>
                                                                    @endif

                                                                    @if (!empty($reserva->observacion_recepcion))
                                                                        <div class="mt-2 text-gray-600">
                                                                            <strong>Observación:</strong>
                                                                            {{ $reserva->observacion_recepcion }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="py-10 text-center">
                                                    <p class="text-sm text-gray-500">
                                                        Este vehículo no tiene reservas registradas.
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                {{-- FIN MODAL --}}
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-400">
                            No hay vehículos registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>