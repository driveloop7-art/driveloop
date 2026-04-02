<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 40px;
        }
        .header {
            border-bottom: 2px solid #ef4444;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            float: left;
            font-size: 24px;
            font-weight: bold;
            color: #ef4444;
        }
        .invoice-info {
            float: right;
            text-align: right;
        }
        .invoice-info h2 {
            margin: 0;
            color: #333;
        }
        .clearfix {
            clear: both;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #666;
            text-transform: uppercase;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .grid {
            width: 100%;
        }
        .grid td {
            vertical-align: top;
            padding-bottom: 10px;
        }
        .label {
            font-size: 10px;
            color: #999;
            text-transform: uppercase;
            display: block;
        }
        .value {
            font-size: 13px;
            font-weight: bold;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th {
            background-color: #f9fafb;
            text-align: left;
            padding: 12px;
            font-size: 11px;
            text-transform: uppercase;
            color: #666;
            border-bottom: 2px solid #eee;
        }
        .table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 12px;
        }
        .total-section {
            float: right;
            width: 250px;
            margin-top: 20px;
        }
        .total-row {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .total-label {
            float: left;
            font-weight: bold;
        }
        .total-value {
            float: right;
            font-weight: bold;
        }
        .grand-total {
            background-color: #fef2f2;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            color: #ef4444;
        }
        .footer {
            position: fixed;
            bottom: 30px;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">DriveLoop</div>
            <div class="invoice-info">
                <h2>FACTURA DE PAGO</h2>
                <p style="margin: 5px 0; font-size: 12px;">#{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p style="margin: 0; font-size: 11px; color: #666;">{{ $pago->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="section">
            <div class="section-title">Información del Cliente</div>
            <table class="grid">
                <tr>
                    <td width="50%">
                        <span class="label">Cliente</span>
                        <span class="value">{{ $reserva->user->nom ?? 'N/A' }} {{ $reserva->user->ape ?? '' }}</span>
                    </td>
                    <td width="50%">
                        <span class="label">Documento</span>
                        <span class="value">{{ $reserva->user->doc ?? 'N/A' }}</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class="label">Correo Electrónico</span>
                        <span class="value">{{ $reserva->user->email ?? 'N/A' }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Detalles del Vehículo</div>
            <table class="grid">
                <tr>
                    <td width="33%">
                        <span class="label">Marca / Línea</span>
                        <span class="value">{{ $marcaNombre }} {{ $lineaNombre }}</span>
                    </td>
                    <td width="33%">
                        <span class="label">Modelo</span>
                        <span class="value">{{ $vehiculo->mod ?? '' }}</span>
                    </td>
                    <td width="33%">
                        <span class="label">Matrícula</span>
                        <span class="value">{{ $vehiculo->vin ?? 'N/A' }}</span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Resumen del Alquiler</div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Periodo</th>
                        <th>Días</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Alquiler de Vehículo - {{ $marcaNombre }} {{ $lineaNombre }}</td>
                        <td>{{ $reserva->fecini->format('d/m/Y') }} - {{ $reserva->fecfin->format('d/m/Y') }}</td>
                        <td>{{ $reserva->fecini->diffInDays($reserva->fecfin) + 1 }}</td>
                        <td>${{ number_format($pago->monto, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <table class="total-section" style="border-collapse: collapse;">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #eee;">
                    <span style="font-weight: bold; font-size: 12px;">Método de Pago:</span>
                </td>
                <td style="padding: 10px 0; border-bottom: 1px solid #eee; text-align: right;">
                    <span style="font-weight: bold; font-size: 12px; text-transform: capitalize;">{{ $pago->metodo_pago }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="background-color: #fef2f2; padding: 15px; border-radius: 8px; color: #ef4444;">
                    <table width="100%">
                        <tr>
                            <td style="font-weight: bold; font-size: 16px;">TOTAL PAGADO:</td>
                            <td style="font-weight: bold; font-size: 18px; text-align: right;">${{ number_format($pago->monto, 0, ',', '.') }} COP</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="footer">
            <p>Gracias por confiar en DriveLoop. Este documento es una factura electrónica válida.</p>
            <p>DriveLoop SAS - Calle Ejemplo #123, Bogotá, Colombia</p>
        </div>
    </div>
</body>
</html>
