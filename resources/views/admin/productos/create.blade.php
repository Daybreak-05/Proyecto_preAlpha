<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">➕ Nuevo Producto</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-2xl rounded-3xl border border-gray-100">
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
                        <ul class="list-disc pl-5 space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Nombre del Producto</label>
                            <input type="text" name="nombre" value="{{ old('nombre') }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Código de Barras</label>
                            <input type="text" name="codigo_barras" value="{{ old('codigo_barras') }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Stock Actual</label>
                            <input type="number" name="stock_actual" value="{{ old('stock_actual') }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Stock Mínimo</label>
                            <input type="number" name="stock_minimo" value="{{ old('stock_minimo') }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Precio (€)</label>
                            <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

			<div class="md:col-span-2">
			    <label class="block text-sm font-bold text-gray-700">Imagen del producto</label>

			    <input type="file" name="imagen" accept="image/*"
			    class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm">
			</div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Fecha de Caducidad</label>
                            <input type="date" name="fecha_caducidad" value="{{ old('fecha_caducidad') }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Estantería</label>
                            <select name="estanteria_id" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                @foreach($estanterias as $e)
                                    <option value="{{ $e->id }}" {{ old('estanteria_id') == $e->id ? 'selected' : '' }}>{{ $e->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Proveedor</label>
                            <select name="proveedor_id" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                @foreach($proveedores as $p)
                                    <option value="{{ $p->id }}" {{ old('proveedor_id') == $p->id ? 'selected' : '' }}>{{ $p->nombre_empresa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <a href="{{ route('productos.index') }}" class="text-gray-400 hover:text-gray-600 font-medium text-sm">⬅ Volver al listado</a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition">
                            Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
