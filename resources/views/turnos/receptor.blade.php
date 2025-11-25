<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Turnos</title>
    <!-- CARGA DE TAILWIND CSS VIA CDN para dar estilo a la cola -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Estilos base para mejor visibilidad en pantalla pública */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }
        /* Animación simple de parpadeo para el turno activo */
        @keyframes pulse-call {
            0%, 100% { background-color: #3b82f6; }
            50% { background-color: #1d4ed8; }
        }
        .animate-pulse-call {
            animation: pulse-call 2s infinite;
        }
    </style>
    @vite(['resources/js/bootstrap.js'])
</head>
<body>
    
    <div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        <h1 class="text-5xl font-extrabold text-gray-900 mb-8 text-center border-b-4 pb-4">
            Sistema de Gestión de Turnos
        </h1>

        <!-- Contenedor Principal de Dos Columnas: Turno Activo (2/3) y Cola (1/3) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- ============================================== -->
            <!-- COLUMNA IZQUIERDA: Turno en Curso (2/3) - ESTRUCTURA DE LISTA -->
            <!-- ============================================== -->
            <div class="lg:col-span-2">
                <div class="bg-white p-6 shadow-2xl rounded-xl border-t-8 border-blue-600 min-h-[300px] flex flex-col">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Turno en Atención</h2>
                    
                    <!-- Encabezado Fijo de las Columnas -->
                    <div class="grid grid-cols-2 text-3xl font-extrabold text-blue-700 bg-blue-100 p-4 rounded-lg shadow-md mb-4">
                        <div class="text-center">TURNO</div>
                        <div class="text-center">MESA / BOX</div>
                    </div>
                    
                    <!-- Contenido Dinámico del Turno en Curso -->
                    <div id="public-en-curso-list" class="flex-grow:1 space-y-4">
                        <div id="initial-message" class="p-4 text-center text-gray-500">
                            <p class="text-4xl font-light">Esperando el primer llamado…</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ================================================= -->
            <!-- COLUMNA DERECHA: Cola de Espera (1/3) -->
            <!-- ================================================= -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 shadow-2xl rounded-xl border-t-8 border-yellow-500 min-h-[300px]">
                    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Próximos Turnos</h2>
                    
                    <div id="public-pendientes-list" class="space-y-2">
                        <!-- Contenido dinámico de la cola de espera -->
                        <p class="text-gray-500 italic text-center">Cargando cola...</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <script>
    window.addEventListener('load', () => {
        if (!window.Echo) {
            console.error("Echo no está inicializado todavía. Verifica tu configuración de Websockets.");
            return;
        }

        const enCursoList = document.getElementById('public-en-curso-list');
        const pendientesList = document.getElementById('public-pendientes-list');

        // Función para renderizar el ítem del turno en curso (resaltado y animado)
        function renderTurnoEnCurso(turno) {
            // Usamos 'corresponde' para el número de Box/Mesa. Si está vacío, usamos 'N/A'.
            const boxNumber = turno.corresponde || 'N/A'; 
            
            // Texto secundario (Atención en curso)
            const smallText = 'Atención en curso';
            
            // Elimina el mensaje de 'Esperando...'
            const initialMessage = document.getElementById('initial-message');
            if (initialMessage) initialMessage.remove();

            return `
                <div id="active-call-${turno.id}" 
                    class="grid grid-cols-2 p-6 rounded-xl shadow-2xl transition duration-500 animate-pulse-call" 
                    style="background-color: #3b82f6;">
                    
                    <!-- TURNO CODE - USANDO FLEX PARA CENTRADO VERTICAL -->
                    <div class="text-center text-white border-r border-dashed border-white pr-4 flex flex-col justify-center">
                        <!-- Texto secundario arriba del código - SIN mb-2 -->
                        <span class="text-2xl font-bold block">${smallText}</span> 
                        <span class="text-8xl font-black block">${turno.codigo}</span>
                    </div>
                    
                    <!-- BOX/MESA NUMBER (Muestra el campo 'corresponde') - USANDO FLEX PARA CENTRADO VERTICAL -->
                    <div class="text-center text-white pl-4 flex flex-col justify-center">
                        <!-- Texto secundario arriba del número de box -->
                        <span class="text-2xl font-bold block">Diríjase a:</span>
                        <span class="text-8xl font-black block">${boxNumber}</span>
                    </div>
                </div>
            `;
        }
        
        // Función para renderizar un turno en la cola de espera
        function renderTurnoPendiente(turno) {
            // Usamos el operador_id como texto de la cola, o 'Cliente' si está vacío
            const turnName = turno.corresponde || turno.nombre || 'Cliente'; 
            return `
                <div id="turno-${turno.id}" class="p-3 bg-gray-50 border border-gray-200 rounded-lg flex justify-between items-center text-xl font-medium">
                    <span class="font-extrabold text-2xl text-yellow-700">${turno.codigo}</span>
                    <span class="text-gray-600 text-sm truncate ml-4">${turnName}</span>
                </div>
            `;
        }

        // Suscripción al canal de turnos
        window.Echo.channel('turnos')
            .listen('.TurnoCreado', e => {
                // Añade el nuevo turno al inicio de la lista de pendientes
                console.log("EVENTO TURNO CREADO", e.turno);
                pendientesList.innerHTML = renderTurnoPendiente(e.turno) + pendientesList.innerHTML;
            })
            .listen('.TurnoActualizado', e => {
                console.log("EVENTO TURNO ACTUALIZADO", e.turno);
                
                const oldPendienteElement = document.getElementById(`turno-${e.turno.id}`);
                
                if (e.turno.estado === 'en_curso') {
                    // 1. Mueve de pendientes (derecha)
                    if (oldPendienteElement) {
                        oldPendienteElement.remove();
                    }
                    // 2. Limpia los anteriores llamados
                    enCursoList.innerHTML = '';
                    // 3. Añade el nuevo llamado (izquierda, animado)
                    enCursoList.innerHTML = renderTurnoEnCurso(e.turno);
                }

                if (e.turno.estado === 'finalizado') {
                    // Limpia la pantalla de en curso si el turno actual finalizó
                    const activeCallElement = document.getElementById(`active-call-${e.turno.id}`);
                    if (activeCallElement) {
                        activeCallElement.remove(); // Remueve el elemento que acaba de finalizar
                    }
                    
                    // Si no hay más turnos en curso, volvemos al mensaje inicial.
                    if (enCursoList.children.length === 0) {
                        enCursoList.innerHTML = `<div id="initial-message" class="p-4 text-center text-gray-500"><p class="text-4xl font-light">Llamada finalizada. Esperando el próximo turno.</p></div>`;
                    }
                }
                
                // TODO: Aquí se podría añadir lógica para cargar la lista inicial de turnos (GET /turnos/estado)
            });
    });
    </script>
</body>
</html>