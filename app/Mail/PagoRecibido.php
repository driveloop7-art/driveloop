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

  
    public function __construct(public $paymentId = 'N/A')
    {
      
    }

 
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Hemos recibido tu pago! #' . $this->paymentId,
        );
    }

   
    public function content(): Content
    {
        return new Content(
            view: 'emails.pago', 
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