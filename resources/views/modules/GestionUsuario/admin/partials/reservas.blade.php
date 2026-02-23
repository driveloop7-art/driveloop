@php
    use App\Models\MER\Reserva;
    use App\Models\MER\Vehiculo;
    use App\Models\MER\User;
    use App\Models\MER\Marca;
    use App\Models\MER\Linea;
    use App\Models\MER\EstadoReserva;
    $reservas = Reserva::orderBy('cod', 'asc')->get();
@endphp
<x-card class="w-full p-8">

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium text-left">{{ __('Reservas') }}</h3>
        <span class="text-sm text-gray-500">Total: {{ $reservas->count() }}</span>
    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y text-gray-500">
            <thead class="bg-gray-200 text-xs font-medium uppercase tracking-wider">
                <tr>
                    <th class="px-4 py-2 text-left">ID</th>
                    <th class="px-4 py-2 text-left">Vehículo</th>
                    <th class="px-4 py-2 text-left">Usuario</th>
                    <th class="px-4 py-2 text-left">Fecha Creación</th>
                    <th class="px-4 py-2 text-left">Fecha Inicio</th>
                    <th class="px-4 py-2 text-left">Fecha Fin</th>
                    <th class="px-4 py-2 text-left">Estado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse ($reservas as $reserva)
                    @php
                        $vehiculo = Vehiculo::find($reserva->codveh);
                        $usuario = User::find($reserva->idusu);
                        $marca = Marca::find($vehiculo->codmar);
                        $linea = Linea::find($vehiculo->codlin);
                        $estado = EstadoReserva::find($reserva->codestres);
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-2 whitespace-nowrap">{{ $reserva->cod }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $marca->des }} {{ $linea->des }} {{ $vehiculo->mod }}
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $usuario->nom }} {{ $usuario->ape }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $reserva->fecrea }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $reserva->fecini }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $reserva->fecfin }}</td>
                        <td class="px-4 py-2 whitespace-nowrap">{{ $estado->des }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-400">
                            No hay reservas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-card>