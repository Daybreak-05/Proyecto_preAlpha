<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['width' => 'md']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['width' => 'md']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(config('app.name', 'UBIKA')); ?></title>
        <link rel="icon" type="image/png" href="<?php echo e(asset('img/logo.png')); ?>">
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-900 flex items-center justify-center px-4 py-6 sm:px-6 lg:px-8">
            <!-- Elementos decorativos -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-teal-500/10 rounded-full blur-3xl"></div>
            </div>

            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([
                'w-full relative z-10',
                'max-w-md' => $width === 'md',
                'max-w-2xl' => $width === '2xl',
                'max-w-4xl' => $width === '4xl',
                'max-w-5xl' => $width === '5xl',
                'max-w-6xl' => $width === '6xl',
                'max-w-7xl' => $width === '7xl',
                'max-w-none' => $width === 'full',
            ]); ?>">
                <!-- Header con logo -->
                <div class="text-center mb-10">
                    <a href="<?php echo e(route('index')); ?>" class="inline-flex items-center gap-3 mb-6">
                        <img src="<?php echo e(asset('img/logo.png')); ?>" alt="Logo" class="h-12 w-12 rounded-xl object-cover ring-2 ring-white/20 shadow-xl">
                        <div class="text-left">
                            <div class="text-xs font-bold uppercase tracking-[0.3em] text-emerald-300">Sistema</div>
                            <div class="text-2xl font-black tracking-wide text-white">UBIKA</div>
                        </div>
                    </a>
                    <h1 class="text-3xl font-black text-white mb-3"><?php echo e(Route::currentRouteName() === 'register' ? 'Crear Cuenta' : 'Acceso'); ?></h1>
                    <p class="text-slate-300 text-sm"><?php echo e(Route::currentRouteName() === 'register' ? 'Regístrate para comenzar' : 'Inicia sesión en tu cuenta'); ?></p>
                </div>

                <!-- Formulario -->
                <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/10 p-8">
                    <?php echo e($slot); ?>

                </div>

                <!-- Footer -->
                <p class="text-center text-slate-300 text-sm mt-6">
                    <?php echo e(Route::currentRouteName() === 'register' ? '¿Ya tienes cuenta? ' : '¿No tienes cuenta? '); ?>

                    <a href="<?php echo e(Route::currentRouteName() === 'register' ? route('login') : route('register')); ?>" class="font-bold text-emerald-400 hover:text-emerald-300 transition">
                        <?php echo e(Route::currentRouteName() === 'register' ? 'Inicia sesión' : 'Regístrate aquí'); ?>

                    </a>
                </p>
            </div>
        </div>
    </body>
</html><?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/layouts/guest.blade.php ENDPATH**/ ?>