<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Turnos</title>

    <!-- Tailwind vía CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #0e1423; 
        }

        @keyframes pulse-call {
            0% { background-color: #1d4ed8; }
            50% { background-color: #1e40af; }
            100% { background-color: #1d4ed8; }
        }
        .animate-pulse-call {
            animation: pulse-call 2s infinite;
        }
    </style>

    @vite(['resources/js/echo.js'])
</head>

<!-- 👇 ESTA LÍNEA ES LA QUE SOLUCIONA EL FOOTER -->
<body class="text-white min-h-screen flex flex-col">

    <!-- 👇 CONTENEDOR FLEX QUE EMPUJA EL FOOTER -->
    <div class="flex-grow">

        <div class="max-w-7xl mx-auto p-6">

            <!-- TÍTULO -->
            <h1 class="text-4xl font-bold text-center mb-10 text-blue-300 drop-shadow">
                Sistema de Turnos
            </h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

                <!-- PANEL IZQUIERDO - EN CURSO -->
                <div class="lg:col-span-2">
                    <div class="bg-[#141b2d] p-8 shadow-xl rounded-2xl border border-blue-700/30">

                        <h2 class="text-2xl font-semibold mb-5 text-blue-300">
                            Turno en Atención
                        </h2>

                        <!-- Encabezados -->
                        <div class="grid grid-cols-2 text-xl font-semibold text-blue-200
                            bg-blue-900/30 p-4 rounded-lg border border-blue-700/40 mb-4">
                            <div class="text-center">TURNO</div>
                            <div class="text-center">MESA / BOX</div>
                        </div>

                        <!-- Contenedor dinámico -->
                        <div id="public-en-curso-list" class="space-y-5">
                            <div id="initial-message" class="p-4 text-center text-gray-400">
                                <p class="text-2xl font-light">Esperando el primer llamado…</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- PANEL DERECHO - COLA -->
                <div>
                    <div class="bg-[#141b2d] p-8 shadow-xl rounded-2xl border border-yellow-600/30">

                        <h2 class="text-2xl font-semibold mb-5 text-yellow-300">
                            Próximos Turnos
                        </h2>

                        <div id="public-pendientes-list" class="space-y-3">
                            <p class="text-gray-400 italic text-center">
                                Cargando cola...
                            </p>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div> <!-- 👈 CIERRE DEL FLEX-GROW -->

    <!-- FOOTER SIEMPRE ABAJO -->
    <footer class="bg-[#0e1423] text-blue-300 text-center py-4 border-t border-blue-800/40">
        <p class="text-sm">© 2025 Sistema de Gestión de Turnos IA-TEAM</p>
    </footer>

</body>
</html>

