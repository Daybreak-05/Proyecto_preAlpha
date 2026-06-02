<nav x-data="{ open: false }" class="relative z-20 border-b border-white/10 bg-slate-950/95 text-white shadow-[0_10px_30px_-18px_rgba(15,23,42,.85)] backdrop-blur-xl">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('index') }}">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-10 w-10 rounded-xl object-cover ring-1 ring-white/10 shadow-lg">
                            <div class="leading-tight">
                                <div class="text-xs uppercase tracking-[0.3em] text-emerald-300/80">Sistema</div>
                                <div class="text-lg font-black tracking-wide text-white">UBIKA</div>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:ms-10">
                    <a href="{{ route('index') }}" class="text-sm font-semibold text-slate-300 transition hover:text-white">
                        Tienda
                    </a>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/10 focus:outline-none">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-400/15 text-emerald-300 font-bold">{{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}</span>
                            <div class="text-left">
                                <div class="text-sm font-semibold">{{ Auth::user()?->name }}</div>
                                <div class="text-xs text-slate-300/80">{{ Auth::user()?->isAdmin() ? 'Administrador' : 'Cliente' }}</div>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-slate-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if (Auth::user()?->isAdmin())
                            <x-dropdown-link :href="route('dashboard')">
                                {{ __('Panel de control') }}
                            </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl border border-white/10 p-2 text-slate-200 transition hover:bg-white/10 hover:text-white focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-white/10 bg-slate-950">
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()?->name }}</div>
                <div class="font-medium text-sm text-slate-300">{{ Auth::user()?->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if (Auth::user()?->isAdmin())
                    <x-responsive-nav-link :href="route('dashboard')">
                        {{ __('Panel de control') }}
                    </x-responsive-nav-link>
                @endif

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
