    <div class="container py-4">
        <h1 class="mb-4">Módulo de Contratos y Garantías</h1>

        @if($reservas->isNotEmpty())
        <div class="max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
            @foreach ($reservas as $reserva)
            @php
            $vehiculo = \App\Models\MER\Vehiculo::find($reserva->codveh);
            $fotoObj = \App\Models\MER\FotoVehiculo::where('codveh', $vehiculo->cod)->first();
            $foto = $fotoObj ? $fotoObj->ruta : 'https://placehold.co/600x400';
            $marcaObj = \App\Models\MER\Marca::find($vehiculo->codmar);
            $lineaObj = \App\Models\MER\Linea::find($vehiculo->codlin);
            $marca = $marcaObj ? $marcaObj->des : '';
            $linea = $lineaObj ? $lineaObj->des : '';
            @endphp

            <div class="bg-white border border-gray-300 rounded-md p-4 mb-4 flex flex-col md:flex-row items-center justify-between shadow-sm">
                <div class="flex items-center space-x-6 w-full md:w-auto">
                    <div class="w-32 h-20 flex-shrink-0">
                        <img src="{{ asset($foto) }}" alt="{{ $marca }} {{ $linea }}" class="w-full h-full object-contain">
                    </div>

                    <div class="flex flex-col">
                        <h4 class="text-xl font-bold text-gray-900">{{ $marca }} {{ $linea }}</h4>
                        <p class="text-gray-500 text-sm">Reserva #{{ $reserva->cod }}</p>
                        <p class="text-gray-500 text-sm">Finaliza: {{ $reserva->fecfin }}</p>
                        @if($reserva->contrato)
                        <span class="badge bg-success mt-1">Contrato generado</span>
                        @else
                        <span class="badge bg-warning text-dark mt-1">Pendiente de contrato</span>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col items-end mt-4 md:mt-0 space-y-2 w-full md:w-auto">
                    {{-- Botón Ver PDF / Generar PDF --}}
                    <div class="flex space-x-2">
                        <a href="{{ route('contrato.descargar', $reserva->cod) }}" target="_blank"
                            class="btn btn-sm {{ $reserva->contrato ? 'btn-outline-primary' : 'btn-primary' }}">
                            {{ $reserva->contrato ? '📄 Ver PDF' : '📄 Generar PDF' }}
                        </a>
                        {{-- Botón Generar Acta de Entrega --}}
                        <a href="{{ route('acta.entrega.descargar', $reserva->cod) }}" target="_blank"
                            class="btn btn-sm btn-outline-info">
                            📝 Acta de Entrega
                        </a>
                    </div>
                    {{-- Botón Enviar por Email --}}
                    <form action="{{ route('contrato.enviar', $reserva->cod) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            ✉️ {{ $reserva->contrato ? 'Reenviar Email' : 'Generar y Enviar' }}
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="p-4 text-center text-gray-500">No hay reservas registradas.</div>
        @endif
    </div>