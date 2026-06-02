<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.35em] text-emerald-600">Panel de control</p>
                <h2 class="mt-2 text-3xl font-black tracking-tight text-slate-900">
                    {{ __('Dashboard') }}
                </h2>
            </div>
            <p class="max-w-xl text-sm text-slate-500">
                Accesos rápidos a productos, proveedores, estanterías y mapa.
            </p>
        </div>
    </x-slot>

    <div class="py-10 pb-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <a href="{{ route('productos.index') }}" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_16px_38px_-26px_rgba(15,23,42,.55)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_48px_-22px_rgba(15,23,42,.65)]">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-50 text-3xl">📦</div>
                    <div class="mt-5">
                        <span class="block text-lg font-black tracking-tight text-slate-900">PRODUCTOS</span>
                        <span class="mt-1 block text-sm text-slate-500">Gestión de inventario</span>
                    </div>
                </a>

                <a href="{{ route('proveedores.index') }}" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_16px_38px_-26px_rgba(15,23,42,.55)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_48px_-22px_rgba(15,23,42,.65)]">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-3xl">🏢</div>
                    <div class="mt-5">
                        <span class="block text-lg font-black tracking-tight text-slate-900">PROVEEDORES</span>
                        <span class="mt-1 block text-sm text-slate-500">Listado y control</span>
                    </div>
                </a>

                <a href="{{ route('proveedores.create') }}" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_16px_38px_-26px_rgba(15,23,42,.55)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_48px_-22px_rgba(15,23,42,.65)]">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-50 text-3xl">➕</div>
                    <div class="mt-5">
                        <span class="block text-lg font-black tracking-tight text-slate-900">NUEVO PROVEEDOR</span>
                        <span class="mt-1 block text-sm text-slate-500">Alta rápida</span>
                    </div>
                </a>

                <a href="{{ route('index') }}" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_16px_38px_-26px_rgba(15,23,42,.55)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_48px_-22px_rgba(15,23,42,.65)]">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-3xl">🗺️</div>
                    <div class="mt-5">
                        <span class="block text-lg font-black tracking-tight text-slate-900">MAPA</span>
                        <span class="mt-1 block text-sm text-slate-500">Vista pública de tienda</span>
                    </div>
                </a>

                <a href="{{ route('estanterias.index') }}" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_16px_38px_-26px_rgba(15,23,42,.55)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_48px_-22px_rgba(15,23,42,.65)]">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-cyan-50 text-3xl">🗂️</div>
                    <div class="mt-5">
                        <span class="block text-lg font-black tracking-tight text-slate-900">ESTANTERÍAS</span>
                        <span class="mt-1 block text-sm text-slate-500">Ver listado</span>
                    </div>
                </a>

                <a href="{{ route('estanterias.create') }}" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_16px_38px_-26px_rgba(15,23,42,.55)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_48px_-22px_rgba(15,23,42,.65)]">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-rose-50 text-3xl">🧩</div>
                    <div class="mt-5">
                        <span class="block text-lg font-black tracking-tight text-slate-900">NUEVA ESTANTERÍA</span>
                        <span class="mt-1 block text-sm text-slate-500">Crear ubicación</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>