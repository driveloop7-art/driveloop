<nav x-data="{ open: false }" class="min-w-[15rem]">
    <!-- Primary Navigation Menu -->
    <div class="px-4 sm:px-6 lg:px-8 bg-white sm:rounded-[70px]">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex mt-3 items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-breeze::application-logo class="block h-12 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                @auth
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-breeze::nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-breeze::nav-link>
                    </div>
                @endauth
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <div class="flex items-center bg-white rounded-full px-4 ring-1 ring-gray-300 lg:w-[17rem] my-8 mx-8">
                    <svg class="h-5 w-5 text-black" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 5.65 5.65a7.5 7.5 0 0 0 10.6 10.6Z" />
                    </svg>
                    <input type="text" class="ml-2 w-full outline-none text-sm border-none focus:ring-0" placeholder="Buscar...">
                </div>

                @auth
                    <x-breeze::dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->nom }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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

                                <x-breeze::dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-breeze::dropdown-link>
                            </form>
                        </x-slot>
                    </x-breeze::dropdown>
                @else
                    <x-breeze::dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-full text-white bg-black hover:text-gray-500 focus:outline-none transition ease-in-out duration-150">
                                <div class="ms-1">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="4 4 18 18"><path fill="#FFFFFF" d="M12 12q-1.65 0-2.825-1.175T8 8q0-1.65 1.175-2.825T12 4q1.65 0 2.825 1.175T16 8q0 1.65-1.175 2.825T12 12Zm-8 8v-2.8q0-.85.438-1.563T5.6 14.55q1.55-.775 3.15-1.163T12 13q1.65 0 3.25.388t3.15 1.162q.725.375 1.163 1.088T20 17.2V20H4Zm2-2h12v-.8q0-.275-.138-.5t-.362-.35q-1.35-.675-2.725-1.012T12 15q-1.4 0-2.775.338T6.5 16.35q-.225.125-.363.35T6 17.2v.8Zm6-8q.825 0 1.413-.588T14 8q0-.825-.588-1.413T12 6q-.825 0-1.413.588T10 8q0 .825.588 1.413T12 10Zm0-2Zm0 10Z"/></svg>
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
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white/80">
            
        @auth
            <div class="pt-2 pb-3 space-y-1">
                <x-breeze::responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-breeze::responsive-nav-link>
            </div>
        @endauth
        <!-- Responsive Settings Options -->
        <div class="pt-1 pb-1">
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

                        <x-breeze::responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
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
                <svg class="h-5 w-5 text-black" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 5.65 5.65a7.5 7.5 0 0 0 10.6 10.6Z" />
                </svg>
                <input type="text" class="ml-2 w-full outline-none text-sm border-none focus:ring-0" placeholder="Buscar...">
            </div>
            
        </div>
    </div>
</nav>
