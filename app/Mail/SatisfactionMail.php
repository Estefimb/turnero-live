<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Turno;

class SatisfactionMail extends Mailable
{
    public $turno;
    public $surveyUrl;

    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct()
    {
        $this->turno = $turno;
        // Genera la URL única para la encuesta.
        // Aquí puedes usar URL::signed() o simplemente route().
        $this->surveyUrl = route('turnos.survey.show', $turno->id);
    }

    public function build()
    {
        return $this->subject('Tu opinión es importante - Encuesta de satisfacción')
                    ->view('emails.satisfaction');
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Satisfaction Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
