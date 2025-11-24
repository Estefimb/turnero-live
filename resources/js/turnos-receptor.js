document.addEventListener('DOMContentLoaded', function () {
    const turno = document.getElementById('numero-turno');
    const caja = document.getElementById('numero-caja');
    const mensaje = document.getElementById('mensaje-turno');

    if (!window.Echo) {
        console.warn("Echo no está inicializado.");
        return;
    }

    window.Echo.channel("turnos")
        .listen(".TurnoActualizado", (e) => {
            turno.innerText = e.codigo ?? "";
            caja.innerText = e.caja ? "Caja: " + e.caja : "";
            mensaje.innerText = e.mensaje ?? "";

            const box = document.getElementById('box');
            box.style.transform = "scale(1.03)";
            setTimeout(() => box.style.transform = "scale(1)", 300);
        });
});
