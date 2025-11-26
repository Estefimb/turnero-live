import './bootstrap';

window.APP_LOADED = true;

window.Echo.channel('turnos')
.listen('.TurnoCreado', (e) => { console.log("Turno creado:", e.turno); })
.listen('.TurnoActualizado', (e) => { console.log("Turno actualizado:", e.turno); });
