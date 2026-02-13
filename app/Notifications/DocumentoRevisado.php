<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentoRevisado extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $documento;
    public $estado;
    public $mensaje;

    /**
     * Create a new notification instance.
     *
     * @param $documento
     * @param $mensaje
     */
    public function __construct($documento, $mensaje = null)
    {
        $this->documento = $documento;
        $this->estado = $documento->estado; // APROBADO o RECHAZADO
        $this->mensaje = $mensaje;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $tipoDoc = match($this->documento->idtipdocusu) {
            1 => 'Cédula de Ciudadanía',
            2 => 'Licencia de Conducción',
            3 => 'Pasaporte',
            default => 'Documento'
        };

        $mail = (new MailMessage)
                    ->subject('Resultado de Verificación de Documentos - DriveLoop')
                    ->greeting('Hola ' . $notifiable->nom . ',')
                    ->line("Tu documento ({$tipoDoc}) ha sido **{$this->estado}**.");

        if ($this->estado === 'RECHAZADO' && $this->mensaje) {
            $mail->line('Motivo del rechazo:')
                 ->line($this->mensaje)
                 ->line('Por favor, ingresa a la plataforma y sube el documento nuevamente corregido.');
        } else {
            $mail->line('Gracias por completar este paso. Tu perfil está más cerca de estar verificado.');
        }

        return $mail->action('Ver Mis Documentos', route('usuario.documentos.index'))
                    ->line('Gracias por confiar en DriveLoop!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $tipoDoc = match($this->documento->idtipdocusu) {
            1 => 'Cédula',
            2 => 'Licencia',
            3 => 'Pasaporte',
            default => 'Documento'
        };

        return [
            'documento_id' => $this->documento->id,
            'tipo_documento' => $tipoDoc,
            'estado' => $this->estado,
            'mensaje' => $this->mensaje,
            'titulo' => "Documento {$this->estado}",
            'descripcion' => "Tu {$tipoDoc} fue {$this->estado}." . ($this->mensaje ? " Motivo: {$this->mensaje}" : ""),
        ];
    }
}
