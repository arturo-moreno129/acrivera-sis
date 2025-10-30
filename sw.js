// sw.js
self.addEventListener('install', e => {
    console.log('Service Worker instalado');
    self.skipWaiting();
});

self.addEventListener('activate', e => {
    console.log('Service Worker activado');
});

// Para mostrar notificaciones push (si luego las usas)
self.addEventListener('push', event => {
    const data = event.data ? event.data.json() : {};
    const title = data.title || 'Nueva notificación';
    const options = {
        body: data.body || 'Tienes una nueva notificación',
        icon: 'imagenes/logo_acr_black.png'
    };

    event.waitUntil(self.registration.showNotification(title, options));

    // Aumenta el contador en el ícono
    event.waitUntil(setBadgeCount());
});

let badgeCount = 0;

async function setBadgeCount() {
    badgeCount++;
    if ('setAppBadge' in navigator) {
        navigator.setAppBadge(badgeCount);
    } else if ('setAppBadge' in self.registration) {
        self.registration.setAppBadge(badgeCount);
    }
}

async function clearBadge() {
    badgeCount = 0;
    if ('clearAppBadge' in navigator) {
        navigator.clearAppBadge();
    } else if ('clearAppBadge' in self.registration) {
        self.registration.clearAppBadge();
    }
}

self.addEventListener('notificationclick', event => {
    event.notification.close();
    clearBadge();
    event.waitUntil(clients.openWindow('/'));
});
