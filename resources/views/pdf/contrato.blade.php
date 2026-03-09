<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Contrato de Alquiler</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
            color: #333;
            margin: 20px 30px;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header-title {
            font-size: 26px;
            font-weight: bold;
            color: #000;
        }

        .header-logo {
            text-align: right;
            color: #D32F2F;
            /* Rojo de driveloop parecido a la imagen */
            font-size: 24px;
            font-weight: bold;
            font-style: italic;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table td {
            vertical-align: top;
            padding-bottom: 15px;
            width: 50%;
        }

        .label {
            display: block;
            font-size: 11px;
            color: #6a7280;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .value {
            display: block;
            font-size: 15px;
            color: #1f2937;
            font-family: 'Times New Roman', Times, serif;
            /* Fuente con serifa como en la imagen */
            font-weight: bold;
        }

        .status-container {
            display: inline-block;
        }

        .status-label {
            font-size: 11px;
            color: #6a7280;
            text-transform: uppercase;
            font-weight: bold;
            margin-right: 5px;
        }

        .description-box {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            background-color: #fafafa;
            margin-top: 5px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            color: #1f2937;
            line-height: 1.6;
            text-align: justify;
        }

        .bold {
            font-weight: bold;
        }

        .signatures {
            margin-top: 50px;
            width: 100%;
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 13px;
        }

        .signatures td {
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }

        .line {
            border-bottom: 1px dashed #6a7280;
            width: 90%;
            margin-bottom: 8px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        /* Ajustes de listas para el contrato dentro de la caja */
        .description-box ul,
        .description-box ol {
            margin-top: 5px;
            margin-bottom: 15px;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    @php
    $fechaInicio = \Carbon\Carbon::parse($reserva->fecini ?? now());
    $fechaFin = \Carbon\Carbon::parse($reserva->fecfin ?? now());
    $diasDuracion = $fechaInicio->diffInDays($fechaFin);

    $nombreUsuario = trim(($reserva->user->nom ?? '') . ' ' . ($reserva->user->ape ?? ''));
    if (empty($nombreUsuario)) $nombreUsuario = '_______________';

    $marcaVehiculo = $reserva->vehiculo->marca->des ?? '_______________';
    $lineaVehiculo = $reserva->vehiculo->linea->des ?? '_______________';
    $modeloVehiculo = $reserva->vehiculo->modelo ?? '________';
    $placaVehiculo = $reserva->vehiculo->placa ?? '________';
    @endphp

    <table class="header-table">
        <tr>
            <td class="header-title">Detalle de Contrato</td>
            <td class="header-logo">DRIVELOOP</td>
        </tr>
    </table>

    <table class="data-table">
        <tr>
            <td>
                <span class="label">CÓDIGO DE VERIFICACIÓN</span>
                <span class="value">{{ $codigo ?? 'N/A' }}</span>
            </td>
            <td>
                <span class="label">USUARIO</span>
                <span class="value">{{ $nombreUsuario }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">FECHA DE CREACIÓN</span>
                <div class="status-container">
                    <span class="status-label">ESTADO</span>
                    <span class="value" style="display:inline;">{{ now()->format('d/m/Y H:i') }}</span>
                </div>
            </td>
            <td>
                <span class="label">ESTADO DEL CONTRATO</span>
                <span class="value">Generado / Activo</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">CÓDIGO DE RESERVA</span>
                <span class="value">{{ $reserva->cod }}</span>
            </td>
            <td>
                <span class="label">VEHÍCULO</span>
                <span class="value">{{ $marcaVehiculo }} {{ $lineaVehiculo }}</span>
            </td>
        </tr>
    </table>

    <div style="margin-bottom: 20px;">
        <span class="label">ASUNTO</span>
        <span class="value" style="font-size: 16px;">Contrato formal de arrendamiento de vehículo particular.</span>
    </div>

    <div>
        <span class="label">CLÁUSULAS Y DESCRIPCIÓN LEGAL</span>
        <div class="description-box">
            <p style="margin-top: 0;">En la ciudad de <strong>Pasto</strong>, a los <strong>{{ date('d') }}</strong> días del mes de <strong>{{ \Carbon\Carbon::now()->locale('es')->monthName }}</strong> de <strong>{{ date('Y') }}</strong>, comparecen:</p>

            <ul>
                <li><span class="bold">EL ARRENDADOR:</span> DriveLoop SAS, identificado con NIT No. _________________, domiciliado en la ciudad de Pasto.</li>
                <li><span class="bold">EL ARRENDATARIO:</span> {{ $nombreUsuario }}, identificado con DNI/Cédula No. _________________, domiciliado en __________________________.</li>
            </ul>

            <p>Ambas partes, en pleno uso de sus facultades legales, acuerdan celebrar el presente contrato bajo las siguientes cláusulas:</p>

            <span class="bold">1. Objeto del Contrato</span><br>
            El Arrendador entrega en arrendamiento al Arrendatario el vehículo de su propiedad con las siguientes características:
            <ul>
                <li><span class="bold">Marca:</span> {{ $marcaVehiculo }}</li>
                <li><span class="bold">Modelo/Línea:</span> {{ $modeloVehiculo }} - {{ $lineaVehiculo }}</li>
                <li><span class="bold">Placa:</span> {{ $placaVehiculo }}</li>
                <li><span class="bold">Color:</span> _________________</li>
                <li><span class="bold">Número de Motor:</span> _________________</li>
            </ul>

            <span class="bold">2. Duración</span><br>
            El término de duración de este contrato será de <strong>{{ $diasDuracion }}</strong> días, contados a partir del <strong>{{ $fechaInicio->format('d/m/Y H:i') }}</strong> hasta el <strong>{{ $fechaFin->format('d/m/Y H:i') }}</strong>.<br><br>

            <span class="bold">3. Canon de Arrendamiento y Depósito</span>
            <ul>
                <li><span class="bold">Precio:</span> El Arrendatario pagará la suma correspondiente al valor total de la reserva confirmada en la plataforma por el alquiler del vehículo especificado.</li>
                <li><span class="bold">Depósito de Garantía:</span> El Arrendatario entrega en este acto la suma de $_________________ para garantizar el cumplimiento de las obligaciones y cubrir posibles daños menores o multas.</li>
            </ul>

            <span class="bold">4. Uso y Conservación</span><br>
            El Arrendatario se compromete a:
            <ol>
                <li>Utilizar el vehículo exclusivamente para fines particulares.</li>
                <li>No subarrendar ni permitir que terceros no autorizados conduzcan el vehículo.</li>
                <li>Mantener el vehículo en el mismo estado mecánico y estético en que lo recibió.</li>
            </ol>

            <span class="bold">5. Cargas y Responsabilidades</span>
            <ul>
                <li><span class="bold">Gastos de Funcionamiento:</span> Los gastos de combustible, peajes y limpieza correrán por cuenta del Arrendatario.</li>
                <li><span class="bold">Mantenimiento:</span> El mantenimiento preventivo (cambio de aceite, filtros) será responsabilidad del Arrendador.</li>
                <li><span class="bold">Siniestros y Multas:</span> El Arrendatario será responsable civil y penalmente por cualquier accidente, daño a terceros o infracción de tránsito cometida durante la vigencia del contrato y uso del vehículo.</li>
            </ul>

            <span class="bold">6. Seguros</span><br>
            El vehículo cuenta con seguro Todo Riesgo / SOAT vigente. En caso de siniestro, el Arrendatario deberá pagar el valor del deducible correspondiente a los daños ocasionados por su responsabilidad.<br><br>

            <span class="bold">7. Restitución</span><br>
            Al finalizar el contrato, el Arrendatario devolverá el vehículo en la dirección acordada, en las mismas condiciones en que fue recibido, salvo el desgaste natural por el uso legítimo.

            <table class="signatures">
                <tr>
                    <td>
                        <div class="line"></div>
                        <span class="bold" style="color: #333">EL ARRENDADOR (DriveLoop SAS)</span><br>
                        Nombre: ____________________<br>
                        NIT: _______________________
                    </td>
                    <td>
                        @if(isset($reserva->contrato) && $reserva->contrato->aceptado_arrendatario)
                        <div style="border: 2px solid #D32F2F; border-radius: 5px; padding: 10px; color: #D32F2F; font-size: 11px; text-align: center; margin-bottom: 5px;">
                            <strong style="font-size: 13px;">FIRMADO Y ACEPTADO ELECTRÓNICAMENTE</strong><br>
                            Por: {{ $nombreUsuario }}<br>
                            Fecha: {{ $reserva->contrato->fecha_aceptacion_arrendatario->format('d/m/Y H:i:s') }}<br>
                            IP: {{ $reserva->contrato->ip_arrendatario }}<br>
                            Cód. Verificación: {{ $codigo ?? $reserva->contrato->codigo_verificacion }}
                        </div>
                        <span class="bold" style="color: #333">EL ARRENDATARIO</span>
                        @else
                        <div class="line"></div>
                        <span class="bold" style="color: #333">EL ARRENDATARIO</span><br>
                        Nombre: {{ $nombreUsuario }}<br>
                        ID/Cédula: _______________________
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        Documento generado por DriveLoop - {{ date('d/m/Y H:i') }}
    </div>
</body>

</html>