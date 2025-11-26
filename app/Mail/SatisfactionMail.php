<?php

namespace App\Mail;

use App\Models\Turno;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SatisfactionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $turno; // <-- ESTA ES LA VARIABLE QUE USARÁS EN LA VISTA

    public function __construct(Turno $turno)
    {
        $this->turno = $turno; // <-- AQUÍ LA GUARDAS
    }

    public function build()
    {
        return $this->subject('Calificá tu atención')
                    ->view('emails.satisfaction') // tu vista
                    ->with([
                        'turno' => $this->turno  // <-- ACÁ SE PASA CORRECTAMENTE
                    ]);
    }
}
