<style>
    :root {
        --bg-base: #eef1eb;
        --bg-soft: #f7f5ef;
        --panel-tint: #fffaf0;
        --ink-strong: #1f2937;
        --ink-soft: #475569;
    }

    .fondo-almacen {
        background:
            radial-gradient(circle at 8% 12%, rgba(20, 184, 166, 0.12), transparent 34%),
            radial-gradient(circle at 88% 86%, rgba(251, 146, 60, 0.14), transparent 30%),
            linear-gradient(160deg, var(--bg-base) 0%, #e8ede5 48%, #e9eef7 100%);
    }

    .tarjeta-mapa {
        background: linear-gradient(175deg, #ffffff 0%, #f6f8f4 100%);
        border-color: #d8e0d4;
        box-shadow: 0 18px 30px -22px rgba(30, 41, 59, 0.45);
    }

    .panel-productos-ui {
        background: linear-gradient(180deg, #fffdf8 0%, #f8f4ec 100%);
        border-color: #e6dcc9;
        box-shadow: 0 18px 34px -20px rgba(31, 41, 55, 0.45);
    }

    .mapa-canvas {
        background:
            linear-gradient(0deg, rgba(148, 163, 184, 0.12) 1px, transparent 1px),
            linear-gradient(90deg, rgba(148, 163, 184, 0.12) 1px, transparent 1px),
            var(--bg-soft);
        background-size: 24px 24px, 24px 24px, auto;
        border-color: #cbd5e1;
    }

    .estanteria {
        fill: #16a34a;
        transition: fill 0.2s ease, stroke 0.2s ease, opacity 0.2s ease;
        cursor: pointer;
    }

    .estanteria:hover {
        opacity: 0.92;
    }

    .estanteria.vacia { fill: #94a3b8; }
    .estanteria.proximo { fill: #d97706; }
    .estanteria.caducado { fill: #dc2626; }
    .estanteria.optimo { fill: #16a34a; }

    .estanteria.active {
        stroke: #1d4ed8;
        stroke-width: 4;
    }

    .estanteria-label {
        fill: #111827;
        stroke: #ffffff;
        stroke-width: 1.5;
        paint-order: stroke;
    }

    .estanteria-label.contraste-alto {
        fill: #ffffff;
        stroke: #111827;
        stroke-width: 1;
    }
</style>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa Interactivo UBIKA</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="fondo-almacen font-sans leading-normal tracking-normal text-slate-800">

    <nav class="bg-gradient-to-r from-slate-900 via-slate-800 to-teal-900 shadow-sm p-4 flex justify-between items-center px-12 border-b border-teal-800/50 relative z-10">
        <div class="flex items-center gap-3">
            <img src="{{ asset('img/logo.png') }}" alt="UBIKA" class="h-10 w-10">
            <h1 class="text-2xl font-black text-emerald-300 uppercase">UBIKA</h1>
        </div>
        @auth
            <a href="{{ url('/dashboard') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/15 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:bg-white/20 hover:shadow-xl hover:shadow-black/20">
                <svg class="h-4 w-4 text-emerald-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v2H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-1V6a4 4 0 00-4-4zm2 6V6a2 2 0 10-4 0v2h4z" clip-rule="evenodd" />
                </svg>
                <span>Acceso</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-black/10 transition hover:-translate-y-0.5 hover:bg-white/20 hover:shadow-xl hover:shadow-black/20">
                <svg class="h-4 w-4 text-emerald-200" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v2H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-1V6a4 4 0 00-4-4zm2 6V6a2 2 0 10-4 0v2h4z" clip-rule="evenodd" />
                </svg>
                <span>Acceso</span>
            </a>
        @endauth
    </nav>

    <main class="container mx-auto mt-8 p-4">
        <div class="flex flex-col lg:flex-row gap-8">
            @if(Auth::check() && Auth::user()->email === 'root@example.com')
                <div class="flex justify-center gap-6 mb-4 text-xs font-bold uppercase tracking-widest text-gray-600">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-green-600 rounded-full"></span> Óptimo
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-amber-600 rounded-full"></span> Caducidad Próxima
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-red-600 rounded-full"></span> Crítico / Caducado
                    </div>
                </div>
            @endif            
            <div class="flex-1 tarjeta-mapa p-6 rounded-2xl border">
                <h2 class="text-lg font-bold text-slate-700 mb-4 flex items-center">
                    <span class="mr-2">📍</span> Plano de Planta Baja
                </h2>
                <svg id="mapa-almacen" viewBox="0 0 800 600" class="w-full h-auto border border-dashed rounded-lg mapa-canvas">
                    @foreach($estanterias as $e)
                        @php
                            // Determina el color según si es admin
                            $esRoot = Auth::check() && Auth::user()->email === 'root@example.com';
                            $colorRelleno = $esRoot ? $e->color_gestion : '#e5e7eb';
                        @endphp

                        <g class="estanteria-group cursor-pointer" data-id="{{ $e->id }}" data-nombre="{{ $e->nombre }}">
                            <rect x="{{ $e->x }}" y="{{ $e->y }}" width="{{ $e->ancho }}" height="{{ $e->alto }}" 
                                data-id="{{ $e->id }}"
                                data-nombre="{{ $e->nombre }}"
                                fill="{{ $colorRelleno }}" 
                                stroke="{{ $esRoot ? '#374151' : '#e2e8f0' }}" 
                                stroke-width="{{ $esRoot ? '2' : '1' }}" 
                                rx="12"
                                class="estanteria transition-all duration-300 hover:opacity-80" />
                            
                            <text x="{{ $e->x + $e->ancho/2 }}" y="{{ $e->y + $e->alto/2 }}" 
                                text-anchor="middle" font-size="10" font-weight="bold" 
                                class="estanteria-label {{ $esRoot ? '' : 'contraste-alto' }} uppercase pointer-events-none select-none">
                                {{ $e->nombre }}
                            </text>
                        </g>
                    @endforeach
                </svg>
            </div>

            <div id="panel-productos" class="w-full lg:w-96 panel-productos-ui p-6 rounded-2xl border hidden lg:sticky lg:top-6 self-start">
                <h3 id="titulo-estanteria" class="text-xl font-bold text-slate-900 mb-4 border-b border-slate-200 pb-3">Productos</h3>
                <ul id="lista-productos" class="space-y-3">
                    </ul>
            </div>
        </div>
    </main>

    <script>
        const CADUCIDAD_PROXIMA_DIAS = 7;

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

        function colorCaducidadTexto(fechaCaducidad) {
            const dias = diasHastaCaducidad(fechaCaducidad);
            if (dias < 0) return '#b91c1c';
            if (dias <= CADUCIDAD_PROXIMA_DIAS) return '#b45309';
            return '#111827';
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
            rect.classList.remove('vacia', 'caducado', 'proximo', 'optimo');
            const estado = estadoEstanteria(productos);
            if (estado) {
                rect.classList.add(estado);
            }

            const etiqueta = rect.parentElement.querySelector('.estanteria-label');
            if (etiqueta) {
                etiqueta.classList.toggle('contraste-alto', estado === 'caducado' || estado === 'proximo');
            }
        }

        function renderProductos(nombre, productos) {
            const panel = document.getElementById('panel-productos');
            const lista = document.getElementById('lista-productos');
            const titulo = document.getElementById('titulo-estanteria');

            panel.classList.remove('hidden');
            titulo.innerText = 'Productos en: ' + nombre;
            lista.innerHTML = '';

            if (!productos || productos.length === 0) {
                lista.innerHTML = '<li class="text-slate-600 italic bg-white/80 border border-amber-100 rounded-lg p-3">No hay productos aquí.</li>';
                return;
            }

            productos.forEach(prod => {
                const colorNombre = colorCaducidadTexto(prod.fecha_caducidad);
                const dias = diasHastaCaducidad(prod.fecha_caducidad);
                const estadoCaducidad = dias < 0
                    ? '<span class="inline-flex items-center rounded-full bg-red-100 px-2 py-0.5 text-[11px] font-semibold text-red-700">Caducado</span>'
                    : dias <= CADUCIDAD_PROXIMA_DIAS
                    ? `<span class="inline-flex items-center rounded-full bg-amber-100 px-2 py-0.5 text-[11px] font-semibold text-amber-700">Caduca en ${dias} d</span>`
                    : '<span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[11px] font-semibold text-emerald-700">En fecha</span>';

                // Mostrar el precio con descuento si aplica
                const precioHTML = prod.tiene_descuento
                    ? `<div class="flex items-center gap-2">
                        <span class="text-sm line-through text-slate-400">${prod.precio.toFixed(2)}€</span>
                        <span class="font-black text-lg text-emerald-600">${prod.precio_final.toFixed(2)}€</span>
                        <span class="inline-flex items-center rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-700">-30%</span>
                       </div>`
                    : `<span class="font-black text-indigo-700">${prod.precio_final.toFixed(2)}€</span>`;

                lista.innerHTML += `
                    <li class="p-4 bg-white/85 rounded-xl border border-amber-100 shadow-sm">
                	${prod.imagen ? `<img src="/piconmp/proyecto/Proyecto_Alpha/storage/${prod.imagen}" class="w-full h-40 object-cover rounded-xl mb-3 border border-slate-200"
			    >
			` : ''}
			 <div class="flex items-start justify-between gap-2 mb-2"
		            <div class="font-bold" style="color: ${colorNombre}">${prod.nombre}</div>
                            ${estadoCaducidad}
                        </div>
                        <div class="text-xs text-slate-600">Stock: <span class="font-semibold text-slate-800">${prod.stock_actual}</span></div>
                        <div class="text-xs text-slate-600 mt-1">Caducidad: ${prod.fecha_caducidad ?? 'Sin fecha'}</div>
                        <div class="mt-3 pt-2 border-t border-amber-100">
                            ${precioHTML}
                        </div>
                    </li>
                `;
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const estanterias = document.querySelectorAll('.estanteria');

            estanterias.forEach(rect => {
                const id = rect.getAttribute('data-id');

                fetch(`api/estanteria/${id}/productos`)
                    .then(res => res.json())
                    .then(productos => {
                        aplicarColorEstanteria(rect, productos);
                    })
                    .catch(() => {
                        rect.classList.add('vacia');
                    });

                rect.addEventListener('click', function () {
                    const nombre = this.getAttribute('data-nombre');

                    document.querySelectorAll('.estanteria').forEach(r => r.classList.remove('active'));
                    this.classList.add('active');

                    fetch(`api/estanteria/${id}/productos`)
                        .then(res => res.json())
                        .then(productos => {
                            aplicarColorEstanteria(this, productos);
                            renderProductos(nombre, productos);
                        })
                        .catch(() => {
                            renderProductos(nombre, []);
                        });
                });
            });
        });
    </script>
</body>
</html>
