<x-page>

    <div class="mb-6 flex space-x-4 border-b">
        <a href="{{ route('soporte.docs.index') }}" 
           class="pb-2 px-4 {{ Route::is('soporte.docs.index') ? 'border-b-2 border-indigo-500 font-bold' : 'text-gray-500' }}">
            Validación de Usuarios
        </a>
        <a href="{{ route('soporte.vehiculos.index') }}" 
           class="pb-2 px-4 {{ Route::is('soporte.vehiculos.index') ? 'border-b-2 border-indigo-500 font-bold' : 'text-gray-500' }}">
            Validación de Vehículos
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($vehiculos->isEmpty())
        <div class="text-center py-8 text-gray-500">
            No hay vehículos con documentos pendientes de revisión.
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehículo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Placa (Doc)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Documentos Pendientes</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($vehiculos as $veh)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $veh->marca->des ?? 'Marca' }} {{ $veh->linea->des ?? 'Línea' }}
                                </div>
                                <div class="text-xs text-gray-500">Modelo: {{ $veh->mod }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @php $primDoc = $veh->documentos_vehiculos->first(); @endphp
                                <div class="text-sm text-gray-500">{{ $primDoc->numdoc ?? '—' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-1">
                                    @foreach($veh->documentos_vehiculos as $doc)
                                        @if($doc->estado === 'PENDIENTE')
                                            @php
                                                $label = match($doc->idtipdocveh) {
                                                    1 => 'Tarjeta',
                                                    2 => 'SOAT',
                                                    3 => 'Tecno',
                                                    default => 'Otro'
                                                };
                                            @endphp
                                            <span class="px-2 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                {{ $label }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('soporte.vehiculos.show', $veh->cod) }}" class="text-indigo-600 hover:text-indigo-900">
                                    Revisar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $vehiculos->links() }}
        </div>
    @endif

</x-page>
