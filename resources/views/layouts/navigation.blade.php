<nav x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8 bg-white xl:rounded-[70px]">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="shrink-0 flex mt-3 items-center">
                <a href="/">
                    <x-breeze::application-logo class="block h-12 w-auto fill-current text-gray-800" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-2 md:-my-px md:ms-10 xl:flex">
                @auth
                    <x-breeze::nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-breeze::nav-link>
                @endauth
                <!-- PROVISIONAL -->
                <x-breeze::nav-link :href="route('calificacion.resena')"
                    :active="request()->routeIs('calificacion.resena')">
                    {{ __('Reseñas') }}
                </x-breeze::nav-link>
                <x-breeze::nav-link :href="route('contrato.garantia')"
                    :active="request()->routeIs('contrato.garantia')">
                    {{ __('Contratos') }}
                </x-breeze::nav-link>
                <x-breeze::nav-link :href="route('gestion.usuario')" :active="request()->routeIs('gestion.usuario')">
                    {{ __('Usuarios') }}
                </x-breeze::nav-link>
                <x-breeze::nav-link :href="route('pago.digital')" :active="request()->routeIs('pago.digital')">
                    {{ __('Pagos') }}
                </x-breeze::nav-link>
                <x-breeze::nav-link :href="route('publicacion.vehiculo')"
                    :active="request()->routeIs('publicacion.vehiculo')">
                    {{ __('Vehiculos') }}
                </x-breeze::nav-link>
                <!-- ========== -->
                <x-breeze::nav-link :href="route('soporte.index')" :active="request()->routeIs('soporte.index')">
                    {{ __('Soporte') }}
                </x-breeze::nav-link>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden xl:flex sm:items-center">

                <div class="flex items-center rounded-full px-4 ring-1 ring-gray-300 mx-2 w-48 hover:ring-dl transition-all cursor-pointer"
                    x-on:click="$dispatch('open-modal', 'search-modal')">
                    <svg class="h-5 w-5 text-black" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 5.65 5.65a7.5 7.5 0 0 0 10.6 10.6Z" />
                    </svg>
                    <input type="text" class="ml-2 w-full outline-none text-sm border-none focus:ring-0 cursor-pointer"
                        placeholder="Buscar..." readonly>
                </div>

                @auth
                    <x-breeze::dropdown>
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 hover:text-dl focus:outline-none focus:text-dl transition ease-in-out duration-150">
                                <div>{{ Auth::user()->nom }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-breeze::dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-breeze::dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-breeze::dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-breeze::dropdown-link>
                            </form>
                        </x-slot>
                    </x-breeze::dropdown>
                @else
                    <x-breeze::dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-full text-white bg-black hover:text-gray-500 focus:outline-none transition ease-in-out duration-150">
                                <div class="ms-1">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="4 4 18 18">
                                        <path fill="#FFFFFF"
                                            d="M12 12q-1.65 0-2.825-1.175T8 8q0-1.65 1.175-2.825T12 4q1.65 0 2.825 1.175T16 8q0 1.65-1.175 2.825T12 12Zm-8 8v-2.8q0-.85.438-1.563T5.6 14.55q1.55-.775 3.15-1.163T12 13q1.65 0 3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2V20H4Zm2-2h12v-.8q0-.275-.138-.5t-.362-.35q-1.35-.675-2.725-1.012T12 15q-1.4 0-2.775.338T6.5 16.35q-.225.125-.363.35T6 17.2v.8Zm6-8q.825 0 1.413-.588T14 8q0-.825-.588-1.413T12 6q-.825 0-1.413.588T10 8q0 .825.588 1.413T12 10Zm0-2Zm0 10Z" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-breeze::dropdown-link :href="route('login')">
                                {{ __('Log in') }}
                            </x-breeze::dropdown-link>
                            <x-breeze::dropdown-link :href="route('register')">
                                {{ __('Register') }}
                            </x-breeze::dropdown-link>
                        </x-slot>
                    </x-breeze::dropdown>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center xl:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-500 hover:gray-100 focus:outline-none focus:text-dl transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden xl:hidden bg-white/80">

        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-breeze::responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-breeze::responsive-nav-link>
            @endauth
            <x-breeze::responsive-nav-link :href="route('soporte.index')"
                :active="request()->routeIs('soporte-comunicacion')">
                {{ __('Soporte') }}
            </x-breeze::responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="py-1">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->nom }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-breeze::responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-breeze::responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-breeze::responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-breeze::responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-breeze::responsive-nav-link :href="route('login')">
                        {{ __('Log in') }}
                    </x-breeze::responsive-nav-link>
                    <x-breeze::responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-breeze::responsive-nav-link>
                </div>
            @endauth

            <!-- Barra de busqueda -->
            <div class="flex items-center bg-white rounded-full px-4 ring-1 ring-gray-300 my-5 mx-8">
                <svg class="h-5 w-5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 5.65 5.65a7.5 7.5 0 0 0 10.6 10.6Z" />
                </svg>
                <input type="text" class="ml-2 w-full outline-none text-sm border-none focus:ring-0"
                    placeholder="Buscar...">
            </div>

        </div>
    </div>
    <!-- Search Modal -->
    <x-modal class="xl:max-w-6xl" name="search-modal" title="Buscar Vehículo" focusable >
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
        <form action="#" method="GET" class="flex flex-col xl:flex-row gap-4 justify-between">
            <!-- Marca -->
            <x-card class="p-[6px] min-w-36">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Marca</label>
                <div class="flex items-center justify-between">
                    <select class="w-full border-none p-0 text-gray-700 font-medium text-sm focus:ring-0 bg-transparent cursor-pointer appearance-none bg-none">
                        <option value="">Seleccione marca</option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca->cod }}">{{ $marca->des }}</option>
                        @endforeach
                    </select>
                    <svg class="w-3 h-3 text-dl" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </x-card>

            <!-- Fecha y hora de recogida -->
            <x-card class="p-[6px] min-w-52">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Fecha y hora de recogida</label>
                <div class="flex items-center text-gray-700">
                    <svg class="w-4 h-4 text-dl mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <input type="date" name="pickup_date" class="border-none p-0 text-sm focus:ring-0 text-gray-700 bg-transparent w-24" required>
                    <span class="text-gray-300 mx-3">|</span>
                    <select name="pickup_time" class="border-none p-0 text-sm focus:ring-0 text-gray-700 bg-transparent cursor-pointer appearance-none bg-none w-16">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </x-card>

            <!-- Fecha y hora de entrega -->
            <x-card class="p-[6px] min-w-52">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Fecha y hora de entrega</label>
                <div class="flex items-center text-gray-700">
                    <svg class="w-4 h-4 text-dl mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <input type="date" name="return_date" class="border-none p-0 text-sm focus:ring-0 text-gray-700 bg-transparent w-24" required>
                    <span class="text-gray-300 mx-3">|</span>
                    <select name="return_time" class="border-none p-0 text-sm focus:ring-0 text-gray-700 bg-transparent cursor-pointer appearance-none bg-none w-16">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </x-card>
            
            <!-- Capacidad -->
            <x-card class="p-[6px] min-w-20">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Capacidad</label>
                <div class="flex items-center">
                    <svg class="w-4 h-4 xl:w-7 xl:h-7 text-dl mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <select name="capacity" class="w-full border-none p-0 text-gray-700 font-medium text-sm focus:ring-0 bg-transparent cursor-pointer appearance-none bg-none">
                        <option value="2">2</option>
                        <option value="4" selected>4</option>
                        <option value="5">5</option>
                        <option value="7">7+</option>
                    </select>
                    <svg class="w-3 h-3 text-dl ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </x-card>

            <!-- Rango de precio -->
            <x-card class="p-[6px] min-w-24">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Rango de precio</label>
                <div class="flex items-center justify-between">
                    <select name="price_range" class="w-full border-none p-0 text-gray-700 font-medium text-sm focus:ring-0 bg-transparent cursor-pointer appearance-none bg-none">
                        <option value="">Precio</option>
                        <option value="0-100000">$0 - $100k</option>
                        <option value="100000-200000">$100k - $200k</option>
                        <option value="200000-300000">$200k - $300k</option>
                        <option value="300000+">$300k+</option>
                    </select>
                    <svg class="w-3 h-3 text-dl ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </x-card>

            <!-- Botón Buscar -->
            <div class="mt-3 xl:mt-0 flex justify-end text-md">
                <x-button class="xl:pt-[17px]" width="full">{{ __('Search') }}</x-button>
            </div>
        </form>
            
    </x-modal>
</nav>
