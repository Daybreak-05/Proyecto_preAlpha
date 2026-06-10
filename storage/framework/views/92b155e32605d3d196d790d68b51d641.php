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

        <h1 class="text-4xl font-black mb-6">
            Política de Privacidad
        </h1>

        <p class="mb-4">
            UBIKA respeta la privacidad de los usuarios y garantiza la protección
            de los datos personales conforme a la normativa vigente.
        </p>

        <h2 class="text-2xl font-bold mt-8 mb-4">
            Datos recopilados
        </h2>

        <ul class="list-disc pl-6 space-y-2">
            <li>Nombre de usuario.</li>
            <li>Correo electrónico.</li>
            <li>Información relacionada con pedidos.</li>
        </ul>

        <h2 class="text-2xl font-bold mt-8 mb-4">
            Finalidad
        </h2>

        <p>
            Los datos se utilizan exclusivamente para la gestión de cuentas,
            pedidos y mejora del servicio.
        </p>

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
<?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/info/privacidad.blade.php ENDPATH**/ ?>