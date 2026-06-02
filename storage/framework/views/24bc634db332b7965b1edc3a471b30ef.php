<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(config('app.name', 'UBIKA')); ?> - Tienda</title>
        <link rel="icon" type="image/png" href="<?php echo e(asset('img/logo.png')); ?>">
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased">
    <style>
        :root {
            --bg-base: #eef1eb;
            --bg-soft: #f7f5ef;
            --panel-tint: #fffaf0;
        }

        * {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
        }

        .fondo-almacen {
            background:
                radial-gradient(circle at 12% 10%, rgba(20, 184, 166, 0.1), transparent 32%),
                radial-gradient(circle at 88% 92%, rgba(251, 146, 60, 0.12), transparent 28%),
                linear-gradient(155deg, var(--bg-base) 0%, #e8ede5 45%, #e9eef7 100%);
            background-attachment: fixed;
        }

        .tarjeta-mapa {
            background: linear-gradient(175deg, #ffffff 0%, #f6f8f4 100%);
            border-color: #d8e0d4;
            box-shadow: 0 18px 30px -22px rgba(30, 41, 59, 0.45);
            transition: all 0.3s ease;
        }

        .tarjeta-mapa:hover {
            box-shadow: 0 24px 40px -18px rgba(30, 41, 59, 0.55);
            transform: translateY(-2px);
        }

        .panel-productos-ui {
            background: linear-gradient(180deg, #fffdf8 0%, #f8f4ec 100%);
            border-color: #e6dcc9;
            box-shadow: 0 18px 34px -20px rgba(31, 41, 55, 0.45);
            transition: all 0.3s ease;
        }

        .panel-productos-ui:hover {
            box-shadow: 0 24px 44px -18px rgba(31, 41, 55, 0.55);
            transform: translateY(-2px);
        }

        .mapa-canvas {
            background:
                linear-gradient(0deg, rgba(148, 163, 184, 0.12) 1px, transparent 1px),
                linear-gradient(90deg, rgba(148, 163, 184, 0.12) 1px, transparent 1px),
                var(--bg-soft);
            background-size: 24px 24px, 24px 24px, auto;
            border-color: #cbd5e1;
        }

        .estanteria-rect { transition: fill 0.2s ease, stroke 0.2s ease, opacity 0.2s ease; }
        .estanteria-rect:hover { opacity: 0.92; }
        .estanteria-rect.vacia { fill: #94a3b8; }
        .estanteria-rect.proximo { fill: #d97706; }
        .estanteria-rect.caducado { fill: #dc2626; }
        .estanteria-rect.optimo { fill: #16a34a; }
        .estanteria-rect.active { stroke: #1d4ed8; stroke-width: 4; }
        .estanteria-label {
            fill: #111827;
            stroke: #ffffff;
            stroke-width: 1.4;
            paint-order: stroke;
        }
        .estanteria-label.contraste-alto {
            fill: #ffffff;
            stroke: #111827;
            stroke-width: 1;
        }
        .animate-fade-in { animation: fadeIn 0.3s ease-in; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Estilos adicionales para mejor consistencia */
        .btn-comprar {
            transition: all 0.3s ease;
        }

        .btn-comprar:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px -4px rgba(16, 185, 129, 0.4);
        }

        h3.text-2xl {
            background: linear-gradient(135deg, #111827, #374151);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    <div class="min-h-screen fondo-almacen relative">
        <!-- Logos decorativos en esquinas -->
        <div class="fixed top-4 right-4 z-0 pointer-events-none opacity-10">
            <img src="<?php echo e(asset('img/logo.png')); ?>" alt="" class="h-24 w-24">
        </div>
        <div class="fixed bottom-4 left-4 z-0 pointer-events-none opacity-10">
            <img src="<?php echo e(asset('img/logo.png')); ?>" alt="" class="h-24 w-24">
        </div>

        <nav class="bg-gradient-to-r from-slate-900 via-slate-800 to-teal-900 shadow-sm p-4 flex justify-between items-center px-12 border-b border-teal-800/50 relative z-10">
            <div class="flex items-center gap-3">
                <img src="<?php echo e(asset('img/logo.png')); ?>" alt="UBIKA" class="h-10 w-10">
                <h1 class="text-lg sm:text-xl lg:text-2xl font-black text-emerald-300 uppercase">UBIKA</h1>
            </div>
            <?php if(auth()->guard()->check()): ?>
                <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                     <?php $__env->slot('trigger', null, []); ?> 
                        <button class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-white transition hover:bg-white/10 focus:outline-none">
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-400/15 text-emerald-300 font-bold"><?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?></span>
                            <div class="text-left leading-tight">
                                <div class="text-sm font-semibold"><?php echo e(Auth::user()->name); ?></div>
                                <div class="text-xs text-slate-300/80"><?php echo e(Auth::user()->isAdmin() ? 'Administrador' : 'Cliente'); ?></div>
                            </div>
                            <svg class="fill-current h-4 w-4 text-slate-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                     <?php $__env->endSlot(); ?>

                     <?php $__env->slot('content', null, []); ?> 
                        <?php if(Auth::user()->isAdmin()): ?>
                            <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('dashboard')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('dashboard'))]); ?>
                                Panel de control
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                        <?php endif; ?>

                        <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('profile.edit')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit'))]); ?>
                            Perfil
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>

                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>

                            <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();']); ?>
                                Cerrar sesión
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                        </form>
                     <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
            <?php else: ?>
                <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:bg-white/20 hover:shadow-xl hover:shadow-black/20">
                    <svg class="h-4 w-4 text-emerald-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v2H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-1V6a4 4 0 00-4-4zm2 6V6a2 2 0 10-4 0v2h4z" clip-rule="evenodd" />
                    </svg>
                    <span>Acceso</span>
                </a>
            <?php endif; ?>
        </nav>

       	<main class="w-full px-3 sm:px-6 lg:px-12 py-4 sm:py-6 lg:py-8">
            <div class="flex flex-col lg:flex-row gap-6 xl:gap-8 items-start">
                <!-- Mapa -->
                <div class="w-full lg:flex-1 tarjeta-mapa p-2 sm:p-4 md:p-6 rounded-3xl border overflow-x-auto">
                    <?php $esRoot = Auth::check() && Auth::user()->isAdmin(); ?>
                    
                    <?php if($esRoot): ?>
                        <div class="flex gap-4 mb-4 text-[10px] font-bold uppercase text-gray-600">
                            <span class="flex items-center gap-1"><i class="w-2 h-2 bg-green-600 rounded-full"></i> Óptimo</span>
                            <span class="flex items-center gap-1"><i class="w-2 h-2 bg-amber-600 rounded-full"></i> Próximo</span>
                            <span class="flex items-center gap-1"><i class="w-2 h-2 bg-red-600 rounded-full"></i> Crítico</span>
                        </div>
                    <?php endif; ?>

                    <svg viewBox="0 0 800 500" class="w-full h-auto rounded-2xl border mapa-canvas">
                        <?php $__currentLoopData = $estanterias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <g class="estanteria-group cursor-pointer" data-id="<?php echo e($e->id); ?>" data-nombre="<?php echo e($e->nombre); ?>">
                                <rect x="<?php echo e($e->x); ?>" y="<?php echo e($e->y); ?>" width="<?php echo e($e->ancho); ?>" height="<?php echo e($e->alto); ?>" 
                                    fill="<?php echo e($e->color_gestion); ?>" 
                                    stroke="<?php echo e($esRoot ? '#374151' : '#e2e8f0'); ?>" 
                                    rx="12" class="estanteria-rect transition-all duration-300 hover:opacity-80" />
                                <text x="<?php echo e($e->x + $e->ancho/2); ?>" y="<?php echo e($e->y + $e->alto/2); ?>" 
                                    text-anchor="middle" font-size="16" font-weight="bold" 
                                    class="estanteria-label uppercase pointer-events-none select-none"><?php echo e($e->nombre); ?></text>
                            </g>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </svg>
                </div>

                <!-- Contenedor lateral: Productos + Carrito -->
                <div class="w-full lg:w-[26rem] xl:w-[30rem] space-y-4 sm:space-y-6 lg:space-y-8">
                    <!-- Panel: Productos -->
                    <div id="panel-productos" class="panel-productos-ui p-4 sm:p-6 lg:p-8 rounded-3xl border">
                        <h3 id="titulo-estanteria" class="text-2xl font-black text-slate-900 mb-6 uppercase tracking-tight border-b border-slate-200 pb-3">Selecciona una estantería</h3>
                        <div id="lista-productos" class="space-y-4">
                            <p class="text-slate-500 italic text-center py-8">Los productos aparecerán aquí</p>
                        </div>
                    </div>

                    <!-- Panel: Carrito -->
                    <div id="panel-carrito" class="panel-productos-ui p-8 rounded-3xl border max-h-[50vh] lg:max-h-screen overflow-y-auto" style="display: none;">
                        <h3 class="text-2xl font-black text-slate-900 mb-6 uppercase tracking-tight border-b border-slate-200 pb-3">🛒 Carrito</h3>
                    <div id="carrito-items" class="space-y-3 mb-4">
                        <p class="text-slate-500 italic text-center">Carrito vacío</p>
                    </div>
                    <div class="border-t border-slate-200 pt-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="font-bold text-slate-900">Total:</span>
                            <span id="carrito-total" class="text-2xl font-black text-indigo-700">0,00€</span>
                        </div>
                        <button id="btn-comprar" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl shadow-md transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                            Ir a la pasarela
                        </button>
                        <button id="btn-limpiar" class="w-full bg-slate-200 hover:bg-slate-300 text-slate-700 font-bold py-2 px-4 rounded-xl shadow-sm transition mt-2">
                            Limpiar Carrito
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const IS_ROOT = "<?php echo e(Auth::check() && Auth::user()->email === 'root@root.es' ? '1' : '0'); ?>" === "1";
        const CADUCIDAD_PROXIMA_DIAS = 7;

        // Carrito con localStorage
        let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

        // Función para escapar HTML y evitar inyección
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, m => map[m]);
        }

        function diasHastaCaducidad(fechaCaducidad) {
            if (!fechaCaducidad) {
                return Infinity;
            }

            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0);

            const fecha = new Date(fechaCaducidad);
            if (Number.isNaN(fecha.getTime())) {
                return Infinity;
            }

            fecha.setHours(0, 0, 0, 0);
            return Math.floor((fecha - hoy) / (1000 * 60 * 60 * 24));
        }

        function estadoEstanteria(productos) {
            if (!productos || productos.length === 0) {
                return 'vacia';
            }

            let hayProximo = false;
            for (const p of productos) {
                const dias = diasHastaCaducidad(p.fecha_caducidad);
                if (dias < 0) {
                    return 'caducado';
                }
                if (dias <= CADUCIDAD_PROXIMA_DIAS) {
                    hayProximo = true;
                }
            }

            return hayProximo ? 'proximo' : 'optimo';
        }

        function aplicarColorEstanteria(rect, productos) {
            // SOLO aplicar colores si es admin
            if (!IS_ROOT) {
                rect.classList.remove('vacia', 'caducado', 'proximo', 'optimo');
                return;
            }

            rect.classList.remove('vacia', 'caducado', 'proximo', 'optimo');
            const estado = estadoEstanteria(productos);
            rect.classList.add(estado);

            const etiqueta = rect.parentElement.querySelector('.estanteria-label');
            if (etiqueta) {
                etiqueta.classList.toggle('contraste-alto', estado === 'caducado' || estado === 'proximo');
            }
        }

        function agregarAlCarrito(producto) {
            const existente = carrito.find(p => p.producto_id === producto.id);
            const stockMax = Number(producto.stock_max ?? 0);

            if (stockMax <= 0) {
                alert('Este producto no tiene stock disponible.');
                return;
            }

            if (existente) {
                // Si cambia el stock en servidor, mantenemos el limite actualizado en carrito
                existente.stock_max = stockMax;

                if (existente.cantidad >= stockMax) {
                    alert(`No puedes anadir mas unidades de ${producto.nombre}. Stock disponible: ${stockMax}.`);
                    return;
                }
                existente.cantidad += 1;
            } else {
                carrito.push({
                    producto_id: producto.id,
                    nombre: producto.nombre,
                    cantidad: 1,
                    precio: producto.precio_final,
                    stock_max: stockMax
                });
            }
            actualizarCarrito();
        }

        function eliminarDelCarrito(productId) {
            carrito = carrito.filter(p => p.producto_id !== productId);
            actualizarCarrito();
        }

	function sumarCantidad(id) {
	    const item = carrito.find(p => p.producto_id === id);

	    if (!item) return;

	    if (item.cantidad < item.stock_max) {
	        item.cantidad++;
	    }

	    actualizarCarrito();
	}

	function restarCantidad(id) {
	    const item = carrito.find(p => p.producto_id === id);

	    if (!item) return;

	    item.cantidad--;

	    if (item.cantidad <= 0) {
	        carrito = carrito.filter(p => p.producto_id !== id);
	    }

	    actualizarCarrito();
	}

        function actualizarCarrito() {
            localStorage.setItem('carrito', JSON.stringify(carrito));
            renderizarCarrito();
        }

        function renderizarCarrito() {
            const panelCarrito = document.getElementById('panel-carrito');
            const itemsDiv = document.getElementById('carrito-items');
            const totalDiv = document.getElementById('carrito-total');
            const btnComprar = document.getElementById('btn-comprar');

            if (carrito.length === 0) {
                itemsDiv.innerHTML = '<p class="text-slate-500 italic text-center">Carrito vacío</p>';
                totalDiv.innerText = '0,00€';
                btnComprar.disabled = true;
                return;
            }

            let total = 0;
            itemsDiv.innerHTML = carrito.map(item => {
                const subtotal = item.precio * item.cantidad;
                total += subtotal;

                return `
		    <div class="p-3 sm:p-4 bg-white/80 rounded-xl border border-amber-100 shadow-sm">

		        <div class="flex justify-between gap-3 items-start">

		            <div class="flex-1 min-w-0">
		                <h5 class="font-bold text-slate-900 text-sm sm:text-base truncate">
		                    ${item.nombre}
		                </h5>

		                <p class="text-xs text-slate-500 mt-1">
		                    ${item.precio.toFixed(2)}€ por unidad
		                </p>

		                <p class="font-black text-indigo-700 mt-2 text-sm sm:text-base">
		                    ${subtotal.toFixed(2)}€
		                </p>
		            </div>

		            <div class="flex items-center gap-2 shrink-0">

		                <button
		                    onclick="restarCantidad(${item.producto_id})"
		                    class="w-8 h-8 rounded-full bg-slate-200 hover:bg-slate-300 font-bold text-lg"
		                >
		                    −
		                </button>

		                <span class="font-bold text-sm min-w-[20px] text-center">
		                    ${item.cantidad}
		                </span>

		                <button
		                    onclick="sumarCantidad(${item.producto_id})"
		                    class="w-8 h-8 rounded-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-lg"
		                >
		                    +
		                </button>

		            </div>
		        </div>
		    </div>
		`;
            }).join('');

            totalDiv.innerText = total.toFixed(2) + '€';
            btnComprar.disabled = false;
        }

        document.getElementById('btn-limpiar').addEventListener('click', function () {
            if (confirm('¿Vaciar carrito?')) {
                carrito = [];
                actualizarCarrito();
            }
        });

        document.getElementById('btn-comprar').addEventListener('click', function () {
            if (carrito.length === 0) {
                alert('Carrito vacío');
                return;
            }

            window.location.href = '<?php echo e(route("checkout.index")); ?>';
        });

        document.querySelectorAll('.estanteria-group').forEach(group => {
            const rect = group.querySelector('.estanteria-rect');
            const id = group.getAttribute('data-id');

            fetch(`api/estanteria/${id}/productos`)
                .then(res => res.json())
                .then(productos => {
                    aplicarColorEstanteria(rect, productos);
                })
                .catch(() => {
                    if (IS_ROOT) rect.classList.add('vacia');
                });

            group.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');

                document.querySelectorAll('.estanteria-rect').forEach(r => r.classList.remove('active'));
                this.querySelector('.estanteria-rect').classList.add('active');

                fetch(`api/estanteria/${id}/productos`)
                    .then(res => {
                        if (!res.ok) {
                            throw new Error(`HTTP error! status: ${res.status}`);
                        }
                        return res.json();
                    })
                    .then(productos => {
                        console.log(`=== Estantería ${id} (${nombre}) ===`);
                        console.log(`Total productos: ${productos.length}`);
                        productos.forEach((p, i) => {
                            const dias = diasHastaCaducidad(p.fecha_caducidad);
                            console.log(`  ${i+1}. ${p.nombre} | Stock: ${p.stock_actual} | Vence: ${p.fecha_caducidad} (${dias} días) | Precio: ${p.precio_final}€`);
                        });
                        
                        aplicarColorEstanteria(this.querySelector('.estanteria-rect'), productos);
                        
			const panel = document.getElementById('panel-productos');
			const lista = document.getElementById('lista-productos');
			
			//Mostrar carrito solo si es cliente
                        if (!IS_ROOT) {
                            document.getElementById('panel-carrito').style.display = 'block';
                        }
                        
                        document.getElementById('titulo-estanteria').innerText = nombre;
                        lista.innerHTML = '';

                        if (productos.length === 0) {
                            lista.innerHTML = '<p class="text-slate-600 italic text-center bg-white/80 border border-amber-100 rounded-xl p-3">Sin stock disponible.</p>';
                            return;
                        }

                        productos.forEach(p => {
                            const dias = diasHastaCaducidad(p.fecha_caducidad);
                            
                            // Determinar si está caducado
                            const esCaducado = dias < 0;
                            
                            // SOLO mostrar badge de estado si es admin
                            const badgeCaducidad = IS_ROOT ? (
                                esCaducado
                                    ? '<span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-[11px] font-semibold text-red-700">⚠️ CADUCADO</span>'
                                    : dias <= CADUCIDAD_PROXIMA_DIAS
                                    ? `<span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-[11px] font-semibold text-amber-700">Caduca en ${dias} d</span>`
                                    : '<span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">En fecha</span>'
                            ) : '';

                            const infoExtra = IS_ROOT ? `<div class="text-[11px] mt-2 font-semibold text-slate-600">Caduca: ${p.fecha_caducidad || 'N/A'}</div>` : '';

                            // Mostrar el precio con descuento si aplica
                            const precioHTML = !esCaducado && p.tiene_descuento
                                ? `<div class="flex items-center gap-2 mt-3 pt-2 border-t border-amber-100">
                                    <span class="text-sm line-through text-slate-400">${p.precio.toFixed(2)}€</span>
                                    <span class="font-black text-lg text-emerald-600">${p.precio_final.toFixed(2)}€</span>
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700">-30%</span>
                                   </div>`
                                : !esCaducado
                                ? `<div class="text-lg font-black text-indigo-700 mt-3 pt-2 border-t border-amber-100">${p.precio_final.toFixed(2)}€</div>`
                                : `<div class="text-lg font-black text-red-600 mt-3 pt-2 border-t border-red-200 line-through opacity-50">${p.precio_final.toFixed(2)}€</div>`;

                            // SOLO mostrar botón de compra si es cliente Y producto NO caducado
                            let btnCompra = '';
                            if (!IS_ROOT && !esCaducado) {
                                btnCompra = `<button class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 sm:py-2 px-3 text-sm sm:text-base rounded-lg transition mt-3 btn-agregar-carrito" data-producto-id="${p.id}" data-producto-nombre="${escapeHtml(p.nombre)}" data-producto-precio="${p.precio_final}" data-producto-stock="${p.stock_actual}">+ Añadir al Carrito</button>`;
                            }

                            const card = document.createElement('div');
                            card.className = `
			    p-3 sm:p-5
			    bg-white/85
			    rounded-2xl
			    border
			    animate-fade-in
			    shadow-sm
			    ${esCaducado ? 'border-red-300 opacity-60' : 'border-amber-100'}
			`;
                            
				card.innerHTML = `
				    ${p.imagen ? `
				        <img 
				            src="<?php echo e(url('public/storage')); ?>/${p.imagen}" 
				            alt="${escapeHtml(p.nombre)}"
				            class="w-full h-30 sm:h-32 md:h-40 object-contain rounded-xl mb-3 border border-slate-200"
				        >
				    ` : ''}

				    <div class="flex justify-between items-start gap-3">
				        <h4 class="font-bold text-slate-900 text-sm sm:text-lg">${escapeHtml(p.nombre)}</h4>
				        ${badgeCaducidad}
				    </div>

				    <p class="text-xs text-slate-600 mt-2">
				        Stock: <span class="font-semibold text-slate-900">${p.stock_actual}</span>
				    </p>

				    ${infoExtra}
				    ${precioHTML}
				    ${btnCompra}
				`;

			// Agregar listener si no es admin y no está caducado
                            if (!IS_ROOT && !esCaducado) {
                                const btnAgregar = card.querySelector('.btn-agregar-carrito');
                                if (btnAgregar) {
                                    btnAgregar.addEventListener('click', function() {
                                        agregarAlCarrito({
                                            id: parseInt(this.dataset.productoId),
                                            nombre: this.dataset.productoNombre,
                                            precio_final: parseFloat(this.dataset.productoPrecio),
                                            stock_max: parseInt(this.dataset.productoStock, 10)
                                        });
                                    });
                                }
                            }
                            
                            lista.appendChild(card);
                        });
                    })
                    .catch(error => {
                        console.error('Error cargando productos:', error);
                        const lista = document.getElementById('lista-productos');
                        lista.innerHTML = `<p class="text-red-600 text-center p-3">Error: ${error.message}</p>`;
                    });
            });
        });

        // Mostrar carrito inicial si hay items
        renderizarCarrito();
    </script>
    
    <footer class="bg-slate-950 text-slate-300 mt-20 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="grid md:grid-cols-3 gap-8">

            <div>
                <h3 class="text-xl font-bold text-white mb-3">UBIKA</h3>
                <p class="text-sm">
                    Plataforma inteligente para localización y gestión de productos.
                </p>
            </div>

            <div>
                <h4 class="font-bold text-white mb-3">Información</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('sobre')); ?>">Sobre Nosotros</a></li>
                    <li><a href="<?php echo e(route('contacto')); ?>">Contacto</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-white mb-3">Legal</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="<?php echo e(route('privacidad')); ?>">Privacidad</a></li>
                    <li><a href="<?php echo e(route('terminos')); ?>">Términos</a></li>
                    <li><a href="<?php echo e(route('cookies')); ?>">Cookies</a></li>
                </ul>
            </div>

        </div>

        <div class="border-t border-slate-800 mt-8 pt-6 text-center text-sm">
            © <?php echo e(date('Y')); ?> UBIKA · Proyecto Final de Desarrollo Web
        </div>

    </div>
</footer>    
    </body>
</html>
<?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/welcome.blade.php ENDPATH**/ ?>