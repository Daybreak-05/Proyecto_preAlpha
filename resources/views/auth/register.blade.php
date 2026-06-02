<x-guest-layout>
    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">
        Al registrarte crearás una cuenta de cliente para comprar en la tienda.
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-bold text-slate-900 mb-2">Nombre Completo</label>
            <input id="name" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Tu nombre" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-bold text-slate-900 mb-2">Email</label>
            <input id="email" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="tu@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-bold text-slate-900 mb-2">Contraseña</label>
            <input id="password" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-bold text-slate-900 mb-2">Confirmar Contraseña</label>
            <input id="password_confirmation" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 placeholder-slate-400 transition focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 px-4 py-3 font-bold text-white shadow-lg transition hover:shadow-xl hover:from-emerald-600 hover:to-teal-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                Crear Cuenta
            </button>
        </div>
    </form>
</x-guest-layout>
