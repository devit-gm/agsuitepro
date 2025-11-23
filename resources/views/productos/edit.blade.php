@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-cup-straw"></i> {{ __('Editar producto') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="editar-producto" action="{{ route('productos.update', $producto->uuid) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    @if ($errors->any())
                                    <div class="custom-error-container" id="custom-error-container">
                                        <ul class="custom-error-list">
                                            @foreach ($errors->all() as $error)
                                            <li class="custom-error-item">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    @if (session('success'))
                                    <div class="custom-success-container" id="custom-success-container">
                                        <ul class="custom-success-list">
                                            <li class="custom-success-item">{{ session('success') }}</li>
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group required mb-3">
                                        <label for="nombre" class="fw-bold form-label">{{ __('Nombre') }}</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $producto->nombre }}" required>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <img width="100" class="float-end" src="{{ URL::to('/') }}/images/{{ $producto->imagen }}" />
                                        <div class="form-group">
                                            <label for="imagen" class="fw-bold form-label">{{ __('Imagen') }}</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="file-name-imagen" readonly placeholder="{{ __('Ningún archivo seleccionado') }}">
                                                <label class="input-group-text" for="imagen" style="cursor: pointer;">{{ __('Seleccionar archivo') }}</label>
                                                <input type="file" id="imagen" name="imagen" onchange="updateFileName(this, 'file-name-imagen')" style="display: none;" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="posicion" class="fw-bold form-label">{{ __('Posición') }}</label>
                                        <input type="number" class="form-control" id="posicion" name="posicion" value="{{ $producto->posicion }}" required>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="familia" class="fw-bold form-label">{{ __('Familia') }}</label>
                                        <select name="familia" id="familia" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            @foreach ($familias as $familia)
                                            <option value="{{ $familia->uuid }}" @if( $producto->familia == $familia->uuid ) selected @endif>{{ $familia->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="combinado" class="fw-bold form-label">{{ __('¿Combinado?') }}</label>
                                        <select name="combinado" id="combinado" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            <option value="0" @if( $producto->combinado == 0 ) selected @endif>{{ __('No') }}</option>
                                            <option value="1" @if( $producto->combinado == 1 ) selected @endif>{{ __('Sí') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="ean13" class="fw-bold form-label">{{ __('EAN') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="ean13" name="ean13" value="{{ $producto->ean13 }}">
                                            @if(isset($ajustes) && $ajustes->permitir_lectura_codigo_barras == 1 && request()->secure())
                                            <button type="button" id="btn-scan-ean" class="btn btn-primary">
                                                <i class="bi bi-upc-scan"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="precio" class="fw-bold form-label">{{ __('Precio') }}</label>
                                        @if( $producto->combinado == 0 )
                                        <input type="number" step='0.01' placeholder='0.00' class="form-control" id="precio" name="precio" value="{{ $producto->precio }}" required>
                                        @else
                                        <input type="number" placeholder='0.00' class="form-control" id="precio" name="precio" value="{{ $producto->precio }}" required>
                                        @endif
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="iva" class="fw-bold form-label">{{ __('IVA (%)') }}</label>
                                        <select name="iva" id="iva" class="form-select form-select-sm">
                                            <option value="0" {{ ($producto->iva ?? 21) == 0 ? 'selected' : '' }}>{{ __('0% - Exento') }}</option>
                                            <option value="4" {{ ($producto->iva ?? 21) == 4 ? 'selected' : '' }}>{{ __('4% - Superreducido') }}</option>
                                            <option value="10" {{ ($producto->iva ?? 21) == 10 ? 'selected' : '' }}>{{ __('10% - Reducido') }}</option>
                                            <option value="21" {{ ($producto->iva ?? 21) == 21 ? 'selected' : '' }}>{{ __('21% - General') }}</option>
                                        </select>
                                        <small class="text-muted">{{ __('Por defecto 21% (IVA general en España)') }}</small>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
                <div class="card-footer">
                    <form action="{{ route('productos.destroy', $producto->uuid) }}" method="post">
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('productos.index') }}><i class="bi bi-chevron-left"></i></a>
                            <a href="{{ route('productos.components', $producto->uuid) }}" title="{{ __('Ver composición producto') }}" class="btn btn-info mx-1 my-1" @if ($producto->combinado == 0) hidden @endif><i class="bi bi-list-ul"></i></a>
                            <button onclick="document.getElementById('editar-producto').submit();" type="button" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                            @csrf
                            @method('DELETE')
                            @if ($producto->borrable == 1)
                            <button type="submit" class="btn btn-danger mx-1 my-1" title="{{ __('Eliminar producto') }}" onclick="return confirm('{{ __('¿Está seguro de eliminar el producto?') }}');"><i class="bi bi-trash"></i></button>
                            @endif
                        </div>
                    </form>
                </div>
				
<script>
function updateFileName(input, inputId) {
    const fileName = input.files[0] ? input.files[0].name : '';
    document.getElementById(inputId).value = fileName;
}
</script>

@if(isset($ajustes) && $ajustes->permitir_lectura_codigo_barras == 1 && request()->secure())
<!-- Modal Scanner Código de Barras -->
<div class="modal fade" id="scannerModalEAN" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="z-index: 1056;">
            <div class="modal-header fondo-rojo">
                <h5 class="modal-title text-white">
                    <i class="bi bi-upc-scan"></i> {{ __('Escanear Código de Barras') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="scanner-container-ean" style="position: relative; width: 100%; height: 200px; background: #000; overflow: hidden;">
                    <div id="barcode-scanner-ean" style="position: relative; width: 100%; height: 100%;">
                        <video style="width: 100%; height: 100%; object-fit: cover;"></video>
                        <canvas class="drawingBuffer" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></canvas>
                    </div>
                    <div id="scanner-overlay-ean" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; pointer-events: none; z-index: 10;">
                        <div style="position: absolute; top: 50%; left: 10%; right: 10%; height: 3px; background: red; transform: translateY(-50%); box-shadow: 0 0 10px rgba(255,0,0,0.8);"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" id="btn-stop-scanner-ean">
                    <i class="bi bi-stop-circle"></i> 
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2@1.8.4/dist/quagga.min.js"></script>
<script>
window.BarcodeScannerEAN = {
    isScanning: false,
    onDetected: null,
    videoStream: null,
    detectionCache: {},
    
    init(videoElementId, onDetectedCallback) {
        this.onDetected = onDetectedCallback;
        this.detectionCache = {};
        
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#' + videoElementId),
                constraints: {
                    width: 640,
                    height: 480,
                    facingMode: "environment"
                },
                area: {
                    top: "5%",
                    right: "5%",
                    left: "5%",
                    bottom: "5%"
                },
                singleChannel: false
            },
            locator: { patchSize: "medium", halfSample: true },
            decoder: {
                readers: ["ean_reader", "ean_8_reader", "code_128_reader", "code_39_reader", "upc_reader", "upc_e_reader"],
                debug: { drawBoundingBox: true, showFrequency: false, drawScanline: true, showPattern: false },
                multiple: false
            },
            locate: true,
            numOfWorkers: 2,
            frequency: 10
        }, (err) => {
            if (err) {
                console.error('Error al inicializar Quagga:', err);
                alert('Error al acceder a la cámara: ' + err.message);
                return;
            }
            this.isScanning = true;
            Quagga.start();
        });
        
        Quagga.onDetected(this.handleDetection.bind(this));
        
        Quagga.onProcessed((result) => {
            const drawingCtx = Quagga.canvas.ctx.overlay;
            const drawingCanvas = Quagga.canvas.dom.overlay;
            if (result) {
                if (result.boxes) {
                    drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                    result.boxes.filter(box => box !== result.box).forEach(box => {
                        Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
                    });
                }
                if (result.box) {
                    Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
                }
                if (result.codeResult && result.codeResult.code) {
                    Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
                }
            }
        });
    },
    
    handleDetection(result) {
        const code = result.codeResult.code;
        if (this.onDetected && typeof this.onDetected === 'function') {
            this.onDetected(code);
        }
        this.stop();
    },
    
    stop() {
        if (this.isScanning) {
            Quagga.stop();
            this.isScanning = false;
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('scannerModalEAN');
    const btnScanEAN = document.getElementById('btn-scan-ean');
    let scannerModal = null;
    
    if (!btnScanEAN || !modalElement) return;
    
    btnScanEAN.addEventListener('click', function(e) {
        e.preventDefault();
        const existingBackdrops = document.querySelectorAll('.modal-backdrop');
        existingBackdrops.forEach(b => b.remove());
        
        const bsModal = window.bootstrap?.Modal;
        if (bsModal) {
            if (!scannerModal) {
                scannerModal = new bsModal(modalElement, { backdrop: true, keyboard: true, focus: true });
            }
            scannerModal.show();
        } else {
            modalElement.classList.add('show');
            modalElement.style.display = 'block';
            modalElement.style.zIndex = '1055';
            document.body.classList.add('modal-open');
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.id = 'scanner-backdrop-ean';
            backdrop.style.zIndex = '-1';
            document.body.appendChild(backdrop);
            initScannerEAN();
        }
    });
    
    function initScannerEAN() {
        setTimeout(function() {
            BarcodeScannerEAN.init('barcode-scanner-ean', function(code) {
                document.getElementById('ean13').value = code;
                if (navigator.vibrate) navigator.vibrate(200);
                closeModalEAN();
            });
        }, 500);
    }
    
    modalElement.addEventListener('shown.bs.modal', initScannerEAN);
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        BarcodeScannerEAN.stop();
    });
    
    document.getElementById('btn-stop-scanner-ean').addEventListener('click', function() {
        BarcodeScannerEAN.stop();
        closeModalEAN();
    });
    
    function closeModalEAN() {
        if (scannerModal) {
            scannerModal.hide();
        } else {
            modalElement.classList.remove('show');
            modalElement.style.display = 'none';
            document.body.classList.remove('modal-open');
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(b => b.remove());
        }
    }
});
</script>
@endif
@endsection