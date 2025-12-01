@if($fichas->isEmpty())
    <div class="d-flex flex-column align-items-center justify-content-center h-100">
        <div class="text-center mb-4">
            <i class="bi bi-egg-fried display-1 text-muted"></i>
            <h4 class="mt-3">No hay pedidos pendientes en cocina</h4>
        </div>
    </div>
@else
<div class="mesas-grid">
    @foreach($fichas as $ficha)
        @php
            // Filtrar productos válidos para mostrar en cocina
            $productosCocina = $ficha->productos->filter(function($producto) {
                return $producto->producto && $producto->producto->familiaObj && $producto->producto->familiaObj->mostrar_en_cocina;
            });
        @endphp
        @if($productosCocina->count() > 0)
        <div class="mesa-card mesa-cocina position-relative animate-slide-in" data-mesa-id="{{ $ficha->uuid }}">
            <!-- @if($ficha->ultima_apertura)
                <span class="badge badge-time text-white position-absolute top-0 start-0 ms-3 mt-2 bg-gradient-cocina" style="font-size:1.1rem;z-index:2;padding:.4em 1.2em;min-width:110px;" title="Fecha y hora de apertura">
                    <i class="bi bi-clock-history" style="color:white;"></i> {{ $ficha->ultima_apertura->format('d/m H:i') }}
                </span>
            @endif
            <span class="badge badge-comensales text-white position-absolute top-0 end-0 m-2 bg-gradient-cocina" style="font-size:1.1rem;z-index:2;padding:.5em 1em;" title="Comensales">
                <i class="bi bi-people-fill" style="color:white;"></i> {{ $ficha->numero_comensales ?? '-' }}
            </span> -->
            <div class="mesa-numero mesa-toggle text-center mesa-header-clickable" style="cursor:pointer; width:100%; font-weight:700; font-size:2rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.1);" data-mesa="{{ $ficha->uuid }}">
                {{ $ficha->descripcion }}
            </div>
            @if(!empty($ficha->observaciones))
            <div class="text-center text-muted" style="font-size:0.95rem; margin-top:0.1rem; margin-bottom:0.5rem;">
                <i class="bi bi-chat-left-text"></i> {{ $ficha->observaciones }}
            </div>
            @endif
            <div class="mesa-info mesa-articulos show" id="mesa-articulos-{{ $ficha->uuid }}">
                <ul class="list-group mesa-acciones">
                    @foreach($productosCocina as $producto)
                    <li class="list-group-item d-flex justify-content-between align-items-center producto-item" data-producto-id="{{ $producto->uuid }}">
                        <span class="articulo-nombre"><span class="cantidad-badge">{{ $producto->cantidad }}x</span> {{ $producto->producto->nombre }}</span>
                        <button class="btn btn-preparar preparar-btn" data-id="{{ $producto->uuid }}">
                            <i class="bi bi-hand-thumbs-up-fill"></i>
                        </button>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    @endforeach
</div>
@endif
