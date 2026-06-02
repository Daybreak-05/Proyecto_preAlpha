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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">➕ Nuevo Producto</h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-2xl rounded-3xl border border-gray-100">
                <?php if($errors->any()): ?>
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
                        <ul class="list-disc pl-5 space-y-1 text-sm">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo e(route('productos.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Nombre del Producto</label>
                            <input type="text" name="nombre" value="<?php echo e(old('nombre')); ?>" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Código de Barras</label>
                            <input type="text" name="codigo_barras" value="<?php echo e(old('codigo_barras')); ?>" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Stock Actual</label>
                            <input type="number" name="stock_actual" value="<?php echo e(old('stock_actual')); ?>" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Stock Mínimo</label>
                            <input type="number" name="stock_minimo" value="<?php echo e(old('stock_minimo')); ?>" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Precio (€)</label>
                            <input type="number" step="0.01" name="precio" value="<?php echo e(old('precio')); ?>" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

			<div class="md:col-span-2">
			    <label class="block text-sm font-bold text-gray-700">Imagen del producto</label>

			    <input type="file" name="imagen" accept="image/*"
			    class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm">
			</div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Fecha de Caducidad</label>
                            <input type="date" name="fecha_caducidad" value="<?php echo e(old('fecha_caducidad')); ?>" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Estantería</label>
                            <select name="estanteria_id" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <?php $__currentLoopData = $estanterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($e->id); ?>" <?php echo e(old('estanteria_id') == $e->id ? 'selected' : ''); ?>><?php echo e($e->nombre); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Proveedor</label>
                            <select name="proveedor_id" class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                                <?php $__currentLoopData = $proveedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($p->id); ?>" <?php echo e(old('proveedor_id') == $p->id ? 'selected' : ''); ?>><?php echo e($p->nombre_empresa); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <a href="<?php echo e(route('productos.index')); ?>" class="text-gray-400 hover:text-gray-600 font-medium text-sm">⬅ Volver al listado</a>
                        <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition">
                            Guardar Producto
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
<?php endif; ?>
<?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/admin/productos/create.blade.php ENDPATH**/ ?>