<div class="modal fade" id="modalAbrirMesa" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="form-abrir-mesa" method="POST">
                @csrf
                <input type="hidden" id="mesa_id_abrir" name="mesa_id">
                
                <div class="modal-header fondo-rojo">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-plus-circle-fill"></i> {{ __('Abrir Mesa') }} <span id="modal-numero-mesa-abrir"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Número de comensales') }}:</label>
                        <input type="number" class="form-control form-control-lg text-center" 
                               name="numero_comensales" min="1" max="20" value="2" required autofocus>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">{{ __('Notas') }} ({{ __('opcional') }}):</label>
                        <textarea class="form-control" name="notas" rows="2" 
                                  placeholder="{{ __('Ej: Alérgicos, zona preferida...') }}"></textarea>
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
document.getElementById('form-abrir-mesa')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const mesaId = document.getElementById('mesa_id_abrir').value;
    const baseUrl = '{{ rtrim(fichaRoute("abrir", ["mesaId" => "MESA_ID_PLACEHOLDER"]), "/") }}'.replace('MESA_ID_PLACEHOLDER', mesaId);
    
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
            // Redirigir a familias para empezar a elegir productos
            window.location.href = `/mesas/${mesaId}/familias`;
        } else {
            alert(data.message || '{{ __('Error al abrir la mesa') }}');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ __('Error al abrir la mesa') }}');
    });
});
</script>
