<x-page>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Revisión de Vehículo') }}: {{ $vehiculo->marca->des ?? '' }} {{ $vehiculo->linea->des ?? '' }} ({{ $vehiculo->mod }})
                </h2>
                <a href="{{ route('soporte.vehiculos.index') }}">
                    <x-button type="tertiary" class="!px-4 !py-2 !text-xs">
                        &larr; Volver al listado
                    </x-button>
                </a>
            </div>

            <!-- Información del Vehículo -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Detalles Técnicos</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <span class="text-gray-500 block text-sm">VIN</span>
                            <span class="font-semibold">{{ $vehiculo->vin }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-sm">Color</span>
                            <span>{{ $vehiculo->col }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-sm">Pasajeros</span>
                            <span>{{ $vehiculo->pas }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-sm">Precio Día</span>
                            <span class="text-green-600 font-bold">${{ number_format($vehiculo->prerent, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Documentos en Rejilla -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @php
                    $docs = [
                        ['type' => 'Tarjeta de Propiedad', 'doc' => $docTarjeta, 'id' => 'tarjeta'],
                        ['type' => 'SOAT', 'doc' => $docSoat, 'id' => 'soat'],
                        ['type' => 'Técnico-Mecánica', 'doc' => $docTecno, 'id' => 'tecno'],
                    ];
                @endphp

                @foreach($docs as $item)
                    @php $d = $item['doc']; @endphp
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg h-full flex flex-col text-left">
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                <h3 class="text-sm font-bold text-gray-900 uppercase">{{ $item['type'] }}</h3>
                                @if($d)
                                    @php
                                        $statusClass = match($d->estado) {
                                            'APROBADO' => 'bg-green-100 text-green-800',
                                            'RECHAZADO' => 'bg-red-100 text-red-800',
                                            default => 'bg-yellow-100 text-yellow-800',
                                        };
                                    @endphp
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $statusClass }}">
                                        {{ $d->estado }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-gray-100 text-gray-800">PENDIENTE SUBIDA</span>
                                @endif
                            </div>

                            <div class="flex-1 flex flex-col">
                                @if($d)
                                    <div class="border rounded p-2 text-center bg-gray-50 flex items-center justify-center min-h-[160px] mb-4">
                                        @php $isPdf = str_ends_with(strtolower($d->descdoc), '.pdf'); @endphp
                                        <a href="{{ asset('storage/'.$d->descdoc) }}" target="_blank" class="w-full">
                                            @if($isPdf)
                                                <div class="flex flex-col items-center justify-center py-4">
                                                    <svg class="w-12 h-12 text-red-500 mb-2" fill="currentColor" viewBox="0 0 20 20"><path d="M4 18V2h12v4h4v12H4zm14-10h-6V2.2l6 5.8zM6 4v12h12V8h-6V4H6zm2 3h4v2H8V7zm0 4h6v2H8v-2z"/></svg>
                                                    <span class="text-red-500 font-bold text-xs uppercase">Abrir PDF</span>
                                                </div>
                                            @else
                                                <img src="{{ asset('storage/'.$d->descdoc) }}" class="max-h-40 mx-auto object-contain" alt="{{ $item['type'] }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="text-center mb-6">
                                        <a href="{{ asset('storage/'.$d->descdoc) }}" target="_blank" class="text-[10px] text-blue-500 hover:underline tracking-tight font-medium uppercase">Ver documento completo</a>
                                    </div>

                                    @if($d->estado == 'PENDIENTE')
                                        <div class="mt-auto pt-4 border-t space-y-3">
                                            <form action="{{ route('soporte.vehiculos.reject', $d->id) }}" method="POST">
                                                @csrf
                                                <textarea name="mensaje_rechazo" required placeholder="Motivo rechazo..." rows="2" class="w-full rounded-md border-gray-300 text-xs focus:ring-red-500 focus:border-red-500 mb-2"></textarea>
                                                <x-button type="primary" class="w-full !bg-red-600 !py-2 !text-[11px] font-bold tracking-widest">RECHAZAR</x-button>
                                            </form>
                                            <form action="{{ route('soporte.vehiculos.approve', $d->id) }}" method="POST">
                                                @csrf
                                                <x-button type="tertiary" class="w-full !py-1.5 !text-[10px]">APROBAR</x-button>
                                            </form>
                                        </div>
                                    @endif

                                    @if($d->estado == 'RECHAZADO')
                                        <div class="mt-auto p-3 bg-red-50 text-red-700 text-[10px] rounded-lg border border-red-100">
                                            <strong class="block mb-1 uppercase tracking-wider">Motivo del rechazo:</strong>
                                            <p class="italic leading-normal">{{ $d->mensaje_rechazo }}</p>
                                        </div>
                                    @endif

                                    @if($d->estado == 'APROBADO')
                                        <div class="mt-auto p-3 bg-green-50 text-green-700 text-[10px] rounded-lg border border-green-100 text-center">
                                            <span class="uppercase font-bold tracking-widest">Documento Verificado</span>
                                        </div>
                                    @endif
                                @else
                                    <div class="flex-1 flex flex-col items-center justify-center py-10">
                                        <p class="text-gray-400 text-xs italic">Aún no se ha cargado este documento</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Fotos del Vehículo -->
            @if($vehiculo->fotos->isNotEmpty())
                <div class="mt-10">
                    <h3 class="text-lg font-bold mb-4">Fotos del Vehículo</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($vehiculo->fotos as $foto)
                            <div class="border rounded-lg overflow-hidden shadow-sm bg-white">
                                <img src="{{ asset('storage/'.$foto->ruta) }}" class="w-full h-32 object-cover" alt="Foto">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-page>
