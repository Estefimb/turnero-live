<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Turno Creado</title>
</head>

<body style="background:#f5f6fa; font-family:Arial, sans-serif; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                       style="background:#ffffff; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.12); padding:40px;">

                    <!-- Banco Litoral -->
                    <tr>
                        <td align="center"
                            style="font-size:28px; font-weight:800; color:#0d47a1; padding-bottom:10px;">
                            Banco Litoral
                        </td>
                    </tr>

                    <!-- Turno Creado -->
                    <tr>
                        <td align="center"
                            style="font-size:20px; font-weight:700; color:#1a73e8; padding-bottom:20px;">
                            Turno Creado
                        </td>
                    </tr>

                    <!-- Texto -->
                    <tr>
                        <td style="font-size:16px; color:#333; text-align:center; padding-bottom:20px;">
                            Hola <strong>{{ $turno->nombre }}</strong>, tu turno fue registrado correctamente.
                        </td>
                    </tr>

                    <!-- Código -->
                    <tr>
                        <td align="center"
                            style="font-size:42px; font-weight:900; color:#1a73e8; padding:20px 0;">
                            {{ $turno->codigo }}
                        </td>
                    </tr>

                    <!-- Botón -->
                    <tr>
                        <td align="center" style="padding:20px 0;">
                            <a href="{{ url('/') }}"
                               style="background:#1a73e8; color:white; padding:12px 24px; 
                                      text-decoration:none; border-radius:6px; font-weight:bold;">
                                Ver más detalles
                            </a>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>


