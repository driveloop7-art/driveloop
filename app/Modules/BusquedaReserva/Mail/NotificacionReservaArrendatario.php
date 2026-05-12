<?php

namespace App\Modules\BusquedaReserva\Mail;

use App\Models\MER\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificacionReservaArrendatario extends Mailable
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
            subject: 'Confirmación de tu reserva',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reservas.notificacion_arrendatario',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
