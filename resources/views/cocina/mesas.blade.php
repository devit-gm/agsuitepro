@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                @php
                    use Illuminate\Support\Facades\Auth;
                    $roleId = Auth::check() ? Auth::user()->role_id : null;
                    $rolCocinero = \App\Enums\Role::COCINERO;
                    $esCocinero = Auth::check() && $roleId == $rolCocinero;
                @endphp
                <div class="card-header position-relative bg-gradient-cocina">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white animate-fade-in">
                            <i class="bi bi-egg-fried pulse-icon" style="color:white !important;"></i> {{ __('Cocina - Pedidos por Mesa') }}
                        </h5>
                    </div>
                    @if($esCocinero)
                    <form id="logout-form-camarero" action="{{ route('logout') }}" method="POST" class="position-absolute" style="top:12px;right:18px;z-index:10;">
                        @csrf
                        <button type="submit" class="btn btn-logout-cocina d-flex align-items-center justify-content-center" title="Cerrar sesión y cambiar de usuario">
                            <i class="bi bi-box-arrow-right" style="color:white !important;"></i>
                        </button>
                    </form>
                    @endif
                </div>
                <div class="card-body overflow-auto flex-fill p-3">
                    @include('cocina.mesas-content')
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
            <span id="countdown">10</span>
        </button>
    </div>
</div>
@endif
@endsection

@push('styles')
@php
    $esCocineroEnCocinaPush = auth()->check() && auth()->user()->role_id == \App\Enums\Role::COCINERO && request()->is('cocina/mesas');
@endphp
@if($esCocineroEnCocinaPush)
<style>
    .main-content, .container-fluid, .card, .card-header, .card-body, .mesa-numero, .mesa-acciones, .mesa-articulos, .list-group-item, .articulo-nombre, .badge, .mesa-cocina, .mesa-info, .mesa-card, .text-muted, .card-footer, h4, h5, span, button, label, .form-label {
        font-size: 1.08em !important;
    }
    .mesa-numero {
        font-size: 1.3em !important;
    }
    .articulo-nombre {
        font-size: 0.7em !important;
    }
    .card-header h5 {
        font-size: 1.15em !important;
    }
    .badge {
        font-size: 0.95em !important;
    }
    .list-group-item {
        padding-top: 0.3em !important;
        padding-bottom: 0.3em !important;
    }
