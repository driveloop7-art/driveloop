{{-- La consulta muestra solo los vehiculos que tienen los 3 documentos aprobados, 
los vehiculos que se crean a partir de factory o seeders no se van a mostrar porque no se realiza 
correspondiente el proceso de creacion de vehiculo. --}}
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
        ->with(['marca', 'linea', 'clase', 'fotos_vehiculos'])
        ->orderByDesc('cod')
        ->get();
@endphp

{{-- No alterar esta linea la cual se implementa para evitar el parpadeo --}}
<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<x-card class="w-full p-8">
    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium text-left">{{ __('Vehículos Registrados') }}</h3>
        <span class="text-sm text-gray-500">Total: {{ $vehiculos->count() }}</span>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y text-gray-500">
            <thead class="bg-gray-200 text-xs font-medium uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Marca</th>
                    <th class="px-4 py-2 text-left">Linea</th>
                    <th class="px-4 py-2 text-left">Color</th>
                    <th class="px-4 py-2 text-left">Acciones</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($vehiculos as $vehiculo)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->cod }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->marca->des ?? '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->linea->des ?? '-' }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->col ?? '-' }}</td>

                        <td class="px-4 py-2 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                {{-- modal --}}
                                @include('modules.PublicacionVehiculo.components.tarjInforVeh')

                                <form action="{{ route('vehiculos.destroy', $vehiculo->cod) }}" method="POST"
                                    class="inline-block m-0"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este vehículo? Esta acción eliminará fotos, documentos y no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">
                                        Eliminar
                                    </button>
                                </form>
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
