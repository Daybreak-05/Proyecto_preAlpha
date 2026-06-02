<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🚚 Editando Proveedor: {{ $proveedor->nombre_empresa }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-2xl rounded-3xl border border-gray-100">
                <form action="{{ route('proveedores.update', $proveedor->id) }}" method="POST">
                    @csrf 
                    @method('PUT') {{-- OBLIGATORIO PARA EDITAR --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Nombre de la Empresa</label>
                            <input type="text" name="nombre_empresa" value="{{ old('nombre_empresa', $proveedor->nombre_empresa) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del Contacto</label>
                                    <input type="text" name="contacto_nombre" value="{{ old('contacto_nombre', $proveedor->contacto_nombre) }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Teléfono</label>
                            <input type="text" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Email de contacto</label>
                            <input type="email" name="email" value="{{ old('email', $proveedor->email) }}" 
                                   class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center border-t pt-6">
                        <a href="{{ route('proveedores.index') }}" class="text-gray-400 hover:text-gray-600 font-medium text-sm">
                            ⬅ Cancelar
                        </a>
                        <button type="submit" class="bg-green-600 text-white px-10 py-3 rounded-xl font-bold shadow-lg hover:bg-green-700 transition">
                            Actualizar Proveedor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>