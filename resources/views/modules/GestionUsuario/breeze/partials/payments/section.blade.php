<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Mis pagos</h2>
        <p class="text-sm text-gray-500 mt-1">
            Aquí puedes consultar el historial de pagos realizados en tus reservas.
        </p>
    </div>

    @if (isset($pagos) && $pagos->count() > 0)
        <div class="overflow-x-auto">
            <div class="max-h-[420px] overflow-y-auto overflow-x-auto rounded-2xl border border-gray-200">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-gray-500 uppercase text-xs tracking-wider">
                            <th class="py-3 pr-4">Referencia</th>
                            <th class="py-3 pr-4">Vehículo</th>
                            <th class="py-3 pr-4">Método</th>
                            <th class="py-3 pr-4">Monto</th>
                            <th class="py-3 pr-4">Estado</th>
                            <th class="py-3 pr-4">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pagos as $pago)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="py-4 pr-4 font-medium text-gray-900">
                                    {{ $pago->referencia }}
                                </td>

                                <td class="py-4 pr-4 text-gray-700">
                                    @php
                                        $marca = optional(optional(optional($pago->reserva)->vehiculo)->marca)->des;
                                        $linea = optional(optional(optional($pago->reserva)->vehiculo)->linea)->des;
                                    @endphp

                                    {{ trim(($marca ?? '') . ' ' . ($linea ?? '')) ?: 'Sin información' }}
                                </td>

                                <td class="py-4 pr-4 text-gray-700 uppercase">
                                    {{ $pago->metodo }}
                                </td>

                                <td class="py-4 pr-4 text-gray-900 font-semibold">
                                    ${{ number_format($pago->monto, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3">
                                    @if ($pago->estado_normalizado === 'aprobado')
                                        <span
                                            class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Aprobado
                                        </span>
                                    @elseif($pago->estado_normalizado === 'pendiente')
                                        <span
                                            class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                            Pendiente
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            Rechazado
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 pr-4 text-gray-600">
                                    {{ optional($pago->fecha_pago)->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="rounded-xl border border-dashed border-gray-300 p-8 text-center">
            <p class="text-gray-600 font-medium">Aún no tienes pagos registrados.</p>
            <p class="text-sm text-gray-400 mt-2">
                Cuando confirmes una reserva, el pago aparecerá aquí.
            </p>
        </div>
    @endif
</div>
