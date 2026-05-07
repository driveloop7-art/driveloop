<div style="font-family: Arial, Helvetica, sans-serif; color:#222; line-height:1.6;">
    <h2 style="margin-bottom: 10px;">Hola {{ $reserva->user->nom ?? 'usuario' }},</h2>

    <p>
        Tu pago fue confirmado y los documentos de tu reserva ya fueron generados correctamente en DriveLoop.
    </p>

    <p>
        <strong>Reserva:</strong> #{{ $reserva->cod }}<br>
        <strong>Vehículo:</strong>
        {{ $reserva->vehiculo->marca->des ?? '' }}
        {{ $reserva->vehiculo->linea->des ?? '' }}
        {{ $reserva->vehiculo->mod ?? '' }}<br>
        <strong>Recogida:</strong> {{ optional($reserva->fecini)->format('d/m/Y H:i') }}<br>
        <strong>Entrega:</strong> {{ optional($reserva->fecfin)->format('d/m/Y H:i') }}
    </p>

    <p>
        En este correo encontrarás adjuntos:
    </p>

    <ul>
        <li>Contrato de arrendamiento del vehículo</li>
        <li>Póliza temporal del servicio</li>
    </ul>

    <p>
        Recuerda que DriveLoop actúa como intermediario entre el propietario del vehículo y el usuario arrendatario.
    </p>

    <p>
        Saludos,<br>
        <strong>Equipo DriveLoop</strong>
    </p>
</div>