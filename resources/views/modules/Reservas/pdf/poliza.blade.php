<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Póliza Temporal Todo Riesgo</title>
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
            border-bottom: 3px solid #981B39;
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
            background: #981B39;
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

        .label {
            font-weight: bold;
            color: #111111;
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
            border-left: 4px solid #C91843;
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

        .badge {
            display: inline-block;
            padding: 4px 10px;
            background: #f8f1f3;
            color: #870027;
            border: 1px solid #e4c5cf;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
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
                    <h1>PÓLIZA TEMPORAL TODO RIESGO</h1>
                    <p><strong>Número de póliza:</strong> {{ $poliza->numero_poliza }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">1. Información general de la póliza</div>
    <div class="section-box">
        <table class="info-table">
            <tr>
                <th>Aseguradora</th>
                <td>{{ $poliza->empresa_aseguradora }}</td>
            </tr>
            <tr>
                <th>Tipo de cobertura</th>
                <td>{{ $poliza->tipo_cobertura }}</td>
            </tr>
            <tr>
                <th>Estado</th>
                <td>
                    <span class="badge">{{ ucfirst($poliza->estado) }}</span>
                </td>
            </tr>
            <tr>
                <th>Vigencia desde</th>
                <td>{{ optional($poliza->fini)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Vigencia hasta</th>
                <td>{{ optional($poliza->ffin)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <th>Valor asegurado</th>
                <td>${{ number_format($poliza->valor_asegurado, 0, ',', '.') }} COP</td>
            </tr>
            <tr>
                <th>Deducible</th>
                <td>{{ $poliza->deducible }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">2. Vehículo amparado</div>
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
                <th>Reserva asociada</th>
                <td>#{{ $reserva->cod }}</td>
            </tr>
        </table>
    </div>

    <div class="section-title">3. Tomador / beneficiario</div>
    <div class="section-box">
        <p><span class="label">Usuario arrendatario:</span> {{ $usuario->nom ?? '' }} {{ $usuario->ape ?? '' }}</p>
        <p><span class="label">Correo electrónico:</span> {{ $usuario->email ?? 'N/A' }}</p>
    </div>

    <div class="section-title">4. Amparos incluidos</div>
    <div class="section-box">
        <ul>
            <li>Daños materiales por choque o impacto.</li>
            <li>Pérdida total por daños.</li>
            <li>Pérdida total por hurto.</li>
            <li>Responsabilidad civil extracontractual.</li>
            <li>Asistencia básica durante el período de reserva.</li>
        </ul>
    </div>

    <div class="section-title">5. Restricción de vigencia</div>
    <div class="section-box">
        <p>
            Esta póliza ha sido emitida exclusivamente para cubrir el período de tiempo correspondiente a la reserva registrada en DriveLoop.
            Fuera de dicho lapso no genera cobertura alguna.
        </p>
    </div>

    <div class="section-title">6. Observaciones</div>
    <div class="section-box">
        <p>{{ $poliza->observaciones ?? 'Sin observaciones adicionales.' }}</p>
    </div>

    <div class="note">
        <strong>Nota:</strong> Documento generado automáticamente por DriveLoop como soporte de cobertura temporal asociada a la reserva.
    </div>

    <div class="footer">
        DriveLoop · Documento de póliza temporal · Generado automáticamente por la plataforma
    </div>

</body>
</html>