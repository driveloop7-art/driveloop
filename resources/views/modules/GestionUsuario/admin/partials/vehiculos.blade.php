@php
    use App\Models\MER\Vehiculo;
    use App\Models\MER\Marca;
    use App\Models\MER\Linea;
    use App\Models\MER\User;
    use App\Models\MER\Clase;

    
    // Obtener parámetros de filtro
    $fMarca = request('marca');
    $fClase = request('clase');
    $fColor = request('color');

    // Cargar opciones para los selects (Necesario para el formulario de filtro)
    $opcionesMarcas = Marca::orderBy('des')->get();
    $opcionesClases = Clase::orderBy('des')->get();

    // Query de vehículos con filtros
    $query = Vehiculo::query()
        ->where('disp', 1);

    if ($fMarca) {
        $query->where('codmar', $fMarca);
    }

    if ($fClase) {
        $query->where('codcla', $fClase);
    }

    if ($fColor) {
        $query->where('col', 'like', '%' . $fColor . '%');
    }

    $vehiculos = $query->get();
@endphp

<x-card class="w-full p-8">

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium text-left">{{ __('Vehículos Registrados') }}</h3>
        <span class="text-sm text-gray-500">Total: {{ $vehiculos->count() }}</span>
    </div>

    
    {{-- Filtro --}}
    <div class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-100 flex justify-center">
        <form action="{{ url()->current() }}" method="GET" class="flex flex-col md:flex-row md:items-end justify-center gap-4 md:gap-6 w-full max-w-6xl">
            {{-- Campo oculto para mantener la pestaña activa --}}
            <input type="hidden" name="tab" value="vehiculos">

            <div class="w-full md:w-48">
                <label for="marca" class="block text-xs font-medium text-gray-500 uppercase mb-2">Marca</label>
                <select name="marca" id="marca" class="w-full rounded-lg border-gray-300 text-sm focus:ring-red-500 focus:border-red-500">
                    <option value="">Todas</option>
                    @foreach($opcionesMarcas as $opcMarca)
                        <option value="{{ $opcMarca->cod }}" {{ $fMarca == $opcMarca->cod ? 'selected' : '' }}>
                            {{ $opcMarca->des }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-48">
                <label for="clase" class="block text-xs font-medium text-gray-500 uppercase mb-2">Clase</label>
                <select name="clase" id="clase" class="w-full rounded-lg border-gray-300 text-sm focus:ring-red-500 focus:border-red-500">
                    <option value="">Todas</option>
                    @foreach($opcionesClases as $opcClase)
                        <option value="{{ $opcClase->cod }}" {{ $fClase == $opcClase->cod ? 'selected' : '' }}>
                            {{ $opcClase->des }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full md:w-48">
                <label for="color" class="block text-xs font-semibold text-gray-500 uppercase mb-2">Color</label>
                <input type="text" name="color" id="color" value="{{ $fColor }}" placeholder="Ej: Rojo, Gris..." 
                    class="w-full rounded-lg border-gray-300 text-sm focus:ring-red-500 focus:border-red-500">
            </div>

            {{-- botones de filtrar y limpiar --}}
            <div class="flex flex-col xl:flex-row gap-3 items-center w-full md:w-auto mt-2 md:mt-0">
                <x-button type="primary" class="w-full sm:w-auto !py-3 !px-10 text-base h-[38px] flex justify-center items-center">
                    FILTRAR
                </x-button>
                <a href="{{ url()->current() }}?tab=vehiculos" 
                   class="inline-flex justify-center items-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 w-full sm:w-auto h-[38px]">
                    Limpiar
                </a>
            </div>
        </form>
    </div>
 {{-- Filtro --}}




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
                    <th class="px-4 py-2 text-left">Acciones</th>
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
                        <td class="px-4 py-2 whitespace-nowrap flex gap-2">
                            {{-- Editar información --}}
                            <a href="{{ route('vehiculos.edit', $vehiculo->cod) }}"
                                class="px-3 py-1 text-xs bg-red-700 text-white rounded hover:bg-red-800 transition">
                                Editar
                            </a>
                            {{-- Modificar documentos --}}
                            {{-- <a href="{{ route('vehiculos.doc.create', $vehiculo->cod) }}"
                                class="px-3 py-1 text-xs bg-gray-800 text-white rounded hover:bg-gray-900 transition">
                                Documentos
                            </a> --}}
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
