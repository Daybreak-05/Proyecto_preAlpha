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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            🚚 Editando Proveedor: <?php echo e($proveedor->nombre_empresa); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-2xl rounded-3xl border border-gray-100">
                <form action="<?php echo e(route('proveedores.update', $proveedor->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?> 
                    <?php echo method_field('PUT'); ?> 

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Nombre de la Empresa</label>
                            <input type="text" name="nombre_empresa" value="<?php echo e(old('nombre_empresa', $proveedor->nombre_empresa)); ?>" 
                                   class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                </div>
                                
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del Contacto</label>
                                    <input type="text" name="contacto_nombre" value="<?php echo e(old('contacto_nombre', $proveedor->contacto_nombre)); ?>" 
                                    class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Teléfono</label>
                            <input type="text" name="telefono" value="<?php echo e(old('telefono', $proveedor->telefono)); ?>" 
                                   class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Email de contacto</label>
                            <input type="email" name="email" value="<?php echo e(old('email', $proveedor->email)); ?>" 
                                   class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center border-t pt-6">
                        <a href="<?php echo e(route('proveedores.index')); ?>" class="text-gray-400 hover:text-gray-600 font-medium text-sm">
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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/proveedores/edit.blade.php ENDPATH**/ ?>