@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-cup-straw"></i> {{ __('Nuevo producto') }}</div>

                <div class="card-body overflow-auto flex-fill">
                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form id="nuevo-producto" action="{{ route('productos.store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @if ($errors->any())
                                    <div class="custom-error-container" id="custom-error-container">
                                        <ul class="custom-error-list">
                                            @foreach ($errors->all() as $error)
                                            <li class="custom-error-item">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    <div class="form-group required mb-3">
                                        <label for="nombre" class="fw-bold form-label">{{ __('Nombre') }}</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="imagen" class="fw-bold form-label">{{ __('Imagen') }}</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="file-name-imagen" readonly placeholder="{{ __('Ningún archivo seleccionado') }}">
                                            <label class="input-group-text" for="imagen" style="cursor: pointer;">{{ __('Seleccionar archivo') }}</label>
                                            <input type="file" id="imagen" name="imagen" required onchange="updateFileName(this, 'file-name-imagen')" style="display: none;">
                                        </div>
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="posicion" class="fw-bold form-label">{{ __('Posición') }}</label>
                                        <input type="number" class="form-control" id="posicion" name="posicion" required>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="familia" class="fw-bold form-label">{{ __('Familia') }}</label>
                                        <select name="familia" id="familia" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            @foreach ($familias as $familia)
                                            <option value="{{ $familia->uuid }}">{{ $familia->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3 required">
                                        <label for="combinado" class="fw-bold form-label">{{ __('¿Combinado?') }}</label>
                                        <select name="combinado" id="combinado" class="form-select form-select-sm" aria-label=".form-select-sm example" required>
                                            <option value="0">{{ __('No') }}</option>
                                            <option value="1">{{ __('Sí') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="ean13" class="fw-bold form-label">{{ __('EAN') }}</label>
                                        @if(isset($ajustes) && $ajustes->permitir_lectura_codigo_barras == 1 && request()->secure())
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="ean13" name="ean13">
                                            <button class="btn btn-outline-secondary" type="button" id="openScannerBtnEAN">
                                                <i class="bi bi-upc-scan"></i> 
                                            </button>
                                        </div>
                                        @else
                                        <input type="text" class="form-control" id="ean13" name="ean13">
                                        @endif
                                    </div>
                                    <div class="form-group required mb-3">
                                        <label for="precio" class="fw-bold form-label">{{ __('Precio') }}</label>
                                        <input type="number" step='0.01' value='0.00' placeholder='0.00' class="form-control" id="precio" name="precio" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="iva" class="fw-bold form-label">{{ __('IVA (%)') }}</label>
                                        <select name="iva" id="iva" class="form-select form-select-sm">
                                            <option value="0">{{ __('0% - Exento') }}</option>
                                            <option value="4">{{ __('4% - Superreducido') }}</option>
                                            <option value="10">{{ __('10% - Reducido') }}</option>
                                            <option value="21" selected>{{ __('21% - General') }}</option>
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
                    <form>
                        <div class="d-flex align-items-center justify-content-center">
                            <a class="btn btn-dark mx-1" href={{ route('productos.index') }}><i class="bi bi-chevron-left"></i></a>
                            <button type="button" onclick="document.getElementById('nuevo-producto').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
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
<!-- Modal Scanner EAN -->
<div class="modal fade" id="scannerModalEAN" tabindex="-1" aria-labelledby="scannerModalEANLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                   <h5 class="modal-title text-white">
                    <i class="bi bi-upc-scan"></i> {{ __('Escanear Código de Barras') }}
                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>

            </div>
            <div class="modal-body">
                <div id="scanner-container-ean" style="position: relative; width: 100%; height: 200px;">
                    <video id="scanner-video-ean" style="width: 100%; height: 100%; object-fit: cover;"></video>
                    <canvas id="scanner-canvas-ean" class="drawingBuffer" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></canvas>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-stop-circle"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Script QuaggaJS para Scanner EAN -->
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2@1.8.4/dist/quagga.min.js"></script>
<script>
const BarcodeScannerEAN = {
    isScanning: false,
    videoStream: null,
    detectionCache: {},
    onDetected: null,
    
    init: function(config) {
        this.detectionCache = {};
        return new Promise((resolve, reject) => {
            Quagga.init(config, function(err) {
                if (err) {
                    console.error('Error al inicializar Quagga:', err);
                    reject(err);
                    return;
                }
                console.log('Quagga iniciado correctamente');
                BarcodeScannerEAN.isScanning = true;
                Quagga.start();
                
                // Guardar referencia al stream de video
                const videoElement = document.querySelector('#scanner-container-ean video');
                if (videoElement && videoElement.srcObject) {
                    BarcodeScannerEAN.videoStream = videoElement.srcObject;
                }
                
                resolve();
            });
        });
    },
    stop: function() {
        if (this.isScanning) {
            try {
                // Remover todos los listeners de Quagga antes de detener
                Quagga.offDetected();
                Quagga.offProcessed();
                
                Quagga.stop();
                
                // Detener todos los tracks del stream de video
                if (this.videoStream) {
                    this.videoStream.getTracks().forEach(track => {
                        track.stop();
                        console.log('Track de video detenido:', track.kind);
                    });
                    this.videoStream = null;
                }
                
                // Limpiar el video element
                const videoElements = document.querySelectorAll('#scanner-container-ean video');
                videoElements.forEach(video => {
                    if (video.srcObject) {
                        video.srcObject.getTracks().forEach(track => track.stop());
                        video.srcObject = null;
                    }
                    video.src = '';
                });
                
                this.isScanning = false;
                this.onDetected = null;
                this.detectionCache = {};
                console.log('Scanner y cámara detenidos');
            } catch (error) {
                console.error('Error al detener scanner:', error);
            }
        }
    },
    onDetected: function(callback) {
        Quagga.onDetected(callback);
    },
    offDetected: function(callback) {
        Quagga.offDetected(callback);
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const modalEAN = document.getElementById('scannerModalEAN');
    const openBtnEAN = document.getElementById('openScannerBtnEAN');
    let bsModalEAN = null;
    let isInitializedEAN = false;

    if (modalEAN && openBtnEAN) {
        openBtnEAN.addEventListener('click', function() {
            // Limpiar backdrops previos
            document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
            
            // Usar Bootstrap Modal con optional chaining
            const bsModal = window.bootstrap?.Modal;
            
            if (bsModal) {
                // Bootstrap 5 está disponible
                if (!bsModalEAN) {
                    bsModalEAN = new bsModal(modalEAN, {
                        backdrop: true,
                        keyboard: true,
                        focus: true
                    });
                }
                bsModalEAN.show();
            } else {
                // Fallback: usar data attributes
                modalEAN.classList.add('show');
                modalEAN.style.display = 'block';
                modalEAN.style.zIndex = '1055';
                document.body.classList.add('modal-open');
                
                // Crear backdrop
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                backdrop.id = 'scanner-backdrop-ean';
                backdrop.style.zIndex = '-1';
                document.body.appendChild(backdrop);
                
                // Iniciar scanner manualmente si no hay evento Bootstrap
                if (!isInitializedEAN) {
                    initScannerEAN();
                    isInitializedEAN = true;
                }
            }
        });

        modalEAN.addEventListener('shown.bs.modal', function() {
            if (!isInitializedEAN) {
                initScannerEAN();
                isInitializedEAN = true;
            }
        });

        modalEAN.addEventListener('hidden.bs.modal', function() {
            console.log('Modal cerrado, deteniendo scanner...');
            if (isInitializedEAN) {
                BarcodeScannerEAN.stop();
                isInitializedEAN = false;
            }
        });
        
        // Botón cerrar (X) del modal
        const btnCloseModal = modalEAN.querySelector('.btn-close');
        if (btnCloseModal) {
            btnCloseModal.addEventListener('click', function() {
                console.log('Botón X presionado, deteniendo scanner...');
                BarcodeScannerEAN.stop();
                closeModalEAN();
            });
        }
        
        // Botón detener del footer
        const btnStopModal = modalEAN.querySelector('.modal-footer .btn-secondary');
        if (btnStopModal) {
            btnStopModal.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Botón detener presionado, deteniendo scanner...');
                BarcodeScannerEAN.stop();
                closeModalEAN();
            });
        }
    }

    function initScannerEAN() {
        setTimeout(() => {
            const config = {
                inputStream: {
                    name: "Live",
                    type: "LiveStream",
                    target: document.querySelector('#scanner-container-ean'),
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
                decoder: {
                    readers: [
                        "ean_reader",
                        "ean_8_reader",
                        "code_128_reader",
                        "code_39_reader",
                        "upc_reader",
                        "upc_e_reader"
                    ],
                    debug: {
                        drawBoundingBox: true,
                        showFrequency: false,
                        drawScanline: true,
                        showPattern: false
                    },
                    multiple: false
                },
                locate: true,
                locator: {
                    patchSize: "medium",
                    halfSample: true
                },
                numOfWorkers: 2,
                frequency: 10
            };

            BarcodeScannerEAN.init(config)
                .then(() => {
                    console.log('Scanner EAN iniciado');
                    Quagga.onDetected(function(result) {
                        // Validar calidad de la lectura
                        if (!result || !result.codeResult) {
                            return;
                        }
                        
                        const code = result.codeResult.code;
                        const format = result.codeResult.format;
                        
                        // Filtrar lecturas con baja confianza
                        const errors = result.codeResult.decodedCodes
                            .filter(_ => _.error !== undefined)
                            .map(_ => _.error);
                        const avgError = errors.reduce((a, b) => a + b, 0) / errors.length;
                        
                        console.log('Código detectado:', code, 'Formato:', format, 'Error promedio:', avgError);
                        
                        // Solo aceptar lecturas con buena calidad (error < 0.1)
                        if (avgError > 0.1) {
                            console.log('Lectura rechazada por baja calidad');
                            return;
                        }
                        
                        // Validar que el código tenga longitud razonable
                        if (code.length < 8) {
                            console.log('Código muy corto, rechazado');
                            return;
                        }
                        
                        // Sistema de validación: requiere 2 lecturas consecutivas del mismo código
                        if (!BarcodeScannerEAN.detectionCache[code]) {
                            BarcodeScannerEAN.detectionCache[code] = 1;
                            console.log('Primera lectura de:', code, '- esperando confirmación');
                            return;
                        } else {
                            BarcodeScannerEAN.detectionCache[code]++;
                            if (BarcodeScannerEAN.detectionCache[code] >= 2) {
                                console.log('Código confirmado:', code);
                                
                                // Rellenar campo EAN13
                                document.getElementById('ean13').value = code;
                                
                                // Cerrar modal
                                closeModalEAN();
                            }
                        }
                    });
                })
                .catch(err => {
                    console.error('Error al iniciar scanner EAN:', err);
                    alert('Error al iniciar el scanner: ' + err.message);
                });
        }, 500);
    }

    function closeModalEAN() {
        if (bsModalEAN) {
            bsModalEAN.hide();
        } else {
            // Fallback manual
            modalEAN.classList.remove('show');
            modalEAN.style.display = 'none';
            document.body.classList.remove('modal-open');
            
            // Eliminar todos los backdrops
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(b => b.remove());
        }
    }
});
</script>
@endif
@endsection