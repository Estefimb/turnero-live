<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encuesta de Satisfacción</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 20px;">

    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">

                <!-- CARD -->
                <table width="600" cellpadding="0" cellspacing="0" 
                       style="background: white; padding: 30px; border-radius: 12px;">

                    <!-- TITULO -->
                    <tr>
                        <td align="center">
                            <h1 style="font-size: 26px; margin-bottom: 5px; color: #111827;">
                                ¡Gracias por su visita!
                            </h1>
                        </td>
                    </tr>

                    <!-- TEXTO PRINCIPAL -->
                    <tr>
                        <td style="font-size: 16px; color: #374151; text-align: center;">
                            <p style="margin-bottom: 20px;">
                                Su turno ha finalizado. Valoramos mucho su tiempo y experiencia.
                            </p>

                            <!-- CODIGO DEL TURNO DESTACADO -->
                            <p style="
                                font-size: 32px;
                                font-weight: bold;
                                color: #1f2937;
                                margin: 0 0 25px 0;
                            ">
                                Código: {{ $turno->codigo }}
                            </p>

                            <p style="margin-bottom: 30px;">
                                Por favor, tómese un momento para calificar su atención.
                            </p>
                        </td>
                    </tr>

                    <!-- BOTÓN -->
                    <tr>
                        <td align="center">
                            <a href="{{ $turno }}" 
                               style="
                                   display: inline-block;
                                   background-color: #3b82f6;
                                   color: white;
                                   padding: 14px 28px;
                                   text-decoration: none;
                                   border-radius: 8px;
                                   font-weight: bold;
                                   font-size: 16px;
                               ">
                                Responder Encuesta
                            </a>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td align="center" style="padding-top: 25px; color: #6b7280; font-size: 14px;">
                            ¡Esperamos verle pronto!
                        </td>
                    </tr>

                </table>
                <!-- END CARD -->

            </td>
        </tr>
    </table>

</body>
</html>
