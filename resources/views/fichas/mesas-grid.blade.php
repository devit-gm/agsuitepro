@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-12 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-grid-3x3-gap-fill"></i> {{ __('Mesas') }}
                        </h5>
                        
                        
                    </div>
                </div>

                <div class="card-body overflow-auto flex-fill p-3">
                    @if($mesas->isEmpty())
                        <!-- Mensaje cuando no hay mesas -->
                        <div class="d-flex flex-column align-items-center justify-content-center h-100">
                            <div class="text-center mb-4">
                                <i class="bi bi-grid-3x3-gap display-1 text-muted mb-3"></i>
                                <h3 class="text-muted">{{ __('No hay mesas registradas') }}</h3>
                                <p class="text-secondary">{{ __('Crea tus primeras mesas para comenzar a gestionar tu restaurante') }}</p>
                            </div>
                            
                            @if(Auth::user()->role_id < \App\Enums\Role::USUARIO_MESAS)
                            <div>
                                <button class="btn btn-secondary btn-lg" data-bs-toggle="modal" data-bs-target="#generarMesasModal">
                                    <i class="bi bi-grid-3x3-gap me-2"></i>{{ __('Generar Mesas Automáticamente') }}
                                </button>
                            </div>
                            @else
                            <div class="alert alert-info mt-3">
                                <i class="bi bi-info-circle me-2"></i>
                                {{ __('Contacta con un administrador para crear las mesas del restaurante') }}
                            </div>
                            @endif
                        </div>
                    @else
                    <!-- Grid de mesas -->
                    <div class="mesas-grid">
                        @foreach($mesas as $mesa)
                        <div class="mesa-card mesa-{{ $mesa->estado_mesa }} 
                                    {{ $mesa->camarero_id == Auth::id() ? 'mesa-mia' : '' }}"
                             data-mesa-id="{{ $mesa->uuid }}"
                             data-estado="{{ $mesa->estado_mesa }}"
                             data-camarero="{{ $mesa->camarero_id }}"
                             data-es-mia="{{ $mesa->camarero_id == Auth::id() ? '1' : '0' }}">
                            @if($mesa->tiene_preparado)
                            <div style="position:absolute;bottom:-8px;left:-8px;z-index:2;">
                                <span class="badge bg-warning text-dark" title="Hay productos preparados">
                                    <i class="bi bi-bell-fill"></i>
                                </span>
                            </div>
                            @endif
                            
                            <!-- Badge "MI MESA" -->
                            @if($mesa->camarero_id == Auth::id() && $mesa->estado_mesa == 'ocupada')
                            <div class="badge-mi-mesa">
                                <i class="bi bi-person"></i> 
                            </div>
                            @endif
                            
                            <!-- Botones de gestión (solo administradores) -->
                            @if(Auth::user()->role_id < \App\Enums\Role::USUARIO_MESAS)
                            <div class="mesa-gestion">
                                <button class="btn btn-sm btn-secondary" 
                                        onclick="event.stopPropagation(); abrirModalEditar('{{ $mesa->uuid }}', '{{ addslashes($mesa->descripcion) }}', {{ $mesa->numero_mesa }}, '{{ $mesa->estado_mesa }}', {{ $mesa->numero_comensales ?? 1 }}, '{{ addslashes($mesa->observaciones ?? '') }}')"
                                        title="{{ __('Editar mesa') }}">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </div>
                            @endif
                            
                            <!-- Número de mesa -->
                            <div class="mesa-numero">
                                {{ $mesa->descripcion }}
                            </div>
                            
                            <!-- Estado -->
                            <div class="mesa-estado">
                                
                                @if($mesa->estado_mesa == 'ocupada')
                                (<i class="bi {{ \App\Enums\EstadoMesa::from($mesa->estado_mesa)->icono() }}"></i>{{ $mesa->numero_comensales }})
                                @else
                                <i class="bi {{ \App\Enums\EstadoMesa::from($mesa->estado_mesa)->icono() }}"></i>
                                @endif
                                {{ \App\Enums\EstadoMesa::from($mesa->estado_mesa)->descripcion() }}
                                
                            </div>
                            
                            <!-- Info si está ocupada -->
                            @if($mesa->estado_mesa == 'ocupada')
                            <div class="mesa-info">
                                
                                
                                <div class="mesa-importe">
                                    <strong>{{ number_format($mesa->importe ?? 0, 2) }} €</strong>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Botones de acción -->
                            <div class="mesa-acciones mt-auto d-flex justify-content-center gap-2">
                                @if($mesa->estado_mesa == 'libre')
                                    <!-- Abrir nueva mesa -->
                                    <button class="btn btn-secondary btn-md" onclick="abrirMesa('{{ $mesa->uuid }}', '{{ $mesa->numero_mesa }}')">
                                        <i class="bi bi-box-arrow-in-right"></i>
                                    </button>
                                    
                                @elseif($mesa->estado_mesa == 'ocupada')
                                    @if($mesa->camarero_id == Auth::id())
                                        <!-- Es mi mesa: gestionar o cerrar -->
                                        <button class="btn btn-secondary" onclick="gestionarMesa('{{ $mesa->uuid }}')">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button class="btn btn-secondary" onclick="cerrarMesa('{{ $mesa->uuid }}', '{{ $mesa->numero_mesa }}')">
                                            <i class="bi bi-box-arrow-in-left"></i>
                                        </button>
                                    @else
                                        <!-- No es mi mesa: puedo tomarla -->
                                        <button class="btn btn-secondary" onclick="tomarMesa('{{ $mesa->uuid }}', '{{ $mesa->numero_mesa }}', '{{ $mesa->camarero->name ?? '' }}')">
                                            <i class="bi bi-box-arrow-in-down"></i>
                                        </button>
                                    @endif
                                    
                                @elseif($mesa->estado_mesa == 'cerrada')
                                    <!-- Liberar mesa para volver a usarla -->
                                    <button class="btn btn-secondary" onclick="liberarMesa('{{ $mesa->uuid }}', '{{ $mesa->numero_mesa }}')">
                                        <i class="bi bi-box-arrow-up"></i>
                                    </button>
                                    <!-- Botón para generar/ver factura -->
                                    @if(($mesa->importe ?? 0) > 0)
                                        @php
                                            $facturaExistente = \App\Models\FacturaMesa::where('mesa_id', $mesa->uuid)->first();
                                        @endphp
                                        @if($facturaExistente)
                                            <!-- Si ya existe factura, descargar PDF directamente -->
                                            <a href="{{ route('facturas.pdf', $facturaExistente->id) }}" class="btn btn-secondary ms-2" title="{{ __('Descargar PDF') }}">
                                                <i class="bi bi-file-earmark-pdf"></i>
                                            </a>
                                        @else
                                            <!-- Si no existe factura, ir a crearla -->
                                            <a href="{{ route('facturas.crear', $mesa->uuid) }}" class="btn btn-secondary ms-2" title="{{ __('Generar Factura') }}">
                                                <i class="bi bi-file-earmark-plus"></i>
                                            </a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
