<!-- Modal para crear mesa individual -->
<div class="modal fade" id="modalCrearMesa" tabindex="-1" aria-labelledby="modalCrearMesaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalCrearMesaLabel">
                    <i class="bi bi-plus-circle me-2"></i>{{ __('Nueva Mesa') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('mesas.crear-individual') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="descripcion_mesa" class="form-label fw-bold">
                            {{ __('Nombre de la mesa') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="descripcion" 
                            id="descripcion_mesa" 
                            class="form-control" 
                            placeholder="{{ __('Ej: Mesa VIP, Terraza 1, Barra 5...') }}"
                            maxlength="100"
                            required
                            autofocus
                        >
                        <small class="form-text text-muted">
                            {{ __('Introduce un nombre descriptivo para identificar la mesa') }}
                        </small>
                    </div>

                    <div class="mb-3">
                        <label for="numero_mesa_crear" class="form-label fw-bold">
                            {{ __('Número de mesa') }}
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="numero_mesa" 
                            id="numero_mesa_crear" 
                            class="form-control" 
                            min="1"
                            max="999"
                            required
                        >
                        <small class="form-text text-muted">
                            {{ __('Define el número para el orden y visualización') }}
                        </small>
                    </div>

                    <div class="alert alert-info mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>{{ __('Nota:') }}</strong> 
                        {{ __('La mesa se creará en estado libre y lista para ser usada') }}
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy me-1"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
