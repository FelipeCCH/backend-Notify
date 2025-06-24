<h1>Hola {{ $tarea->usuario->nombre }},</h1>
<p>La siguiente tarea ha vencido:</p>

<ul>
    <li><strong>Título:</strong> {{ $tarea->titulo }}</li>
    <li><strong>Fecha límite:</strong> {{ $tarea->fecha_limite }}</li>
    <li><strong>Hora límite:</strong> {{ $tarea->hora_limite }}</li>
</ul>

<p>Por favor, revisá tu lista de tareas.</p>
