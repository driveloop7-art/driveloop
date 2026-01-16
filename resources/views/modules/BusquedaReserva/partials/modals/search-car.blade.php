@vite('resources/js/validar_fecha_busqueda.js')
<x-modal class="xl:max-w-6xl" name="search-car" title="Buscar Vehículo" focusable>
    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            background: transparent;
            color: transparent;
            cursor: pointer;
            position: absolute;
            width: 6rem;
            height: 1rem;
        }
    </style>
    <!-- Contenido del Formulario -->
    <form action="{{ route('busqueda.reserva')}}" method="POST"
        class="flex flex-col xl:flex-row justify-between px-8 gap-4" id="search-car-form">
        @csrf
        <!-- Marca -->
        <x-card class="p-[6px] min-w-36 h-[52px]">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Marca</label>
            <div class="flex items-center justify-between">
                <select
                    class="w-full border-none p-0 text-gray-700 font-medium text-sm focus:ring-0 bg-transparent cursor-pointer appearance-none bg-none"
                    name="marca">
                    <option value="">Seleccione marca</option>
                    @foreach($marcas as $marca)
                        <option value="{{ $marca->cod }}">{{ $marca->des }}</option>
                    @endforeach
                </select>
                <svg class="w-3 h-3 text-dl" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </x-card>

        <!-- Fecha y hora de recogida -->
        <x-card class="p-[6px] min-w-52 h-[52px]">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Fecha y hora de
                recogida</label>
            <div class="flex items-center text-gray-700">
                <svg class="w-4 h-4 text-dl mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <input type="date" name="pickup_date"
                    class="border-none p-0 text-sm focus:ring-0 text-gray-700 bg-transparent w-24" required>
                <span class="text-gray-300 mx-3">|</span>
                <select name="pickup_time"
                    class="border-none p-0 text-sm focus:ring-0 text-gray-700 bg-transparent cursor-pointer appearance-none bg-none w-16">
                    <option>6:00 am</option>
                    <option>6:30 am</option>
                    <option>7:00 am</option>
                    <option>7:30 am</option>
                    <option>8:00 am</option>
                    <option>8:30 am</option>
                    <option>9:00 am</option>
                    <option>9:30 am</option>
                    <option>10:00 am</option>
                    <option>10:30 am</option>
                    <option>11:00 am</option>
                    <option>11:30 am</option>
                    <option>12:00 pm</option>
                    <option>12:30 pm</option>
                    <option>1:00 pm</option>
                    <option>1:30 pm</option>
                    <option>2:00 pm</option>
                    <option>2:30 pm</option>
                    <option>3:00 pm</option>
                    <option>3:30 pm</option>
                    <option>4:00 pm</option>
                    <option>4:30 pm</option>
                    <option>5:00 pm</option>
                    <option>5:30 pm</option>
                    <option>6:00 pm</option>
                    <option>6:30 pm</option>
                    <option>7:00 pm</option>
                </select>
                <svg class="w-3 h-3 text-dl ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </x-card>

        <!-- Fecha y hora de entrega -->
        <x-card class="p-[6px] min-w-52 h-[52px]">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Fecha y hora de
                entrega</label>
            <div class="flex items-center text-gray-700">
                <svg class="w-4 h-4 text-dl mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <input type="date" name="return_date"
                    class="border-none p-0 text-sm focus:ring-0 text-gray-700 bg-transparent w-24" required>
                <span class="text-gray-300 mx-3">|</span>
                <select name="return_time"
                    class="border-none p-0 text-sm focus:ring-0 text-gray-700 bg-transparent cursor-pointer appearance-none bg-none w-16">
                    <option>6:00 am</option>
                    <option>6:30 am</option>
                    <option>7:00 am</option>
                    <option>7:30 am</option>
                    <option>8:00 am</option>
                    <option>8:30 am</option>
                    <option>9:00 am</option>
                    <option>9:30 am</option>
                    <option>10:00 am</option>
                    <option>10:30 am</option>
                    <option>11:00 am</option>
                    <option>11:30 am</option>
                    <option>12:00 pm</option>
                    <option>12:30 pm</option>
                    <option>1:00 pm</option>
                    <option>1:30 pm</option>
                    <option>2:00 pm</option>
                    <option>2:30 pm</option>
                    <option>3:00 pm</option>
                    <option>3:30 pm</option>
                    <option>4:00 pm</option>
                    <option>4:30 pm</option>
                    <option>5:00 pm</option>
                    <option>5:30 pm</option>
                    <option>6:00 pm</option>
                    <option>6:30 pm</option>
                    <option>7:00 pm</option>
                </select>
                <svg class="w-3 h-3 text-dl ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </x-card>

        <!-- Capacidad -->
        <x-card class="p-[6px] min-w-20 h-[52px]">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Capacidad</label>
            <div class="flex items-center">
                <svg class="w-4 h-4 xl:w-7 xl:h-7 text-dl mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <select name="capacity"
                    class="w-full border-none p-0 text-gray-700 font-medium text-sm focus:ring-0 bg-transparent cursor-pointer appearance-none bg-none">
                    <option value="2">2</option>
                    <option value="4" selected>4</option>
                    <option value="5">5</option>
                    <option value="7">7+</option>
                </select>
                <svg class="w-3 h-3 text-dl ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </x-card>

        <!-- Rango de precio -->
        <x-card class="p-[6px] min-w-24 h-[52px]">
            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Rango de
                precio</label>
            <div class="flex items-center justify-between">
                <select name="price_range"
                    class="w-full border-none p-0 text-gray-700 font-medium text-sm focus:ring-0 bg-transparent cursor-pointer appearance-none bg-none">
                    <option value="">Precio</option>
                    <option value="0-100000">$0 - $100k</option>
                    <option value="100000-200000">$100k - $200k</option>
                    <option value="200000-300000">$200k - $300k</option>
                    <option value="300000+">$300k+</option>
                </select>
                <svg class="w-3 h-3 text-dl ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </x-card>

        <!-- Botón Buscar -->
        <div class="mt-3 xl:mt-0 flex justify-end">
            <x-button class="text-xs xl:text-[16px] xl:pt-[16px]">{{ __('Search') }}</x-button>
        </div>
    </form>
</x-modal>