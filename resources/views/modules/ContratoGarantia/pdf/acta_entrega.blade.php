<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Acta de Entrega y Recepción de Vehículo</title>
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
            font-size: 22px;
            font-weight: bold;
            color: #000;
        }

        .header-logo {
            text-align: right;
            color: #D32F2F;
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
            padding-bottom: 10px;
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
            font-weight: bold;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            background-color: #f3f4f6;
            padding: 8px;
            margin-top: 15px;
            margin-bottom: 10px;
            border-left: 4px solid #D32F2F;
        }

        .bold {
            font-weight: bold;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 12px;
        }

        .inventory-table th, .inventory-table td {
            border: 1px solid #e5e7eb;
            padding: 6px;
            text-align: left;
        }

        .inventory-table th {
            background-color: #f9fafb;
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
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        .checkbox-box {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            margin-right: 5px;
            vertical-align: middle;
        }
        
        .line-blank {
            display: inline-block;
            border-bottom: 1px solid #000;
            width: 200px;
        }
        
        ul {
            margin-top: 5px;
            margin-bottom: 10px;
            padding-left: 20px;
        }
        li {
            margin-bottom: 5px;
        }
        
        .tips {
            margin-top: 30px;
            padding: 15px;
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            font-size: 11px;
            color: #92400e;
        }
    </style>
</head>

<body>
    @php
    $fechaInicio = \Carbon\Carbon::parse($reserva->fecini ?? now());
    $nombreUsuario = trim(($reserva->user->nom ?? '') . ' ' . ($reserva->user->ape ?? ''));
    if (empty($nombreUsuario)) $nombreUsuario = '_______________';

    $marcaVehiculo = $reserva->vehiculo->marca->des ?? '_______________';
    $lineaVehiculo = $reserva->vehiculo->linea->des ?? '_______________';
    $modeloVehiculo = $reserva->vehiculo->modelo ?? '________';
    $placaVehiculo = $reserva->vehiculo->placa ?? '________';
    @endphp

    <table class="header-table">
        <tr>
            <td class="header-title">ACTA DE ENTREGA Y RECEPCIÓN DE VEHÍCULO</td>
            <td class="header-logo">DRIVELOOP</td>
        </tr>
    </table>

    <table class="data-table">
        <tr>
            <td>
                <span class="label">FECHA DE ENTREGA</span>
                <span class="value">{{ $fechaInicio->format('d/m/Y') }}</span>
            </td>
            <td>
                <span class="label">HORA DE ENTREGA</span>
                <span class="value">{{ $fechaInicio->format('H:i') }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">CONTRATO REFERENCIA</span>
                <span class="value">Reserva #{{ $reserva->cod }}</span>
            </td>
            <td>
                <span class="label">VEHÍCULO</span>
                <span class="value">{{ $marcaVehiculo }} {{ $lineaVehiculo }} ({{ $placaVehiculo }})</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">CLIENTE (ARRENDATARIO)</span>
                <span class="value">{{ $nombreUsuario }}</span>
            </td>
            <td>
            </td>
        </tr>
    </table>

    <div class="section-title">1. Datos del Vehículo y Estado General Al Momento de la Entrega</div>
    <ul style="list-style-type: none; padding-left: 0;">
        <li><span class="bold">Kilometraje de salida:</span> <span class="line-blank"></span> km</li>
        <li><span class="bold">Nivel de combustible:</span> [ &nbsp; ] 1/4 &nbsp;&nbsp; [ &nbsp; ] 1/2 &nbsp;&nbsp; [ &nbsp; ] 3/4 &nbsp;&nbsp; [ &nbsp; ] Lleno &nbsp;&nbsp; [ &nbsp; ] Reserva</li>
        <li><span class="bold">Limpieza:</span> [ &nbsp; ] Óptima &nbsp;&nbsp; [ &nbsp; ] Aceptable &nbsp;&nbsp; [ &nbsp; ] Requiere limpieza</li>
    </ul>

    <div class="section-title">2. Inventario de Accesorios y Documentos</div>
    <table class="inventory-table">
        <thead>
            <tr>
                <th width="45%">Ítem</th>
                <th width="10%">Sí</th>
                <th width="10%">No</th>
                <th width="35%">Estado / Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Tarjeta de Propiedad (Original/Copia)</td>
                <td>[ &nbsp; ]</td>
                <td>[ &nbsp; ]</td>
                <td></td>
            </tr>
            <tr>
                <td>Seguro Obligatorio (SOAT/Otros)</td>
                <td>[ &nbsp; ]</td>
                <td>[ &nbsp; ]</td>
                <td>Vence el: <span class="line-blank" style="width:100px;"></span></td>
            </tr>
            <tr>
                <td>Llave / Control de repuesto</td>
                <td>[ &nbsp; ]</td>
                <td>[ &nbsp; ]</td>
                <td></td>
            </tr>
            <tr>
                <td>Gato y palanca</td>
                <td>[ &nbsp; ]</td>
                <td>[ &nbsp; ]</td>
                <td></td>
            </tr>
            <tr>
                <td>Llave de pernos (Cruceta)</td>
                <td>[ &nbsp; ]</td>
                <td>[ &nbsp; ]</td>
                <td></td>
            </tr>
            <tr>
                <td>Llanta de repuesto</td>
                <td>[ &nbsp; ]</td>
                <td>[ &nbsp; ]</td>
                <td></td>
            </tr>
            <tr>
                <td>Kit de carretera / Botiquín</td>
                <td>[ &nbsp; ]</td>
                <td>[ &nbsp; ]</td>
                <td></td>
            </tr>
            <tr>
                <td>Extintor (Vigente)</td>
                <td>[ &nbsp; ]</td>
                <td>[ &nbsp; ]</td>
                <td>Vence el: <span class="line-blank" style="width:100px;"></span></td>
            </tr>
            <tr>
                <td>Radio / Pantalla / Multimedia</td>
                <td>[ &nbsp; ]</td>
                <td>[ &nbsp; ]</td>
                <td></td>
            </tr>
            <tr>
                <td>Tapetes (Juego completo)</td>
                <td>[ &nbsp; ]</td>
                <td>[ &nbsp; ]</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">3. Estado Exterior e Interior (Carrocería, Pintura, Cojinería)</div>
    <ul style="list-style-type: none; padding-left: 0; font-size: 13px; line-height: 1.8;">
        <li><span class="bold">Parte Frontal (Luces, capó, vidrio, parachoques):</span> <div style="border-bottom: 1px dotted #000; width: 100%; display:inline-block; height: 1em;"></div></li>
        <li><span class="bold">Costado Derecho (Puertas, guardabarros, retrovisor):</span> <div style="border-bottom: 1px dotted #000; width: 100%; display:inline-block; height: 1em;"></div></li>
        <li><span class="bold">Costado Izquierdo (Puertas, guardabarros, retrovisor):</span> <div style="border-bottom: 1px dotted #000; width: 100%; display:inline-block; height: 1em;"></div></li>
        <li><span class="bold">Parte Posterior (Baúl, luces, vidrio, parachoques):</span> <div style="border-bottom: 1px dotted #000; width: 100%; display:inline-block; height: 1em;"></div></li>
        <li><span class="bold">Techo / Antenas:</span> <div style="border-bottom: 1px dotted #000; width: 100%; display:inline-block; height: 1em;"></div></li>
        <li><span class="bold">Tapicería / Coginería / Techo interior:</span> <div style="border-bottom: 1px dotted #000; width: 100%; display:inline-block; height: 1em;"></div></li>
        <li><span class="bold">Llantas/Rines (Marcas de fricción, pernos de seguridad):</span> 
            <br> [ &nbsp; ] Del. Der &nbsp;&nbsp; [ &nbsp; ] Del. Izq &nbsp;&nbsp; [ &nbsp; ] Tras. Der &nbsp;&nbsp; [ &nbsp; ] Tras. Izq 
        </li>
    </ul>

    <div class="section-title">4. Observaciones Mecánicas Adicionales</div>
    <p style="font-size: 13px;"><i>Indique si hay ruidos extraños, testigos encendidos en el tablero, fallas en el aire acondicionado, rayones en los vidrios, etc.</i></p>
    <div style="border: 1px solid #ccc; height: 60px; width: 100%; border-radius: 4px;"></div>

    <div class="section-title">Compromiso de Devolución</div>
    <p style="text-align: justify;">El <strong>ARRENDATARIO</strong> declara que recibe el vehículo y los accesorios descritos en este documento a su entera satisfacción, verificando personalmente el estado del mismo, y se obliga a devolverlo(s) en idéntico estado y condiciones al momento de finalizar el alquiler o cuando el propietario lo solicite, asumiendo los costos por faltantes, daños, perjuicios o deméritos causados durante el periodo de arrendamiento.</p>

    <table class="signatures">
        <tr>
            <td>
                <div class="line"></div>
                <span class="bold" style="color: #333">EL ARRENDADOR (Entregador)</span><br>
                Nombre: ____________________<br>
                C.C. / NIT: _______________________
            </td>
            <td>
                <div class="line"></div>
                <span class="bold" style="color: #333">EL ARRENDATARIO (Quien Recibe)</span><br>
                Nombre: {{ $nombreUsuario }}<br>
                C.C. / ID: _______________________
            </td>
        </tr>
    </table>
    
    <div class="tips">
        <strong>💡 Consejos Importantes de Entrega:</strong><br>
        <strong>1. Las fotos son ley:</strong> Antes de que el arrendatario se lleve el coche, toma fotos nítidas de los cuatro costados, el techo y del tablero (donde se vea el kilometraje y el nivel de gasolina). Si es posible, graba un video corto alrededor del auto detallando cualquier imperfección preexistente.<br>
        <strong>2. Testigos del Tablero:</strong> Asegúrate de que no haya luces de advertencia (como "Check Engine", "Airbag" o "Aceite") encendidas al momento de dar marcha, y déjalo evidenciado si existiera alguna.
    </div>

    <div class="footer">
        Acta de Entrega generada por DriveLoop - {{ date('d/m/Y H:i') }}
    </div>
</body>

</html>
