<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">📦 Gestión de Inventario</h2>
            <a href="{{ route('productos.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-full shadow-md transition">
                + Nuevo Producto
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Producto</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Ubicación</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($productos as $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $p->nombre }}</div>
                                <div class="text-xs text-gray-400">{{ $p->codigo_barras }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $p->stock_actual <= $p->stock_minimo ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                                    {{ $p->stock_actual }} unidades
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-medium">
                                📍 {{ $p->estanteria->nombre }}
                            </td>
                            <td class="px-6 py-4 flex space-x-4">
                                <a href="{{ route('productos.edit', $p->id) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">Editar</a>
                                <form action="{{ route('productos.destroy', $p->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('¿Borrar?')" class="text-red-400 hover:text-red-600 font-bold">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>