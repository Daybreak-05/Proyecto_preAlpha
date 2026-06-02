<style>
   
    .mapa-cliente {
        filter: grayscale(100%);
        opacity: 0.7;
        pointer-events: none;  
    }
    
    .estanteria-publica {
        fill: #94a3b8;  
        stroke: #64748b;
    }
</style>

<div class="mapa-cliente">
    <svg viewBox="0 0 800 600">
        @foreach($estanterias as $e)
            <rect x="{{ $e->x }}" y="{{ $e->y }}" width="{{ $e->ancho }}" height="{{ $e->alto }}" 
                  class="estanteria-publica" />
        @endforeach
    </svg>
</div>

@if(Auth::user()->isAdmin())
    <a href="{{ route('estanterias.edit', $e->id) }}">Configurar Mapa</a>
@endif