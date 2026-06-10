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
    <section class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12">

        <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-6">
            Sobre UBIKA
        </h1>

        <p class="text-lg text-slate-700 leading-relaxed mb-6">
            UBIKA es una plataforma inteligente de gestión y localización de productos
            desarrollada para mejorar la experiencia de compra dentro de supermercados y
            grandes almacenes superficies.
        </p>

        <p class="text-slate-700 leading-relaxed mb-6">
            El sistema combina mapas interactivos, gestión de inventario en tiempo real,
            control de caducidades y herramientas de administración para facilitar tanto
            la experiencia del cliente como la gestión interna del establecimiento.
        </p>

        <p class="text-slate-700 leading-relaxed mb-6">
            Mediante un sistema visual basado en estanterías inteligentes, los usuarios
            pueden localizar rápidamente los productos que necesitan, consultar su
            disponibilidad y realizar compras de forma sencilla.
        </p>

        <div class="grid md:grid-cols-3 gap-6 mt-10">
            <div class="bg-slate-50 rounded-2xl p-6">
                <h3 class="font-bold text-xl mb-2">📍 Localización</h3>
                <p class="text-slate-600">
                    Encuentra cualquier producto mediante mapas interactivos.
                </p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-6">
                <h3 class="font-bold text-xl mb-2">📦 Inventario</h3>
                <p class="text-slate-600">
                    Gestión de stock y disponibilidad en tiempo real.
                </p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-6">
                <h3 class="font-bold text-xl mb-2">🛒 Compra</h3>
                <p class="text-slate-600">
                    Experiencia de compra rápida e intuitiva.
                </p>
            </div>
        </div>

        <div class="mt-12 border-t pt-8">
            <h2 class="text-2xl font-bold mb-4">Proyecto Final</h2>

            <p class="text-slate-700">
                UBIKA ha sido desarrollado como proyecto final de desarrollo web,
                aplicando tecnologías modernas como Laravel, MySQL, Tailwind CSS,
                JavaScript y sistemas de gestión de datos en tiempo real.
            </p>
        </div>

    </div>
</section>

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

<?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/info/sobre-nosotros.blade.php ENDPATH**/ ?>