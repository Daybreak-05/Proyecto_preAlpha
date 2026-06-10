<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-slate-900 mb-2">Email</label>
            <input id="email" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="tu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-slate-900 mb-2">Contraseña</label>
            <input id="password" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" name="remember">
            <label for="remember_me" class="ms-3 text-sm text-slate-700">Recuérdame</label>
        </div>

        <div class="flex flex-col gap-3 pt-2">
            <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 px-4 py-3 font-bold text-white shadow-lg transition hover:shadow-xl hover:from-emerald-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                Inicia Sesión
            </button>

            @if (Route::has('password.request'))
                <a class="text-center text-sm text-slate-600 hover:text-emerald-600 transition font-medium" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
