@foreach ($reservas as $reserva)
    @php
        $vehiculo = $reserva->vehiculo;
        $foto = $vehiculo->fotos_vehiculos->first()->ruta ?? 'https://placehold.co/600x400';
        $isAvailable = true; // Logic for availability can be added later if needed based on 'codestres' or other logic
        $statusLabel = $isAvailable ? 'Disponible' : 'No disponible'; // Just matching the mockup text for now, though it's "Mis Viajes" history
        $fechaFin = $reserva->fecfin ? \Carbon\Carbon::parse($reserva->fecfin)->format('d/m/Y') : 'N/A';
    @endphp

    <div class="bg-white border border-gray-300 rounded-md p-4 mb-4 flex flex-col md:flex-row items-center justify-between shadow-sm">
        <div class="flex items-center space-x-6 w-full md:w-auto">
            <div class="w-32 h-20 flex-shrink-0">
                <img src="{{ asset($foto) }}" alt="{{ $vehiculo->marca->nom }} {{ $vehiculo->linea->nom }}" class="w-full h-full object-contain">
            </div>
            
            <div class="flex flex-col">
                <h4 class="text-xl font-bold text-gray-900">{{ $vehiculo->marca->nom }}</h4>
                <p class="text-gray-500 text-sm">{{ $vehiculo->linea->nom }} {{ $vehiculo->mod ? $vehiculo->mod->format('Y') : '' }}</p>
            </div>
        </div>

        <div class="flex flex-col items-end mt-4 md:mt-0 space-y-2 w-full md:w-auto">
             <span class="text-gray-500 text-sm">Finalizado: {{ $fechaFin }}</span>
             
             {{-- Using a button style similar to the mockup "RENTAR" but maybe disabled or different action since it's history --}}
             <button class="bg-crimson-600 hover:bg-crimson-700 text-white font-bold py-2 px-8 rounded text-sm uppercase tracking-wider" style="background-color: #be1e2d;">
                 RENTAR DE NUEVO
             </button>
        </div>
    </div>
@endforeach
