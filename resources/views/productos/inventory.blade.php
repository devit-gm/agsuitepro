@extends('layouts.app')






























































































































































































































- [Laravel - Asset Versioning](https://laravel.com/docs/10.x/mix#versioning-and-cache-busting)- [Web.dev - Image Optimization](https://web.dev/fast/#optimize-your-images)- [MDN - HTTP Caching](https://developer.mozilla.org/es/docs/Web/HTTP/Caching)Para dudas sobre la implementación, revisa:## 📧 Soporte---8. Vistas administrativas de sitios/licencias7. Formularios de edición (edit.blade.php)**Baja prioridad**:6. `usuarios/index.blade.php` ⭐5. `familias/index.blade.php` ⭐**Media prioridad**:4. `productos/index.blade.php` ⭐⭐3. `productos/inventory.blade.php` ✅ (Ya optimizado)2. `fichas/familias.blade.php` ⭐⭐⭐1. `fichas/productos.blade.php` ⭐⭐⭐**Alta prioridad** (más tráfico/imágenes):## 🎯 Prioridad de Archivos a Optimizar---   ```   }       $imagen = $webpPath;   if (file_exists(public_path('images/' . $webpPath))) {   $webpPath = str_replace(['.jpg', '.png'], '.webp', $imagen);   $imagen = $producto->imagen;   // Detectar soporte WebP y servir formato apropiado   ```php5. **Formatos modernos**: Para máxima optimización, considera usar WebP:4. **Imágenes grandes**: Considera redimensionar imágenes grandes antes de subirlas (max 1200px ancho es suficiente).3. **Servidor compartido**: Si `mod_expires` o `mod_headers` no están disponibles, contacta a tu proveedor de hosting.2. **Compatibilidad**: `loading="lazy"` funciona en 97% de navegadores modernos. Para navegadores viejos, se ignora y carga normal.1. **Imágenes críticas**: Las imágenes above-the-fold (logos, banners) NO deben tener `loading="lazy"`, déjalas sin ese atributo.## 📝 Notas Importantes---- Ejemplo: `/images/producto.jpg?v=1700745123`- La URL debe tener un nuevo parámetro `?v=timestamp`- Cambia una imagen del producto### 3. **Verificar cache busting**- Al hacer scroll, deben aparecer nuevas peticiones- Las imágenes fuera de la vista NO deben cargarse inicialmente- Recarga la página con DevTools abierto (Network tab)### 2. **Verificar lazy loading**```Expires: [fecha 1 año futuro]Cache-Control: public, max-age=31536000, immutable```Abre las DevTools del navegador (F12) → Network → Selecciona una imagen → Headers:### 1. **Verificar headers de caché**## 🔍 Testing---```# Debería mostrar: headers_module (shared)apachectl -M | grep headers```bash### Verificar si mod_headers está activo:```# Debería mostrar: expires_module (shared)apachectl -M | grep expires```bash### Verificar si mod_expires está activo (Apache):```php artisan optimize:clear```bash### Limpiar cachés después de cambios:## 🛠️ Comandos Útiles---- 🚀 **30-50% menos ancho de banda** (por compresión)- 🚀 **50-70% carga inicial más rápida** (por lazy loading)- 🚀 **70-90% menos peticiones** al servidor (por caché)### **Mejoras de rendimiento:**- ✅ Decodificación asíncrona (no bloquea renderizado)- ✅ Cache busting automático (nueva versión al cambiar imagen)- ✅ Dimensiones fijas (sin layout shift)- ✅ Compresión GZIP activa- ✅ Lazy loading (solo cargan cuando son visibles)- ✅ Caché de 1 año en navegador (imágenes se cargan 1 vez)### **Después de la optimización:**- ❌ Sin dimensiones específicas (layout shift)- ❌ Sin compresión- ❌ Todas las imágenes se cargan al inicio- ❌ Imágenes sin cache (siempre se descargan)### **Antes de la optimización:**## 📊 Resultados Esperados---```     decoding="async" />     loading="lazy"     alt="{{ $producto->nombre ?? 'Imagen' }}"     src="{{ cachedImage($producto->imagen) }}"      class="img-fluid rounded img-responsive"      height="80"<img width="80" ```php### **Método 3: Manual completo**```{!! optimizedImageTag($producto->imagen, $producto->nombre, 80, null, 'img-fluid rounded') !!}# Después:<img width="80" class="img-fluid rounded" src="{{ URL::to('/') }}/images/{{ $producto->imagen }}" /># Antes:```php### **Método 2: Tag completo (recomendado)**```     decoding="async" />     loading="lazy"      alt="{{ $producto->nombre }}"<img src="{{ cachedImage($producto->imagen) }}" # Después:<img src="{{ URL::to('/') }}/images/{{ $producto->imagen }}" /># Antes:```php### **Método 1: Solo URL (simple)**## 🔄 Patrón de Reemplazo---- ⏳ `resources/views/licencias/index.blade.php` línea 67- ⏳ `resources/views/sitios/edit.blade.php` líneas 60, 69, 76- ⏳ `resources/views/sitios/index.blade.php` línea 43### **Otros**- ⏳ `resources/views/fichas/productos.blade.php` líneas 39-40 y 63- ⏳ `resources/views/fichas/familias.blade.php` línea 36### **Fichas (importante - alta carga)**- ⏳ `resources/views/usuarios/edit.blade.php` línea 32- ⏳ `resources/views/usuarios/index.blade.php` línea 40### **Usuarios**- ⏳ `resources/views/familias/view.blade.php` línea 27- ⏳ `resources/views/familias/edit.blade.php` línea 32- ⏳ `resources/views/familias/index.blade.php` línea 42### **Familias**- ⏳ `resources/views/productos/list.blade.php` línea 22- ⏳ `resources/views/productos/edit.blade.php` línea 38- ⏳ `resources/views/productos/index.blade.php` línea 42- ✅ `resources/views/productos/inventory.blade.php` (Ya optimizado)### **Productos**Para completar la optimización, actualiza las imágenes en estos archivos:## 📋 Archivos a Actualizar---Se agregó `loading="lazy"` a las imágenes para carga diferida (solo se cargan cuando son visibles).### 3. **Lazy Loading Nativo**```     class="img-fluid rounded" />     decoding="async"      loading="lazy"      height="80"     width="80"      alt="Producto" <img src="/images/producto.jpg?v=1234567890" // Genera:{!! optimizedImageTag($producto->imagen, $producto->nombre, 80, 80) !!}// Uso:```phpGenera etiqueta completa optimizada:#### `optimizedImageTag($imagePath, $alt, $width, $height, $classes)````<img src="{{ cachedImage($producto->imagen) }}" />// Después (con versión automática):<img src="{{ URL::to('/') }}/images/{{ $producto->imagen }}" />// Antes:```phpGenera URL de imagen con cache busting automático:#### `cachedImage($imagePath, $version = true)`### 2. **Helpers de PHP** (`app/helpers.php`)- **Compresión GZIP**: Para reducir tamaño de transferencia- **Fuentes**: Cache por 1 año- **CSS/JS**: Cache por 1 mes- **Imágenes**: Cache por 1 año (`max-age=31536000`)Se agregaron reglas de caché al archivo `public/.htaccess`:### 1. **Caché HTTP en `.htaccess`**## ✅ Cambios Implementados@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-12 col-sm-12 col-lg-8 d-flex h-100">
            <div class="card flex-fill d-flex flex-column">
                <div class="card-header fondo-rojo"><i class="bi bi-cup-straw"></i> {{ __('Productos - Inventario') }}</div>

                <div class="card-body overflow-auto flex-fill">

                    <div class="container-fluid">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12 col-md-12 col-lg-12">


                                <form id='editar-inventario' action="{{ route('productos.inventory') }}" method="post">
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
                                            <table class="table table-bordered table-responsive table-hover">
                                                <thead>
                                                    <tr class="">
                                                        <th scope="col-auto" class="text-center">{{ __('Imagen') }}</th>
                                                        <th scope="col-auto">{{ __('Nombre') }}</th>
                                                        <th scope="col-auto">{{ __('Stock') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($productos as $producto)
                                                    <tr style="height: 80px;" class="{{ $producto->stock <= ($ajustes->stock_minimo ?? 5) ? 'table-danger' : '' }}">
                                                        <td class="align-middle">
                                                            <img width="60" height="60" class="img-fluid rounded img-responsive" 
                                                                 src="{{ cachedImage($producto->imagen) }}" 
                                                                 alt="{{ $producto->nombre }}"
                                                                 loading="lazy"
                                                                 decoding="async" />
                                                            <input type="hidden" name="uuid[{{ $producto->uuid }}]" value="{{ $producto->uuid }}">
                                                        </td>

                                                        <td class="align-middle">
                                                            {{ $producto->nombre }}
                                                            @if($producto->stock <= ($ajustes->stock_minimo ?? 5))
                                                                <span class="badge bg-danger ms-2 fondo-rojo">{{ __('Stock bajo') }}</span>
                                                            @endif
                                                        </td>
                                                        <td width="80" class="align-middle col-md-4">
                                                            <div class="form-group">
                                                                <input class="form-control" type="number" min="0" max="15" name="stock[{{ $producto->uuid }}]" id="stock[{{ $producto->uuid }}]" value="{{ $producto->stock }}">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
        
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
                            <a class="btn btn-secondary mx-1" href={{ route('productos.index') }}><i class="bi bi-chevron-left"></i></a>
                            @if(isset($ajustes) && $ajustes->permitir_lectura_codigo_barras == 1)
                            <button type="button" id="btn-open-scanner" class="btn btn-primary mx-1">
                                <i class="bi bi-upc-scan"></i>
                            </button>
                            @endif
                            <button type="button" onclick="document.getElementById('editar-inventario').submit();" class="btn btn-success mx-1"><i class="bi bi-floppy"></i></button>
                        </div>
                    </form>
                </div>

<!-- Modal Scanner Código de Barras -->
<div class="modal fade" id="scannerModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header fondo-rojo">
                <h5 class="modal-title text-white">
                    <i class="bi bi-upc-scan"></i> {{ __('Escanear Código de Barras') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="scanner-container" style="position: relative; width: 100%; height: 200px; background: #000; overflow: hidden;">
                    <div id="barcode-scanner" style="position: relative; width: 100%; height: 100%;">
                        <video style="width: 100%; height: 100%; object-fit: cover;"></video>
                        <canvas class="drawingBuffer" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></canvas>
                    </div>
                    <div id="scanner-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; pointer-events: none; z-index: 10;">
                        <!-- Línea roja de guía -->
                        <div style="position: absolute; top: 50%; left: 10%; right: 10%; height: 3px; background: red; transform: translateY(-50%); box-shadow: 0 0 10px rgba(255,0,0,0.8);"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" id="btn-stop-scanner">
                    <i class="bi bi-stop-circle"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .modal-backdrop.show {
        z-index: -1 !important;
    }
    
    #scannerModal.show {
        z-index: 1060 !important;
    }
    
    #scannerModal .modal-dialog {
        z-index: 1061 !important;
        position: relative;
    }
</style>
@endpush

@push('scripts')
<!-- Cargar Quagga desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2@1.8.4/dist/quagga.min.js"></script>

<script>
// Objeto BarcodeScanner
window.BarcodeScanner = {
    isScanning: false,
    onDetected: null,
    videoStream: null,
    
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
            locator: {
                patchSize: "medium",
                halfSample: true
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
            numOfWorkers: 2,
            frequency: 10
        }, (err) => {
            if (err) {
                console.error('Error al inicializar Quagga:', err);
                alert('Error al acceder a la cámara: ' + err.message);
                return;
            }
            console.log("Quagga inicializado correctamente");
            this.isScanning = true;
            Quagga.start();
            
            const videoElement = document.querySelector('#' + videoElementId + ' video');
            if (videoElement && videoElement.srcObject) {
                this.videoStream = videoElement.srcObject;
            }
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
        if (!result || !result.codeResult) {
            return;
        }
        
        const code = result.codeResult.code;
        const format = result.codeResult.format;
        
        const errors = result.codeResult.decodedCodes
            .filter(_ => _.error !== undefined)
            .map(_ => _.error);
        const avgError = errors.reduce((a, b) => a + b, 0) / errors.length;
        
        console.log('Código detectado:', code, 'Formato:', format, 'Error promedio:', avgError);
        
        if (avgError > 0.1) {
            console.log('Lectura rechazada por baja calidad');
            return;
        }
        
        if (code.length < 8) {
            console.log('Código muy corto, rechazado');
            return;
        }
        
        if (!this.detectionCache[code]) {
            this.detectionCache[code] = 1;
            console.log('Primera lectura de:', code, '- esperando confirmación');
            return;
        } else {
            this.detectionCache[code]++;
            if (this.detectionCache[code] >= 2) {
                console.log('Código confirmado:', code);
                if (this.onDetected && typeof this.onDetected === 'function') {
                    this.onDetected(code, format);
                }
                this.stop();
            }
        }
    },
    
    stop() {
        if (this.isScanning) {
            try {
                Quagga.offDetected();
                Quagga.offProcessed();
                Quagga.stop();
                
                if (this.videoStream) {
                    this.videoStream.getTracks().forEach(track => {
                        track.stop();
                    });
                    this.videoStream = null;
                }
                
                const videoElements = document.querySelectorAll('#barcode-scanner video');
                videoElements.forEach(video => {
                    if (video.srcObject) {
                        video.srcObject.getTracks().forEach(track => track.stop());
                        video.srcObject = null;
                    }
                    video.src = '';
                });
                
                this.isScanning = false;
                this.onDetected = null;
                console.log('Scanner y cámara detenidos');
            } catch (error) {
                console.error('Error al detener scanner:', error);
            }
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const modalElement = document.getElementById('scannerModal');
    const btnOpenScanner = document.getElementById('btn-open-scanner');
    const btnStopScanner = document.getElementById('btn-stop-scanner');
    
    if (!btnOpenScanner || !modalElement) {
        console.log('Elementos del scanner no encontrados');
        return;
    }
    
    let scannerModal = null;
    let scannerInitialized = false;
    let detectedBarcode = null;
    
    // Intentar crear instancia de Bootstrap Modal
    try {
        const Bootstrap = window.bootstrap || window.Bootstrap;
        if (Bootstrap && Bootstrap.Modal) {
            scannerModal = new Bootstrap.Modal(modalElement, {
                backdrop: true,
                keyboard: true
            });
        }
    } catch (e) {
        console.log('Bootstrap Modal no disponible, usando método alternativo');
    }
    
    btnOpenScanner.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('Abriendo modal del scanner...');
        
        if (scannerModal) {
            scannerModal.show();
        } else {
            // Fallback manual
            modalElement.classList.add('show');
            modalElement.style.display = 'block';
            document.body.classList.add('modal-open');
            
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.id = 'scanner-backdrop-inventory';
            document.body.appendChild(backdrop);
            
            // Iniciar scanner manualmente
            setTimeout(initScanner, 500);
        }
    });
    
    function initScanner() {
        if (scannerInitialized) {
            console.log('Scanner ya inicializado, omitiendo...');
            return;
        }
        
        setTimeout(function() {
            console.log('Iniciando scanner...');
            scannerInitialized = true;
            BarcodeScanner.init('barcode-scanner', function(code, format) {
                detectedBarcode = code;
                
                if (navigator.vibrate) {
                    navigator.vibrate(200);
                }
                
                buscarProducto(code);
            });
        }, 500);
    }
    
    modalElement.addEventListener('shown.bs.modal', initScanner);
    
    modalElement.addEventListener('hidden.bs.modal', function() {
        console.log('Modal cerrado, deteniendo scanner...');
        if (scannerInitialized) {
            BarcodeScanner.stop();
            scannerInitialized = false;
        }
        detectedBarcode = null;
    });
    
    const btnCloseModal = modalElement.querySelector('.btn-close');
    if (btnCloseModal) {
        btnCloseModal.addEventListener('click', function() {
            if (scannerInitialized) {
                BarcodeScanner.stop();
                scannerInitialized = false;
            }
            closeModal();
        });
    }
    
    if (btnStopScanner) {
        btnStopScanner.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (scannerInitialized) {
                BarcodeScanner.stop();
                scannerInitialized = false;
            }
            closeModal();
        });
    }
    
    function closeModal() {
        if (scannerModal && scannerModal.hide) {
            scannerModal.hide();
        } else {
            modalElement.classList.remove('show');
            modalElement.style.display = 'none';
            document.body.classList.remove('modal-open');
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(b => b.remove());
        }
    }
    
    // Eventos de Bootstrap Modal si está disponible
    if (scannerModal) {
        modalElement.addEventListener('shown.bs.modal', initScanner);
        
        modalElement.addEventListener('hidden.bs.modal', function() {
            console.log('Modal cerrado, deteniendo scanner...');
            if (scannerInitialized) {
                BarcodeScanner.stop();
                scannerInitialized = false;
            }
            detectedBarcode = null;
        });
    }
    
    function buscarProducto(code) {
        if (!code) return;
        
        fetch('{{ route("productos.buscar.barcode") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ 
                ean13: code
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.producto) {
                closeModal();
                
                // Preguntar cantidad a añadir
                const cantidad = prompt('{{ __("Producto encontrado") }}: ' + data.producto.nombre + '\n{{ __("\u00bfCuántas unidades deseas añadir al inventario?") }}', '1');
                
                if (cantidad !== null && cantidad !== '' && !isNaN(cantidad) && parseInt(cantidad) > 0) {
                    actualizarInventario(data.producto.uuid, parseInt(cantidad));
                }
            } else {
                alert(data.message || '{{ __("Producto no encontrado") }}');
                if (scannerInitialized) {
                    BarcodeScanner.stop();
                    scannerInitialized = false;
                }
                closeModal();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('{{ __("Error al buscar el producto") }}');
            if (scannerInitialized) {
                BarcodeScanner.stop();
                scannerInitialized = false;
            }
            closeModal();
        });
    }
    
    function actualizarInventario(productoUuid, cantidad) {
        const inputStock = document.querySelector('input[name="stock[' + productoUuid + ']"]');
        
        if (inputStock) {
            const stockActual = parseInt(inputStock.value) || 0;
            const nuevoStock = stockActual + cantidad;
            inputStock.value = nuevoStock;
            
            // Buscar la fila (tr) que contiene este input
            const fila = inputStock.closest('tr');
            const stockMinimo = {{ $ajustes->stock_minimo ?? 5 }};
            
            // Si el nuevo stock es mayor que el mínimo, quitar el fondo rojo y el badge
            if (nuevoStock > stockMinimo && fila) {
                // Quitar clase table-danger de la fila
                fila.classList.remove('table-danger');
                
                // Buscar y eliminar el badge "Stock bajo"
                const badge = fila.querySelector('.badge.bg-danger');
                if (badge) {
                    badge.remove();
                }
            }
            
            // Resaltar el campo actualizado
            inputStock.classList.add('border-success', 'border-3');
            setTimeout(() => {
                inputStock.classList.remove('border-success', 'border-3');
            }, 2000);
            
            alert('{{ __("Stock actualizado") }}: ' + cantidad + ' {{ __("unidades añadidas") }}. {{ __("Total") }}: ' + nuevoStock);
        } else {
            console.error('Input de stock no encontrado para UUID:', productoUuid);
            alert('{{ __("Error: No se pudo actualizar el stock") }}');
        }
    }
});
</script>
@endpush