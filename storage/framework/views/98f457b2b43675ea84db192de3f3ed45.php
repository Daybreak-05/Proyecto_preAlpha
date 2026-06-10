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
            Contacto
        </h1>

        <p class="text-slate-600 mb-8">
            ¿Tienes alguna consulta o sugerencia? Puedes contactar con nosotros
            mediante el siguiente formulario.
        </p>

        <form class="space-y-6">

            <div>
                <label class="block font-semibold mb-2">Nombre</label>
                <input
                    type="text"
                    class="w-full rounded-xl border-slate-300"
                    placeholder="Tu nombre">
            </div>

            <div>
                <label class="block font-semibold mb-2">Correo electrónico</label>
                <input
                    type="email"
                    class="w-full rounded-xl border-slate-300"
                    placeholder="correo@ejemplo.com">
            </div>

            <div>
                <label class="block font-semibold mb-2">Mensaje</label>
                <textarea
                    rows="6"
                    class="w-full rounded-xl border-slate-300"
                    placeholder="Escribe tu mensaje"></textarea>
            </div>

            <button
                type="submit"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl font-bold">
                Enviar mensaje
            </button>

        </form>

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
<?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/info/contacto.blade.php ENDPATH**/ ?>