</div>

<!-- Modales -->
@include('fichas.modales.abrir-mesa')
@include('fichas.modales.cerrar-mesa')
@if(Auth::user()->role_id < \App\Enums\Role::USUARIO_MESAS)
    @include('fichas.modales.generar-mesas')
    @include('fichas.modales.crear-mesa')
    @include('fichas.modales.editar-mesa')
@endif

@endsection

@section('footer')
<div class="card-footer">
    <div class="d-flex align-items-center justify-content-center">
                <i class="bi bi-calendar-event"></i>
    
    <select id="filtro-estado" class="form-select form-select-sm" style="width: 150px;">
            <option value="">Todas</option>
            <option value="libre">Libres</option>
            <option value="ocupada">Ocupadas</option>
            <option value="mis-mesas">Mis mesas</option>
        </select>
        @if(Auth::user()->role_id < \App\Enums\Role::USUARIO_MESAS && !$mesas->isEmpty())
                        <div class="d-flex gap-2">
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalCrearMesa">
                                <i class="bi bi-plus"></i>
                            </button>
<a href="{{route('cocina.mesas')}}" class="btn btn-secondary btn-sm">
                                <i class="bi bi-fire"></i>
                            </a>
                        </div>
                        @endif
        
        <!-- Auto-refresh invisible -->
        <button class="btn btn-sm" id="toggle-refresh" style="display: none !important;">
            <span id="countdown">30</span>
        </button>
    </div>
