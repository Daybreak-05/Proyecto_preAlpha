<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'UBIKA') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-950">
        <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(16,185,129,0.12),_transparent_32%),linear-gradient(180deg,_#0f172a_0%,_#111827_40%,_#f8fafc_40%,_#f8fafc_100%)]">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="border-b border-emerald-500/10 bg-white/90 backdrop-blur-md shadow-[0_18px_40px_-28px_rgba(15,23,42,.55)]">
                    <div class="max-w-7xl mx-auto py-7 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="relative">
                {{ $slot }}
            </main>
                </div>

        <footer class="bg-slate-900 text-slate-300 border-t border-slate-700 mt-12">
            <div class="max-w-7xl mx-auto px-4 py-8">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    <div>
                        <h3 class="font-bold text-white mb-3">UBIKA</h3>
                        <p class="text-sm text-slate-400">
                            Tu supermercado inteligente con gestión de stock,
                            descuentos automáticos y compra online.
                        </p>
                    </div>

                    <div>
			    <h3 class="font-bold text-white mb-3">Información</h3>
			    <ul class="space-y-2 text-sm">
			        <li>
			            <a href="{{ route('sobre') }}" class="hover:text-emerald-400">
			                Sobre nosotros
			            </a>
			        </li>
			        <li>
			            <a href="{{ route('contacto') }}" class="hover:text-emerald-400">
			                Contacto
			            </a>
			        </li>
			        <li>
			            <a href="{{ route('privacidad') }}" class="hover:text-emerald-400">
			                Política de privacidad
			            </a>
			        </li>
			        <li>
			            <a href="{{ route('terminos') }}" class="hover:text-emerald-400">
			                Términos y condiciones
			            </a>
			        </li>
			        <li>
			            <a href="{{ route('cookies') }}" class="hover:text-emerald-400">
			                Cookies
			            </a>
			        </li>
			    </ul>
			</div>

                    <div>
                        <h3 class="font-bold text-white mb-3">Contacto</h3>
                        <p class="text-sm text-slate-400">
                            contacto@ubika.es
                        </p>
                        <p class="text-sm text-slate-400">
                            +34 600 000 000
                        </p>
                    </div>

                </div>

                <div class="border-t border-slate-700 mt-8 pt-4 text-center text-sm text-slate-500">
                    © {{ date('Y') }} UBIKA. Todos los derechos reservados.
                </div>

            </div>
        </footer>

    </body>
</html>
