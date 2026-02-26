<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket # {{ $ticket->cod }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 40px;
        }

        .header {
            border-bottom: 2px solid #000000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #000000;
            font-size: 24px;
        }

        .info-grid {
            width: 100%;
            margin-bottom: 10px;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .label {
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            font-size: 10px;
            display: block;
        }

        .value {
            font-size: 14px;
            font-weight: 600;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .content-box {
            background-color: #f9fafb;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 13px;
            white-space: pre-line;
        }

        .footer {
            margin-top: 50px;
            font-size: 10px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>

<body>
    <div>
        <!-- El paquete dompdf requiere instalar/habilitar la extensión gd de php para no generar error al renderizar las imágenes -->
        <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="width: 120px; float: right;">
        <div class="header">
            <h1>Detalle de Ticket</h1>
        </div>
    </div>

    <table class="info-grid">
        <tr>
            <td width="50%">
                <div class="info-item">
                    <span class="label">Código</span>
                    <span class="value">{{ $ticket->cod }}</span>
                </div>
            </td>
            <td width="50%">
                <div class="info-item">
                    <span class="label">Usuario</span>
                    <span class="value">{{ $ticket->user->nom . ' ' . $ticket->user->ape }}</span>
                </div>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <div class="info-item">
                    <span class="label">Fecha de creación</span>
                    <span class="value">{{ $ticket->feccre->format('d/m/Y H:i') }}</span>
                </div>
            </td>
            <td width="50%">
                <div class="info-item">
                    <span class="label">Estado</span>
                    <span class="value">{{ $ticket->estado_ticket->des ?? 'N/A' }}</span>
                </div>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <div class="info-item">
                    <span class="label">Código de Reserva</span>
                    <span class="value">{{ $ticket->reserva->cod ?? 'N/A' }}</span>
                </div>
            </td>
            <td width="50%">
                <div class="info-item">
                    <span class="label">PDF Adjunto</span>
                    <span class="value">{{ $ticket->urlpdf ? 'Sí' : 'No' }}</span>
                </div>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <div class="info-item">
                    <span class="label">Asunto</span>
                    <span class="value">{{ $ticket->asu }}</span>
                </div>
            </td>
            @if(!Auth::user()->hasRole('Usuario'))
                <td width="50%">
                    <div class="info-item">
                        <span class="label">Prioridad</span>
                        <span class="value">{{ $ticket->prioridad_ticket->des ?? 'N/A' }}</span>
                    </div>
                </td>
            @endif
        </tr>
    </table>

    <div class="section-title">Descripción</div>
    <div class="content-box">
        {{ $ticket->des }}
    </div>

    @if($ticket->res)
        <div class="section-title"
            style="margin-top: 35px; margin-bottom: 20px; font-size: 15px; text-align: center; border-top: 2px solid #000000; padding: 10px;">
            Respuesta</div>
        <table class="info-grid">
            <tr>
                <td width="50%">
                    <div class="info-item">
                        <span class="label">Personal de soporte</span>
                        <span
                            class="value">{{ $ticket->idusu === $ticket->idususop ? 'Cerrado por usuario' : $ticket->user_soporte->nom . ' ' . $ticket->user_soporte->ape }}</span>
                    </div>
                </td>
                <td width="50%">
                    <div class="info-item">
                        <span class="label">Fecha de cierre</span>
                        <span class="value">{{ $ticket->feccie->format('d/m/Y H:i') }}</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <div class="info-item">
                        <span class="label">PDF Adjunto</span>
                        <span class="value">{{ $ticket->urlpdfres ? 'Sí' : 'No' }}</span>
                    </div>
                </td>
            </tr>
        </table>

        <div class="content-box">
            {{ $ticket->res }}
        </div>
    @endif

    <div class="footer">
        Documento generado por DriveLoop - {{ now()->format('d/m/Y H:i') }}
    </div>
</body>

</html>