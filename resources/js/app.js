import './bootstrap';
import Echo from 'laravel-echo';

window.APP_LOADED = true;


//window.Echo = new Echo({
    //broadcaster: 'reverb',
    //key: import.meta.env.VITE_REVERB_APP_KEY,
    //wsHost: import.meta.env.VITE_REVERB_HOST,
    //wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    //wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    //forceTLS: false,
    //encrypted: false,
    //disableStats: true,
    //enabledTransports: ['ws','wss'],
//})

//window.Echo.channel('turnos')
//.listen('.TurnoCreado', (e) => { addToPendientes(e); })
//.listen('.TurnoActualizado', (e) => { moveTurno(e); });

//window.addToPendientes = function(e) {
    //console.log("Turno creado:", e.turno);
//};

//window.moveTurno = function(e) {
    //console.log("Turno actualizado:", e.turno);
//};