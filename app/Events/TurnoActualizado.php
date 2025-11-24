<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

class TurnoActualizado implements ShouldBroadcastNow
{
    use SerializesModels;

    public string $codigo;
    public string $caja;
    public ?string $mensaje;

    public function __construct(string $codigo, string $caja, ?string $mensaje = null)
    {
        $this->codigo = $codigo;
        $this->caja   = $caja;
        $this->mensaje = $mensaje;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('turnos');
    }

    public function broadcastAs(): string
    {
        return 'TurnoActualizado';
    }

    public function broadcastWith(): array
    {
        return [
            'codigo'  => $this->codigo,
            'caja'    => $this->caja,
            'mensaje' => $this->mensaje,
        ];
    }
}
