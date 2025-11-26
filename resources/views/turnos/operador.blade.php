<!-- CARGA TEMPORAL DE TAILWIND CSS VIA CDN (Eliminar si ya lo tienes en tu layout principal) -->
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Estilos base para mejor legibilidad */
    body {
        font-family: 'Inter', sans-serif;
    }
</style>

@vite(['resources/js/echo.js'])

<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 bg-gray-100 min-h-screen">
    <h1 class="text-4xl font-bold text-gray-900 mb-8 text-center border-b-2 pb-2">Panel de Control del Operador</h1>

    <!-- Contenedor Principal de Dos Columnas (1/3 y 2/3 en pantallas grandes) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- ============================================== -->
        <!-- COLUMNA IZQUIERDA: Formulario de Creación (1/3) -->
        <!-- ============================================== -->
        <div class="lg:col-span-1">
            <!-- Incluimos el formulario (ya estilizado en turnos.form) -->
            <h2 class="sr-only">Crear turno</h2>
            @include('turnos.form')
        </div>

        <!-- ================================================= -->
        <!-- COLUMNA DERECHA: Cola de Turnos (2/3) -->
        <!-- ================================================= -->
        <div class="lg:col-span-2 space-y-6">
            <h2 class="text-3xl font-extrabold text-gray-800 pb-2 border-b-2">Cola de Turnos</h2>

            <button onclick="siguienteTurno()" 
                class="bg-blue-700 text-white px-4 py-2 rounded">
                Siguiente Turno
            </button>


            <!-- Turnos Pendientes (Cola) -->
            <div id="cola-pendientes" class="bg-white p-6 shadow-xl rounded-xl border-t-4 border-yellow-500 transition duration-300 hover:shadow-2xl">
                <h3 class="text-2xl font-semibold text-yellow-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Pendientes
                </h3>
                <div class="space-y-3">
                    @include('turnos.lista', ['turnos' => $pendientes])
                </div>
            </div>

            <!-- Turnos en Curso (Atendido) -->
            <div id="cola-en-curso" class="bg-white p-6 shadow-xl rounded-xl border-t-4 border-blue-500 transition duration-300 hover:shadow-2xl">
                <h3 class="text-2xl font-semibold text-blue-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    En curso
                </h3>
                <div class="space-y-3">
                     @include('turnos.lista', ['turnos' => $enCurso])
                </div>
            </div>
            
            <!-- Turnos Finalizados (Historial Reciente) -->
            <div id="cola-finalizados" class="bg-white p-6 shadow-xl rounded-xl border-t-4 border-gray-500 transition duration-300 hover:shadow-2xl">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Finalizados
                </h3>
                <div class="space-y-3">
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

    const contPendientes = document.querySelector('#cola-pendientes .space-y-3');
    const contEnCurso = document.querySelector('#cola-en-curso .space-y-3');
    const contFinalizados = document.querySelector('#cola-finalizados .space-y-3');

    const renderTurno = (turno) => {
    let botones = '';

    if (turno.estado === 'pendiente') {
        botones = `
            <button 
                class="bg-blue-600 text-white px-3 py-1 rounded ml-4"
                onclick="siguienteTurno(${turno.id})">
                Siguiente Turno
            </button>`;
    }

    if (turno.estado === 'en_curso') {
        botones = `
            <button 
                class="bg-red-600 text-white px-3 py-1 rounded ml-4"
                onclick="finalizarTurno(${turno.id})">
                Finalizar Turno
            </button>`;
    }

    return `
        <li id="turno-${turno.id}" class="mb-3 p-3 border rounded">
            <strong>${turno.codigo}</strong> — ${turno.nombre ?? ''} (${turno.dni ?? ''})
            — ${turno.tipo ?? ''} — ${turno.corresponde ?? 'Sin asignar'}
            ${botones}
        </li>
    `;
};


    window.Echo.channel('turnos')
        .listen('.TurnoCreado', (e) => {
            console.log("CREADO:", e.turno);
            contPendientes.innerHTML +=
                renderTurno(e.turno) + contPendientes.innerHTML;
        })

        .listen('.TurnoActualizado', (e) => {
            console.log("ACTUALIZADO:", e.turno);

            const turnoDOMPend = document.getElementById(`turno-${e.turno.id}`);
            if (turnoDOMPend) turnoDOMPend.remove();

            if (e.turno.estado === "pendiente") {
                const turnoDOM = document.getElementById(`turno-${e.turno.id}`);
                if (turnoDOM) turnoDOM.remove();
                contPendientes.innerHTML += renderTurno(e.turno) + contPendientes.innerHTML;
            }

            if (e.turno.estado === "en_curso") {
                const turnoDOM = document.getElementById(`turno-${e.turno.id}`);
                if (turnoDOM) turnoDOM.remove();
                contEnCurso.innerHTML =
                    renderTurno(e.turno) + contEnCurso.innerHTML;
            }

            if (e.turno.estado === "finalizado") {
                const turnoDOM = document.getElementById(`turno-${e.turno.id}`);
                if (turnoDOM) turnoDOM.remove();
                contFinalizados.innerHTML =
                renderTurno(e.turno) + contFinalizados.innerHTML;
            }
        })

        .listen('.TurnoFinalizado', (e) => {
            console.log("FINALIZADO", e.turno);
            const turnoDOM = document.getElementById(`turno-${e.turno.id}`);
            if (turnoDOM) turnoDOM.remove();
            contFinalizados.innerHTML =
                renderTurno(e.turno) + contFinalizados.innerHTML;
        });

});


</script>