</div>
@endsection

@push('styles')
<style>
.mesas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1.25rem;
}

.mesa-card {
    border: 3px solid;
    border-radius: 15px;
    padding: 0.75rem;
    transition: all 0.3s ease;
    position: relative;
    min-height: 220px;
    display: flex;
    flex-direction: column;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

/* Botones de gestión en esquina superior izquierda */
.mesa-gestion {
    position: absolute;
    top: -8px;
    left: -8px;
    display: flex;
    gap: 4px;
    z-index: 5;
}

.mesa-gestion .btn {
    padding: 4px 8px;
    font-size: 0.875rem;
    opacity: 0.9;
}

.mesa-gestion .btn:hover {
    opacity: 1;
    transform: scale(1.1);
}

/* Estados de mesa */
.mesa-libre {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    border-color: #28a745;
}

.mesa-ocupada {
    background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
    border-color: #ffc107;
}

.mesa-cerrada {
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    border-color: #6c757d;
    opacity: 0.8;
}

/* Destacar "mis mesas" */
.mesa-mia {
    border-width: 4px;
    border-color: #0d6efd !important;
    box-shadow: 0 0 20px rgba(13, 110, 253, 0.4);
}

.badge-mi-mesa {
    position: absolute;
    top: -12px;
    right: -12px;
    background: linear-gradient(135deg, #0d6efd, #0a58ca);
    color: white;
    border-radius: 20px;
    padding: 6px 12px;
    font-size: 0.75rem;
    font-weight: bold;
    box-shadow: 0 4px 8px rgba(13, 110, 253, 0.5);
    animation: pulse-badge 2s infinite;
    z-index: 10;
}

@keyframes pulse-badge {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.mesa-card:hover:not(.mesa-cerrada) {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

.mesa-numero {
    font-size: 1.75rem;
    font-weight: bold;
    text-align: center;
    margin-bottom: 0.5rem;
    color: #333;
}

.mesa-estado {
    text-align: center;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    padding: 4px 8px;
    background: rgba(255,255,255,0.7);
    border-radius: 8px;
}

.mesa-info {
    background: rgba(255,255,255,0.9);
    border-radius: 10px;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    font-size: 0.85rem;
    flex-grow: 1;
}

.mesa-importe {
    font-size: 1.25rem;
    color: #0d6efd;
    text-align: center;
    margin-top: 0.25rem;
}

.mesa-acciones {
    /* Estilos definidos inline con d-flex justify-content-center gap-2 */
}

.mesa-acciones .btn {
    min-width: 50px;
    height: 45px;
    font-size: 1.2rem;
    padding: 0.5rem 0.75rem;
}

/* Responsive */
@media (max-width: 768px) {
    .mesas-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        padding:0px !important;
    }
    
    .mesa-card {
        min-height: 200px;
        padding: 0.75rem;
    }
    
    .mesa-numero {
        font-size: 1.5rem !important;
    }
    
    .mesa-info {
        font-size: 0.8rem;
    }
}

@media (max-width: 576px) {
    .card-header h5 {
        font-size: 1rem;
    }
    
    .card-header .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem !important;
    }
    
    .card-header .form-select-sm {
        font-size: 0.75rem;
        width: 100px !important;
    }
}

/* Fix z-index para modales y backdrop */
.modal {
    z-index: 1055;
}

.modal-backdrop {
    z-index: 1050;
}

/* Estilos para Drag & Drop */
@media (min-width: 768px) {
    .mesas-grid .mesa-card.mesa-libre {
        cursor: grab;
    }
    
    .mesas-grid .mesa-card.mesa-libre:active {
        cursor: grabbing;
    }
}

/* Prevenir selección de texto durante drag & drop */
.mesas-grid .mesa-card {
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    -webkit-touch-callout: none;
    -webkit-tap-highlight-color: transparent;
}

.mesa-ghost {
    opacity: 0.3;
    background: #e9ecef !important;
    border: 3px dashed #6c757d !important;
}

.mesa-drag {
    opacity: 0.9;
    transform: rotate(3deg) scale(1.05);
    cursor: grabbing !important;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important;
    z-index: 1000;
}

/* Solo las mesas libres se pueden arrastrar */
.mesa-ocupada,
.mesa-cerrada {
    cursor: default !important;
}
</style>
@endpush

@push('scripts')
<script>
let autoRefreshEnabled = true;
let autoRefreshInterval;
let countdown = 60;

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

document.getElementById('toggle-refresh')?.addEventListener('click', function() {
    autoRefreshEnabled = !autoRefreshEnabled;
    this.classList.toggle('btn-outline-secondary');
    this.classList.toggle('btn-secondary');
    
    if (!autoRefreshEnabled) {
        clearInterval(autoRefreshInterval);
        this.innerHTML = '<i class="bi bi-pause-fill"></i> Pausado';
    } else {
        countdown = 60;
        iniciarAutoRefresh();
        this.innerHTML = '<i class="bi bi-arrow-clockwise"></i> <span id="countdown">60</span>s';
    }
});

// Filtros
document.getElementById('filtro-estado')?.addEventListener('change', function() {
    const filtro = this.value;
    
    document.querySelectorAll('.mesa-card').forEach(card => {
        const estado = card.dataset.estado;
        const esMia = card.dataset.esMia === '1';
        
        let mostrar = true;
        
        if (filtro === 'libre' && estado !== 'libre') mostrar = false;
        if (filtro === 'ocupada' && estado !== 'ocupada') mostrar = false;
        if (filtro === 'mis-mesas' && !esMia) mostrar = false;
        
        card.style.display = mostrar ? 'flex' : 'none';
    });
});

// Abrir mesa nueva
function abrirMesa(mesaId, numeroMesa) {
    document.getElementById('mesa_id_abrir').value = mesaId;
    document.getElementById('modal-numero-mesa-abrir').textContent = numeroMesa;
    const modal = document.getElementById('modalAbrirMesa');
    modal.classList.add('show');
    modal.style.display = 'block';
    document.body.classList.add('modal-open');
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    backdrop.id = 'modal-backdrop-abrir';
    document.body.appendChild(backdrop);
}

// Tomar mesa de otro camarero
function tomarMesa(mesaId, numeroMesa, camareroAnterior) {
    if (confirm(`¿Quieres tomar la mesa?\n\nActualmente está con: ${camareroAnterior}\n\nSi la tomas, pasará a ser tuya y podrás gestionarla.`)) {
        const baseUrl = '{{ rtrim(fichaRoute("tomar", ["mesaId" => "MESA_ID_PLACEHOLDER"]), "/") }}'.replace('MESA_ID_PLACEHOLDER', mesaId);
        fetch(baseUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al tomar la mesa');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al tomar la mesa');
        });
    }
}

