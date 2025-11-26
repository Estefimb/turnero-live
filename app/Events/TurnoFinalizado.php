<?php

namespace App\Events;

use App\Models\Turno;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TurnoFinalizado implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $turno;

    public function __construct(Turno $turno)
    {
        $this->turno = $turno;
    }

    public function broadcastOn()
    {
        return new Channel('turnos');
    }

    public function broadcastAs()
    {
        return 'TurnoFinalizado';
    }

    public function broadcastWith() {
        return ['turno' => $this->turno];
    }
}

