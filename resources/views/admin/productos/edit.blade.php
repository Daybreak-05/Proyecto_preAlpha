ç<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">✏️ Editando: {{ $producto->nombre }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-2xl rounded-3xl border border-gray-100">
                <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Nombre del Producto</label>
                            <input type="text" name="nombre" value="{{ $producto->nombre }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Código de Barras</label>
                            <input type="text" name="codigo_barras" value="{{ old('codigo_barras', $producto->codigo_barras) }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Stock Actual</label>
                            <input type="number" name="stock_actual" value="{{ $producto->stock_actual }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Precio (€)</label>
                            <input type="number" step="0.01" name="precio" value="{{ $producto->precio }}" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm">
                        </div>

			<div class="md:col-span-2">
			    <label class="block text-sm font-bold text-gray-700">Imagen del producto</label>

			    @if($producto->imagen)
			        <img src="{{ asset('storage/' . $producto->imagen) }}"
			             class="h-24 rounded-lg mb-3">
			    @endif

			    <input type="file" name="imagen" accept="image/*"
			           class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm">
			</div>

                        <div>
                            <label>Fecha de Caducidad:</label>
                            <input class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm" type="date" name="fecha_caducidad" value="{{ old('fecha_caducidad', $producto->fecha_caducidad->format('Y-m-d')) }}" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Cambiar Estantería</label>
                            <select name="estanteria_id" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm">
                                @foreach($estanterias as $e)
                                    <option value="{{ $e->id }}" {{ $producto->estanteria_id == $e->id ? 'selected' : '' }}>
                                        {{ $e->nombre }} (X:{{ $e->x }}, Y:{{ $e->y }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <a href="{{ route('productos.index') }}" class="text-gray-400 hover:text-gray-600 font-medium text-sm">⬅ Volver al listado</a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition">
                            Actualizar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