// Gestionar mesa (ir a la vista de consumos)
function gestionarMesa(mesaId) {
    window.location.href = `/mesas/${mesaId}/lista`;
}

// Cerrar mesa y cobrar
function cerrarMesa(mesaId, numeroMesa) {
    document.getElementById('mesa_id_cerrar').value = mesaId;
    document.getElementById('modal-numero-mesa-cerrar').textContent = numeroMesa;
    
    // Cargar resumen de la mesa
    fetch(`/mesas/${mesaId}/resumen`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('resumen-comensales').textContent = data.numero_comensales;
            document.getElementById('resumen-importe').textContent = data.importe_formateado;
            document.getElementById('resumen-camarero').textContent = data.camarero;
            document.getElementById('resumen-hora').textContent = data.hora_apertura;
            
            // Llenar tabla de consumos
            let htmlConsumos = '';
            if (data.productos && data.productos.length > 0) {
                htmlConsumos += '<h6>Productos:</h6><ul class="list-unstyled">';
                data.productos.forEach(p => {
                    htmlConsumos += `<li>${p.cantidad}x ${p.nombre} - ${p.precio_total}</li>`;
                });
                htmlConsumos += '</ul>';
            }
            if (data.servicios && data.servicios.length > 0) {
                htmlConsumos += '<h6>Servicios:</h6><ul class="list-unstyled">';
                data.servicios.forEach(s => {
                    htmlConsumos += `<li>${s.nombre} - ${s.precio}</li>`;
                });
                htmlConsumos += '</ul>';
            }
            document.getElementById('resumen-consumos').innerHTML = htmlConsumos || '<p class="text-muted">Sin consumos</p>';
            
            // Mostrar modal
            const modal = document.getElementById('modalCerrarMesa');
            modal.classList.add('show');
            modal.style.display = 'block';
            document.body.classList.add('modal-open');
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.id = 'modal-backdrop-cerrar';
            document.body.appendChild(backdrop);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Liberar mesa cerrada
function liberarMesa(mesaId, numeroMesa) {
    if (confirm(`¿Desea liberar la mesa para que pueda volver a usarse?`)) {
        const baseUrl = '{{ rtrim(fichaRoute("liberar", ["mesaId" => "MESA_ID_PLACEHOLDER"]), "/") }}'.replace('MESA_ID_PLACEHOLDER', mesaId);
        fetch(baseUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'Error al liberar la mesa');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al liberar la mesa');
        });
    }
}

