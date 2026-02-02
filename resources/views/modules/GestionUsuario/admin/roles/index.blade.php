<x-page class="py-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-dl">Gestión de Roles y Permisos</h1>
        <p class="text-gray-500 mt-2">Administra los roles del sistema y define qué puede hacer cada uno.</p>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-green-700 bg-green-100 rounded-lg shadow-sm border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($roles as $role)
            <x-card class="bg-white p-6 shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $role->name }}</h2>
                        <span class="text-xs font-mono text-gray-400">Guard: {{ $role->guard_name }}</span>
                    </div>
                    <div class="bg-dl-light bg-opacity-10 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-dl" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-600">
                        Este rol cuenta con <span class="font-bold text-dl">{{ $role->permissions->count() }}</span> permisos asignados.
                    </p>
                </div>

                <div class="mt-auto">
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="block w-full">
                        <x-button type="primary" class="w-full text-sm py-2">
                            Gestionar Permisos
                        </x-button>
                    </a>
                </div>
            </x-card>
        @endforeach

        {{-- Tarjeta informativa para nuevos permisos --}}
        <x-card class="bg-gray-50 p-6 border-dashed border-2 border-gray-300 flex flex-col justify-center items-center text-center">
            <div class="text-gray-400 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-gray-600 font-medium">¿Necesitas nuevos permisos?</h3>
            <p class="text-xs text-gray-500 mt-2 px-4">
                Puedes agregar nuevos permisos desde la terminal usando Tinker o agregándolos al `RolesAndPermissionsSeeder` y ejecutándolo de nuevo.
            </p>
        </x-card>
    </div>
</x-page>
