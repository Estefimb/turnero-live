<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Pantalla de Turnos</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body style="font-family:sans-serif;padding:40px;background:#f5f5f9;">
  <h1>Pantalla de Turnos</h1>
  <div id="box" style="padding:32px;background:#fff;border-radius:16px;border:1px solid #ddd;">
    <div id="numero-turno" style="font-size:64px;font-weight:bold;">Esperando…</div>
    <div id="numero-caja" style="font-size:28px;margin-top:8px;"></div>
    <div id="mensaje-turno" style="font-size:20px;margin-top:12px;"></div>
  </div>
</body>
</html>
