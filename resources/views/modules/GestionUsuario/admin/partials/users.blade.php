@php
    //Traer todos los usuarios con roles ordenados por orden de creacion descendente
    use App\Models\MER\User;
    $users = User::with('roles')->orderBy('created_at', 'desc')->get();
@endphp
<x-card class="w-full p-8">

    {{-- Encabezado --}}
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-medium text-left">{{ __('Usuarios Registrados') }}</h3>
        <span class="text-sm text-gray-500">Total: {{ $users->count() }}</span>
    </div>

    {{-- Tabla agrupada por rol usando x-toggle --}}
    <div x-data="{ active: null }" class="space-y-2">

        @php
            $roles = ['Usuario', 'Administrador', 'Soporte'];
        @endphp

        @foreach ($roles as $rolNombre)
            @php
                $grupo = $users->filter(fn($u) => $u->hasRole($rolNombre));
            @endphp

            <x-toggle :title="$rolNombre . ' (' . $grupo->count() . ')'">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y text-gray-500">
                        <thead class="bg-gray-200 text-xs font-medium uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left">Nombre</th>
                                <th class="px-4 py-2 text-left">Apellido</th>
                                <th class="px-4 py-2 text-left">Correo</th>
                                <th class="px-4 py-2 text-left">Registrado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 text-sm">
                            @forelse ($grupo as $usuario)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $usuario->id }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $usuario->nom }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $usuario->ape }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-gray-500">{{ $usuario->email }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap text-gray-400">
                                        {{ \Carbon\Carbon::parse($usuario->created_at)->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-400">
                                        No hay usuarios con rol {{ $rolNombre }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-toggle>

        @endforeach

    </div>
</x-card>