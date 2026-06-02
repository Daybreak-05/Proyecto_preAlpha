<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configurar Nueva Estantería en el Mapa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('estanterias.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre de la Ubicación</label>
                        <input type="text" name="nombre" placeholder="Ej: Pasillo A, Estantería 1..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Posición X (Horizontal)</label>
                            <input type="number" name="x" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Posición Y (Vertical)</label>
                            <input type="number" name="y" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Ancho (px)</label>
                            <input type="number" name="ancho" value="100" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Alto (px)</label>
                            <input type="number" name="alto" value="50" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                    </div>

                    @error('colision')
                        <div class="mt-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700 text-sm font-bold">
                            {{ $message }}
                        </div>
                    @enderror
                    <div class="mt-6 rounded-2xl border border-gray-200 bg-gray-50 p-4">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <h3 class="text-sm font-bold text-gray-800 flex items-center">
                                    <span class="mr-2">👁️</span> Vista previa de ocupación
                                </h3>
                                <p class="text-xs text-gray-500 mt-1">Se abrirá en un modal y se actualizará con los valores del formulario.</p>
                            </div>

                            <button type="button" id="btn-open-preview" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-bold text-white shadow hover:bg-indigo-700 transition">
                                Abrir vista previa
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <a href="{{ route('estanterias.index') }}" class="text-gray-600 hover:underline">Volver</a>
                        <x-primary-button class="bg-indigo-600">Crear Estantería</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="preview-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 px-4">
        <div class="w-full max-w-5xl rounded-3xl bg-white shadow-2xl ring-1 ring-black/5">
            <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Vista previa de la estantería</h3>
                    <p class="text-sm text-gray-500">Posición, tamaño y relación con el resto del mapa</p>
                </div>
                <button type="button" id="btn-close-preview" class="rounded-xl bg-gray-100 px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">Cerrar</button>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_280px] gap-6 p-6">
                <div class="rounded-2xl bg-slate-950 p-4 overflow-auto">
                    <svg id="preview-svg" viewBox="0 0 800 600" class="h-[520px] w-full rounded-xl bg-slate-900 border border-slate-700">
                        @foreach($estanterias_existentes as $existente)
                            <g>
                                <rect x="{{ $existente->x }}" y="{{ $existente->y }}" width="{{ $existente->ancho }}" height="{{ $existente->alto }}" rx="4" fill="#9ca3af" stroke="#e5e7eb" stroke-width="2" stroke-dasharray="3 2" />
                                <text x="{{ $existente->x + 6 }}" y="{{ $existente->y + 16 }}" fill="#111827" font-size="11" font-weight="700">{{ $existente->nombre }}</text>
                                <text x="{{ $existente->x + 6 }}" y="{{ $existente->y + 31 }}" fill="#111827" font-size="10">X:{{ $existente->x }} Y:{{ $existente->y }}</text>
                                <text x="{{ $existente->x + 6 }}" y="{{ $existente->y + 45 }}" fill="#111827" font-size="10">{{ $existente->ancho }} x {{ $existente->alto }}</text>
                            </g>
                        @endforeach

                        <g id="preview-group" transform="translate(0 0)">
                            <rect id="preview-new" x="0" y="0" width="100" height="50" rx="4" fill="rgba(99, 102, 241, 0.55)" stroke="#818cf8" stroke-width="3" />
                            <text id="preview-name" x="8" y="18" fill="#ffffff" font-size="11" font-weight="700">Nueva estantería</text>
                            <text id="preview-xy" x="8" y="33" fill="#ffffff" font-size="10">X:0 Y:0</text>
                            <text id="preview-size" x="8" y="47" fill="#ffffff" font-size="10">100 x 50</text>
                        </g>

                        <rect id="draw-layer" x="0" y="0" width="800" height="600" fill="transparent" style="cursor: crosshair;" />
                    </svg>
                </div>

                <div class="space-y-4">
                    <div class="rounded-2xl bg-indigo-50 p-4">
                        <p class="text-xs font-bold uppercase tracking-wide text-indigo-500">Bloque actual</p>
                        <p id="preview-summary" class="mt-2 text-sm text-gray-700">Completa los campos para ver la posición.</p>
                    </div>

                    <div class="rounded-2xl border border-indigo-200 bg-indigo-50/60 p-4">
                        <p class="text-sm font-bold text-indigo-900">Dibujo rápido</p>
                        <p class="mt-2 text-xs text-indigo-700">Haz clic y arrastra fuera del bloque para dibujar uno nuevo. Haz clic y arrastra dentro del bloque azul para moverlo facilmente.</p>
                        <p id="collision-warning" class="mt-2 text-xs text-red-600 font-bold hidden">⚠️ ¡Colisión detectada! El bloque se solapa con otra estantería.</p>
                    </div>

                    <div class="rounded-2xl border border-gray-200 p-4">
                        <p class="text-sm font-bold text-gray-900 mb-2">Leyenda</p>
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex items-center gap-2"><span class="h-3 w-3 rounded bg-slate-500"></span> Estanterías existentes</div>
                            <div class="flex items-center gap-2"><span class="h-3 w-3 rounded bg-indigo-500"></span> Nueva estantería</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data del servidor como JSON
        const ESTANTERIAS_EXISTENTES = {!! json_encode($estanterias_existentes) !!};

        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('preview-modal');
            const openButton = document.getElementById('btn-open-preview');
            const closeButton = document.getElementById('btn-close-preview');
            const previewSvg = document.getElementById('preview-svg');
            const drawLayer = document.getElementById('draw-layer');
            const previewGroup = document.getElementById('preview-group');
            const previewRect = document.getElementById('preview-new');
            const previewName = document.getElementById('preview-name');
            const previewXY = document.getElementById('preview-xy');
            const previewSize = document.getElementById('preview-size');
            const previewSummary = document.getElementById('preview-summary');
            const SVG_WIDTH = 800;
            const SVG_HEIGHT = 600;

            // Estanterías existentes (data del servidor)
            const existentes = ESTANTERIAS_EXISTENTES;

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
                const warningEl = document.getElementById('collision-warning');
                const createBtn = document.querySelector('button[type="submit"]');

                if (collision) {
                    previewRect.setAttribute('fill', 'rgba(239, 68, 68, 0.55)');
                    previewRect.setAttribute('stroke', '#ef4444');
                    warningEl.classList.remove('hidden');
                    createBtn.disabled = true;
                    createBtn.style.opacity = '0.5';
                } else {
                    previewRect.setAttribute('fill', 'rgba(99, 102, 241, 0.55)');
                    previewRect.setAttribute('stroke', '#818cf8');
                    warningEl.classList.add('hidden');
                    createBtn.disabled = false;
                    createBtn.style.opacity = '1';
                }
            }

            function clamp(value, min, max) {
                return Math.min(max, Math.max(min, value));
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
                const nombre = inputs.nombre.value || 'Nueva estantería';
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
                setText(previewSummary, `${nombre} · Posición (${x}, ${y}) · Tamaño ${ancho} x ${alto}`);
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

            updateCollisionStatus();
            updatePreview();
        });
    </script>
</x-app-layout>