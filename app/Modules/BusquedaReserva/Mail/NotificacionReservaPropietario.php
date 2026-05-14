<?php

namespace App\Modules\BusquedaReserva\Mail;

use App\Models\MER\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionReservaPropietario extends Mailable
{
    use Queueable, SerializesModels;

    public $reserva;

    public function __construct(Reserva $reserva)
    {
        $this->reserva = $reserva;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Alguien ha reservado tu vehículo!',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reservas.notificacion_propietario',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
