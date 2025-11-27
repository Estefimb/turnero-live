<div class="p-6 bg-white shadow-2xl rounded-xl border border-gray-200">
    
    
    <!-- Div para mostrar mensajes de estado (éxito o error) sin recargar la página -->
    <div id="status-message" class="mb-4 p-4 rounded text-sm hidden" role="alert"></div>

    <!-- Formulario con ID para ser interceptado por JavaScript -->
    <form id="formulario-turno" action="{{ route('turnos.store') }}" method="POST" class="space-y-4">
        @csrf

        <div class="space-y-1">
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
            <input type="text"  id="nombre" name="nombre" required class="w-full p-3 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150">
        </div>

        <div class="space-y-1">
            <label for="dni" class="block text-sm font-medium text-gray-700">DNI:</label>
            <input type="text" id="dni" name="dni" required class="w-full p-3 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150">
        </div>

        <div class="space-y-1">
            <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de turno:</label>
            <select id="tipo" name="tipo" required class="w-full p-3 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150 bg-white">
                <option value="caja">Caja</option>
                <option value="asesoria">Asesoría</option>
            </select>
        </div>

        <div class="space-y-1">
            <label for="corresponde" class="block text-sm font-medium text-gray-700">Corresponde a:</label>
            <input type="text" id="corresponde" name="corresponde" class="w-full p-3 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150">
        </div>

        <div class="space-y-1">
            <label for="email" class="block text-sm font-medium text-gray-700">Email (opcional):</label>
            <input type="email" id="email" name="email" class="w-full p-3 border border-gray-700 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-150">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-200 shadow-lg transform hover:scale-[1.01]">
            Crear Turno
        </button>
    </form>
</div>

<!-- Script JavaScript para el envío AJAX (Fetch API) -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('formulario-turno');
    const submitButton = form.querySelector('button[type="submit"]');
    const statusMessage = document.getElementById('status-message');

    // Función para mostrar mensajes de estado
    function showMessage(message, type = 'success') {
        statusMessage.textContent = message;
        // Aplica clases Tailwind para estilos de éxito o error
        statusMessage.className = `mb-4 p-4 rounded text-sm ${type === 'success' ? 'bg-green-100 text-green-800 border border-green-300' : 'bg-red-100 text-red-800 border border-red-300'}`;
        statusMessage.classList.remove('hidden');
    }

    if (form) {
        form.addEventListener('submit', function (e) {
            // *** CLAVE: Intercepta el envío del formulario para prevenir la recarga de la página ***
            e.preventDefault(); 
            
            statusMessage.classList.add('hidden');

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            const csrfToken = data._token; 
            
            submitButton.disabled = true;
            submitButton.textContent = 'Generando...';

            // Inicio de la solicitud AJAX con Fetch API
            fetch(form.action, { 
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken, 
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().catch(() => {
                        throw new Error(`Error del servidor: HTTP ${response.status}`);
                    }).then(err => {
                        let errorMessage = 'Error desconocido al crear el turno.';
                        if (err.errors) {
                            errorMessage = Object.values(err.errors).flat().join('; ');
                        } else if (err.message) {
                            errorMessage = err.message;
                        }
                        throw new Error(errorMessage);
                    });
                }
                
                // Corrección para el error 'Unexpected end of JSON input'
                const contentLength = response.headers.get('content-length');
                if (response.status === 204 || (contentLength !== null && parseInt(contentLength) === 0)) {
                    return null; 
                }
                
                return response.json(); 
            })
            .then(data => {
                // Éxito: La actualización de la cola se maneja por Laravel Echo
                showMessage('✅ Turno creado exitosamente. La pantalla se actualizará en tiempo real.', 'success');
                form.reset(); 
            })
            .catch(error => {
                console.error('Error en la solicitud AJAX:', error);
                showMessage(`❌ Error: ${error.message}`, 'error');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.textContent = 'Crear Turno';
            });
        });
    }
});
</script>