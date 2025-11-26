<!-- Tailwind CDN (si ya tenés Tailwind en tu layout, borrá esto) -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: #0d1117;
    }
</style>

@vite(['resources/js/echo.js'])

<div class="max-w-7xl mx-auto p-6 lg:p-10 text-gray-200">

    <h1 class="text-4xl font-extrabold mb-10 text-center text-white tracking-tight">
        🎛️ Panel del Operador
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- ====================== -->
        <!-- FORMULARIO (Columna 1) -->
        <!-- ====================== -->
        <div class="lg:col-span-1">
            <div class="bg-[#161b22] p-6 rounded-2xl shadow-xl border border-gray-700">
                <h2 class="text-xl font-bold mb-4 text-blue-400">➕ Crear turno</h2>
                @include('turnos.form')
            </div>
        </div>

        <!-- ============================ -->
        <!-- COLA DE TURNOS (Columna 2-3) -->
        <!-- ============================ -->
        <div class="lg:col-span-2 space-y-10">

            <!-- Botón global -->
            <button 
                onclick="siguienteTurno()"
                class="bg-blue-600 hover:bg-blue-700 transition px-5 py-3 rounded-xl font-semibold shadow-lg text-white">
                ▶️ Siguiente Turno
            </button>

            <!-- =============== -->
            <!-- PENDIENTES -->
            <!-- =============== -->
            <div id="cola-pendientes" class="bg-[#161b22] p-6 rounded-2xl shadow-xl border border-yellow-600/60">
                <h3 class="text-2xl font-semibold flex items-center text-yellow-400 mb-4">
                    ⏳ Pendientes
                </h3>
                <div class="space-y-4">
                    @include('turnos.lista', ['turnos' => $pendientes])
                </div>
            </div>

            <!-- =============== -->
            <!-- EN CURSO -->
            <!-- =============== -->
            <div id="cola-en-curso" class="bg-[#161b22] p-6 rounded-2xl shadow-xl border border-blue-600/60">
                <h3 class="text-2xl font-semibold flex items-center text-blue-400 mb-4">
                    ⚡ En curso
                </h3>
                <div class="space-y-4">
                    @include('turnos.lista', ['turnos' => $enCurso])
                </div>
            </div>

            <!-- =============== -->
            <!-- FINALIZADOS -->
            <!-- =============== -->
            <div id="cola-finalizados" class="bg-[#161b22] p-6 rounded-2xl shadow-xl border border-gray-600/60">
                <h3 class="text-2xl font-semibold flex items-center text-gray-300 mb-4">
                    ✔️ Finalizados
                </h3>
                <div class="space-y-4">
                    @include('turnos.lista', ['turnos' => $finalizados])
                </div>
            </div>
        </div>
    </div>
</div>

<script>
window.addEventListener('load', () => {

    if (!window.Echo) {
        console.error("Echo no inicializado");
        return;
    }

    const contPendientes = document.querySelector('#cola-pendientes .space-y-4');
    const contEnCurso = document.querySelector('#cola-en-curso .space-y-4');
    const contFinalizados = document.querySelector('#cola-finalizados .space-y-4');

    const renderTurno = (turno) => {
        let boton = '';

        if (turno.estado === 'pendiente') {
            boton = `
                <button 
                    class="bg-blue-600 hover:bg-blue-700 transition text-white px-3 py-1 rounded-lg ml-3"
                    onclick="siguienteTurno(${turno.id})">
                    ▶️ Atender
                </button>`;
        }

        if (turno.estado === 'en_curso') {
            boton = `
                <button 
                    class="bg-red-600 hover:bg-red-700 transition text-white px-3 py-1 rounded-lg ml-3"
                    onclick="finalizarTurno(${turno.id})">
                    ✔️ Finalizar
                </button>`;
        }

        return `
            <li id="turno-${turno.id}" 
                class="p-4 rounded-xl border border-gray-600 bg-[#0f141a] shadow hover:shadow-lg transition">
                
                <strong class="text-blue-400">${turno.codigo}</strong>
                — ${turno.nombre ?? ''} (${turno.dni ?? ''})
                — <span class="text-gray-400">${turno.tipo ?? ''}</span>
                — <span class="text-green-400">${turno.corresponde ?? 'Sin asignar'}</span>

                ${boton}
            </li>
        `;
    };

    window.Echo.channel('turnos')
        .listen('.TurnoCreado', (e) => {
            contPendientes.innerHTML =
                renderTurno(e.turno) + contPendientes.innerHTML;
        })

        .listen('.TurnoActualizado', (e) => {
            document.querySelector(`#turno-${e.turno.id}`)?.remove();

            if (e.turno.estado === "pendiente") {
                const turnoDOM = document.getElementById(`turno-${e.turno.id}`);
                if (turnoDOM) turnoDOM.remove();
                contPendientes.innerHTML += renderTurno(e.turno) + contPendientes.innerHTML;
            }

            if (e.turno.estado === "en_curso") {
                contEnCurso.innerHTML =
                    renderTurno(e.turno) + contEnCurso.innerHTML;
            }

            if (e.turno.estado === "finalizado") {
                contFinalizados.innerHTML =
                    renderTurno(e.turno) + contFinalizados.innerHTML;
            }
        })

        .listen('.TurnoFinalizado', (e) => {
            document.querySelector(`#turno-${e.turno.id}`)?.remove();
            contFinalizados.innerHTML =
                renderTurno(e.turno) + contFinalizados.innerHTML;
        });
});
    </script>

    <footer class="bg-[#0e1423] text-blue-300 text-center py-4 mt-10 border-t border-blue-800/40">
        <p class="text-sm">© 2025 Sistema de Gestión de Turnos IA-TEAM</p>
    </footer>

</body>
</html>

</script>
