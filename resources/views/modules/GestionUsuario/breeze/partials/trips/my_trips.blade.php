@php
    use App\Models\MER\Vehiculo;
    use App\Models\MER\FotoVehiculo;
    use App\Models\MER\Marca;
    use App\Models\MER\Linea;
@endphp

@foreach ($reservas as $reserva)
    @php
        $vehiculo = Vehiculo::find($reserva->codveh);
        $fotoObj = FotoVehiculo::where('codveh', $vehiculo->cod)->first();
        $foto = $fotoObj ? $fotoObj->ruta : 'https://placehold.co/600x400';
        $marca = Marca::find($vehiculo->codmar);
        $linea = Linea::find($vehiculo->codlin);
        
        $isAvailable = true; 
        $statusLabel = $isAvailable ? 'Disponible' : 'No disponible'; 
        $fechaFin = $reserva->fecfin ? \Carbon\Carbon::parse($reserva->fecfin)->format('d/m/Y') : 'N/A';
    @endphp

    <div class="bg-white border border-gray-300 rounded-md p-4 mb-4 flex flex-col md:flex-row items-center justify-between shadow-sm">
        <div class="flex items-center space-x-6 w-full md:w-auto">
            <div class="w-32 h-20 flex-shrink-0">
                <img src="{{ asset($foto) }}" alt="{{ $marca->des }} {{ $linea->des }}" class="w-full h-full object-contain">
            </div>
            
            <div class="flex flex-col">
                <h4 class="text-xl font-bold text-gray-900">{{ $marca->des }}</h4>
                <p class="text-gray-500 text-sm">{{ $linea->des }} {{ $vehiculo->mod ?? '' }}</p>
            </div>
        </div>

        <div class="flex flex-col items-end mt-4 md:mt-0 space-y-2 w-full md:w-auto">
             <span class="text-gray-500 text-sm">Finalizado: {{ $fechaFin }}</span>
             
             <button class="bg-crimson-600 hover:bg-crimson-700 text-white font-bold py-2 px-8 rounded text-sm uppercase tracking-wider" style="background-color: #be1e2d;">
                 RENTAR DE NUEVO
             </button>
        </div>
    </div>
@endforeach