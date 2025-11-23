import Quagga from 'quagga';

window.BarcodeScanner = {
    isScanning: false,
    onDetected: null,

    // Iniciar el scanner
    init(videoElementId, onDetectedCallback) {
        this.onDetected = onDetectedCallback;

        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector(`#${videoElementId}`),
                constraints: {
                    width: { min: 640, ideal: 1280, max: 1920 },
                    height: { min: 480, ideal: 720, max: 1080 },
                    facingMode: "environment" // Cámara trasera en móviles
                }
            },
            decoder: {
                readers: [
                    "ean_reader",      // EAN-13, EAN-8
                    "ean_8_reader",
                    "code_128_reader", // CODE-128
                    "code_39_reader",  // CODE-39
                    "upc_reader",      // UPC-A, UPC-E
                    "upc_e_reader"
                ],
                multiple: false
            },
            locate: true, // Localizar automáticamente el código en el frame
            numOfWorkers: navigator.hardwareConcurrency || 4,
            frequency: 10, // Escaneos por segundo
            debug: false
        }, (err) => {
            if (err) {
                console.error('Error al inicializar Quagga:', err);
                alert('Error al acceder a la cámara: ' + err.message);
                return;
            }
            console.log("Quagga inicializado correctamente");
            this.isScanning = true;
            Quagga.start();
        });

        // Evento cuando se detecta un código
        Quagga.onDetected(this.handleDetection.bind(this));

        // Dibujar rectángulo alrededor del código detectado
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

    // Manejar detección
    handleDetection(result) {
        const code = result.codeResult.code;
        const format = result.codeResult.format;

        console.log('Código detectado:', code, 'Formato:', format);

        // Llamar al callback con el código
        if (this.onDetected && typeof this.onDetected === 'function') {
            this.onDetected(code, format);
        }

        // Detener el scanner después de detectar
        this.stop();
    },

    // Detener el scanner
    stop() {
        if (this.isScanning) {
            Quagga.stop();
            this.isScanning = false;
            console.log('Scanner detenido');
        }
    },

    // Pausar temporalmente
    pause() {
        if (this.isScanning) {
            Quagga.pause();
        }
    },

    // Reanudar
    resume() {
        if (this.isScanning) {
            Quagga.start();
        }
    }
};
