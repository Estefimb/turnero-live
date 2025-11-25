<html>
<body>
    <h1>¡Gracias por su visita!</h1>
    <p>Su turno con código **{{ $turno->codigo }}** ha finalizado. Valoramos mucho su tiempo y experiencia.</p>
    <p>Por favor, tómese un momento para calificar su atención.</p>

    <a href="{{ $surveyUrl }}" style="
        display: inline-block;
        padding: 10px 20px;
        background-color: #3b82f6;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
    ">
        Responder la Encuesta
    </a>

    <p>¡Esperamos verle pronto!</p>
</body>
</html>