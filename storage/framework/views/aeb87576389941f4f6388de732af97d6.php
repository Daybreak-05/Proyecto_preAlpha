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
            🏗️ Editando Ubicación: <?php echo e($estanteria->nombre); ?>

        </h2>
     <?php $__env->endSlot(); ?>
    

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-2xl rounded-3xl border border-gray-100">
                <form action="<?php echo e(route('estanterias.update', $estanteria->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?> 
                    <?php echo method_field('PUT'); ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-gray-700">Nombre de la Estantería / Pasillo</label>
                            <input type="text" name="nombre" value="<?php echo e(old('nombre', $estanteria->nombre)); ?>" 
                                   class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                        </div>

                        <div class="bg-indigo-50 p-4 rounded-2xl">
                            <label class="block text-sm font-bold text-indigo-900">Coordenada X (Horizontal)</label>
                            <input type="number" name="x" value="<?php echo e(old('x', $estanteria->x)); ?>" 
                                   class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                            <p class="text-xs text-indigo-400 mt-1 italic">Distancia desde la izquierda del mapa.</p>
                        </div>

                        <div class="bg-indigo-50 p-4 rounded-2xl">
                            <label class="block text-sm font-bold text-indigo-900">Coordenada Y (Vertical)</label>
                            <input type="number" name="y" value="<?php echo e(old('y', $estanteria->y)); ?>" 
                                   class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm" required>
                            <p class="text-xs text-indigo-400 mt-1 italic">Distancia desde la parte superior.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Ancho (px)</label>
                            <input type="number" name="ancho" value="<?php echo e(old('ancho', $estanteria->ancho)); ?>" 
                                   class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Alto (px)</label>
                            <input type="number" name="alto" value="<?php echo e(old('alto', $estanteria->alto)); ?>" 
                                   class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm" required>
                        </div>
                    </div>

                    <div class="mt-6 rounded-2xl border border-gray-200 bg-gray-50 p-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 flex items-center">
                                    <span class="mr-2">👁️</span> Vista previa de ocupación
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">La estantería en edición se resalta en azul dentro del modal.</p>
                            </div>

                            <button type="button" id="btn-open-preview-edit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-bold text-white shadow hover:bg-indigo-700 transition">
                                Abrir vista previa
                            </button>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center border-t pt-6">
                        
                        <a href="<?php echo e(route('estanterias.index')); ?>" class="text-gray-400 hover:text-gray-600 font-medium text-sm">
                            ⬅ Cancelar y volver
                        </a>
                        <button type="submit" class="bg-indigo-600 text-white px-10 py-3 rounded-xl font-bold shadow-lg hover:bg-indigo-700 transition">
                            Guardar Cambios en el Mapa
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 text-sm">
                <strong>Importante:</strong> Si cambias las coordenadas, refresca el mapa principal para ver cómo se ha desplazado el rectángulo.
            </div>
        </div>
    </div>

    <div id="preview-modal-edit" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4">
        <div class="w-full max-w-5xl rounded-3xl bg-white shadow-2xl ring-1 ring-black/5">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Vista previa de la estantería</h3>
                    <p class="text-sm text-gray-500">La estantería editada aparece resaltada en azul</p>
                </div>
                <button type="button" id="btn-close-preview-edit" class="rounded-xl bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">Cerrar</button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_280px] gap-6 p-6">
                <div class="rounded-2xl bg-slate-950 p-4 overflow-auto">
                    <svg id="preview-svg-edit" viewBox="0 0 800 600" class="h-[520px] w-full rounded-xl bg-slate-900 border border-slate-700">
                        <?php $__currentLoopData = $estanterias_existentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $existente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <g>
                                <rect x="<?php echo e($existente->x); ?>" y="<?php echo e($existente->y); ?>" width="<?php echo e($existente->ancho); ?>" height="<?php echo e($existente->alto); ?>" rx="4" fill="#9ca3af" stroke="#e5e7eb" stroke-width="2" stroke-dasharray="3 2" />
                                <text x="<?php echo e($existente->x + 6); ?>" y="<?php echo e($existente->y + 16); ?>" fill="#111827" font-size="11" font-weight="700"><?php echo e($existente->nombre); ?></text>
                                <text x="<?php echo e($existente->x + 6); ?>" y="<?php echo e($existente->y + 31); ?>" fill="#111827" font-size="10">X:<?php echo e($existente->x); ?> Y:<?php echo e($existente->y); ?></text>
                                <text x="<?php echo e($existente->x + 6); ?>" y="<?php echo e($existente->y + 45); ?>" fill="#111827" font-size="10"><?php echo e($existente->ancho); ?> x <?php echo e($existente->alto); ?></text>
                            </g>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <g id="preview-group-edit" transform="translate(<?php echo e(old('x', $estanteria->x)); ?> <?php echo e(old('y', $estanteria->y)); ?>)">
                            <rect id="preview-new-edit" x="0" y="0" width="<?php echo e(old('ancho', $estanteria->ancho)); ?>" height="<?php echo e(old('alto', $estanteria->alto)); ?>" rx="4" fill="rgba(59, 130, 246, 0.65)" stroke="#3b82f6" stroke-width="4" />
                            <text id="preview-name-edit" x="6" y="16" fill="#ffffff" font-size="11" font-weight="700"><?php echo e(old('nombre', $estanteria->nombre)); ?></text>
                            <text id="preview-xy-edit" x="6" y="31" fill="#ffffff" font-size="10">X:<?php echo e(old('x', $estanteria->x)); ?> Y:<?php echo e(old('y', $estanteria->y)); ?></text>
                            <text id="preview-size-edit" x="6" y="45" fill="#ffffff" font-size="10"><?php echo e(old('ancho', $estanteria->ancho)); ?> x <?php echo e(old('alto', $estanteria->alto)); ?></text>
                        </g>

                        <rect id="draw-layer-edit" x="0" y="0" width="800" height="600" fill="transparent" style="cursor: crosshair;" />
                    </svg>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl bg-indigo-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wide text-indigo-500">Bloque seleccionado</p>
                        <p id="preview-summary-edit" class="mt-2 text-sm text-gray-700">Ajusta posición y tamaño en el formulario o dibujando en el mapa.</p>
                    </div>

                    <div class="rounded-2xl border border-indigo-200 bg-indigo-50/60 p-4">
                        <p class="text-sm font-bold text-indigo-900">Dibujo y movimiento</p>
                        <p class="mt-2 text-xs text-indigo-700">Haz clic y arrastra fuera del bloque azul para redibujarlo. Haz clic y arrastra dentro del bloque para moverlo facilmente.</p>
                        <p id="collision-warning-edit" class="mt-2 text-xs text-red-600 font-bold hidden">⚠️ ¡Colisión detectada! El bloque se solapa con otra estantería.</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 p-4">
                        <p class="text-sm font-bold text-gray-900 mb-2">Leyenda</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center gap-2"><span class="h-3 w-3 rounded bg-slate-500"></span> Estanterías existentes</div>
                            <div class="flex items-center gap-2"><span class="h-3 w-3 rounded bg-blue-500"></span> Estantería en edición</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data del servidor como JSON
        const ESTANTERIAS_EXISTENTES = <?php echo json_encode($estanterias_existentes); ?>;
        const CURRENT_ESTANTERIA_ID = <?php echo e($estanteria->id); ?>;

        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('preview-modal-edit');
            const openButton = document.getElementById('btn-open-preview-edit');
            const closeButton = document.getElementById('btn-close-preview-edit');
            const previewSvg = document.getElementById('preview-svg-edit');
            const drawLayer = document.getElementById('draw-layer-edit');
            const previewGroup = document.getElementById('preview-group-edit');
            const previewRect = document.getElementById('preview-new-edit');
            const previewName = document.getElementById('preview-name-edit');
            const previewXY = document.getElementById('preview-xy-edit');
            const previewSize = document.getElementById('preview-size-edit');
            const previewSummary = document.getElementById('preview-summary-edit');
            const SVG_WIDTH = 800;
            const SVG_HEIGHT = 600;

            // Estanterías existentes (data del servidor) - excluye la actual
            const existentes = ESTANTERIAS_EXISTENTES;
            const currentEstanteriaId = CURRENT_ESTANTERIA_ID;

            let isDrawing = false;
            let isMoving = false;
            let startX = 0;
            let startY = 0;
            let moveOffsetX = 0;
            let moveOffsetY = 0;
            let hasCollision = false;

            const inputs = {
                nombre: document.querySelector('input[name="nombre"]'),
                x: document.querySelector('input[name="x"]'),
                y: document.querySelector('input[name="y"]'),
                ancho: document.querySelector('input[name="ancho"]'),
                alto: document.querySelector('input[name="alto"]'),
            };

            function setText(node, value) {
                if (node) node.textContent = value;
            }

            function toInt(value, fallback) {
                const parsed = parseInt(value, 10);
                return Number.isNaN(parsed) ? fallback : parsed;
            }

            function clamp(value, min, max) {
                return Math.min(max, Math.max(min, value));
            }

            function checkCollision(x, y, ancho, alto) {
                return existentes.some(e => {
                    const rect1 = { x, y, x2: x + ancho, y2: y + alto };
                    const rect2 = { x: e.x, y: e.y, x2: e.x + e.ancho, y2: e.y + e.alto };

                    return rect1.x < rect2.x2 && rect1.x2 > rect2.x &&
                           rect1.y < rect2.y2 && rect1.y2 > rect2.y;
                });
            }

            function updateCollisionStatus() {
                const current = getCurrentRectValues();
                const collision = checkCollision(current.x, current.y, current.ancho, current.alto);

                hasCollision = collision;
                const warningEl = document.getElementById('collision-warning-edit');
                const saveBtn = document.querySelector('button[type="submit"]');

                if (collision) {
                    previewRect.setAttribute('fill', 'rgba(239, 68, 68, 0.65)');
                    previewRect.setAttribute('stroke', '#ef4444');
                    warningEl.classList.remove('hidden');
                    saveBtn.disabled = true;
                    saveBtn.style.opacity = '0.5';
                } else {
                    previewRect.setAttribute('fill', 'rgba(59, 130, 246, 0.65)');
                    previewRect.setAttribute('stroke', '#3b82f6');
                    warningEl.classList.add('hidden');
                    saveBtn.disabled = false;
                    saveBtn.style.opacity = '1';
                }
            }

            function setRectValues(x, y, ancho, alto) {
                inputs.x.value = Math.round(x);
                inputs.y.value = Math.round(y);
                inputs.ancho.value = Math.max(1, Math.round(ancho));
                inputs.alto.value = Math.max(1, Math.round(alto));
                updatePreview();
                updateCollisionStatus();
            }

            function getCurrentRectValues() {
                return {
                    x: toInt(inputs.x.value, 0),
                    y: toInt(inputs.y.value, 0),
                    ancho: Math.max(1, toInt(inputs.ancho.value, 100)),
                    alto: Math.max(1, toInt(inputs.alto.value, 50)),
                };
            }

            function getSvgCoords(event) {
                const box = previewSvg.getBoundingClientRect();
                const x = ((event.clientX - box.left) / box.width) * SVG_WIDTH;
                const y = ((event.clientY - box.top) / box.height) * SVG_HEIGHT;

                return {
                    x: clamp(x, 0, SVG_WIDTH),
                    y: clamp(y, 0, SVG_HEIGHT),
                };
            }

            function updatePreview() {
                const nombre = inputs.nombre.value || 'Estanteria en edicion';
                const x = toInt(inputs.x.value, 0);
                const y = toInt(inputs.y.value, 0);
                const ancho = toInt(inputs.ancho.value, 100);
                const alto = toInt(inputs.alto.value, 50);

                previewGroup.setAttribute('transform', `translate(${x} ${y})`);
                previewRect.setAttribute('x', 0);
                previewRect.setAttribute('y', 0);
                previewRect.setAttribute('width', ancho);
                previewRect.setAttribute('height', alto);

                setText(previewName, nombre);
                setText(previewXY, `X:${x} Y:${y}`);
                setText(previewSize, `${ancho} x ${alto}`);
                setText(previewSummary, `${nombre} · Posicion (${x}, ${y}) · Tamano ${ancho} x ${alto}`);
            }

            function onDrawStart(event) {
                if (event.button !== 0) return;

                const point = getSvgCoords(event);
                const current = getCurrentRectValues();
                const insideCurrent =
                    point.x >= current.x &&
                    point.x <= current.x + current.ancho &&
                    point.y >= current.y &&
                    point.y <= current.y + current.alto;

                if (insideCurrent) {
                    isMoving = true;
                    moveOffsetX = point.x - current.x;
                    moveOffsetY = point.y - current.y;
                    drawLayer.style.cursor = 'grabbing';
                    return;
                }

                isDrawing = true;
                startX = point.x;
                startY = point.y;
                setRectValues(startX, startY, 1, 1);
            }

            function onDrawMove(event) {
                const point = getSvgCoords(event);

                if (isMoving) {
                    const current = getCurrentRectValues();
                    const maxX = SVG_WIDTH - current.ancho;
                    const maxY = SVG_HEIGHT - current.alto;
                    const x = clamp(point.x - moveOffsetX, 0, Math.max(0, maxX));
                    const y = clamp(point.y - moveOffsetY, 0, Math.max(0, maxY));

                    setRectValues(x, y, current.ancho, current.alto);
                    return;
                }

                if (!isDrawing) return;
                const x = Math.min(startX, point.x);
                const y = Math.min(startY, point.y);
                const ancho = Math.abs(point.x - startX);
                const alto = Math.abs(point.y - startY);

                setRectValues(x, y, ancho, alto);
            }

            function onDrawEnd() {
                isDrawing = false;
                isMoving = false;
                drawLayer.style.cursor = 'crosshair';
            }

            function openModal() {
                updatePreview();
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }

            function closeModal() {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }

            Object.values(inputs).forEach((input) => {
                if (input) {
                    input.addEventListener('input', updatePreview);
                    input.addEventListener('change', updatePreview);
                }
            });

            openButton.addEventListener('click', openModal);
            closeButton.addEventListener('click', closeModal);
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            drawLayer.addEventListener('mousedown', onDrawStart);
            drawLayer.addEventListener('mousemove', onDrawMove);
            window.addEventListener('mouseup', onDrawEnd);

            updatePreview();
            updateCollisionStatus();
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
<?php endif; ?><?php /**PATH /var/www/html/piconmp/proyecto/Proyecto_Alpha/resources/views/estanterias/edit.blade.php ENDPATH**/ ?>