<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Emisor – Turnos</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body style="font-family:sans-serif;padding:24px;">
  <h1>Panel Operador</h1>

  @if(session('ok'))
    <p style="background:#e7f7ee;padding:8px;border-radius:6px;">
      {{ session('ok') }}
    </p>
  @endif

  <form method="POST" action="{{ route('emitir') }}">
    @csrf
    <label>Código del turno</label><br>
    <input type="text" name="codigo" required><br><br>

    <label>Caja</label><br>
    <input type="text" name="caja" required><br><br>

    <label>Mensaje (opcional)</label><br>
    <textarea name="mensaje" rows="3"></textarea><br><br>

    <button type="submit">Llamar turno</button>
  </form>

  <p style="margin-top:10px;">
    Abrí <a href="{{ route('receptor') }}" target="_blank">/receptor</a> en otra pestaña.
  </p>
</body>
</html>
