<x-page>
    <h1>Vista Principal Módulo Calificaciones y Reseñas</h1>
   
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Reseñas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="GET" action="{{ route('calificacion.resena') }}" class="mb-6 flex gap-4">
                        <select name="filtro" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Todas las reseñas</option>
                            <option value="positivas" {{ request('filtro') == 'positivas' ? 'selected' : '' }}>Positivas (4-5 ⭐)</option>
                            <option value="negativas" {{ request('filtro') == 'negativas' ? 'selected' : '' }}>Negativas (1-3 ⭐)</option>
                            <option value="con_texto" {{ request('filtro') == 'con_texto' ? 'selected' : '' }}>Con comentarios escritos</option>
                        </select>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Filtrar
                        </button>
                    </form>

                    @if($resenas->count() > 0)
                        <div class="space-y-6">
                            @foreach ($resenas as $resena)
                                <div class="bg-gray-50 p-4 rounded-lg shadow-sm border border-gray-200">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <div class="text-yellow-400 text-lg mb-1">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $resena->puntuacion)
                                                        ★
                                                    @else
                                                        <span class="text-gray-300">★</span>
                                                    @endif
                                                @endfor
                                            </div>
                                            <p class="text-sm text-gray-500">
                                                Reserva #{{ $resena->codres }} | Vehículo: {{ $resena->reserva->vehiculo->mod ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <div class="text-sm text-gray-500 text-right">
                                            {{ \Carbon\Carbon::parse($resena->fec)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-700 mt-2">{{ $resena->des }}</p>

                                    <div class="mt-4 border-t pt-4">
                                        @if($resena->respuesta_propietario)
                                            <div class="bg-indigo-50 p-3 rounded text-sm text-indigo-900">
                                                <strong>Tu respuesta:</strong> {{ $resena->respuesta_propietario }}
                                            </div>
                                        @else
                                            <button class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold">
                                                Responder a esta reseña
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $resenas->links() }}
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-8">
                            Aún no tienes reseñas que coincidan con los filtros.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</x-page>