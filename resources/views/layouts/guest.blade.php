@props(['width' => 'md'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'UBIKA') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900 flex items-center justify-center px-4 py-6 sm:px-6 lg:px-8">
            <!-- Elementos decorativos -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl"></div>
            </div>

            <div @class([
                'w-full relative z-10',
                'max-w-md' => $width === 'md',
                'max-w-2xl' => $width === '2xl',
                'max-w-4xl' => $width === '4xl',
                'max-w-5xl' => $width === '5xl',
                'max-w-6xl' => $width === '6xl',
                'max-w-7xl' => $width === '7xl',
                'max-w-none' => $width === 'full',
            ])>
                <!-- Header con logo -->
                <div class="text-center mb-10">
                    <a href="{{ route('index') }}" class="inline-flex items-center gap-3 mb-6">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-12 w-12 rounded-xl object-cover ring-2 ring-white/20 shadow-xl">
                        <div class="text-left">
                            <div class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-300">Sistema</div>
                            <div class="text-2xl font-black tracking-wide text-white">UBIKA</div>
                        </div>
                    </a>
                    <h1 class="text-3xl font-black text-white mb-3">{{ Route::currentRouteName() === 'register' ? 'Crear Cuenta' : 'Acceso' }}</h1>
                    <p class="text-slate-300 text-sm">{{ Route::currentRouteName() === 'register' ? 'Regístrate para comenzar' : 'Inicia sesión en tu cuenta' }}</p>
                </div>

                <!-- Formulario -->
                <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 p-8">
                    {{ $slot }}
                </div>

                <!-- Footer -->
                <p class="text-center text-slate-300 text-sm mt-6">
                    {{ Route::currentRouteName() === 'register' ? '¿Ya tienes cuenta? ' : '¿No tienes cuenta? ' }}
                    <a href="{{ Route::currentRouteName() === 'register' ? route('login') : route('register') }}" class="font-bold text-emerald-400 hover:text-emerald-300 transition">
                        {{ Route::currentRouteName() === 'register' ? 'Inicia sesión' : 'Regístrate aquí' }}
                    </a>
                </p>
            </div>
        </div>
    </body>
</html>