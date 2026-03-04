<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PagoRecibido extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Definimos la variable pública para que esté disponible en la vista.
     */
    public function __construct(public $paymentId = 'N/A')
    {
        // Al usar 'public' en el constructor, Laravel pasa automáticamente
        // la variable a la vista sin hacer nada más.
    }

    /**
     * Personalizamos el asunto del correo.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Hemos recibido tu pago! #' . $this->paymentId,
        );
    }

    /**
     * Definimos la ruta de la vista que crearemos a continuación.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.pago', // Esto buscará resources/views/emails/pago.blade.php
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}