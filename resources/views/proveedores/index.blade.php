<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Proveedores') }}
            </h2>
            <a href="{{ route('proveedores.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
                + Nuevo Proveedor
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">{{ session('success') }}</div>
                @endif

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase italic">Empresa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase italic">Contacto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase italic">Teléfono</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase italic">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($proveedores as $p)
                        <tr>
                            <td class="px-6 py-4 font-bold">{{ $p->nombre_empresa }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $p->contacto_nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $p->telefono }}</td>
                            <td class="px-6 py-4 text-sm">
                                <a href="{{ route('proveedores.edit', $p->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">Editar</a>
                                <form action="{{ route('proveedores.destroy', $p->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Borrar proveedor?')">Eliminar</button>
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