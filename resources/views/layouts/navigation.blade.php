<nav x-data="{ open: false }">
    <div class="px-4 sm:px-6 lg:px-8 bg-white xl:rounded-[70px]">
        <div class="flex justify-between h-16">

            {{-- LOGO --}}
            <div class="shrink-0 flex mt-3 items-center">
                <a href="{{ route('home') }}">
                    <x-breeze::application-logo class="block h-12 w-auto fill-current text-gray-800" />
                </a>
            </div>

            {{-- MENÚ --}}
            <div class="hidden space-x-2 md:-my-px md:ms-10 xl:flex">

                <x-breeze::nav-link :href="route('home')">
                    Inicio
                </x-breeze::nav-link>

                {{-- USUARIO NO AUTENTICADO --}}
                @guest
                    <x-breeze::nav-link :href="route('informacion.nosotros')">
                        Nosotros
                    </x-breeze::nav-link>

                    <x-breeze::nav-link :href="route('informacion.servicios')">
                        Servicios
                    </x-breeze::nav-link>

                    <x-breeze::nav-link href="#" x-on:click.prevent="$dispatch('open-modal', 'search-car')">
                        Alquilar
                    </x-breeze::nav-link>

                    <x-breeze::nav-link :href="route('publicacion.vehiculo')">
                        Publicar
                    </x-breeze::nav-link>

                    <x-breeze::nav-link :href="route('soporte.index')">
                        Soporte
                    </x-breeze::nav-link>
                @endguest

                {{-- USUARIO AUTENTICADO --}}
                @auth

                    <x-breeze::nav-link href="#" x-on:click.prevent="$dispatch('open-modal', 'search-car')">
                        Alquilar
                    </x-breeze::nav-link>

                    <x-breeze::nav-link :href="route('publicacion.vehiculo')">
                        Publicar
                    </x-breeze::nav-link>

                    <x-breeze::nav-link :href="route('dashboard')">
                        Dashboard
                    </x-breeze::nav-link>

                    {{-- 🔐 SOLO ADMINISTRADOR --}}
                    @role('Administrador')

                        <x-breeze::nav-link :href="route('soporte.docs.index')"
                            :active="request()->routeIs('soporte.docs.*')">
                            Documentos
                        </x-breeze::nav-link>

                        <x-breeze::nav-link :href="route('tickets.soporte.index')"
                            :active="request()->routeIs('tickets.soporte.*')">
                            Tickets
                        </x-breeze::nav-link>

                    @endrole

                @endauth

            </div>

            {{-- BUSCADOR + USUARIO --}}
            <div class="hidden xl:flex sm:items-center">

                {{-- BUSCADOR --}}
                <div class="flex items-center rounded-full px-4 ring-1 ring-gray-300 mx-2 w-48 hover:ring-dl transition-all cursor-pointer"
                    x-on:click="$dispatch('open-modal', 'search-car')">

                    <svg class="h-5 w-5 text-black" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 5.65 5.65a7.5 7.5 0 0 0 10.6 10.6Z" />
                    </svg>

                    <input type="text"
                        class="ml-2 w-full outline-none text-sm border-none focus:ring-0 cursor-pointer"
                        placeholder="Buscar..."
                        readonly>
                </div>

                @auth
                    <x-breeze::dropdown>
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 hover:text-dl">
                                {{ Auth::user()->nom }}

                                <svg class="h-4 w-4 ms-1" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293 10 12l4.707-4.707 1.414 1.414L10 14.828 3.879 8.707z" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-breeze::dropdown-link :href="route('profile.edit')">
                                Perfil
                            </x-breeze::dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-breeze::dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Cerrar sesión
                                </x-breeze::dropdown-link>
                            </form>
                        </x-slot>
                    </x-breeze::dropdown>
                @else
                    <x-breeze::dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center p-2 border border-transparent text-sm font-medium rounded-full text-white bg-black hover:text-gray-500">

                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="4 4 18 18">
                                    <path fill="#FFFFFF"
                                        d="M12 12q-1.65 0-2.825-1.175T8 8q0-1.65 1.175-2.825T12 4q1.65 0 2.825 1.175T16 8q0 1.65-1.175 2.825T12 12Zm-8 8v-2.8q0-.85.438-1.563T5.6 14.55q1.55-.775 3.15-1.163T12 13q1.65 0 3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2V20H4Zm2-2h12v-.8q0-.275-.138-.5t-.362-.35q-1.35-.675-2.725-1.012T12 15q-1.4 0-2.775.338T6.5 16.35q-.225.125-.363.35T6 17.2v.8Z" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-breeze::dropdown-link :href="route('login')">
                                Ingresar
                            </x-breeze::dropdown-link>

                            <x-breeze::dropdown-link :href="route('register')">
                                Registrarse
                            </x-breeze::dropdown-link>
                        </x-slot>
                    </x-breeze::dropdown>
                @endauth
            </div>

            {{-- MENÚ MÓVIL --}}
            <div class="-me-2 flex items-center xl:hidden">
                <button @click="open = ! open">☰</button>
            </div>
        </div>
    </div>

    {{-- MENÚ MÓVIL --}}
    <div x-show="open" class="xl:hidden bg-white p-4 space-y-2">

        <a href="{{ route('home') }}">Inicio</a>

        @guest
            <a href="{{ route('informacion.nosotros') }}">Nosotros</a>
            <a href="{{ route('informacion.servicios') }}">Servicios</a>

            <button x-on:click="$dispatch('open-modal', 'search-car')">
                Alquilar
            </button>

            <a href="{{ route('publicacion.vehiculo') }}">Publicar</a>
            <a href="{{ route('soporte.index') }}">Soporte</a>
        @endguest

        @auth
            <button x-on:click="$dispatch('open-modal', 'search-car')">
                Alquilar
            </button>

            <a href="{{ route('publicacion.vehiculo') }}">Publicar</a>
            <a href="{{ route('dashboard') }}">Dashboard</a>

            {{-- 🔐 SOLO ADMIN --}}
            @role('Administrador')
                <a href="{{ route('soporte.docs.index') }}">Documentos</a>
                <a href="{{ route('tickets.soporte.index') }}">Tickets</a>
            @endrole
        @endauth

        <div class="mt-4 cursor-pointer"
            x-on:click="$dispatch('open-modal', 'search-car')">
            🔍 Buscar
        </div>
    </div>

    {{-- MODALES --}}
    @include('modules.BusquedaReserva.partials.modals.search-car')
    @include('modules.BusquedaReserva.partials.modals.verification-warning')
</nav>