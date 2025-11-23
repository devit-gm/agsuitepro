<div class="modal fade" id="modalCerrarMesa" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="form-cerrar-mesa" method="POST">
                @csrf
                <input type="hidden" id="mesa_id_cerrar" name="mesa_id">
                
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-check-circle-fill"></i> {{ __('Cerrar Mesa') }} <span id="modal-numero-mesa-cerrar"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <!-- Resumen de la cuenta -->
                    <div class="alert alert-info">
                        <div class="d-flex gap-3 justify-content-center align-items-center">
                            <div>
                                <i class="bi bi-people-fill"></i> 
                                <span id="resumen-comensales">0</span>
                            </div>
                            <div>
                                <i class="bi bi-person-badge"></i> 
                                <span id="resumen-camarero">-</span>
                            </div>
                            <div>
                                <i class="bi bi-clock-fill"></i> 
                                <span id="resumen-hora">-</span>
                            </div>
                        </div>
                    </div>
                    
                    <div id="resumen-consumos" class="mb-3">
                        <!-- Se llenará dinámicamente -->
                    </div>
                    
                    <div class="text-center mb-3 p-3 bg-light rounded">
                        <h3 class="text-primary mb-0">
                            {{ __('Total') }}: <span id="resumen-importe">0,00 €</span>
                        </h3>
                    </div>
                    
                    <hr>
                    
                    <!-- Método de pago -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Método de pago') }}:</label>
                        <select class="form-select" name="metodo_pago" required>
                            <option value="efectivo">{{ __('Efectivo') }}</option>
                            <option value="tarjeta">{{ __('Tarjeta') }}</option>
                            <option value="mixto">{{ __('Mixto') }}</option>
                        </select>
                    </div>
                    
                    <!-- Propina (opcional) -->
                    <div class="mb-3">
                        <label class="form-label">{{ __('Propina') }} ({{ __('opcional') }}):</label>
                        <input type="number" class="form-control" name="propina" 
                               min="0" step="0.01" value="0" placeholder="0,00">
                    </div>
                </div>
                
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x"></i>
                    </button>
                    <button type="submit" class="btn btn-secondary">
                        <i class="bi bi-floppy"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('form-cerrar-mesa')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const mesaId = document.getElementById('mesa_id_cerrar').value;
    
    if (confirm('{{ __('¿Confirmar el cierre de la mesa?') }}\n\n{{ __('Se marcará como pagada y se cerrará.') }}')) {
        const baseUrl = '{{ rtrim(fichaRoute("cerrar", ["mesaId" => "MESA_ID_PLACEHOLDER"]), "/") }}'.replace('MESA_ID_PLACEHOLDER', mesaId);
        fetch(baseUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('{{ __('Mesa cerrada correctamente') }}');
                location.reload();
            } else {
                alert(data.message || '{{ __('Error al cerrar la mesa') }}');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __('Error al cerrar la mesa') }}');
        });
    }
});
</script>
