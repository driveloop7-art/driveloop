<h3 class="text-lg font-medium mb-6 text-left">{{ __('Filtros') }}</h3>
<form action="{{ route('tickets.soporte.index') }}" method="GET"
    class="mb-8 bg-gray-50 p-6  border border-gray-200 xl:rounded-md">
    <div @class(['grid grid-cols-1 lg:grid-cols-2 gap-4 items-end', Auth::user()->hasRole('Administrador') ? 'xl:grid-cols-4' : 'xl:grid-cols-3'])>
        <div>
            <label for="codigo"
                class="block text-sm font-medium text-gray-700 mb-1">{{ __('Código de Ticket') }}</label>
            <input type="text" name="codigo" id="codigo" value="{{ request('codigo') }}"
                placeholder="{{ __('Ej: A1B2C3D4E5') }}"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        @if (Auth::user()->hasRole('Administrador'))
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select name="estado" id="estado"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Todos los estados</option>
                    @foreach($estados as $estado)
                        <option value="{{ $estado->cod }}" {{ request('estado') == $estado->cod ? 'selected' : '' }}>
                            {{ $estado->des }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        <div>
            <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha de creación</label>
            <input type="date" name="fecha" id="fecha" value="{{ request('fecha') }}"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        </div>
        <div>
            <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-1">Prioridad</label>
            <select name="prioridad" id="prioridad"
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Todas las prioridades</option>
                @foreach($prioridades as $prioridad)
                    <option value="{{ $prioridad->cod }}" {{ request('prioridad') == $prioridad->cod ? 'selected' : '' }}>
                        {{ $prioridad->des }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="sm:flex sm:gap-2">
            <x-button class="h-[38px] w-full">{{ __('Filtrar') }}</x-button>
            <a href="{{ route('tickets.soporte.index') }}"
                class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium xl:rounded-md text-gray-700 bg-white hover:bg-gray-50 w-full mt-2 sm:mt-0">
                {{ __('Limpiar') }}
            </a>
        </div>
    </div>
</form>