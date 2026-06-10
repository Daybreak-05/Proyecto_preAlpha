<x-guest-layout> {{-- Usamos el layout de invitados --}}
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Nuestros Productos</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($productos as $p)
                    <div class="border rounded-xl p-4 hover:shadow-lg transition">
                        <div class="h-40 bg-gray-100 rounded-lg mb-4 flex items-center justify-center">
                            {{-- Aquí iría la imagen del producto --}}
                            <span class="text-4xl">🛒</span>
                        </div>
                        <h3 class="font-bold text-lg">{{ $p->nombre }}</h3>
                        <p class="text-indigo-600 font-bold text-xl">{{ $p->precio }}€</p>
                        
                        <button class="w-full mt-4 bg-indigo-600 text-white py-2 rounded-lg font-bold hover:bg-indigo-700">
                            Añadir al carrito
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-guest-layout>