</style>
@endif
<style>
    /* Gradiente para el header */
    .bg-gradient-cocina {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }

    /* Animación del icono principal */
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.1); }
    }
    
    .pulse-icon {
        animation: pulse 2s ease-in-out infinite;
        display: inline-block;
    }

    /* Animación de entrada */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    .animate-slide-in {
        animation: slideIn 0.4s ease-out;
    }

    /* Botón de logout mejorado */
    .btn-logout-cocina {
        font-size: 1.6rem;
        width: 2.5rem;
        height: 2.5rem;
        line-height: 1;
        color: white;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .btn-logout-cocina:hover {
        background: rgba(255,255,255,0.3);
        border-color: white;
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        color: white;
        padding: 5px;
    }

    /* Estilos mejorados para las tarjetas de mesa */
    .mesa-card.mesa-cocina {
        background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
        border: 2px solid #e9ecef;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }

    .mesa-card.mesa-cocina:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        border-color: #667eea;
    }

    /* Highlight para nuevos elementos */
    @keyframes highlight {
        0% { background-color: #fff3cd; }
        100% { background-color: transparent; }
    }

    .highlight-new {
        animation: highlight 2s ease-out;
    }

    /* Header de mesa con efecto hover */
    .mesa-header-clickable:hover {
        color: #667eea;
        transform: scale(1.02);
        transition: all 0.3s ease;
    }

    /* Badges mejorados */
    .badge-time, .badge-comensales {
        border-radius: 12px;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        transition: all 0.3s ease;
    }

    .badge-time:hover, .badge-comensales:hover {
        transform: scale(1.05);
    }

    /* Botón preparar mejorado */
    .btn-preparar {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.2rem;
        border-radius: 10px;
        box-shadow: 0 3px 8px rgba(40,167,69,0.3);
        transition: all 0.3s ease;
    }

    .btn-preparar:hover {
        background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40,167,69,0.4);
        color: white;
    }

    .btn-preparar:active {
        transform: translateY(0);
        box-shadow: 0 2px 5px rgba(40,167,69,0.3);
    }

    .btn-preparar:disabled {
        background: #6c757d;
        box-shadow: none;
    }

    /* Items de producto mejorados */
    .producto-item {
        border-left: 4px solid #dc3545;
        transition: all 0.3s ease;
        background: white;
    }

    .producto-item:hover {
        background: #f8f9fa;
        border-left-color: #c82333;
        transform: translateX(5px);
    }

    /* Badge de cantidad */
    .cantidad-badge {
        display: inline-block;
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
        padding: 0.2em 0.6em;
        border-radius: 8px;
        font-weight: 700;
        margin-right: 0.5em;
        font-size: 0.95em;
    }

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
    @media (max-width: 1199px) {
       
    .mesas-grid {
        display:flex !important;
        padding:0px !important;
    }

        .mesa-card.mesa-cocina {
            flex: 1 1 32% !important;
            min-width: 32%;
            max-width: 32%;
        }
    }
    @media (min-width: 1200px) {
        .mesas-grid {
        display:flex !important;
    }
        .mesa-card.mesa-cocina {
            flex: 1 1 24% !important;
             min-width: 24% !important;
            max-width: 24% !important;
        }
    }
    @media (min-width: 1400px) {
        .mesas-grid {
        display:flex !important;
    }
        .mesa-card.mesa-cocina {
            flex: 1 1 19% !important;
             min-width: 19% !important;
            max-width: 19% !important;
        }
    }

.mesa-acciones .articulo-nombre {
    font-size: 1.3rem;
    letter-spacing: 0.01em;
    text-align: left;
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
let countdown = 10; // 10 segundos
let isUpdating = false;

// Auto-refresh con AJAX
function iniciarAutoRefresh() {
    console.log('🔄 iniciarAutoRefresh() llamado');
    
    // Limpiar intervalo anterior si existe
    if (autoRefreshInterval) {
        console.log('⚠️ Ya existía un intervalo, limpiando...');
        clearInterval(autoRefreshInterval);
    }
    
    autoRefreshInterval = setInterval(() => {
        if (!autoRefreshEnabled) return;
        
        // No decrementar si está actualizando
        if (isUpdating) {
            console.log('⏸️ Actualizando, pausando contador en:', countdown);
            return;
        }
        
        countdown--;
        const countdownEl = document.getElementById('countdown');
        if (countdownEl) {
            countdownEl.textContent = countdown;
        }
        
        if (countdown <= 0) {
            console.log('⏰ Tiempo cumplido, llamando actualizarCocina()');
            actualizarCocina();
            countdown = 10; // Reiniciar contador
        }
    }, 1000);
    
    console.log('✅ Intervalo creado con ID:', autoRefreshInterval);
}

// Actualizar contenido de cocina sin recargar
function actualizarCocina() {
    console.log('🔃 actualizarCocina() llamado - isUpdating:', isUpdating);
    
    if (isUpdating) {
        console.log('⛔ Ya está actualizando, abortando...');
        return;
    }
    
    isUpdating = true;
    console.log('📡 Iniciando fetch a /cocina/mesas/actualizar');
    
    const container = document.querySelector('.card-body');
    
    fetch('/cocina/mesas/actualizar', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'text/html',
        }
    })
    .then(r => r.text())
    .then(html => {
        console.log('📥 HTML recibido, reemplazando contenido suavemente');
        
        // Reemplazar directamente sin fade out
        container.innerHTML = html;
        
        // Resaltar nuevas mesas/productos con un efecto sutil
        document.querySelectorAll('.mesa-card').forEach(card => {
            card.classList.add('highlight-new');
            setTimeout(() => card.classList.remove('highlight-new'), 2000);
        });
        
        console.log('✅ Actualización completa');
        isUpdating = false;
    })
    .catch(err => {
        console.error('❌ Error actualizando cocina:', err);
        isUpdating = false;
    });
}

// Inicializar solo una vez cuando carga la página
if (typeof window.cocinaAutoRefreshIniciado === 'undefined') {
    console.log('🚀 Inicializando sistema de auto-refresh por primera vez');
    window.cocinaAutoRefreshIniciado = true;
    iniciarAutoRefresh();
    
    // Event listener para botones de preparar (delegación de eventos)
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
                    //Actualizar después de 500ms
                    setTimeout(() => {
                        actualizarCocina();
                        countdown = 10; // Reiniciar contador
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
        
        // Soporte para colapsar mesas (delegación de eventos)
        const toggleBtn = e.target.closest('.mesa-toggle');
        if (toggleBtn) {
            const mesaId = toggleBtn.getAttribute('data-mesa');
            const content = document.getElementById('mesa-articulos-' + mesaId);
            if (content) {
                content.classList.toggle('show');
            }
        }
    });
}
</script>

@endpush
