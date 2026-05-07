<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contrato de Reserva y Arrendamiento</title>
    <style>
        @page {
            margin: 36px 34px 34px 34px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #282828;
            line-height: 1.5;
        }

        .header {
            width: 100%;
            border-bottom: 3px solid #C91843;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            border: none;
            vertical-align: middle;
        }

        .logo {
            width: 190px;
        }

        .doc-title {
            text-align: right;
        }

        .doc-title h1 {
            margin: 0;
            font-size: 18px;
            color: #111111;
        }

        .doc-title p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #981B39;
        }

        .section-title {
            background: #C91843;
            color: #ffffff;
            font-size: 12px;
            font-weight: bold;
            padding: 8px 10px;
            margin-top: 18px;
            margin-bottom: 0;
            border-radius: 4px 4px 0 0;
        }

        .section-box {
            border: 1px solid #ead2d8;
            background: #fffafb;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 0 0 4px 4px;
        }

        .label {
            font-weight: bold;
            color: #111111;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        .info-table th,
        .info-table td {
            border: 1px solid #e7d7dc;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        .info-table th {
            width: 34%;
            background: #f8f1f3;
            color: #870027;
            font-weight: bold;
        }

        .text-justify {
            text-align: justify;
        }

        ul {
            margin: 6px 0 0 18px;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        .note {
            margin-top: 18px;
            padding: 10px 12px;
            border-left: 4px solid #981B39;
            background: #fdf1f4;
            color: #282828;
        }

        .footer {
            margin-top: 24px;
            border-top: 1px solid #ead2d8;
            padding-top: 10px;
            font-size: 10px;
            color: #666666;
            text-align: center;
        }

        .signature-box {
            margin-top: 28px;
            width: 100%;
        }

        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #777;
            width: 240px;
            padding-top: 5px;
            font-size: 10px;
            color: #444;
        }
    </style>
</head>
<body>

    <div class="header">
        <table class="header-table">
            <tr>
                <td style="width: 45%;">
                    <img src="{{ public_path('img/driveloop-logo.png') }}" alt="DriveLoop" class="logo">
                </td>
                <td style="width: 55%;" class="doc-title">
                    <h1>CONTRATO DE RESERVA Y ARRENDAMIENTO DE VEHÍCULO</h1>
                    <p><strong>Número:</strong> {{ $contrato->numero_contrato }}</p>
                    <p><strong>Fecha de emisión:</strong> {{ optional($contrato->fecha_emision)->format('d/m/Y H:i') }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">1. Partes intervinientes</div>
    <div class="section-box">
        <p>
            <span class="label">Arrendatario:</span>
            {{ $usuario->nom ?? '' }} {{ $usuario->ape ?? '' }}
            @if(!empty($usuario->email))
                - {{ $usuario->email }}
            @endif
        </p>

        <p>
            <span class="label">Propietario del vehículo:</span>
            {{ $propietario->nom ?? 'Propietario registrado en la plataforma' }}
            {{ $propietario->ape ?? '' }}
        </p>

        <p class="text-justify">
            <span class="label">Intermediario tecnológico:</span>
            DriveLoop, plataforma digital orientada a la publicación, búsqueda, reserva y gestión de vehículos en arrendamiento.
        </p>
    </div>

    <div class="section-title">2. Información de la reserva</div>
    <div class="section-box">
        <table class="info-table">
            <tr>
                <th>Código de reserva</th>
                <td>#{{ $reserva->cod }}</td>
            </tr>
            <tr>
                <th>Fecha y hora de recogida</th>
                <td>{{ optional($reserva->fecini)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Fecha y hora de entrega</th>
                <td>{{ optional($reserva->fecfin)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Valor total del servicio</th>
                <td>${{ number_format($reserva->val, 0, ',', '.') }} COP</td>
            </tr>
        </table>
    </div>

    <div class="section-title">3. Datos del vehículo</div>
    <div class="section-box">
        <table class="info-table">
            <tr>
                <th>Marca</th>
                <td>{{ $vehiculo->marca->des ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Línea</th>
                <td>{{ $vehiculo->linea->des ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Modelo</th>
                <td>{{ $vehiculo->mod ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Color</th>
                <td>{{ $vehiculo->col ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>VIN / Identificador</th>
                <td>{{ $vehiculo->vin ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Clase</th>
                <td>{{ $vehiculo->clase->des ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Combustible</th>
                <td>{{ $vehiculo->combustible->des ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">4. Naturaleza del servicio</div>
    <div class="section-box text-justify">
        <p>
            DriveLoop actúa exclusivamente como intermediario tecnológico entre el propietario del vehículo y el usuario arrendatario.
            En consecuencia, no ostenta la calidad de propietario, asegurador, transportador ni operador directo del vehículo.
        </p>
        <p>
            La entrega material del vehículo, su disponibilidad efectiva, sus condiciones físicas, el uso durante el periodo de reserva
            y la devolución del bien corresponden a la relación contractual entre propietario y arrendatario, gestionada a través de la plataforma.
        </p>
    </div>

    <div class="section-title">5. Obligaciones del arrendatario</div>
    <div class="section-box">
        <ul>
            <li>Usar el vehículo conforme a la ley, las normas de tránsito y su destinación normal.</li>
            <li>Devolver el vehículo en la fecha y hora pactadas o dentro del periodo autorizado.</li>
            <li>No subarrendar, prestar ni entregar el vehículo a terceros no autorizados.</li>
            <li>Responder por multas, comparendos, sanciones o usos indebidos ocurridos durante la vigencia de la reserva.</li>
            <li>Informar oportunamente cualquier incidente, siniestro o novedad relacionada con el vehículo.</li>
        </ul>
    </div>

    <div class="section-title">6. Cobertura y protección</div>
    <div class="section-box text-justify">
        <p>
            La reserva cuenta con una póliza temporal emitida exclusivamente por el periodo exacto de vigencia de la reserva,
            según documento generado por la plataforma y asociado a esta transacción.
        </p>
    </div>

    <div class="section-title">7. Aceptación contractual</div>
    <div class="section-box text-justify">
        <p>
            La confirmación del pago y la aceptación electrónica de la reserva constituyen manifestación válida de aceptación
            del presente contrato por parte del usuario arrendatario.
        </p>
    </div>

    <div class="note">
        <strong>Nota:</strong> Este documento ha sido generado automáticamente por DriveLoop como soporte formal de la reserva y del servicio contratado.
    </div>

    <div class="signature-box">
        <div class="signature-line">
            Firma electrónica / aceptación digital del arrendatario
        </div>
    </div>

    <div class="footer">
        DriveLoop · Plataforma digital de intermediación de vehículos · Documento generado automáticamente
    </div>

</body>
</html>