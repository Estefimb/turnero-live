
@if(count($turnos) === 0)
  
@else
    <ul>
        @foreach($turnos as $turno)
            <li class="mb-3 p-3 border rounded">

                <strong>{{ $turno->codigo }}</strong>
                — {{ $turno->nombre }} ({{ $turno->dni }})
                — {{ ucfirst($turno->tipo) }}
                — {{ $turno->corresponde ?? 'Sin asignar' }}

                

                {{-- Botón SOLO si está en curso --}}
                @if($turno->estado === 'en_curso')
                    <button
                        class="
    bg-red-600 hover:bg-red-700 
    text-white font-semibold 
    px-3.5 py-1.5 
    rounded-md 
    text-sm 
    shadow-md hover:shadow-lg 
    transition-all duration-200 
    hover:scale-[1.03]
"

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
        },
    })
    .then(r => r.json())
    .then(data => {
        console.log("Turno actualizado:", data);

        // ❗ NO tocar DOM acá
        // Los listeners de Echo actualizan todo en tiempo real
    })
    .catch(err => console.error(err));
}

function finalizarTurno(id) {
    fetch(`/turnos/${id}/finalizar`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Content-Type": "application/json"
        },
        body: JSON.stringify({})
    })
    .then(r => r.json())
    .then(data => {
        console.log("Turno finalizado:", data);
    })
    .catch(err => console.error(err));
}



</script>
