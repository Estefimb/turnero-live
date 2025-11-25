@if(count($turnos) === 0)
    <p>No hay turnos en este estado.</p>
@else
    <ul>
        @foreach($turnos as $turno)
            <li class="mb-3 p-3 border rounded">

                <strong>{{ $turno->codigo }}</strong>
                — {{ $turno->nombre }} ({{ $turno->dni }})
                — {{ ucfirst($turno->tipo) }}
                — {{ $turno->corresponde ?? 'Sin asignar' }}

                {{-- Botón SOLO si está pendiente --}}
                @if($turno->estado === 'pendiente')
                    <button
                        class="bg-blue-600 text-white px-3 py-1 rounded ml-4"
                        onclick="siguienteTurno({{ $turno->id }})">
                        Siguiente Turno
                    </button>
                @endif

                {{-- Botón SOLO si está en curso --}}
                @if($turno->estado === 'en_curso')
                    <button
                        class="bg-red-600 text-white px-3 py-1 rounded ml-4"
                        onclick="finalizarTurno({{ $turno->id }})">
                        Finalizar Turno
                    </button>
                @endif

            </li>
        @endforeach
    </ul>
@endif

<script>
function siguienteTurno() {
    fetch("/turnos/siguiente", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        }
    })
    .then(r => r.json())
    .then(data => {
        console.log("Turno actualizado:", data);
        location.reload(); // recarga panel operador
    });
}

function finalizarTurno(id) {
    const email = prompt("Ingrese email del cliente para la encuesta (opcional):");

    fetch(`/turnos/${id}/finalizar`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            email: email || null
        })
    })
    .then(r => r.json())
    .then(data => {
        console.log("Turno finalizado:", data);
        location.reload();
    });
}
</script>
