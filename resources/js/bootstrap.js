import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// PASO 1: Importar el cliente Pusher.js, ya que Reverb utiliza este protocolo.
import Pusher from 'pusher-js';
window.Pusher = Pusher; 

import Echo from "laravel-echo";

window.Echo = new Echo({
    // PASO 2: El Broadcaster DEBE ser 'pusher' para usar el protocolo.
    broadcaster: "reverb", 
    // Los demás parámetros son correctos para apuntar a Reverb
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST ?? window.location.hostname,
    wsPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
    wssPort: Number(import.meta.env.VITE_REVERB_PORT ?? 8080),
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? "http") === "https",
    enabledTransports: ["ws", "wss"],
    // Es recomendable añadir esto si usas Reverb para evitar advertencias de timeouts.
    encrypted: true, 
    disableStats: true, 
});

// Función para debug de conexión
window.EchoConnected = () => {
    // Si usas el driver 'pusher', el conector es el cliente de Pusher.
    if(window.Echo && window.Echo.connector && window.Echo.connector.pusher) {
        console.log("Estado de conexión:", window.Echo.connector.pusher.connection.state);
        if (window.Echo.connector.pusher.connection.state === 'connected') {
            console.log("✅ Echo conectado y listo para escuchar eventos.");
        }
    } else {
        console.log("Echo no está listo todavía");
    }
};

// Muestra el estado de la conexión en la consola al iniciar
window.Echo.connector.pusher.connection.bind('connected', () => {
    console.log("Reverb / Echo: Conexión establecida.");
});

window.Echo.connector.pusher.connection.bind('disconnected', () => {
    console.warn("Reverb / Echo: Conexión perdida.");
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