// Iniciar auto-refresh al cargar
iniciarAutoRefresh();

// Cerrar modales con botones data-bs-dismiss
document.addEventListener('click', function(e) {
    if (e.target.matches('[data-bs-dismiss="modal"]') || e.target.closest('[data-bs-dismiss="modal"]')) {
        const modals = document.querySelectorAll('.modal.show');
        modals.forEach(modal => {
            modal.classList.remove('show');
            modal.style.display = 'none';
        });
        document.body.classList.remove('modal-open');
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
    }
});

// Cerrar modal al hacer clic en el backdrop
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-backdrop')) {
        const modals = document.querySelectorAll('.modal.show');
        modals.forEach(modal => {
            modal.classList.remove('show');
            modal.style.display = 'none';
        });
        document.body.classList.remove('modal-open');
        e.target.remove();
    }
});

// Función para confirmar eliminación de mesa
function confirmarEliminar(mesaUuid, numeroMesa) {
    if (confirm(`¿Está seguro de que desea eliminar la mesa?\n\nEsta acción no se puede deshacer.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/mesas/${mesaUuid}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').content;
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

@if(Auth::user()->role_id < \App\Enums\Role::USUARIO_MESAS)
// Inicializar Drag & Drop con SortableJS (solo para administradores)
let sortableInstance = null;

function inicializarSortable() {
    const mesasGrid = document.querySelector('.mesas-grid');
    if (mesasGrid && !sortableInstance && typeof Sortable !== 'undefined') {
        sortableInstance = Sortable.create(mesasGrid, {
            animation: 150,
            ghostClass: 'mesa-ghost',
            dragClass: 'mesa-drag',
            handle: '.mesa-numero',
            filter: '.mesa-ocupada, .mesa-cerrada',
            onStart: function() {
                document.body.style.cursor = 'grabbing';
            },
            onEnd: function(evt) {
                document.body.style.cursor = 'default';
                
                // Recopilar nuevo orden
                const nuevoOrden = Array.from(mesasGrid.children).map((card, index) => ({
                    uuid: card.dataset.mesaId,
                    orden: index + 1
                }));
                
                // Enviar al servidor
                actualizarOrdenMesas(nuevoOrden);
            }
        });
    }
}

function actualizarOrdenMesas(orden) {
    fetch('{{ route('mesas.reordenar') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ orden: orden })
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error('Error al actualizar orden:', data.message);
            // Recargar para restaurar orden original
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        location.reload();
    });
}

// Cargar librería y luego inicializar
const sortableScript = document.createElement('script');
sortableScript.src = 'https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js?v=281120252245';
sortableScript.onload = function() {
    // Inicializar sortable cuando la librería esté cargada
    if (document.querySelector('.mesas-grid')) {
        inicializarSortable();
    }
};
document.head.appendChild(sortableScript);
@endif
</script>
@endpush
