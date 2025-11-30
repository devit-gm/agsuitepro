@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-egg-fried"></i> {{ __('Cocina - Pedidos por Mesa') }}
                        </h5>
                    </div>
                </div>
                <div class="card-body overflow-auto flex-fill p-3">
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
                            @foreach($ficha->productos->where('estado', 'pendiente') as $producto)
                                @if($producto->producto && $producto->producto->familiaObj && $producto->producto->familiaObj->mostrar_en_cocina)
                                <div class="mesa-card mesa-cocina position-relative">
                                    @if($ficha->ultima_apertura)
                                        <span class="badge text-dark position-absolute top-0 start-0 ms-3 mt-2" style="font-size:1.1rem;opacity:0.92;z-index:2;padding:.4em 1.2em;min-width:110px;" title="Fecha y hora de apertura">
                                            <i class="bi bi-clock-history"></i> {{ $ficha->ultima_apertura->format('d/m H:i') }}
                                        </span>
                                    @endif
                                    <span class="badge text-dark position-absolute top-0 end-0 m-2" style="font-size:1.1rem;opacity:0.92;z-index:2;padding:.5em 1em;" title="Comensales">
                                        <i class="bi bi-people-fill"></i> {{ $ficha->numero_comensales ?? '-' }}
                                    </span>
                                    <div class="mesa-numero mesa-toggle text-center" style="cursor:pointer; width:100%; font-weight:600; font-size:2rem; margin-top:1.2rem;" data-mesa="{{ $ficha->uuid }}">
                                        Mesa {{ $ficha->numero_mesa ?? $ficha->uuid }}
                                    </div>
                                    @if(!empty($ficha->observaciones))
                                    <div class="text-center text-muted" style="font-size:0.95rem; margin-top:0.1rem; margin-bottom:0.5rem;">
                                        <i class="bi bi-chat-left-text"></i> {{ $ficha->observaciones }}
                                    </div>
                                    @endif
                                <div class="mesa-info mesa-articulos show" id="mesa-articulos-{{ $ficha->uuid }}">
                                    <ul class="list-group mesa-acciones">
                                        @foreach($ficha->productos->where('estado', 'pendiente') as $producto)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <span class="articulo-nombre">{{ $producto->cantidad }}x {{ $producto->producto->nombre }}</span>
                                            
                                            <button class="btn btn-secondary preparar-btn" data-id="{{ $producto->uuid }}">
                                                <i class="bi bi-egg-fried"></i>
                                            </button>
                                
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@php $esCocineroEnCocina = auth()->check() && auth()->user()->role_id == \App\Enums\Role::COCINERO && request()->is('cocina/mesas'); @endphp
@if(!$esCocineroEnCocina)
<div class="card-footer">
    <div class="d-flex align-items-center justify-content-center">
        @if(Auth::user()->role_id < \App\Enums\Role::COCINERO)
            <div class="d-flex gap-2">
                <a href="{{route('mesas.index')}}" class="btn btn-secondary btn-sm">
                    <i class="bi-grid-3x3-gap-fill"></i>
                </a>
            </div>
        @endif
        <!-- Auto-refresh invisible -->
        <button class="btn btn-sm" id="toggle-refresh" style="display: none !important;">
            <span id="countdown">5</span>
        </button>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .mesa-acciones .btn {
        min-width: 50px;
        height: 45px;
        font-size: 1.2rem;
        padding: 0.5rem 0.75rem;
    }

    .mesas-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .mesa-card.mesa-cocina {
        flex: 1 1 48%;
        min-width: 350px;
        max-width: 48%;
        margin-bottom: 1rem;
        display: block;
    }
    @media (max-width: 768px) {
       
    .mesas-grid {
        display:flex !important;
        padding:0px !important;
    }

        .mesa-card.mesa-cocina {
            flex: 1 1 100% !important;
            min-width: 100%;
            max-width: 100%;
        }
    }
    @media (min-width: 1200px) {
        .mesas-grid {
        display:flex !important;
    }
        .mesa-card.mesa-cocina {
            flex: 1 1 20% !important;
             min-width: 20% !important;
            max-width: 20% !important;
        }
    }

.mesa-acciones .articulo-nombre {
    font-size: 1.3rem;
    letter-spacing: 0.01em;
}

</style>
<style>
    .mesa-articulos {
        transition: max-height 0.3s ease;
        overflow: hidden;
        max-height: 2000px;
        display: block;
    }
    .mesa-articulos:not(.show) {
        max-height: 200px;
        padding: 0 !important;
        display: block !important;
    }
</style>
@endpush

@push('scripts')
<script>
let autoRefreshEnabled = true;
let autoRefreshInterval;
let countdown = 100; // 100 segundos

// Auto-refresh
function iniciarAutoRefresh() {
    autoRefreshInterval = setInterval(() => {
        if (!autoRefreshEnabled) return;
        
        countdown--;
        const countdownEl = document.getElementById('countdown');
        if (countdownEl) {
            countdownEl.textContent = countdown;
        }
        
        if (countdown <= 0) {
            location.reload();
        }
    }, 1000);
}
iniciarAutoRefresh();

document.addEventListener('click', function(e) {
    const btn = e.target.closest('.preparar-btn');
    if (btn) {
        let id = btn.dataset.id;
        btn.disabled = true;
        fetch('/cocina/mesas/preparar', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ ficha_producto: id })
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-secondary');
                btn.innerHTML = '<i class="bi bi-check2"></i>';
                //recargar la página a los 500 ms
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                btn.disabled = false;
                alert(data.message || 'Error');
            }
        })
        .catch(() => {
            btn.disabled = false;
            alert('Error de red');
        });
    }
});

// Soporte para colapsar mesas
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.mesa-toggle').forEach(function(el) {
        el.addEventListener('click', function() {
            const mesaId = el.getAttribute('data-mesa');
            const content = document.getElementById('mesa-articulos-' + mesaId);
            if (content) {
                content.classList.toggle('show');
            }
        });
    });
});
</script>

@endpush
