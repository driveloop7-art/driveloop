<!DOCTYPE html>
<html>

<head>
    <title>Tu Contrato de Alquiler</title>
</head>

<body>
    <h1>Hola, {{ $reserva->user->nom }}!</h1>
    <p>Gracias por confiar en Driveloop. Adjunto encontrarás el contrato de arrendamiento para tu reserva.</p>

    <ul>
        <li><strong>Reserva ID:</strong> {{ $reserva->cod }}</li>
        <li><strong>Vehículo:</strong> {{ $reserva->vehiculo->marca->des }} {{ $reserva->vehiculo->linea->des }}</li>
        <li><strong>Fecha Inicio:</strong> {{ $reserva->fecini }}</li>
        <li><strong>Fecha Fin:</strong> {{ $reserva->fecfin }}</li>
    </ul>

    <p>Si tienes alguna duda, contáctanos.</p>

    <p>Saludos,<br>El equipo de Driveloop</p>
</body>

</html>