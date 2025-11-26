<?php

namespace App\Mail;

use App\Models\Turno;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TurnoCreadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $turno;

    public function __construct(Turno $turno)
    {
        $this->turno = $turno;
    }

    public function build()
    {
        return $this
            ->subject('Tu turno ha sido creado')
            ->view('emails.turnocreado');
    }
}

