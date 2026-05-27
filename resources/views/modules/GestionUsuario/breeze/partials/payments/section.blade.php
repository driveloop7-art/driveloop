<x-card class="mx-auto p-8">
    <div class="mb-6">
        <h2 class="text-xl font-bold">Pagos Registrados</h2>
        <p class="text-sm text-gray-500 mt-1">
            Aquí puedes consultar el historial de pagos realizados en tus reservas.
        </p>
    </div>

    @if (isset($pagos) && $pagos->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y text-gray-500">
                <thead class="bg-gray-200 text-xs font-medium uppercase tracking-wider">
                    <tr>
                        <th class="py-2">Referencia</th>
                        <th class="py-2">Vehículo</th>
                        <th class="py-2">Método</th>
                        <th class="py-2">Monto</th>
                        <th class="py-2">Estado</th>
                        <th class="py-2">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm text-center">
                    @foreach ($pagos as $pago)
                        <tr>
                            <td class="py-3">
                                {{ $pago->referencia }}
                            </td>

                            <td class="py-3">
                                @php
                                    $marca = optional(optional(optional($pago->reserva)->vehiculo)->marca)->des;
                                    $linea = optional(optional(optional($pago->reserva)->vehiculo)->linea)->des;
                                @endphp

                                {{ trim(($marca ?? '') . ' ' . ($linea ?? '')) ?: 'Sin información' }}
                            </td>

                            <td class="py-3 uppercase">
                                {{ $pago->metodo }}
                            </td>

                            <td class="py-3 text-gray-900 font-semibold">
                                ${{ number_format($pago->monto, 0, ',', '.') }}
                            </td>

                            <td class="px-3">
                                @if ($pago->estado_normalizado === 'aprobado')
                                    <span
                                        class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Aprobado
                                    </span>
                                @elseif($pago->estado_normalizado === 'pendiente')
                                    <span
                                        class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                        Pendiente
                                    </span>
                                @else
                                    <span
                                        class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                        Rechazado
                                    </span>
                                @endif
                            </td>

                            <td class="py-3 text-gray-600">
                                {{ optional($pago->fecha_pago)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="rounded-xl border border-dashed border-gray-300 p-8 text-center">
            <p class="text-gray-600 font-medium">Aún no tienes pagos registrados.</p>
            <p class="text-sm text-gray-400 mt-2">
                Cuando confirmes una reserva, el pago aparecerá aquí.
            </p>
        </div>
    @endif
</x-card>
