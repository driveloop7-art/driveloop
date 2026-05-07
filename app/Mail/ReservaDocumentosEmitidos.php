<?php

namespace App\Mail;

use App\Models\MER\Reserva;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservaDocumentosEmitidos extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Reserva $reserva,
        public string $contratoPath,
        public string $polizaPath
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Documentos de tu reserva DriveLoop #' . $this->reserva->cod,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reserva-documentos',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('public', $this->contratoPath)
                ->as('contrato-reserva-' . $this->reserva->cod . '.pdf')
                ->withMime('application/pdf'),

            Attachment::fromStorageDisk('public', $this->polizaPath)
                ->as('poliza-reserva-' . $this->reserva->cod . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}