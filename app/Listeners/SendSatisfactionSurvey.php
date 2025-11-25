<?php

namespace App\Listeners;

use App\Events\TurnoActualizado;
use App\Mail\SatisfactionMail; // Importamos tu Mailable
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;

// Usamos ShouldQueue para que el envío de mail no retrase la respuesta HTTP del operador
class SendSatisfactionSurvey implements ShouldQueue 
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\TurnoActualizado  $event
     * @return void
     */
    public function handle(TurnoActualizado $event)
    {
        $turno = $event->turno;

        // VERIFICACIÓN: Solo enviar si el estado es 'finalizado' y si existe un email registrado.
        if ($turno->estado === 'finalizado' && !empty($turno->email)) {
            // Enviamos el Mailable 'SatisfactionMail' al email del turno.
            Mail::to($turno->email)->send(new SatisfactionMail($turno));
        }
    }
}
