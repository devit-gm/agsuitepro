<!-- Modal para generar mesas automáticamente -->
<div class="modal fade" id="generarMesasModal" tabindex="-1" aria-labelledby="generarMesasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="generarMesasModalLabel">
                    <i class="bi bi-grid-3x3-gap me-2"></i>{{ __('Generar Mesas Automáticamente') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('mesas.generar') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-muted mb-4">
                        <i class="bi bi-info-circle me-1"></i>
                        {{ __('Genera múltiples mesas de forma automática para comenzar a trabajar rápidamente.') }}
                    </p>

                    <div class="mb-3">
                        <label for="cantidad_mesas" class="form-label fw-bold">
                            {{ __('¿Cuántas mesas quieres crear?') }}
                            <span class="text-danger">*</span>
                        </label>
                        <select name="cantidad" id="cantidad_mesas" class="form-select" required>
                            <option value="" selected disabled>{{ __('Selecciona una cantidad') }}</option>
                            <option value="5">5 {{ __('mesas') }}</option>
                            <option value="10">10 {{ __('mesas') }}</option>
                            <option value="15">15 {{ __('mesas') }}</option>
                            <option value="20">20 {{ __('mesas') }}</option>
                            <option value="25">25 {{ __('mesas') }}</option>
                            <option value="30">30 {{ __('mesas') }}</option>
                            <option value="40">40 {{ __('mesas') }}</option>
                            <option value="50">50 {{ __('mesas') }}</option>
                        </select>
                        <small class="form-text text-muted">
                            {{ __('Selecciona el número de mesas que deseas crear') }}
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="prefijo_mesa" class="form-label fw-bold">
                            {{ __('Prefijo para el nombre') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="prefijo" 
                            id="prefijo_mesa" 
                            class="form-control" 
                            value="Mesa " 
                            maxlength="20"
                            required
                        >
                        <small class="form-text text-muted">
                            {{ __('Ejemplo: "Mesa " generará "Mesa 1", "Mesa 2", etc.') }}
                        </small>
                    </div>

                    <div class="alert alert-info mb-0">
                        <i class="bi bi-lightbulb me-2"></i>
                        <strong>{{ __('Nota:') }}</strong> 
                        {{ __('Las mesas se numerarán automáticamente del 1 al número seleccionado.') }}
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x me-1"></i>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy me-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
