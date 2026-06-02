<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Mapa: Gestión de Estanterías')); ?>

            </h2>
            <a href="<?php echo e(route('estanterias.create')); ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded transition">
                + Nueva Estantería
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Posición (X,Y)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tamaño</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $estanterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estanteria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 font-bold"><?php echo e($estanteria->nombre); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php echo e($estanteria->x); ?> , <?php echo e($estanteria->y); ?>

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <?php echo e($estanteria->ancho); ?>x<?php echo e($estanteria->alto); ?>

                            </td>
                            <td class="px-6 py-4 text-sm flex items-center gap-3">
                                
                                <button type="button" 
                                        class="text-emerald-600 hover:text-emerald-900 font-medium"
                                        onclick="abrirModalProductos(<?php echo e($estanteria->id); ?>, '<?php echo e($estanteria->nombre); ?>')">
                                    Ver objetos
                                </button>

                                <a href="<?php echo e(route('estanterias.edit', $estanteria->id)); ?>" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                                
                                <form action="<?php echo e(route('estanterias.destroy', $estanteria->id)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Eliminar del mapa?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    
	<div id="modal-productos" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
	    
	    <div id="modal-bg" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm transition-opacity duration-300 opacity-0"></div>

	    <div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-0">
	        
	        <div id="modal-content" class="bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 scale-95 opacity-0 sm:my-8 sm:max-w-lg sm:w-full border border-gray-100">
	            <div class="bg-white px-5 pt-6 pb-4 sm:p-6 sm:pb-4">
	                <div class="sm:flex sm:items-start">
	                    <div class="mt-3 text-center sm:mt-0 sm:ml-2 sm:text-left w-full">
	                        <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
	                            <h3 class="text-lg font-black text-gray-900" id="modal-titulo-estanteria">
	                                Contenido de la Estantería
	                            </h3>
	                            <button type="button" class="text-gray-400 hover:text-gray-600 transition" onclick="cerrarModal()">
	                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
	                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
	                                </svg>
	                            </button>
	                        </div>
	                        
	                        
	                        <div id="lista-productos-modal" class="divide-y divide-gray-100 max-h-72 overflow-y-auto pr-1">
	                            <p class="text-sm text-gray-500">Cargando objetos...</p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            
	            <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end">
	                <button type="button" class="w-full sm:w-auto inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 transition focus:outline-none sm:text-sm" onclick="cerrarModal()">
	                    Cerrar
	                </button>
	            </div>
	        </div>
	    </div>
	</div>

    
    <script>
    const modal = document.getElementById('modal-productos');
    const modalBg = document.getElementById('modal-bg');
    const modalContent = document.getElementById('modal-content');
    const tituloModal = document.getElementById('modal-titulo-estanteria');
    const listaProductos = document.getElementById('lista-productos-modal');

    async function abrirModalProductos(id, nombreEstanteria) {
        // 1. Configuramos el texto inicial
        tituloModal.textContent = `Objetos en: ${nombreEstanteria}`;
        listaProductos.innerHTML = '<p class="text-sm text-gray-500 animate-pulse py-4 text-center">Buscando productos en la estantería...</p>';
        
        // 2. Quitamos el hidden del contenedor principal para que exista en el DOM
        modal.classList.remove('hidden');
        
        // 3. Activamos las animaciones visuales (opacidad del fondo y escala del popup)
        setTimeout(() => {
            modalBg.classList.remove('opacity-0');
            modalContent.classList.remove('opacity-0', 'scale-95');
        }, 20);

        try {
            // 4. CORREGIDO: Usamos la ruta exacta que está definida en tu web.php
            const response = await fetch(`<?php echo e(url('/api/estanteria')); ?>/${id}/productos`);
            if (!response.ok) throw new Error('Error al cargar productos');
            
            const productos = await response.json();

            if (productos.length === 0) {
                listaProductos.innerHTML = `
                    <div class="p-4 my-2 text-sm text-amber-600 bg-amber-50 rounded-xl text-center font-medium">
                        Esta estantería no tiene productos asignados o no tienen stock.
                    </div>
                `;
                return;
            }

            listaProductos.innerHTML = productos.map(prod => `
                <div class="flex justify-between items-center py-3 hover:bg-gray-50 px-2 rounded-lg transition">
                    <div>
                        <p class="font-bold text-gray-900 text-sm">${prod.nombre}</p>
                        <p class="text-xs text-gray-400">ID: ${prod.id}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                            Stock: ${prod.stock_actual}
                        </span>
                        <p class="text-sm font-black text-gray-800 mt-1">${Number(prod.precio_final || prod.precio || 0).toFixed(2)}€</p>
                    </div>
                </div>
            `).join('');

        } catch (error) {
            listaProductos.innerHTML = `
                <div class="p-4 my-2 text-sm text-red-600 bg-red-50 rounded-xl text-center font-medium">
                    No se pudo conectar con el servidor para obtener los productos.
                </div>
            `;
        }
    }

    function cerrarModal() {
        // 1. Añadimos las clases de ocultación para activar la animación de salida suave
        modalBg.classList.add('opacity-0');
        modalContent.classList.add('opacity-0', 'scale-95');
        
        // 2. Esperamos a que termine la animación (300ms) antes de poner el 'hidden' definitivo
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Cerrar si se hace clic en el fondo oscuro
    modalBg.addEventListener('click', cerrarModal);

    // Permitir cerrar el modal presionando la tecla Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            cerrarModal();
        }
    });
</script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/estanterias/index.blade.php ENDPATH**/ ?>