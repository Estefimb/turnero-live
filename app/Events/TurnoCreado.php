<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Turno;

class TurnoCreado implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $turno;

    public function __construct(Turno $turno)
    {
        \Log::info("EVENTO: TurnoCreado DISPARADO", [
    'id' => $turno->id,
    'codigo' => $turno->codigo
]);

        $this->turno = $turno;
    }

    public function broadcastOn()
    {
        return new Channel('turnos');
    }

    public function broadcastAs()
    {
        return 'TurnoCreado';
    }
}

