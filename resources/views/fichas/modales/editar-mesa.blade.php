<!-- Modal para editar mesa -->
<div class="modal fade" id="modalEditarMesa" tabindex="-1" aria-labelledby="modalEditarMesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="modalEditarMesaLabel">
                    <i class="bi bi-pencil-square me-2"></i>{{ __('Editar Mesa') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-editar-mesa" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="mesa_uuid_editar" name="mesa_uuid">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="descripcion_mesa_editar" class="form-label fw-bold">
                            {{ __('Nombre de la mesa') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="descripcion" 
                            id="descripcion_mesa_editar" 
                            class="form-control" 
                            placeholder="{{ __('Ej: Mesa VIP, Terraza 1, Barra 5...') }}"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="numero_mesa_editar" class="form-label fw-bold">
                            {{ __('Número de mesa') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="numero_mesa" 
                            id="numero_mesa_editar" 
                            class="form-control" 
                            min="1"
                            max="999"
                            required
                        >
                        <small class="form-text text-muted">
                            {{ __('Cambiar el número afectará el orden de visualización') }}
                        </small>
                    </div>

                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>{{ __('Importante:') }}</strong> 
                        {{ __('Los cambios se aplicarán inmediatamente') }}
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                    </button>
                    <button type="submit" class="btn btn-secondary text-dark">
                        <i class="bi bi-floppy me-1"></i>
                    </button>
                    <button type="button" id="btn-eliminar-mesa" class="btn btn-secondary" onclick="eliminarMesaDesdeModal()" style="display: none;">
                        <i class="bi bi-trash me-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function abrirModalEditar(mesaUuid, descripcion, numeroMesa, estadoMesa) {
    document.getElementById('mesa_uuid_editar').value = mesaUuid;
    document.getElementById('descripcion_mesa_editar').value = descripcion;
    document.getElementById('numero_mesa_editar').value = numeroMesa;
    
    // Actualizar action del formulario
    const form = document.getElementById('form-editar-mesa');
    form.action = `/mesas/${mesaUuid}/actualizar`;
    
    // Mostrar/ocultar botón eliminar solo si está libre
    const btnEliminar = document.getElementById('btn-eliminar-mesa');
    if (estadoMesa === 'libre') {
        btnEliminar.style.display = 'inline-block';
    } else {
        btnEliminar.style.display = 'none';
    }
    
    // Mostrar modal manualmente
    const modal = document.getElementById('modalEditarMesa');
    modal.classList.add('show');
    modal.style.display = 'block';
    document.body.classList.add('modal-open');
    
    // Crear backdrop
    const backdrop = document.createElement('div');
    backdrop.className = 'modal-backdrop fade show';
    backdrop.id = 'modal-backdrop-editar';
    document.body.appendChild(backdrop);
}

function eliminarMesaDesdeModal() {
    const mesaUuid = document.getElementById('mesa_uuid_editar').value;
    const numeroMesa = document.getElementById('numero_mesa_editar').value;
    
    if (confirm(`¿Está seguro de que desea eliminar la Mesa ${numeroMesa}?\n\nEsta acción no se puede deshacer.`)) {
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
</script>
