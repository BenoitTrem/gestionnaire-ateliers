<!-- @author Benoit Tremblay -->
<nav class="bg-white border-b border-gray-100 ">
    <!-- Primary Navigation Menu -->
    <nav class="menu">
        <div class="flex w-full justify-between h-16">
            <div class="flex items-center gap-x-4">
                <!-- Logo -->
                <section class="image-logo-menu w-16 h-16 flex-shrink-0 items-start ml-7"></section>
                <div class="flex flex-col items-center text-center">
                    <div class="nav-titre">
                        SSHCO 2025
                    </div>
                    <div class="nav-titre-2">
                        Cahier de la programmation
                    </div>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-14 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="nav-link">
                        {{ __('Accueil') }}
                    </x-nav-link>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex ">
                    <x-nav-link :href="route('horaires.index')" :active="request()->routeIs('horaires.index')" class="nav-link">
                        {{ __('Horaire') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('ateliers.index')" :active="request()->routeIs('ateliers.index')" class="nav-link">
                        {{ __('Ateliers') }}
                    </x-nav-link>

                </div>
                @canAny(['organisateur', 'estAdmin'])
                <div class="hidden space-x-8  sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('animateurs.index')" :active="request()->routeIs('animateurs.index')" class="nav-link">
                        {{ __('Animateurs') }}
                    </x-nav-link>
                </div>
                @endcan
                @canAny(['organisateur', 'estAdmin'])
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('locaux.index')" :active="request()->routeIs('locaux.index')" class="nav-link">
                            {{ __('Locaux') }}
                        </x-nav-link>
                    </div>
                @endcan
                @canAny(['organisateur', 'estAdmin'])
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <x-nav-link :href="route('profile.index')" :active="request()->routeIs('profile.index')" class="nav-link">
                            {{ __('Utilisateur') }}
                        </x-nav-link>
                    </div>
                @endcan
            </div>
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center mr-24">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="profile-container flex justify-start items-center">
                            @if(Auth::check())
                                <div>{{ Auth::user()->prenom }}</div>
                            @else
                                <div>Invité</div>
                            @endif

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault();
                             localStorage.removeItem('loggedInAlert_' + '{{ Auth::id() }}');
                             sessionStorage.removeItem('loggedInAlert_' + '{{ Auth::id() }}');
                             this.closest('form').submit();">
                                {{ __('Se déconnecter') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>


            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>

        <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Accueil') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('horaires.index')" :active="request()->routeIs('horaires.index')" class="nav-link">
                    {{ __('Horaire') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('ateliers.index')" :active="request()->routeIs('ateliers.index')" class="nav-link">
                    {{ __('Ateliers') }}
                </x-responsive-nav-link>

                @canAny(['organisateur', 'estAdmin'])
                    <x-responsive-nav-link :href="route('animateurs.index')" :active="request()->routeIs('animateurs.index')" class="nav-link">
                        {{ __('Animateurs') }}
                    </x-responsive-nav-link>

                @endcan
                @canAny(['organisateur', 'estAdmin'])
                    <x-responsive-nav-link :href="route('locaux.index')" :active="request()->routeIs('locaux.index')" class="nav-link">
                        {{ __('Locaux') }}
                    </x-responsive-nav-link>
                @endcan
                @canAny(['organisateur', 'estAdmin'])
                    <x-responsive-nav-link :href="route('profile.index')" :active="request()->routeIs('profile.index')" class="nav-link">
                        {{ __('Utilisateur') }}
                    </x-responsive-nav-link>
                @endcan
            </div>
            <div class="pt-4 border-t border-gray-200">
                @if(Auth::check())
                    <div class="px-4 font-medium">{{ Auth::user()->name }}</div>
                @endif
                <div class="mt-2 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profil') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Se déconnecter') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</nav>
