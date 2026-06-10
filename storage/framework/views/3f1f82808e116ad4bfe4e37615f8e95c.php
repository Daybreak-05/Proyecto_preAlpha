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
        :root {
            --bg-1: #0f172a;
            --bg-2: #133b47;
            --panel: rgba(255, 255, 255, 0.92);
            --panel-border: rgba(148, 163, 184, 0.28);
        }

        .checkout-bg {
            background:
                radial-gradient(circle at 15% 15%, rgba(45, 212, 191, 0.18), transparent 28%),
                radial-gradient(circle at 85% 10%, rgba(251, 191, 36, 0.14), transparent 26%),
                linear-gradient(160deg, var(--bg-1) 0%, var(--bg-2) 58%, #eef1eb 100%);
        }

        .glass-panel {
            background: var(--panel);
            border: 1px solid var(--panel-border);
            box-shadow: 0 24px 60px -30px rgba(15, 23, 42, 0.7);
        }

        .ticket-line { border-bottom: 1px dashed rgba(148, 163, 184, 0.55); }
        .payment-card input:checked + .payment-card-ui {
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
            background: linear-gradient(180deg, rgba(240, 253, 250, 0.98), rgba(236, 253, 245, 0.94));
        }
    </style>

    <div class="min-h-screen checkout-bg text-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-8">
                <div>
                    <p class="text-xs uppercase tracking-[0.35em] text-emerald-200 font-semibold">Pasarela de pago</p>
                    <h1 class="mt-2 text-3xl lg:text-5xl font-black text-white tracking-tight">Revisa tu ticket y elige cómo pagar</h1>
                    <p class="mt-3 text-sm lg:text-base text-slate-200 max-w-2xl">Aquí puedes comprobar el resumen final antes de confirmar la compra. El stock se descuenta solo al completar el pago.</p>
                </div>
                <a href="<?php echo e(route('index')); ?>" class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/10 px-4 py-2 text-sm font-bold text-white transition hover:bg-white/15">
                    Volver a la tienda
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8">
                <section class="glass-panel rounded-3xl p-6 lg:p-8 lg:col-span-8">
                    <div class="flex items-center justify-between gap-4 border-b border-slate-200 pb-5 mb-6">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-slate-500 font-bold">Resumen del ticket</p>
                            <h2 class="text-2xl lg:text-3xl font-black text-slate-900 mt-2">Tu compra</h2>
                        </div>
                        <div class="rounded-2xl bg-slate-900 px-4 py-3 text-right text-white">
                            <p class="text-[10px] uppercase tracking-[0.28em] text-slate-300 font-bold">Total</p>
                            <p id="ticket-total-header" class="text-2xl font-black">0,00€</p>
                        </div>
                    </div>

                    <div id="ticket-items" class="space-y-4">
                        <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                            Cargando ticket...
                        </div>
                    </div>
                </section>

                <aside class="space-y-6 lg:col-span-4">
                    <section class="glass-panel rounded-3xl p-6 lg:p-8">
                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500 font-bold">Opciones de pago</p>
                        <h2 class="text-2xl font-black text-slate-900 mt-2">Elige tu método</h2>

                        <div class="mt-5 space-y-3">
                            <label class="payment-card block cursor-pointer">
                                <input type="radio" name="metodo_pago" value="tarjeta" class="sr-only" checked>
                                <div class="payment-card-ui rounded-2xl border border-slate-200 p-4 transition">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="font-bold text-slate-900">Tarjeta</p>
                                            <p class="text-sm text-slate-500">Pago seguro con Stripe Checkout</p>
                                        </div>
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">Recomendado</span>
                                    </div>
                                </div>
                            </label>

                            <label class="payment-card block cursor-pointer">
                                <input type="radio" name="metodo_pago" value="paypal" class="sr-only">
                                <div class="payment-card-ui rounded-2xl border border-slate-200 p-4 transition">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="font-bold text-slate-900">PayPal</p>
                                            <p class="text-sm text-slate-500">Pago rápido con tu cuenta</p>
                                        </div>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-700">Online</span>
                                    </div>
                                </div>
                            </label>

                            <label class="payment-card block cursor-pointer">
                                <input type="radio" name="metodo_pago" value="bizum" class="sr-only">
                                <div class="payment-card-ui rounded-2xl border border-slate-200 p-4 transition">
                                    <div class="flex items-center justify-between gap-3">
                                        <div>
                                            <p class="font-bold text-slate-900">Herramienta de prueba</p>
                                            <p class="text-sm text-slate-500">Pago rápido para test</p>
                                        </div>
                                        <span class="rounded-full bg-cyan-100 px-3 py-1 text-xs font-bold text-cyan-700">Intantáneo</span>
                                    </div>
                                </div>
                            </label>
                        </div>

                    </section>

                    <section class="glass-panel rounded-3xl p-6 lg:p-8">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-xs uppercase tracking-[0.3em] text-slate-500 font-bold">Finalizar</p>
                                <h3 class="text-2xl font-black text-slate-900 mt-2">Confirmación de pago</h3>
                            </div>
                        </div>

                        <div class="mt-5 rounded-2xl bg-slate-50 p-4 text-sm text-slate-600 leading-6">
                            Al confirmar, validaremos el stock, descontaremos los productos y te llevaremos al ticket final de la compra.
                        </div>

                        <button id="btn-pagar" class="mt-5 w-full rounded-2xl bg-emerald-600 px-5 py-4 text-white font-black text-lg transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-50" disabled>
                            Confirmar y generar ticket
                        </button>

                        <p id="checkout-feedback" class="mt-4 text-sm text-slate-500"></p>
                    </section>
                </aside>
            </div>
        </div>
    </div>

    <script>
        const carrito = JSON.parse(localStorage.getItem('carrito') || '[]');
        const ticketItems = document.getElementById('ticket-items');
        const ticketTotalHeader = document.getElementById('ticket-total-header');
        const btnPagar = document.getElementById('btn-pagar');
        const feedback = document.getElementById('checkout-feedback');
        

        function money(value) {
            return `${Number(value || 0).toFixed(2)}€`;
        }

        function getMetodoSeleccionado() {
            const radio = document.querySelector('input[name="metodo_pago"]:checked');
            return radio ? radio.value : 'tarjeta';
        }

        function renderTicket() {
            if (!carrito.length) {
                ticketItems.innerHTML = `
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                        No hay productos en el carrito. Vuelve a la tienda para añadir artículos antes de pagar.
                    </div>
                `;
                ticketTotalHeader.textContent = '0,00€';
                btnPagar.disabled = true;
                feedback.textContent = 'Tu carrito está vacío.';
                return;
            }

            let total = 0;
            ticketItems.innerHTML = carrito.map(item => {
                const precio = Number(item.precio ?? item.precio_final ?? 0);
                const cantidad = Number(item.cantidad ?? 0);
                const subtotal = precio * cantidad;
                total += subtotal;

                return `
                    <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">${item.nombre}</h4>
                                <p class="mt-1 text-sm text-slate-500">${cantidad} x ${money(precio)}</p>
                            </div>
                            <div class="rounded-xl bg-slate-900 px-3 py-2 text-right text-white">
                                <p class="text-[10px] uppercase tracking-[0.22em] text-slate-300 font-bold">Subtotal</p>
                                <p class="text-base font-black">${money(subtotal)}</p>
                            </div>
                        </div>
                    </article>
                `;
            }).join('');

            ticketTotalHeader.textContent = money(total);
            btnPagar.disabled = false;
            feedback.textContent = 'Todo listo para confirmar el pago.';
        }

        btnPagar.addEventListener('click', async function () {
            if (!carrito.length) {
                feedback.textContent = 'El carrito está vacío.';
                return;
            }

            const metodoPago = getMetodoSeleccionado();

            this.disabled = true;
            this.textContent = 'Procesando pago...';
            feedback.textContent = 'Validando compra y actualizando stock...';

            try {
                const response = await fetch('<?php echo e(route("carrito.procesar")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: JSON.stringify({
                        carrito,
                        metodo_pago: metodoPago,
                        
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.error || 'No se pudo completar el pago');
                }

                if (metodoPago === 'tarjeta') {
                    if (!data.checkout_url) {
                        throw new Error(data.error || 'No se pudo iniciar el pago con Stripe');
                    }

                    feedback.textContent = 'Redirigiendo a Stripe...';
                    window.location.href = data.checkout_url;
                    return;
                }

                if (metodoPago === 'paypal') {
                    if (!data.approval_url) {
                        throw new Error(data.error || 'No se pudo iniciar el pago con PayPal');
                    }

                    feedback.textContent = 'Redirigiendo a PayPal...';
                    window.location.href = data.approval_url;
                    return;
                }

                localStorage.removeItem('carrito');
                window.location.href = data.pedido_url;
            } catch (error) {
                feedback.textContent = error.message;
                this.disabled = false;
                this.textContent = 'Confirmar pago';
            }
        });

        renderTicket();
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
<?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/checkout.blade.php ENDPATH**/ ?>