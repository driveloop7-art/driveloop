@php
    //Traer todos los usuarios con roles ordenados por orden de creacion descendente
    use App\Models\MER\Vehiculo;
    use App\Models\MER\Marca;
    use App\Models\MER\Linea;
    use App\Models\MER\User;
    use App\Models\MER\Clase;
    $vehiculos = Vehiculo::orderBy('codmar', 'asc')->get();
@endphp
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
                    <th class="px-4 py-2 text-left">Modelo</th>
                    <th class="px-4 py-2 text-left">Clase</th>
                    <th class="px-4 py-2 text-left">Color</th>
                    <th class="px-4 py-2 text-left">Propietario</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($vehiculos as $vehiculo)
                    @php
                        $marca = Marca::find($vehiculo->codmar);
                        $linea = Linea::find($vehiculo->codlin);
                        $usuario = User::find($vehiculo->user_id);
                        $clase = Clase::find($vehiculo->codcla);
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->cod }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $marca->des }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $linea->des }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->mod }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $clase->des }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $vehiculo->col }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $usuario->nom }} {{ $usuario->ape }}</td>
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