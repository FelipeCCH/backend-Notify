<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Content;
use App\Models\Tarea;

class TareaRecordatorioMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tarea;

    /**
     * Crear nueva instancia del recordatorio.
     */
    public function __construct(Tarea $tarea)
    {
        $this->tarea = $tarea;
    }

    /**
     * Configurar asunto y remitente.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⏰ Recordatorio: tu tarea está próxima a vencer'
        );
    }

    /**
     * Enviar vista y datos.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.tarea_recordatorio',
            with: ['tarea' => $this->tarea]
        );
    }

    /**
     * Archivos adjuntos (no usamos en este caso).
     */
    public function attachments(): array
    {
        return [];
    }
}
