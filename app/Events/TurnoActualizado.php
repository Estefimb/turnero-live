<?php
namespace App\Events;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;
use App\Models\Turno;

class TurnoActualizado implements ShouldBroadcastNow
{
    use SerializesModels;
    public $turno;
    
    public function __construct(Turno $turno){
        \Log::info("EVENTO: TurnoActualizado DISPARADO", [
    'id' => $turno->id,
    'estado' => $turno->estado
]);

        $this->turno = $turno;
    }

    public function broadcastOn(){
        return new Channel('turnos');
    }

    public function broadcastAs(){
        return 'TurnoActualizado';
    }
}

