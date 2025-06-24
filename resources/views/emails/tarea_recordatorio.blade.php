<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Recordatorio de tarea</title>
</head>
<body>
    <h2>Hola {{ $tarea->usuario->nombre }},</h2>

    <p>Te recordamos que la siguiente tarea está próxima a vencer:</p>

    <ul>
        <li><strong>Título:</strong> {{ $tarea->titulo }}</li>
        <li><strong>Fecha límite:</strong> {{ $tarea->fecha_limite }}</li>
        <li><strong>Hora límite:</strong> {{ $tarea->hora_limite }}</li>
    </ul>

    <p>Por favor, completala antes del vencimiento para evitar penalizaciones.</p>

    <p style="font-size: small; color: gray;">Este es un mensaje automático de Notify.</p>
</body>
</html>
