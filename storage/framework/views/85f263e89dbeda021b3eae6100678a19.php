<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['width' => '7xl']); ?>
    <style>
        .ticket-bg {
            background:
                radial-gradient(circle at 15% 15%, rgba(34, 197, 94, 0.16), transparent 24%),
                radial-gradient(circle at 85% 15%, rgba(245, 158, 11, 0.14), transparent 22%),
                linear-gradient(150deg, #0f172a 0%, #143b47 52%, #eef1eb 100%);
        }

        .ticket-card {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 24px 60px -34px rgba(15, 23, 42, 0.74);
            border: 1px solid rgba(148, 163, 184, 0.25);
        }
    </style>

    <div class="min-h-screen ticket-bg py-8 lg:py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 text-center lg:text-left">
                <p class="text-xs uppercase tracking-[0.35em] text-emerald-200 font-semibold">Ticket final</p>
                <h1 class="mt-2 text-3xl lg:text-5xl font-black text-white tracking-tight">Compra completada con éxito</h1>
                <p class="mt-3 text-sm lg:text-base text-slate-200">Este es el resumen definitivo de tu pedido y el método de pago utilizado.</p>
            </div>

            <div class="ticket-card rounded-3xl p-6 lg:p-8">
                <?php if(session('ticket_enviado')): ?>
                    <div class="mb-5 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                        <?php echo e(session('ticket_enviado')); ?>

                    </div>
                <?php endif; ?>

                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 border-b border-slate-200 pb-5">
                    <div>
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500 font-bold">Referencia</p>
                        <h2 class="mt-2 text-2xl lg:text-3xl font-black text-slate-900"><?php echo e($pedido['codigo']); ?></h2>
                        <p class="mt-2 text-sm text-slate-500">Fecha: <?php echo e($pedido['fecha']); ?></p>
                    </div>
                    <div class="rounded-2xl bg-emerald-600 px-4 py-3 text-white lg:text-right">
                        <p class="text-[10px] uppercase tracking-[0.24em] text-emerald-100 font-bold">Estado</p>
                        <p class="text-xl font-black"><?php echo e($pedido['estado']); ?></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mt-6">
                    <section class="lg:col-span-8">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5">
                            <div class="flex items-center justify-between gap-3 mb-4">
                                <h3 class="text-xl font-black text-slate-900">Resumen del ticket</h3>
                                <span class="rounded-full bg-slate-900 px-3 py-1 text-xs font-bold text-white"><?php echo e(count($pedido['detalles'])); ?> artículos</span>
                            </div>

                            <div class="space-y-3">
                                <?php $__currentLoopData = $pedido['detalles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $linea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <article class="rounded-2xl bg-white p-4 border border-slate-200 shadow-sm">
                                        <div class="flex items-start justify-between gap-4">
                                            <div>
                                                <h4 class="font-bold text-slate-900"><?php echo e($linea['nombre']); ?></h4>
                                                <p class="text-sm text-slate-500 mt-1"><?php echo e($linea['cantidad']); ?> x <?php echo e(number_format($linea['precio_unitario'], 2, ',', '.')); ?> €</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-[10px] uppercase tracking-[0.24em] text-slate-400 font-bold">Subtotal</p>
                                                <p class="text-lg font-black text-slate-900"><?php echo e(number_format($linea['subtotal'], 2, ',', '.')); ?> €</p>
                                            </div>
                                        </div>
                                    </article>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </section>

                    <aside class="space-y-4 lg:col-span-4">
                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-500 font-bold">Pago</p>
                            <h3 class="mt-2 text-xl font-black text-slate-900"><?php echo e(strtoupper($pedido['metodo_pago'])); ?></h3>
                            <p class="mt-2 text-sm text-slate-500">Método seleccionado en la pasarela.</p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-500 font-bold">Acciones</p>
                            <div class="mt-4 space-y-3">
                                <a href="<?php echo e(route('pedido.pdf', ['id' => $pedido['codigo']])); ?>" class="inline-flex w-full items-center justify-center rounded-2xl bg-slate-900 px-4 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                    Descargar PDF
                                </a>
                                <button type="button" onclick="window.print()" class="inline-flex w-full items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50">
                                    Imprimir
                                </button>
                            </div>
                        </div>

                        <form method="POST" action="<?php echo e(route('pedido.enviar', ['id' => $pedido['codigo']])); ?>" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                            <?php echo csrf_field(); ?>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-500 font-bold">Enviar por correo</p>
                            <label class="mt-4 block text-sm font-bold text-slate-700" for="correo">Correo destino</label>
                            <input id="correo" name="correo" type="email" value="<?php echo e($pedido['correo_ticket'] ?? ''); ?>" class="mt-2 w-full rounded-xl border-slate-300 focus:border-emerald-500 focus:ring-emerald-500" required>
                            <?php $__errorArgs = ['correo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-sm font-semibold text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <button type="submit" class="mt-4 inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-emerald-700">
                                Enviar ticket por correo
                            </button>
                        </form>

                        <div class="rounded-2xl border border-slate-200 bg-slate-900 p-5 text-white shadow-sm">
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-300 font-bold">Total pagado</p>
                            <p class="mt-2 text-4xl font-black"><?php echo e(number_format($pedido['total'], 2, ',', '.')); ?> €</p>
                        </div>

                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 text-emerald-900">
                            <p class="text-sm font-bold">Tu ticket ha quedado registrado en esta sesión.</p>
                            <p class="mt-2 text-sm">Si vuelves a la tienda, podrás seguir comprando con normalidad y el stock ya estará actualizado.</p>
                        </div>

                        <a href="<?php echo e(route('index')); ?>" class="inline-flex w-full items-center justify-center rounded-2xl bg-emerald-600 px-5 py-4 text-white font-black text-lg transition hover:bg-emerald-700">
                            Volver a la tienda
                        </a>
                    </aside>
                </div>
            </div>
        </div>
    </div>

    <script>
        localStorage.removeItem('carrito');
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/pedido.blade.php ENDPATH**/ ?>