<x-page class="py-4">
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs text-gray-500">
                    <li><a href="{{ route('admin.roles.index') }}" class="hover:text-dl">Roles</a></li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"></path></svg>
                            <span class="text-gray-400">{{ $role->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="text-2xl font-bold text-dl">Editar Permisos: {{ $role->name }}</h1>
            <p class="text-gray-500 text-sm mt-1">Selecciona los permisos que deseas asignar a este rol.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('admin.roles.index') }}">
                <x-button type="tertiary" class="text-sm">
                    Volver al listado
                </x-button>
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="p-4 mb-6 text-red-700 bg-red-100 rounded-lg border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 gap-8">
            @foreach($permissions as $module => $modulePermissions)
                <x-card class="bg-white p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center mb-6 border-b border-gray-50 pb-3">
                        <div class="bg-dl bg-opacity-10 p-2 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-dl" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-700">Módulo: {{ $module }}</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($modulePermissions as $permission)
                            <label class="flex items-center p-3 rounded-xl border border-gray-50 hover:bg-gray-50 transition-colors cursor-pointer group">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                                        class="w-5 h-5 text-dl border-gray-300 rounded focus:ring-dl focus:ring-opacity-25"
                                        {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                </div>
                                <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 font-medium">
                                    {{ str_replace($module . '.', '', $permission->name) }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </x-card>
            @endforeach
        </div>

        <div class="mt-8 mb-12 flex justify-end">
            <x-button type="primary" class="px-12 py-3 shadow-lg shadow-dl/20">
                Guardar Cambios
            </x-button>
        </div>
    </form>
</x-page>
