const webpush = require('web-push');
const fs = require('fs');

const VAPID_PUBLIC = 'BLP3CuKaxos2Rl294_NOKxeEaPe6c_j2RV-zYExiACvKaV1hNb7Cf9M-9xTenqAeF1k2tUDz05-NiE18swyhfCk';
const VAPID_PRIVATE = 'hqp1ClusGn6bYrQkRwU_ya_0rGnPMmqqutA1oKHWhaQ';

webpush.setVapidDetails(
    'mailto:tu@correo.com',
    VAPID_PUBLIC,
    VAPID_PRIVATE
);

// Cargar suscripciones
if (!fs.existsSync('suscripciones.json')) {
    console.error('⚠️ No existe el archivo suscripciones.json');
    process.exit(1);
}

const data = fs.readFileSync('suscripciones.json', 'utf8');
let subs;
try {
    subs = JSON.parse(data);
    if (!Array.isArray(subs)) {
        throw new Error('El archivo suscripciones.json no contiene un array válido');
    }
} catch (err) {
    console.error('⚠️ Error al parsear suscripciones.json:', err.message);
    process.exit(1);
}

// Enviar notificación
const payload = JSON.stringify({
    title: '🚀 Notificación de prueba',
    body: '¡Esto llegó desde el servidor correctamente!',
    icon: 'imagenes/logo_acr_black.png'
});

let activas = [];

(async () => {
    for (const subscription of subs) {
        try {
            await webpush.sendNotification(subscription, payload);
            console.log('✅ Notificación enviada correctamente');
            activas.push(subscription);
        } catch (err) {
            if (err.statusCode === 410 || err.statusCode === 404) {
                console.warn('⚠️ Suscripción caducada, será eliminada.');
            } else {
                console.error('❌ Error al enviar push:', err.message);
                activas.push(subscription); // conservar si no fue error 410
            }
        }
    }

    // Guardar solo las suscripciones válidas
    fs.writeFileSync('suscripciones.json', JSON.stringify(activas, null, 2));
    console.log(`🧹 Limpieza completada. Quedan ${activas.length} suscripciones activas.`);
})();
