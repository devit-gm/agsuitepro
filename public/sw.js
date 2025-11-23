const CACHE_NAME = 'mezzix-v2'; // Incrementado para forzar actualización
const urlsToCache = [
    // NO incluimos '/' ni '/home' porque son dinámicas según modo_operacion
    '/css/app.css',
    '/js/app.js',
    '/images/logo.png',
    '/manifest.json'
];

// Instalación del Service Worker
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => {
                console.log('Cache abierto');
                return cache.addAll(urlsToCache);
            })
            .catch(err => console.log('Error al cachear archivos:', err))
    );
});

// Activación del Service Worker
self.addEventListener('activate', event => {
    const cacheWhitelist = [CACHE_NAME];
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (!cacheWhitelist.includes(cacheName)) {
                        console.log('Eliminando cache antiguo:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Estrategia de caché: Network First con fallback a Cache
self.addEventListener('fetch', event => {
    // Solo cachear peticiones GET
    if (event.request.method !== 'GET') {
        return;
    }

    // Ignorar peticiones a dominios externos y APIs
    if (!event.request.url.startsWith(self.location.origin)) {
        return;
    }

    // Obtener la URL sin parámetros de query
    const url = new URL(event.request.url);
    const pathname = url.pathname;

    // NUNCA cachear la ruta raíz ni /home porque dependen del modo_operacion dinámico
    const noCacheRoutes = ['/', '/home'];
    const shouldNeverCache = noCacheRoutes.includes(pathname);

    event.respondWith(
        fetch(event.request)
            .then(response => {
                // Si la respuesta es válida, clonarla y guardarla en caché
                if (response && response.status === 200 && !shouldNeverCache) {
                    const responseToCache = response.clone();
                    caches.open(CACHE_NAME)
                        .then(cache => {
                            // No cachear rutas de autenticación ni CSRF
                            if (!event.request.url.includes('/login') &&
                                !event.request.url.includes('/logout') &&
                                !event.request.url.includes('/csrf-token')) {
                                cache.put(event.request, responseToCache);
                            }
                        });
                }
                return response;
            })
            .catch(() => {
                // Si falla la red, intentar obtener de caché (excepto rutas dinámicas)
                if (shouldNeverCache) {
                    return new Response('Sin conexión - Por favor, conéctate a internet para acceder a la aplicación.', {
                        status: 503,
                        statusText: 'Service Unavailable',
                        headers: new Headers({ 'Content-Type': 'text/plain; charset=utf-8' })
                    });
                }

                return caches.match(event.request)
                    .then(cachedResponse => {
                        if (cachedResponse) {
                            return cachedResponse;
                        }
                        // Si no está en caché, mostrar mensaje de offline
                        if (event.request.mode === 'navigate') {
                            return new Response('Sin conexión - Por favor, conéctate a internet.', {
                                status: 503,
                                statusText: 'Service Unavailable',
                                headers: new Headers({ 'Content-Type': 'text/plain; charset=utf-8' })
                            });
                        }
                    });
            })
    );
});

// Manejo de mensajes desde el cliente
self.addEventListener('message', event => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});
